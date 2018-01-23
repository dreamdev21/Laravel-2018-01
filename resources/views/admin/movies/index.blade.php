@extends('admin.king')
<script src="{{asset('assets/js/webcomponents.min.js')}}"></script>

<style>
    .panel-default>.panel-heading {
        color: #333;
        background-color: #e5e9ec !important;
        border-color: #e5e9ec;
    }

    .panel-heading {
        padding: 10px 15px;
        border-bottom: 0px solid transparent;
        border-top-left-radius: 3px;
        border-top-right-radius: 3px;
    }

    /*Publish Toggle Style start*/
    .toggle-btn {
        width: 80px;
        height: 40px;
        margin: 10px;
        border-radius: 50px;
        display: inline-block;
        position: relative;
        background: url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAyklEQVQ4T42TaxHCQAyENw5wAhLACVUAUkABOCkSwEkdhNmbpHNckzv689L98toIAKjqGcAFwElEFr5ln6ruAMwA7iLyFBM/TPDuQSrxwf6fCKBoX2UMIYGYkg8BLOnVg2RiAEexGaQQq4w9e9klcxGLLAUwgDAcihlYAR1IvZA1sz/+AAaQjXhTQQVoe2Yo3E7UQiT2ijeQdojRtClOfVKvMVyVpU594kZK9zzySWTlcNqZY9tjCsUds00+A57z1e35xzlzJjee8xf0HYp+cOZQUQAAAABJRU5ErkJggg==") no-repeat 50px center #e74c3c;
        cursor: pointer;
        -webkit-transition: background-color .40s ease-in-out;
        -moz-transition: background-color .40s ease-in-out;
        -o-transition: background-color .40s ease-in-out;
        transition: background-color .40s ease-in-out;
        cursor: pointer;
    }
    .toggle-btn.active {
        background: url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAmUlEQVQ4T6WT0RWDMAhFeZs4ipu0mawZpaO4yevBc6hUIWLNd+4NeQDk5sE/PMkZwFvZywKSTxF5iUgH0C4JHGyF97IggFVSqyCFga0CvQSg70Mdwd8QSSr4sGBMcgavAgdvwQCtApvA2uKr1x7Pu++06ItrF5LXPB/CP4M0kKTwYRIDyRAOR9lJTuF0F0hOAJbKopVHOZN9ACS0UgowIx8ZAAAAAElFTkSuQmCC") no-repeat 10px center #2ecc71;
    }
    .toggle-btn.active .round-btn {
        left: 45px;
    }
    .toggle-btn .round-btn {
        width: 30px;
        height: 30px;
        background-color: #fff;
        border-radius: 50%;
        display: inline-block;
        position: absolute;
        left: 5px;
        top: 50%;
        margin-top: -15px;
        -webkit-transition: all .30s ease-in-out;
        -moz-transition: all .30s ease-in-out;
        -o-transition: all .30s ease-in-out;
        transition: all .30s ease-in-out;
    }
    .toggle-btn .cb-value {
        position: absolute;
        left: 0;
        right: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        z-index: 9;
        cursor: pointer;
        -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";
    }
    /*Publish Toggle Style end*/

</style>

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


@section('content')
    <div class="row">
        <div class="panel panel-default">

            <h2 class="panel-heading" style="background-color: none !important;">All Movies
            @if(Auth::user()->role == 2)
            <a href="/studio/media" type="button" class="btn btn-danger">Add a new movie</a>
            @else
            <a href="/admin/movies/create" type="button" class="btn btn-danger">Add a new movie</a>
            @endif
            </h2>

            <div class="panel-body">

                <table id="adminmoviestv" class="display" cellspacing="0" width="100%">
                    <thead class="table-header">
                    <th>ID:</th>
                    @if(Auth::user()->role == 1)
                    <th>poster</th>
                    @endif
                    <th>Title</th>
                    <th>Type</th>
                    <th>Parental stuff</th>
                    <th>Black List</th>
                    @if(Auth::user()->role == 1)
                        <th>Url</th>
                    @endif


                    <th>Created Date</th>
                    @if(Auth::user()->role == 1)
                        <th>Publish</th>
                    @else
                    <th>All rented</th>
                    @endif
                    <th>Actions</th>

                    </thead>
                    <tbody>
                    @foreach ($movie as $movi)
                        <tr>
                            <td>
                                {{ $movi->id }}
                            </td>
                            @if(Auth::user()->role == 1)
                            <td>
                                @if (strpos($movi->poster, 'https') !== false)
                                    <img src="{{ $movi->poster}}" alt="" style="max-width: 80px">
                                @else
                                    <img src="{{ asset('assets/images/' . $movi->poster) }}" style="max-width: 80px"  class="img-responsive" alt=""/>
                                @endif
                            </td>
                            @endif
                            <td style="width:10%">
                                {{ $movi->title }}
                            </td>
                            <td style="width:10%">
                                {{ $movi->type }}
                            </td>
                            <td>
                                <p>
                                    <select name="parentl" class="
                                    @if(Auth::user()->role == 1)
                                    sel_parental
                                    @else
                                    sel_parental_stud
                                    @endif
                                    " id="{{$movi->id}}">

                                        <option value="">-----</option>

                                        @foreach($parental as $pr)

                                            <option value="{{$pr->id}}"

                                                @if($pr->id == $movi->parental_id)
                                                     selected
                                                @endif

                                            >{{$pr->name}}</option>

                                        @endforeach


                                    </select>
                                </p>
                            </td>
                            <td>
                                {{--{{dd($movi->blacklist)}}--}}
                                <x-multiselect placeholder="Select" class="x_mult_sel" id="{{$movi->id}}"  style="height:44px">
                                    @foreach($continents as $continent)
                                        <li value="{{ $continent }}" @if(in_array($continent, explode(',', $movi->blacklist))) selected @endif >{{ $continent }}</li>
                                    @endforeach
                                </x-multiselect>
                                <input type="hidden" id="geo_f" value="">
                            </td>

                            @if(Auth::user()->role == 1)
                            <td>
                                <input readonly value="{{ $movi->url }}" style="overflow: hidden; max-width: 60ch; width: 100%; background: #ecf0f2;">
                            </td>
                            @endif
                            <td>
                                <p>
                                    {{ date('F j, Y', strtotime( $movi->created_at)) }}
                                </p>
                            </td>
                            @if(Auth::user()->role == 1)
                             <td>
                                 <div class="toggle-btn @if($movi->publish != 0) active @endif" >
                                     <input type="checkbox" id="{{$movi->id}}" @if($movi->publish != 0) checked @endif  class="cb-value" />
                                     <span class="round-btn"></span>
                                 </div>
                             </td>
                            @else

                                <td>
                                    ${{$all_pay['mid_'.$movi->id]}}
                                </td>

                            @endif
                            <td>
                                <p>
                                    <a href="{{ route('movies.edit', $movi->id) }}" class="btn btn-xs btn-danger"> Edit</a>
                                    <a href="{{ route('movies.show', $movi->id) }}" class="btn btn-xs btn-success delete"> View</a>
                                </p>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <link rel="stylesheet" href="//cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css">
                {{csrf_field()}}
            </div>
        </div>
    </div>
@endsection

@section('javascript')

    <script>
        $('.cb-value').click(function() {
            var id = $(this).attr('id');

            $.ajax({
                type:'post',
                url:'/admin/make_public',
                data:{
                    id: id,
                    '_token':Laravel.csrfToken
                },
                success:function(){
                }
            });

            var mainParent = $(this).parent('.toggle-btn');
            if($(mainParent).find('input.cb-value').is(':checked')) {
                $(mainParent).addClass('active');
            } else {
                $(mainParent).removeClass('active');
            }

        });

        var multiselect = document.querySelectorAll('.x_mult_sel');
        for(var i = 0; i<multiselect.length; i++){
            multiselect[i].addEventListener('change', function() {

                var id = this.getAttribute('id');
                var geo = this.selectedItems();

                $.ajax({
                    type:'post',
                    url:'/admin/set_geoFencing',
                    data:{
                        id: id,
                        geo: geo,
                        '_token':Laravel.csrfToken
                    },
                    success:function(){
                        console.log('success');
                    }
                });
            });
        }

    </script>

    <script>
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



        }());
    </script>
    {{--Multselect lib END--}}

@endsection



