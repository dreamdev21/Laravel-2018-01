@extends('admin.king')
@include('includes.tv-header')
@include('includes.tv-footer')

@section('content')
    <script src="{{ Request::root() }}/assets/plugins/jquery/jquery-1.11.3.min.js" type="text/javascript"></script>
    <script src="{{asset('assets/js/webcomponents.min.js')}}"></script>
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
    @if (session('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    @if (session('failed'))
        <div class="alert alert-success">
            {{ session('failed') }}
        </div>
    @endif

    <div class="content">
        @if(Session::has('success'))
            <div class="alert alert-success">
                <strong>Success!</strong> {{ Session::get('success') }}
            </div>
        @endif
        @if(Session::has('failed'))
            <div class="alert alert-success">
                <strong>Success!</strong> {{ Session::get('failed') }}
            </div>
        @endif
        <div class="page-title">
            <h3>Account Setting</h3>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="grid-body">

                    <div class="container">

                        <div class="col-lg-12">

                            <h4>Change your password</h4>

                            <form method="POST" action="{{route('tvSettingsPassChange') }}"
                                  enctype="multipart/form-data">
                                {{ csrf_field() }}

                                <div class="form-group">
                                    <label class="form-label">Old password</label>
                                    <div class="controls">
                                        <input type="text" class="form-control" name="oldPassword" autocomplete="off"
                                               required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">New Password</label>
                                    <div class="controls">
                                        <input type="password" class="form-control" name="newPassword"
                                               autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">New Password</label>
                                    <div class="controls">
                                        <input type="password" class="form-control" name="password_confirmation"
                                               autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="button-set">
                                    <button class="btn btn-danger btn-cons" type="submit">Change my password</button>
                                    <input type="hidden" name="_token" value="{{ Session::token() }}"/>
                                </div>

                            </form>
                        </div>

                        <div class="col-lg-6">
                            <br>
                            <br>
                            <h4>Change Player Background Image</h4>

                            <form method="POST" action="{{route('tvSettingsAddPlayerBackground') }}"
                                  enctype="multipart/form-data">
                                {{ csrf_field() }}

                                <div class="form-group">
                                    <label class="form-label" name="thumb_img">Backgorund Image (Images must be 'jpeg',  'jpg',  'png' )</label>
                                    <div class="controls">
                                        <input type="file" name="thumb_img" id="thumb_img" accept="image/*" class="form-control" required>
                                    </div>
                                </div>

                                <div class="button-set">
                                    <button class="btn btn-danger btn-cons" type="submit">Change Player Background Image</button>
                                    <input type="hidden" name="_token" value="{{ Session::token() }}"/>
                                </div>

                            </form>
                        </div>
                        <div class="col-lg-6">
                            <br>
                            <br>
                            <div class="form-group">
                                <h4>Logo</h4>
                                <form method="POST" action="{{route('updateChannelLogo') }}"
                                      enctype="multipart/form-data">
                                    {{ csrf_field() }}

                                    <div class="form-group">
                                        <label class="form-label" name="thumb_img">Channel logo (Logo must be 'jpeg',  'jpg',  'png' )</label>
                                        <div class="controls">
                                            <input type="file" name="logo" id="logo" accept="image/*" class="form-control" required>
                                        </div>
                                    </div>

                                    <div class="button-set">
                                        <button class="btn btn-danger btn-cons" type="submit">Set channel logo</button>
                                        <button class="btn btn-danger btn-cons" type="button" id="remove-logo">Remove current logo</button>
                                        <input type="hidden" name="_token" value="{{ Session::token() }}"/>
                                    </div>

                                </form>
                            </div>
                            {{--@if(!empty($channel->channel_logo))--}}
                                {{--<img src="{{\Storage::disk('s3frenvid')->url('tv_users/logo/'.Auth::user()->id.'/'.$channel->channel_logo)}}" alt="">--}}
                            {{--@endif--}}
                        </div>
                        @if($subscription === "pro")
                            <div class="col-lg-6">
                                <div class="form-group" style="height: 300px">
                                     <h4>Black list</h4>
                                     <x-multiselect placeholder="Select" class="x_mult_sel" style="height:44px">
                                         @foreach($continents as $continent)
                                             <li value="{{ $continent }}" {{in_array($continent, explode(',', $channel->blacklist)) ? 'selected' : ''}} >{{ $continent }}</li>
                                         @endforeach
                                     </x-multiselect>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection

@section('javascript')
    <script src="/assets/plugins/jquery-notifications/js/messenger.min.js" type="text/javascript"></script>
    <script src="/assets/js/notifications.js" type="text/javascript"></script>
    <script>
        var multiselect = document.querySelectorAll('.x_mult_sel');
        for(var i = 0; i<multiselect.length; i++){
            multiselect[i].addEventListener('change', function() {
                var geo = this.selectedItems();
                $.ajax({
                    type:'post',
                    url:'/tv/update_geoblock',
                    data:{
                        geo: geo,
                        '_token':Laravel.csrfToken
                    },
                    success:function(){
                        console.log('success');
                    }
                });
            });
        }

        var ownerDocument = (document._currentScript || document.currentScript).ownerDocument;
        var template = ownerDocument.querySelector('#multiselectTemplate');

        (function() {
            var multiselectPrototype = Object.create(HTMLElement.prototype);

            multiselectPrototype.createdCallback = function() {
                this.init();
                this.render();
            };

            multiselectPrototype.init = function() {
                this.initOptions();

                this._root = this.createRootElement();
                this._control = this._root.querySelector('.multiselect');
                this._field = this._root.querySelector('.multiselect-field');
                this._popup = this._root.querySelector('.multiselect-popup');
                this._list = this._root.querySelector('.multiselect-list');
            };

            multiselectPrototype.initOptions = function() {
                this._options = {
                    placeholder: this.getAttribute("placeholder") || 'Select'
                };
            };

            multiselectPrototype.createRootElement = function() {
                var root = this.createShadowRoot();
                var content = document.importNode(template.content, true);

                if (window.ShadowDOMPolyfill) {
                    WebComponents.ShadowCSS.shimStyling(content, 'x-multiselect');
                }

                root.appendChild(content);
                return root;
            };

            multiselectPrototype.render = function() {
                this.attachHandlers();
                this.refreshField();
                this.refreshItems();
            };

            multiselectPrototype.attachHandlers = function() {
                this._field.addEventListener('click', this.fieldClickHandler.bind(this));
                this._control.addEventListener('keydown', this.keyDownHandler.bind(this));
                this._list.addEventListener('click', this.listClickHandler.bind(this));
            };

            multiselectPrototype.fieldClickHandler = function() {
                this._isOpened ? this.close() : this.open();
            };

            multiselectPrototype.keyDownHandler = function(event) {
                switch(event.which) {
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

            multiselectPrototype.handleEnterKey = function() {
                if(this._isOpened) {
                    var focusedItem = this.itemElements()[this._focusedItemIndex];
                    this.selectItem(focusedItem);
                }
            };

            multiselectPrototype.handleArrowDownKey = function() {
                this._focusedItemIndex = (this._focusedItemIndex < this.itemElements().length - 1)
                    ? this._focusedItemIndex + 1
                    : 0;

                this.refreshFocusedItem();
            };

            multiselectPrototype.handleArrowUpKey = function() {
                this._focusedItemIndex = (this._focusedItemIndex > 0)
                    ? this._focusedItemIndex - 1
                    : this.itemElements().length - 1;

                this.refreshFocusedItem();
            };

            multiselectPrototype.handleAltArrowDownKey = function() {
                this.open();
            };

            multiselectPrototype.handleAltArrowUpKey = function() {
                this.close();
            };

            multiselectPrototype.refreshFocusedItem = function() {
                this.itemElements()[this._focusedItemIndex].focus();
            };

            multiselectPrototype.handleBackspaceKey = function() {
                var selectedItemElements = this.querySelectorAll("li[selected]");

                if(selectedItemElements.length) {
                    this.unselectItem(selectedItemElements[selectedItemElements.length - 1]);
                }
            };

            multiselectPrototype.handleEscapeKey = function() {
                this.close();
            };

            multiselectPrototype.listClickHandler = function(event) {
                var item = event.target;
                while(item && item.tagName !== 'LI') {
                    item = item.parentNode;
                }

                this.selectItem(item);
            };

            multiselectPrototype.selectItem = function(item) {
                if(!item.hasAttribute('selected')) {
                    item.setAttribute('selected', 'selected');
                    item.setAttribute('aria-selected', true);
                    this.fireChangeEvent();
                    this.refreshField();
                }

                this.close();
            };

            multiselectPrototype.fireChangeEvent = function() {
                var event = new CustomEvent("change");
                this.dispatchEvent(event);
            };

            multiselectPrototype.togglePopup = function(show) {
                this._isOpened = show;
                this._popup.style.display = show ? 'block' : 'none';
                this._control.setAttribute("aria-expanded", show);
            };

            multiselectPrototype.refreshField = function() {
                this._field.innerHTML = '';

                var selectedItems = this.querySelectorAll('li[selected]');

                if(!selectedItems.length) {
                    this._field.appendChild(this.createPlaceholder());
                    return;
                }

                for(var i = 0; i < selectedItems.length; i++) {
                    this._field.appendChild(this.createTag(selectedItems[i]));
                }
            };

            multiselectPrototype.refreshItems = function() {
                var itemElements = this.itemElements();

                for(var i = 0; i < itemElements.length; i++) {
                    var itemElement = itemElements[i];
                    itemElement.setAttribute("role", "option");
                    itemElement.setAttribute("aria-selected", itemElement.hasAttribute("selected"));
                    itemElement.setAttribute("tabindex", -1);
                }

                this._focusedItemIndex = 0;
            };

            multiselectPrototype.itemElements = function() {
                return this.querySelectorAll('li');
            };

            multiselectPrototype.createPlaceholder = function() {
                var placeholder = document.createElement('div');
                placeholder.className = 'multiselect-field-placeholder';
                placeholder.textContent = this._options.placeholder;
                return placeholder;
            };

            multiselectPrototype.createTag = function(item) {
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

            multiselectPrototype.removeTag = function(tag, item, event) {
                this.unselectItem(item);
                event.stopPropagation();
            };

            multiselectPrototype.unselectItem = function(item) {
                item.removeAttribute('selected');
                item.setAttribute('aria-selected', false);
                this.fireChangeEvent();
                this.refreshField();
            };

            multiselectPrototype.attributeChangedCallback = function(optionName, oldValue, newValue) {
                this._options[optionName] = newValue;
                this.refreshField();
            };

            multiselectPrototype.open = function() {
                this.togglePopup(true);
                this.refreshFocusedItem();
            };

            multiselectPrototype.close = function() {
                this.togglePopup(false);
                this._field.focus();
            };

            multiselectPrototype.selectedItems = function() {
                var result = [];
                var selectedItems = this.querySelectorAll('li[selected]');

                for(var i = 0; i < selectedItems.length; i++) {
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

            $('#remove-logo').on('click', function () {
                $.ajax({
                    type:"get",
                    url: "remove_logo",
                    success: function (data) {
                        showSuccess(data);
                    }
                });
            })

        }());
    </script>
@stop
