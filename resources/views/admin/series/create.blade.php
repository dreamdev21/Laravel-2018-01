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

    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <h2 class="panel-heading">Add new series</h2>

                <form action="{{ route('series.store') }}" method="post" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <div class="panel panel-primary" data-collapsed="0">
                        <div class="panel-heading">
                            <div class="panel-title">Add new series</div>
                            <div class="panel-options">
                                <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                            </div>
                        </div>
                        @if(Auth::user()->role == 1)
                        <div class="panel-body" style="display: block;">
                            <p>Select studio name</p>
                            <select name="studio_id" style="min-height: 40px; width: 100%;" required>
                                @foreach($studios as $studio)
                                    <option value="{{$studio->id}}">{{$studio->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        @endif

                    </div>

                    <div class="panel panel-primary" data-collapsed="0">
                        <p>Enter series name</p>
                        <div class="panel-body" style="display: block;">
                            <input type="text" name="series_name" placeholder="Series Name" style="background-color:white; min-height: 40px; width: 100%;" required>
                        </div>
                    </div>

                    <div class="panel panel-primary" data-collapsed="0">
                        <p>Add the rental price for pay per view. Eg -> 2.50 . <span class="label label-danger">ONLY PUT NUMBERS</span></p>
                        <div class="panel-body" style="display: block;">
                            <input type="text" name="price" id="price" placeholder="rental price" style="background-color:white; width: 100%;">
                        </div>
                    </div>


                    <div class="panel panel-primary" data-collapsed="0">
                        <p>Put it in hours. Eg -> 48hs (2 days). <span class="label label-danger">ONLY PUT NUMBERS</span></p>
                        <div class="panel-body" style="display: block;">
                            <input type="number" class="form-control" name="period" id="period" placeholder="series Length" style="background-color:white; width: 100%;">
                        </div>
                    </div>

                    <div class="panel panel-primary" data-collapsed="0">
                        <p>Enter series description</p>
                        <div class="panel-body" style="display: block;">
                            <textarea class="form-control" name="description" placeholder="Description" id="description"></textarea>
                        </div>
                    </div>


                    <div class="panel panel-primary" data-collapsed="0">

                        <p>Add poster</p>

                        <div class="panel-body" style="display: block;">
                            <input type="file" class="form-control" name="poster" id="poster" required>
                        </div>
                    </div>

                    <div class="panel panel-primary" data-collapsed="0">

                        <p>Select a Genre/s Below:</p>

                        <div class="panel-body" style="display: block;">

                            {{--<select id="genre_id" name="genre_id" class="form-control">--}}
                                {{--@foreach($genres as $genre)--}}

                                    {{--<option value="{{ $genre->id }}">{{ $genre->name }}</option>--}}

                                {{--@endforeach--}}
                            {{--</select>--}}
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
//                    console.log('Selected items:', this.selectedItems());
                            });
                        </script>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="panel panel-primary" data-collapsed="0">
                                <p>Actors</p>
                                <div class="panel-body">
                                    <p>Enter Cast</p>
                                    <input type="text" id="actors" name="actor" style="background-color:white; width: 100%;">
                                </div>
                            </div>
                        </div>
                    </div><!-- row -->

                    <div class="panel panel-primary" data-collapsed="0">
                        <p>Push the button to continue</p>
                        <div class="panel-body" style="display: block;">
                            <button type ="submit" class="btn btn-lg btn-danger" style="width: 100%;"> Add new Series </button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>


@stop

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

