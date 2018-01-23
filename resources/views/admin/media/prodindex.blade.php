@extends('admin.king')

@section('content')

    {{--Multselect lib START--}}
    <template id="multiselectTemplate">
        <style>
            .multiselect {
                position: relative;
                box-sizing: border-box;
                display: inline-block;
                width: 20em;
            }

            .multiselect-field {
                overflow: hidden;
                padding: .2em .2em 0 .2em;
                border: 1px solid #adadad;
                border-radius: .2em;
                cursor: pointer;
                -webkit-user-select: none;
                user-select: none;
            }

            .multiselect-field-placeholder {
                padding: .25em .5em;
                margin-bottom: .2em;
                color: #888;
                line-height: 1;
            }

            .multiselect-tag {
                position: relative;
                display: inline-block;
                padding: .25em 1.5em .25em .5em;
                border: 1px solid #bdbdbd;
                border-radius: .2em;
                margin: 0 .2em .2em 0;
                line-height: 1;
                vertical-align: middle;
            }

            .multiselect-tag:last-child {
                margin-right: 0;
            }

            .multiselect-tag:hover {
                background: #efefef;
            }

            .multiselect-tag-text {
                min-height: 1em;
            }

            .multiselect-tag-remove-button {
                position: absolute;
                top: .25em;
                right: .25em;
                width: 1em;
                height: 1em;
                opacity: 0.3;
            }

            .multiselect-tag-remove-button:hover {
                opacity: 1;
            }

            .multiselect-tag-remove-button:before,
            .multiselect-tag-remove-button:after {
                content: ' ';
                position: absolute;
                left: .5em;
                width: 2px;
                height: 1em;
                background-color: #333;
            }

            .multiselect-tag-remove-button:before {
                transform: rotate(45deg);
            }

            .multiselect-tag-remove-button:after {
                transform: rotate(-45deg);
            }

            .multiselect-popup {
                position: absolute;
                z-index: 1000;
                display: none;
                overflow-y: auto;
                width: 100%;
                max-height: 300px;
                box-sizing: border-box;
                border: 1px solid #bdbdbd;
                border-radius: .2em;
                background: white;
            }

            .multiselect-list {
                padding: 0;
                margin: 0;
            }

            ::content li {
                padding: .5em 1em;
                min-height: 1em;
                list-style: none;
                cursor: pointer;
            }

            ::content li[selected] {
                background: #f3f3f3;
            }

            ::content li:focus {
                outline: dotted 1px #333;
                background: #e9e9e9;
            }

            ::content li:hover {
                background: #e9e9e9;
            }
        </style>

        <div class="multiselect" role="combobox">
            <div class="multiselect-field" tabindex="0"></div>
            <div class="multiselect-popup">
                <ul class="multiselect-list" role="listbox" aria-multiselectable="true">
                    <content select="li"></content>
                </ul>
            </div>
        </div>
    </template>
    <script>
        var ownerDocument = (document._currentScript || document.currentScript).ownerDocument;
        var template = ownerDocument.querySelector('#multiselectTemplate');

        (function () {
            var multiselectPrototype = Object.create(HTMLElement.prototype);

            multiselectPrototype.createdCallback = function () {
                this.init();
                this.render();
            };

            multiselectPrototype.init = function () {
                this.initOptions();

                this._root = this.createRootElement();
                this._control = this._root.querySelector('.multiselect');
                this._field = this._root.querySelector('.multiselect-field');
                this._popup = this._root.querySelector('.multiselect-popup');
                this._list = this._root.querySelector('.multiselect-list');
            };

            multiselectPrototype.initOptions = function () {
                this._options = {
                    placeholder: this.getAttribute("placeholder") || 'Select'
                };
            };

            multiselectPrototype.createRootElement = function () {
                var root = this.createShadowRoot();
                var content = document.importNode(template.content, true);

                if (window.ShadowDOMPolyfill) {
                    WebComponents.ShadowCSS.shimStyling(content, 'x-multiselect');
                }

                root.appendChild(content);
                return root;
            };

            multiselectPrototype.render = function () {
                this.attachHandlers();
                this.refreshField();
                this.refreshItems();
            };

            multiselectPrototype.attachHandlers = function () {
                this._field.addEventListener('click', this.fieldClickHandler.bind(this));
                this._control.addEventListener('keydown', this.keyDownHandler.bind(this));
                this._list.addEventListener('click', this.listClickHandler.bind(this));
            };

            multiselectPrototype.fieldClickHandler = function () {
                this._isOpened ? this.close() : this.open();
            };

            multiselectPrototype.keyDownHandler = function (event) {
                switch (event.which) {
                    case 8:
                        this.handleBackspaceKey();
                        break;
                    case 13:
                        this.handleEnterKey();
                        break;
                    case 27:
                        this.handleEscapeKey();
                        break;
                    case 38:
                        event.altKey ? this.handleAltArrowUpKey() : this.handleArrowUpKey();
                        break;
                    case 40:
                        event.altKey ? this.handleAltArrowDownKey() : this.handleArrowDownKey();
                        break;
                    default:
                        return;
                }
                event.preventDefault();
            };

            multiselectPrototype.handleEnterKey = function () {
                if (this._isOpened) {
                    var focusedItem = this.itemElements()[this._focusedItemIndex];
                    this.selectItem(focusedItem);
                }
            };

            multiselectPrototype.handleArrowDownKey = function () {
                this._focusedItemIndex = (this._focusedItemIndex < this.itemElements().length - 1)
                    ? this._focusedItemIndex + 1
                    : 0;

                this.refreshFocusedItem();
            };

            multiselectPrototype.handleArrowUpKey = function () {
                this._focusedItemIndex = (this._focusedItemIndex > 0)
                    ? this._focusedItemIndex - 1
                    : this.itemElements().length - 1;

                this.refreshFocusedItem();
            };

            multiselectPrototype.handleAltArrowDownKey = function () {
                this.open();
            };

            multiselectPrototype.handleAltArrowUpKey = function () {
                this.close();
            };

            multiselectPrototype.refreshFocusedItem = function () {
                this.itemElements()[this._focusedItemIndex].focus();
            };

            multiselectPrototype.handleBackspaceKey = function () {
                var selectedItemElements = this.querySelectorAll("li[selected]");

                if (selectedItemElements.length) {
                    this.unselectItem(selectedItemElements[selectedItemElements.length - 1]);
                }
            };

            multiselectPrototype.handleEscapeKey = function () {
                this.close();
            };

            multiselectPrototype.listClickHandler = function (event) {
                var item = event.target;
                while (item && item.tagName !== 'LI') {
                    item = item.parentNode;
                }

                this.selectItem(item);
            };

            multiselectPrototype.selectItem = function (item) {
                if (!item.hasAttribute('selected')) {
                    item.setAttribute('selected', 'selected');
                    item.setAttribute('aria-selected', true);
                    this.fireChangeEvent();
                    this.refreshField();
                }

                this.close();
            };

            multiselectPrototype.fireChangeEvent = function () {
                var event = new CustomEvent("change");
                this.dispatchEvent(event);
            };

            multiselectPrototype.togglePopup = function (show) {
                this._isOpened = show;
                this._popup.style.display = show ? 'block' : 'none';
                this._control.setAttribute("aria-expanded", show);
            };

            multiselectPrototype.refreshField = function () {
                this._field.innerHTML = '';

                var selectedItems = this.querySelectorAll('li[selected]');

                if (!selectedItems.length) {
                    this._field.appendChild(this.createPlaceholder());
                    return;
                }

                for (var i = 0; i < selectedItems.length; i++) {
                    this._field.appendChild(this.createTag(selectedItems[i]));
                }
            };

            multiselectPrototype.refreshItems = function () {
                var itemElements = this.itemElements();

                for (var i = 0; i < itemElements.length; i++) {
                    var itemElement = itemElements[i];
                    itemElement.setAttribute("role", "option");
                    itemElement.setAttribute("aria-selected", itemElement.hasAttribute("selected"));
                    itemElement.setAttribute("tabindex", -1);
                }

                this._focusedItemIndex = 0;
            };

            multiselectPrototype.itemElements = function () {
                return this.querySelectorAll('li');
            };

            multiselectPrototype.createPlaceholder = function () {
                var placeholder = document.createElement('div');
                placeholder.className = 'multiselect-field-placeholder';
                placeholder.textContent = this._options.placeholder;
                return placeholder;
            };

            multiselectPrototype.createTag = function (item) {
                var tag = document.createElement('div');
                tag.className = 'multiselect-tag';

                var content = document.createElement('div');
                content.className = 'multiselect-tag-text';
                content.textContent = item.textContent;

                var removeButton = document.createElement('div');
                removeButton.className = 'multiselect-tag-remove-button';
                removeButton.addEventListener('click', this.removeTag.bind(this, tag, item));

                tag.appendChild(content);
                tag.appendChild(removeButton);

                return tag;
            };

            multiselectPrototype.removeTag = function (tag, item, event) {
                this.unselectItem(item);
                event.stopPropagation();
            };

            multiselectPrototype.unselectItem = function (item) {
                item.removeAttribute('selected');
                item.setAttribute('aria-selected', false);
                this.fireChangeEvent();
                this.refreshField();
            };

            multiselectPrototype.attributeChangedCallback = function (optionName, oldValue, newValue) {
                this._options[optionName] = newValue;
                this.refreshField();
            };

            multiselectPrototype.open = function () {
                this.togglePopup(true);
                this.refreshFocusedItem();
            };

            multiselectPrototype.close = function () {
                this.togglePopup(false);
                this._field.focus();
            };

            multiselectPrototype.selectedItems = function () {
                var result = [];
                var selectedItems = this.querySelectorAll('li[selected]');

                for (var i = 0; i < selectedItems.length; i++) {
                    var selectedItem = selectedItems[i];

                    result.push(selectedItem.hasAttribute('value')
                        ? selectedItem.getAttribute('value')
                        : selectedItem.textContent);
                }

                return result;
            };

            document.registerElement('x-multiselect', {
                prototype: multiselectPrototype
            });

        }());
    </script>
    {{--Multselect lib END--}}

    <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>

    <script>
        tinymce.init({
            selector: 'textarea',
            plugins: 'link code'
        });
    </script>

    <style>
        .panel-body {
            background: #f9f9f9 !important;
        }
        .panel-primary>.panel-heading {
            background: none !important;
        }

        .panel-primary>.panel-heading {
            color: #333 !important;
        }

        .panel-primary {
            border: 0px #fff solid  !important;
        }


    </style>


    <link rel="stylesheet" href="https://www.w3schools.com/w3css/3/w3.css">
    <div class="row">
        <div class="panel panel-default">
            <div class="row">

                <div class="col-md-12">



                    <h2 class="panel-heading">Media</h2>
                    {{ csrf_field() }}

                    <div class="col-md-6">
                        <form id="uploadForm_film" enctype="multipart/form-data" action="" method="post">
                            <div class="form-group">
                                <div class="controls" style="display: none;">
                                    <input name="uploadForm_film_inp" id="uploadForm_film_inp" value="film" disabled>
                                </div>
                            </div>

                            <div style="display: none;" class="form-group">
                                <div class="controls">
                                    <select name="studio" id="studio" class="s3_up_studio">

                                        @foreach($studios as $studio)

                                            <option value="{{$studio->name}}">{{$studio->name}}</option>

                                        @endforeach

                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label" name="s3_up_file_film">Add Film</label>
                                <div class="controls">
                                    <input type="file" name="s3_up_file_film" id="s3_up_file_film" class="form-control" accept="video/mp4" required>
                                </div>
                            </div>


                            <!-- END HTML5 WYS5646456IWG CONTROLS-->
                            <div class="col-md-12 m-b-50 text-center">
                                <button type="submit" class="btn btn-lg btn-danger"> Add Film </button>
                                <input type="hidden" name="_token" value="{{ Session::token() }}" />
                            </div>
                        </form>
                        <br><br><br><br><br>
                        <div class="w3-light-grey w3-round" style="width: 95%; position: relative;">
                            <img class="adm_media_upl_img_film" src="{{ asset('assets/images/loading.gif') }}" alt="">
                            <img class="adm_media_upl_img_check_film" src="{{ asset('assets/images/check.png') }}" alt="">
                            <div class="w3-container media_prog_bar_film w3-blue w3-round" style="width:0%; height: 20px;">0%</div>
                            <h3><span class="label label-warning scr_tt adm_media_upl_text_film">Please wait the file is uploading to server</span></h3>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <form id="uploadForm_trailer" enctype="multipart/form-data" action="" method="post">
                            <div class="form-group">
                                <div class="controls" style="display: none;">
                                    <input name="uploadForm_trailer_inp" id="uploadForm_trailer_inp" value="trailer" disabled>
                                </div>
                            </div>

                            <div style="display: none;" class="form-group">
                                <div class="controls">
                                    <select name="studio" id="studio" class="s3_up_studio">

                                        @foreach($studios as $studio)

                                            <option value="{{$studio->name}}">{{$studio->name}}</option>

                                        @endforeach

                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label" name="movie_mp4">Add Trailer (Optional)</label>
                                <div class="controls">
                                    <input type="file" name="s3_up_file_trailer" id="s3_up_file_trailer" class="form-control" accept="video/mp4">
                                </div>
                            </div>


                            <!-- END HTML5 WYS5646456IWG CONTROLS-->
                            <div class="col-md-12 m-b-50 text-center">
                                <button type="submit" class="btn btn-lg btn-danger"> Add Trailer </button>
                                <input type="hidden" name="_token" value="{{ Session::token() }}" />
                            </div>
                        </form>
                        <br><br><br><br><br>
                        <div class="w3-light-grey w3-round" style="width: 95%; position: relative;">
                            <img class="adm_media_upl_img_trailer" src="{{ asset('assets/images/loading.gif') }}" alt="">
                            <img class="adm_media_upl_img_check_trailer" src="{{ asset('assets/images/check.png') }}" alt="">
                            <div class="w3-container media_prog_bar_trailer w3-blue w3-round" style="width:0%; height: 20px;">0%</div>
                            <h3><span class="label label-warning scr_tt adm_media_upl_text_trailer">Please wait the file is uploading to server</span></h3>
                        </div>
                    </div>




                    {{--<div class="col-md-4">--}}
                        {{--<form id="uploadForm_image" enctype="multipart/form-data" action="" method="post">--}}
                            {{--<div class="form-group">--}}
                                {{--<div class="controls" style="display: none;">--}}
                                    {{--<input name="uploadForm_image_inp" id="uploadForm_image_inp" value="image" disabled>--}}
                                {{--</div>--}}
                            {{--</div>--}}

                            {{--<div style="display: none;" class="form-group">--}}
                                {{--<div class="controls">--}}
                                    {{--<select name="studio" id="studio">--}}

                                        {{--@foreach($studios as $studio)--}}

                                            {{--<option value="{{$studio->name}}">{{$studio->name}}</option>--}}

                                        {{--@endforeach--}}

                                    {{--</select>--}}
                                {{--</div>--}}
                            {{--</div>--}}

                            {{--<div class="form-group">--}}
                                {{--<label class="form-label" name="s3_up_file_image">Add Image</label>--}}
                                {{--<div class="controls">--}}
                                    {{--<input type="file" name="s3_up_file_image" id="s3_up_file_image" class="form-control" accept="image/*" required>--}}
                                {{--</div>--}}
                            {{--</div>--}}


                            {{--<!-- END HTML5 WYS5646456IWG CONTROLS-->--}}
                            {{--<div class="col-md-12 m-b-50 text-center">--}}
                                {{--<button type="submit" class="btn btn-lg btn-danger"> Add Image </button>--}}
                                {{--<input type="hidden" name="_token" value="{{ Session::token() }}" />--}}
                            {{--</div>--}}
                        {{--</form>--}}
                        {{--<hr>--}}
                        {{--<hr>--}}
                        {{--<hr>--}}
                        {{--<hr>--}}
                        {{--<hr>--}}
                        {{--<div class="w3-light-grey w3-round" style="width: 95%;">--}}
                            {{--<div class="w3-container media_prog_bar_image w3-blue w3-round" style="width:0%; height: 20px;">0%</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}




                </div>
            </div>
        </div>
        <hr>
        <div class="container">
            <h2 class="text-center">Add New Movie</h2>
            <div id="admin-container">


                <div class="clear"></div>


                <form action="{{ route('movies.store') }}" method="post" file="1" enctype="multipart/form-data" id="formVideo" class="prod_moviup_form">
                    {{ csrf_field() }}
                    <div class="panel panel-primary" data-collapsed="0">
                        <div class="panel-heading">
                            <div class="panel-title">Title</div>
                            <div class="panel-options">
                                <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                            </div>
                        </div>
                        <div class="panel-body" style="display: block;">
                            <p>Add movie title in the textbox below:</p>
                            <input type="text" class="form-control" name="title" id="title" placeholder="movie title">
                        </div>
                    </div>

                    <div class="panel panel-primary" data-collapsed="0">
                        <div class="panel-heading">
                            <div class="panel-title">Year</div>
                            <div class="panel-options">
                                <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                            </div>
                        </div>
                        <div class="panel-body" style="display: block;">
                            <p>Add the video year in the textbox below:</p>
                            <input type="text" class="form-control" name="year" id="year" placeholder="movie Year">
                        </div>
                    </div>



                    <div class="panel panel-primary" data-collapsed="0" id="ppv_cost_panel"> <div class="panel-heading">
                            <div class="panel-title">Rental Price</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div>
                        <div class="panel-body" style="display: block;">
                            <p>Add the rental price for pay per view. Eg -> 2.50 . <span class="label label-danger">ONLY PUT NUMBERS</span></p>
                            <input type="text" class="form-control" name="price" id="price" placeholder="rental price">
                        </div>
                    </div>

                    <div class="form-group" data-collapsed="0" id="ppv_cost_length" > <div class="panel-heading">
                            <div class="panel-title">Movie access window to the user</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div>
                        <div class="panel-body" style="display: block;">
                            <p>Put it in hours. Eg -> 48hs (2 days). <span class="label label-danger">ONLY PUT NUMBERS</span></p>
                            <input type="number" class="form-control" name="period" id="period" placeholder="movie Length">
                        </div>
                    </div>

                    <div class="form-group" data-collapsed="0" id="ppv_cost_length" > <div class="panel-heading">
                            <div class="panel-title">Movie Duration</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div>
                        <div class="panel-body" style="display: block;">
                            <p>Example 1:25:00</p>
                            <input type="text" class="form-control" name="duration" id="period" placeholder="movie Length"  />
                        </div>
                    </div>

                    <input type="hidden" id="type" name="type" value="movie" class="form-control">

                    <div class="form-group" data-collapsed="0"> <div class="panel-heading">
                            <div class="panel-title">Video Poster</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div>
                        <div class="panel-body" style="display: block;">
                            <p>Select the video image (1280x720 px or 16:9 ratio):</p>
                            <input type="file" multiple="true" class="form-control" name="poster" id="poster" accept="image/*">
                        </div>
                    </div>

                    {{--<div class="form-group" data-collapsed="0"> <div class="panel-heading">--}}
                            {{--<div class="panel-title">Movie Background Image</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div>--}}
                        {{--<div class="panel-body" style="display: block;">--}}
                            {{--<p>Select the movie bg image (1280x720 px or 16:9 ratio):</p>--}}
                            {{--<input type="file" multiple="true" class="form-control" name="bg_poster" id="bg_poster" accept="image/*">--}}
                        {{--</div>--}}
                    {{--</div>--}}

                    <div style="display: none;" class="panel panel-primary" data-collapsed="0">
                        <div class="panel-heading">
                            <div class="panel-title">studio</div>
                            <div class="panel-options">
                                <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                            </div>
                        </div>
                        <div class="panel-body" style="display: block;">
                            <p>Select a studio Below:</p>
                            <select id="studio" name="studio_id" class="form-control">
                                @foreach($studios_all as $house)

                                    <option value="{{ $house->id }}">{{ $house->name }}</option>

                                @endforeach

                            </select>
                        </div>
                    </div>

                    <div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading">
                            <div class="panel-title">Director</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div>
                        <div class="panel-body">
                            <p>Enter Director Below</p>
                            <input type="text" id="director" name="director[]" value="" data-role="tagsinput" />
                        </div>
                        {{--<div class="panel-body" style="display: block;">--}}
                            {{--<p>Select a Director Below:</p>--}}
                            {{--<select id="director" name="director_id" class="form-control">--}}
                                {{--@foreach($directors as $director)--}}
                                    {{--<option value="{{ $director->id }}"--}}
                                            {{--@if(!empty($movie) && !empty($movie->director->first()))--}}
                                            {{--@if($movie->director->first()->pivot->director_id == $director->id)--}}
                                            {{--selected="selected"--}}
                                            {{--@endif--}}
                                            {{--@endif>{{ $director->name }}</option>--}}

                                {{--@endforeach--}}
                            {{--</select>--}}
                        {{--</div>--}}
                    </div>




                    <div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading">
                            <div class="panel-title">Movie url Source</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div>
                        <div class="panel-body" style="display: block;">
                            <div class="new-wistia" >
                                <label for="wistia">
                                    <h3><span class="label label-danger scr_tt">This section automatically filled after full uploads file</span></h3>
                                </label>
                                <input class="form-control" type="hidden" name="url" id="url">
                                <input class="form-control" type="text" id="url_f" disabled>
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading">
                            <div class="panel-title">Trailer</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div>
                        <div class="panel-body" style="display: block;">
                            <div class="new-wistia">
                                <label for="wistia">
                                    <h3><span class="label label-danger scr_tt">This section automatically filled after full uploads file</span></h3>
                                </label>
                                <input class="form-control" type="hidden" name="trailer" id="trailer">
                                <input class="form-control" type="text" id="trailer_f" disabled>
                            </div>
                        </div>
                    </div>


                    <div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading">
                            <div class="panel-title">Movie Description</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div>
                        <div class="panel-body" style="display: block; padding:0px;">
                            <textarea class="form-control" name="description" id="description"></textarea>
                        </div>
                    </div>



                    <div class="panel panel-primary" data-collapsed="0">
                        <div class="panel-heading">
                            <div class="panel-title">Genre</div>
                            <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a></div>
                        </div>
                        <div class="panel-body" style="display: block;">
                            <p>Select all necessary Genre/s Below:</p>
                            <div>
                                <input type="hidden" id="genreInput" name="genre_id" value="">
                                <x-multiselect placeholder="Select " style="height:44px">
                                    @foreach($genres as $genre)

                                        <li value="{{ $genre->id }}">{{ $genre->name }}</li>

                                    @endforeach
                                </x-multiselect>
                            </div>
                            <script>
                                var multiselect = document.querySelector('x-multiselect');
                                multiselect.addEventListener('change', function() {
                                    document.getElementById('genreInput').value = this.selectedItems();
                                });
                            </script>
                        </div>


                        <div class="row">

                            <div class="col-sm-12">
                                <div class="panel panel-primary" data-collapsed="0">
                                    <div class="panel-heading"> <div class="panel-title"> Actors</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div>
                                    <div class="panel-body">
                                        <p>Enter Cast</p>
                                        <input type="text" id="actors" name="actor[]"
                                               @if(!empty($movie))
                                               @if($movie->actor()->count() > 0)
                                               value="
                                    @foreach($movie->actor as $actor)

                                               {{ $actor->name .',' }}

                                               @endforeach
                                                       "
                                               @endif
                                               @endif
                                               data-role="tagsinput" />
                                    </div>
                                </div>
                            </div>




                        </div><!-- row -->


                        <div class="clear"></div>





                        <button type ="submit" class="btn btn-lg btn-success m-b-50"> Add new movie </button>
                        <center><span class="label label-danger adm_form_req_mess">Please make sure that all sections are completed.</span></center>
                        <input type="hidden" name="_token" value="{{ Session::token() }}" />

                    </div>

                </form>

                <div class="clear"></div>

            </div>
        </div>


    </div>


@endsection


@section('javascript')


    <script type="text/javascript" src="{{ 'assets/admin/js/tinymce/tinymce.min.js' }}"></script>
    <script type="text/javascript" src="{{ 'assets/js/tagsinput/jquery.tagsinput.min.js' }}"></script>
    <script type="text/javascript" src="{{ 'assets/js/jquery.mask.min.js' }}"></script>
    <script type="text/javascript" src="{{ 'assets/admin/js/bootstrap-tagsinput/bootstrap-tagsinput.min.js' }}"></script>
    <script type="text/javascript" src="{{ 'assets/admin/js/typeahead/typeahead.bundle.js' }}"></script>
    <script type="text/javascript" src="{{ 'assets/admin/js/multi-select/jquery.multi-select.js' }}"></script>
    <script type="text/javascript" src="{{ '/theme/assets/plugins/w2ui/w2ui-1.4.3.min.js' }}"></script>

    <script type="text/javascript">

        $ = jQuery;

        $(document).ready(function(){




            $('#type').on('change', function() {
                addRating();
            });

            $('#duration').mask('00:00:00');
            $('#tags').tagsInput();




        });


        var actors = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            prefetch: {
                url: '/api/v1/helpers/actors',
                filter: function(list) {
                    return $.map(list, function(cityname) {
                        return { name: cityname }; });
                },
                ttl: 0
            }
        });

        actors.initialize();

        $('#actors').tagsinput({
            typeaheadjs: {
                name: 'citynames',
                displayKey: 'name',
                valueKey: 'name',
                source: actors.ttAdapter()
            }
        });



        function createRating(type){

            if(type=='movie'){
                var actualParentalRatingId = 1;
            }else{
                var actualParentalRatingId = 8;
            }

            if(type=='movie'){
                var ratings = {"1":"G | General Audiences","2":"PG | Parental Guidance Suggested","3":"PG-13 | Parents Strongly Cautioned","4":"R | Restricted","5":"NC-17 | No one 17 and under admitted"};
            }else{
                var ratings = {"6":"TV-Y | All Children","7":"TV-Y7 | Directed to Older Children. Age 7 and above.","8":"TV-G | General Audience","9":"TV-PG | Parental Guidance Suggested","10":"TV-14 | Parents Strongly Cautioned","11":"TV-MA | Mature Audience Only"};
            }

            $('#parental_id').empty();

            $.each(ratings, function (index, value) {
                $('#parental_id').append($('<option/>', {
                    value: index,
                    text : value
                }));
            });

            $("#parental_id").val(actualParentalRatingId);

        }


    </script>

@stop

