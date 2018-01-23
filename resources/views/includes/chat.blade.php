<?php use App\Http\Controllers\FollowerController;

$fol_res = FollowerController::chat_res(); ?>
<!-- RIGHT SIDEBAR BEGIN CHAT -->

<div class="chat-window-wrapper">
    <div id="main-chat-wrapper" class="inner-content">
        <div class="chat-window-wrapper scroller scrollbar-dynamic" id="chat-users">
            <div class="chat-header">
                <div class="pull-right" style="padding-right: 15px;">
                    <a href="#" class="">
                        <div class="iconset top-chat-dark "></div>
                    </a>
                </div>
            </div>
            <div class="side-widget">
                <div class="side-widget-content">

                </div>
            </div>
            <div class="side-widget fadeIn">
                <div class="side-widget-title">Your Friends</div>
                <div id="favourites-list">
                    <div class="side-widget-content">

                        @foreach($fol_res as $fol_val)
                            <script>
                                user_fr_list.push('{{$fol_val->id}}');
                            </script>
                            <div class="user-details-wrapper open_mess_area active" id="{{$fol_val->id}}" data-chat-status="online"
                                 data-chat-user-pic="{{ Request::root() }}/assets/images/{{$fol_val->avatar}}"
                                 data-chat-user-pic-retina="{{ Request::root() }}/assets/img/profiles/d2x.jpg"
                                 data-user-name="{{$fol_val->username}}">
                                <div class="user-profile">
                                    <img src="{{ Request::root() }}/assets/images/{{$fol_val->avatar}}" alt=""
                                         data-src="{{ Request::root() }}/assets/images/{{$fol_val->avatar}}"
                                         data-src-retina="{{ Request::root() }}/assets/img/profiles/d2x.jpg" width="35"
                                         height="35">
                                </div>
                                <div class="user-details">
                                    <div class="user-name">
                                        {{ substr(strip_tags($fol_val->username), 0, 10 ) }}{{ strlen(strip_tags($fol_val->username)) > 4 ? "..." : ""  }}
                                    </div>
                                    <div class="user-more">
                                        {{--Hello you there?--}}
                                    </div>
                                </div>
                                <div class="user-details-status-wrapper">
                                    <span class="badge badge-important"></span>
                                </div>
                                <div class="user-details-count-wrapper">
                                    <div id="{{$fol_val->id}}" title="Status" class="status-icon chat_online_icon red"></div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        @endforeach

                        @if(isset($room_id))
                            <hr>

                            <div class="user-details-wrapper open_group_mess_area active" id="{{$room_id}}" data-chat-status="online"
                                 data-chat-user-pic="{{ Request::root() }}/assets/images/{{$movie->poster}}"
                                 data-chat-user-pic-retina="{{ Request::root() }}/assets/img/profiles/d2x.jpg"
                                 data-user-name="{{$movie->title}}">
                                <div class="user-profile">
                                    <img src="{{ Request::root() }}/assets/images/{{$movie->poster}}" alt=""
                                         data-src="{{ Request::root() }}/assets/images/{{$movie->poster}}"
                                         data-src-retina="{{ Request::root() }}/assets/img/profiles/d2x.jpg" width="35"
                                         height="35">
                                </div>
                                <div class="user-details">
                                    <div class="user-name">
                                        {{$movie->title}}
                                    </div>
                                    <div class="user-more">
                                        Movie group chat
                                    </div>
                                </div>
                                <div class="user-details-status-wrapper">
                                    <span class="badge badge-important"></span>
                                </div>
                                <div class="user-details-count-wrapper">
                                    <div title="Status" class="status-icon green"></div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        @endif


                        {{--<div class="user-details-wrapper" data-chat-status="busy"--}}
                        {{--data-chat-user-pic="{{ Request::root() }}/assets/img/profiles/d.jpg"--}}
                        {{--data-chat-user-pic-retina="{{ Request::root() }}/assets/img/profiles/d2x.jpg"--}}
                        {{--data-user-name="David Nester">--}}
                        {{--<div class="user-profile">--}}
                        {{--<img src="{{ Request::root() }}/assets/img/profiles/c.jpg" alt=""--}}
                        {{--data-src="{{ Request::root() }}/assets/img/profiles/c.jpg"--}}
                        {{--data-src-retina="{{ Request::root() }}/assets/img/profiles/c2x.jpg" width="35" height="35">--}}
                        {{--</div>--}}
                        {{--<div class="user-details">--}}
                        {{--<div class="user-name">--}}
                        {{--David Nester--}}
                        {{--</div>--}}
                        {{--<div class="user-more">--}}
                        {{--Busy, Do not disturb--}}
                        {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="user-details-status-wrapper">--}}
                        {{--<div class="clearfix"></div>--}}
                        {{--</div>--}}
                        {{--<div class="user-details-count-wrapper">--}}
                        {{--<div class="status-icon red"></div>--}}
                        {{--</div>--}}
                        {{--<div class="clearfix"></div>--}}
                        {{--</div>--}}


                    </div>
                </div>
            </div>
            {{--<div class="side-widget">--}}
            {{--<div class="side-widget-title">more friends</div>--}}
            {{--<div class="side-widget-content" id="friends-list">--}}


            {{--<div class="user-details-wrapper" data-chat-status="online" data-chat-user-pic="{{ Request::root() }}/assets/img/profiles/d.jpg" data-chat-user-pic-retina="{{ Request::root() }}/assets/img/profiles/d2x.jpg" data-user-name="Jane Smith">--}}
            {{--<div class="user-profile">--}}
            {{--<img src="{{ Request::root() }}/assets/img/profiles/d.jpg" alt="" data-src="{{ Request::root() }}/assets/img/profiles/d.jpg" data-src-retina="{{ Request::root() }}/assets/img/profiles/d2x.jpg" width="35" height="35">--}}
            {{--</div>--}}
            {{--<div class="user-details">--}}
            {{--<div class="user-name">--}}
            {{--Jane Smith--}}
            {{--</div>--}}
            {{--<div class="user-more">--}}
            {{--Hello you there?--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--<div class="user-details-status-wrapper">--}}
            {{--</div>--}}
            {{--<div class="user-details-count-wrapper">--}}
            {{--<div class="status-icon green"></div>--}}
            {{--</div>--}}
            {{--<div class="clearfix"></div>--}}
            {{--</div>--}}
            {{--<div class="user-details-wrapper" data-chat-status="busy" data-chat-user-pic="{{ Request::root() }}/assets/img/profiles/d.jpg" data-chat-user-pic-retina="{{ Request::root() }}/assets/img/profiles/d2x.jpg" data-user-name="David Nester">--}}
            {{--<div class="user-profile">--}}
            {{--<img src="{{ Request::root() }}/assets/img/profiles/h.jpg" alt="" data-src="{{ Request::root() }}/assets/img/profiles/h.jpg" data-src-retina="{{ Request::root() }}/assets/img/profiles/h2x.jpg" width="35" height="35">--}}
            {{--</div>--}}
            {{--<div class="user-details">--}}
            {{--<div class="user-name">--}}
            {{--David Nester--}}
            {{--</div>--}}
            {{--<div class="user-more">--}}
            {{--Busy, Do not disturb--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--<div class="user-details-status-wrapper">--}}
            {{--<div class="clearfix"></div>--}}
            {{--</div>--}}
            {{--<div class="user-details-count-wrapper">--}}
            {{--<div class="status-icon red"></div>--}}
            {{--</div>--}}
            {{--<div class="clearfix"></div>--}}
            {{--</div>--}}




            {{--<div class="user-details-wrapper" data-chat-status="online" data-chat-user-pic="{{ Request::root() }}/assets/img/profiles/d.jpg" data-chat-user-pic-retina="{{ Request::root() }}/assets/img/profiles/d2x.jpg" data-user-name="Jane Smith">--}}
            {{--<div class="user-profile">--}}
            {{--<img src="{{ Request::root() }}/assets/img/profiles/c.jpg" alt="" data-src="{{ Request::root() }}/assets/img/profiles/c.jpg" data-src-retina="{{ Request::root() }}/assets/img/profiles/c2x.jpg" width="35" height="35">--}}
            {{--</div>--}}
            {{--<div class="user-details">--}}
            {{--<div class="user-name">--}}
            {{--Jane Smith--}}
            {{--</div>--}}
            {{--<div class="user-more">--}}
            {{--Hello you there?--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--<div class="user-details-status-wrapper">--}}
            {{--</div>--}}
            {{--<div class="user-details-count-wrapper">--}}
            {{--<div class="status-icon green"></div>--}}
            {{--</div>--}}
            {{--<div class="clearfix"></div>--}}
            {{--</div>--}}
            {{--<div class="user-details-wrapper" data-chat-status="busy" data-chat-user-pic="{{ Request::root() }}/assets/img/profiles/d.jpg" data-chat-user-pic-retina="{{ Request::root() }}/assets/img/profiles/d2x.jpg" data-user-name="David Nester">--}}
            {{--<div class="user-profile">--}}
            {{--<img src="{{ Request::root() }}/assets/img/profiles/h.jpg" alt="" data-src="{{ Request::root() }}/assets/img/profiles/h.jpg" data-src-retina="{{ Request::root() }}/assets/img/profiles/h2x.jpg" width="35" height="35">--}}
            {{--</div>--}}
            {{--<div class="user-details">--}}
            {{--<div class="user-name">--}}
            {{--David Nester--}}
            {{--</div>--}}
            {{--<div class="user-more">--}}
            {{--Busy, Do not disturb--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--<div class="user-details-status-wrapper">--}}
            {{--<div class="clearfix"></div>--}}
            {{--</div>--}}
            {{--<div class="user-details-count-wrapper">--}}
            {{--<div class="status-icon red"></div>--}}
            {{--</div>--}}
            {{--<div class="clearfix"></div>--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--</div>--}}
        </div>


        <div class="chat-window-wrapper" id="messages-wrapper" style="display:none">
            <div class="chat-header">
                <div class="pull-right" style="padding-right: 15px;">
                    <a href="#" class="">
                        <div class="iconset top-settings-dark "></div>
                    </a>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="chat-messages-header">
                <div class="status online"></div>
                <span class="semi-bold">Jane Smith(Typing..)</span>
                <a href="#" class="chat-back"><i class="icon-custom-cross"></i></a>
            </div>
            <div class="chat-messages scrollbar-dynamic clearfix">


                <div class="inner-scroll-content clearfix chat_mess_area">



                    <div class="sent_time">Yesterday 11:25pm</div>

                    <div class="user-details-wrapper ">
                        <div class="user-profile">
                            <img src="{{ Request::root() }}/assets/img/profiles/d.jpg" alt=""
                                 data-src="{{ Request::root() }}/assets/img/profiles/d.jpg"
                                 data-src-retina="{{ Request::root() }}/assets/img/profiles/d2x.jpg" width="35"
                                 height="35">
                        </div>
                        <div class="user-details">
                            <div class="bubble">
                                Hello, You there?
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="sent_time off">Yesterday 11:25pm</div>
                    </div>

                    <div class="user-details-wrapper ">
                        <div class="user-profile">
                            <img src="{{ Request::root() }}/assets/img/profiles/d.jpg" alt=""
                                 data-src="{{ Request::root() }}/assets/img/profiles/d.jpg"
                                 data-src-retina="{{ Request::root() }}/assets/img/profiles/d2x.jpg" width="35"
                                 height="35">
                        </div>
                        <div class="user-details">
                            <div class="bubble">
                                How was the meeting?
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="sent_time off">Yesterday 11:25pm</div>
                    </div>


                    <div class="user-details-wrapper ">
                        <div class="user-profile">
                            <img src="{{ Request::root() }}/assets/img/profiles/d.jpg" alt=""
                                 data-src="{{ Request::root() }}/assets/img/profiles/d.jpg"
                                 data-src-retina="{{ Request::root() }}/assets/img/profiles/d2x.jpg" width="35"
                                 height="35">
                        </div>
                        <div class="user-details">
                            <div class="bubble">
                                Let me know when you free
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="sent_time off">Yesterday 11:25pm</div>
                    </div>


                    <div class="sent_time ">Today 11:25pm</div>


                    <div class="user-details-wrapper pull-right">

                        <div class="user-details">

                            <div class="bubble sender">

                                Let me know when you free
                            </div>

                        </div>

                        <div class="clearfix"></div>

                        <div class="sent_time off">Sent On Tue, 2:45pm</div>

                    </div>

                </div>




            </div>
            <div class="chat-input-wrapper" style="display:none">
                <textarea class="form-control myTest" data-emojiable="true" data-emoji-input="unicode" data-usid data-room-id id="chat-message-input" rows="1" placeholder="Type your message"></textarea>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
<!-- END CHAT -->


@push('javascriptChat')
    <script src="{{ Request::root() }}/lib/js/config.js"></script>
    <script src="{{ Request::root() }}/lib/js/util.js"></script>
    <script src="{{ Request::root() }}/lib/js/jquery.emojiarea.js"></script>
    <script src="{{ Request::root() }}/lib/js/emoji-picker.js"></script>
    <script>
        $(function() {
            // Initializes and creates emoji set from sprite sheet
            window.emojiPicker = new EmojiPicker({
                emojiable_selector: '[data-emojiable=true]',
                assetsPath: '{{ Request::root() }}/lib/img/',
                popupButtonClasses: 'fa fa-smile-o'
            });
            // Finds all elements with `emojiable_selector` and converts them to rich emoji input fields
            // You may want to delay this step if you have dynamically created input fields that appear later in the loading process
            // It can be called as many times as necessary; previously converted input fields will not be converted again
            window.emojiPicker.discover();
        });

        $(function(){
            $(".emoji-wysiwyg-editor").keypress(function (event) {
                var $this_tag = $('#chat-message-input');
                if (event.keyCode == 13) {
//
                    var u_mess = $(this).text();
                    var u_to_id = $this_tag.attr('data-usid');
                    var room_id = $this_tag.attr('data-room-id');
//
                    if(room_id){
                        if(u_mess != ''){
                            socket.emit('chat room message', { f_b: u_mess, u_from_id:sio_u_id, room_id:room_id, sio_u_username:sio_u_username, sio_u_avatar: sio_u_avatar });
                            send_message($(this).text());
                        }
                    }
                    else{
                        if(u_mess != ''){
                            socket.emit('chat message', { f_b: u_mess, u_to_id:u_to_id, u_from_id:sio_u_id, sio_u_username:sio_u_username, sio_u_avatar: sio_u_avatar });
                            send_message($(this).text());
                        }
                    }
                    if(user_chat_history == 0) {
                        $('.chat_mess_area .user-details-wrapper').delay(5000).fadeOut(400);
                    }
                    $(this).text("");
                    event.preventDefault();
                }

            });
        });

    </script>

@endpush



                      