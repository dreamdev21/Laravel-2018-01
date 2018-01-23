/* Webarch Admin Dashboard 
-----------------------------------------------------------------*/
var socket = io.connect(baseurl + ':3000');
var not_area_count;
var seenInterval_ = false;
    $(document).ready(function() {


     if($( window ).width() < 1024){
         not_area_count = 2;
     }
     else{
         not_area_count = 3;
     }

     $(window).resize(function(){
         if($( window ).width()  < 1024){
             not_area_count = 2;
         }
         else{
             not_area_count = 3;
         }
     });

    //change this sio_u_avatar:'http://tv.loc/assets/img/profiles/d.jpg' TO     sio_u_avatar:sio_u_avatar
    socket.emit('join', {sio_u_id: sio_u_id, sio_u_username:sio_u_username, sio_u_avatar: sio_u_avatar});
    socket.emit('get fr rent', {user_fr_list: user_fr_list});
    socket.emit('get chat unseen mess', {user_fr_list: user_fr_list, sio_u_id: sio_u_id});

    socket.on('red ses', function(data){
        window.location.href = "/logout";
    });

	var conversation = [];
	$('.user-details-wrapper').click(function(){
			set_user_details($(this).attr('data-user-name'),$(this).attr('data-chat-status'));
            var el = $('#messages-wrapper').parent('.scroll-content').show();
            if(el.length > 0){
                $('#chat-users').parent().hide(); 
                $('#messages-wrapper').parent('.scroll-content').show();  
            }
            else{
                 $('#chat-users').hide();
            }
            $('#messages-wrapper').show(); 
			$('.chat-input-wrapper').show();
	})
	
	$('.chat-back').click(function(){
			$('#messages-wrapper .chat-messages-header .status').removeClass('online');
			$('#messages-wrapper .chat-messages-header .status').removeClass('busy');
            var el = $('#messages-wrapper').parent('.scroll-content').show();
            if(el.length > 0){
                $('#chat-users').parent().show(); 
                $('#messages-wrapper').parent('.scroll-content').hide();  
            }
            else{
                 $('#chat-users').show();
            }
            $('#messages-wrapper').hide(); 
			$('.chat-input-wrapper').hide();
	});
	$('.bubble').click(function(){
		$(this).parent().parent('.user-details-wrapper').children('.sent_time').slideToggle();
	});

	 // $('#chat-message-input').keypress(function(e){
		// if(e.keyCode == 13)
		// {
		// 	var u_mess = $(this).val();
		// 	var u_to_id = $(this).attr('data-usid');
      //       var room_id = $(this).attr('data-room-id');
     //
      //       if(room_id){
      //           if(u_mess != ''){
      //               socket.emit('chat room message', { f_b: u_mess, u_from_id:sio_u_id, room_id:room_id, sio_u_username:sio_u_username, sio_u_avatar: sio_u_avatar });
      //               send_message($(this).val());
      //           }
      //       }
      //       else{
      //           if(u_mess != ''){
      //               socket.emit('chat message', { f_b: u_mess, u_to_id:u_to_id, u_from_id:sio_u_id, sio_u_username:sio_u_username, sio_u_avatar: sio_u_avatar });
      //               send_message($(this).val());
      //           }
      //       }
      //       if(user_chat_history == 0) {
      //           $('.chat_mess_area .user-details-wrapper').delay(5000).fadeOut(400);
      //       }
      //       // console.log();
		// 	$(this).val("");
		// 	$(this).focus();
      //       e.preventDefault();
		// }
	 // });
    $('#chat-users').scrollbar({
        ignoreMobile:true
    });
    $('.chat-messages').scrollbar({
        ignoreMobile:true
    });

    var fupic;
    var fid;
    $('.open_mess_area').click(function(){

        $(this).find('.user-details-status-wrapper').find('.badge').text('');

    	$('.chat_mess_area').empty();

    	fid = $(this).attr('id');
    	fupic = $(this).attr('data-chat-user-pic');

    	$('#chat-message-input').val('');
        $('#chat-message-input').attr('data-room-id', '');
        $('#chat-message-input').attr('data-usid', fid);

        socket.emit('get chat message', { u_from_id: sio_u_id, u_to_id:fid });

        if(seenInterval_ != false){
            clearInterval(seenInterval_);
            seenInterval_ = false;
        }

        seenInterval_ = setInterval(function(){
            socket.emit('seen mess', { u_from_id: sio_u_id, u_to_id:fid });
        },3000);

    	return false;

	});

    $('.chat-back').click(function(){
        if(seenInterval_ != false){
            clearInterval(seenInterval_);
            seenInterval_ = false;
        }
    });

    $('.open_group_mess_area').click(function(){

    	$('.chat_mess_area').empty();

        fid = $(this).attr('id');
    	fupic = $(this).attr('data-chat-user-pic');

    	$('#chat-message-input').val('');
        $('#chat-message-input').attr('data-usid', '');
        $('#chat-message-input').attr('data-room-id', fid);

        socket.emit('get room chat message', { room_id:fid });

    	return false;

	});

    socket.on('rent inv', function (data) {
    	if($( ".follow_not_area .follow_not_area_noti" ).length >= not_area_count){
            $( ".follow_not_area .follow_not_area_noti" )[0].remove();
		}

        $('.follow_not_area').append(
            '<div class="follow_not_area_noti col-lg-4 col-sm-6 col-xs-6">' +
            '<div class="notification-messages info">' +
            '<div class="user-profile">' +
            '<a href="/users/'+data.u_rent_username+'"><img src="/assets/images/'+data.u_rent_avatar+'" alt="" data-src="/assets/images/'+data.u_rent_avatar+'" data-src-retina="/assets/images/'+data.u_rent_avatar+'" width="35" height="35"></a>' +
            '</div>' +
            '<div class="message-wrapper" style="width: 45%">' +
            '<div class="heading"> '+data.u_rent_username+
            '</div>' +
            '<div class="description fs-15"> Rented a movie '+data.u_movie_title+
            '</div>' +
            '<div data-itime="'+data.date+'" class="date pull-left r_inv_time">' + timeDifference( new Date(data.date)) +
            '</div>' +
            '</div>' +
            '<div class="clearfix"></div>' +
            '</div>' +
            '</div>'
        );

	});

    socket.on('follow inv you', function (itemires) {

        if($( ".follow_not_area .follow_not_area_noti" ).length >= not_area_count){
            $( ".follow_not_area .follow_not_area_noti" )[0].remove();
        }


        $.ajax({
            type: 'post',
            url: '/users/check_follow',
            data: {
                from_id: itemires.from_u_id,
                '_token': Laravel.csrfToken
            },
            success: function(res){
                if(res == 0 && itemires.from_u_id != 1){
                    $('.follow_not_area').append(
                        '<div class="follow_not_area_noti col-lg-4 col-sm-6 col-xs-6">' +
                        '<div class="notification-messages info">' +
                        '<div class="user-profile">' +
                        '<a href="/users/'+itemires.from_u_username+'"><img src="/assets/images/'+itemires.from_u_avatar+'" alt="" data-src="/assets/images/'+itemires.from_u_avatar+'" data-src-retina="/assets/images/'+itemires.from_u_avatar+'" width="35" height="35"></a>' +
                        '</div>' +
                        '<div class="message-wrapper" style="width: 45%">' +
                        '<div class="heading"> '+itemires.from_u_username +
                        ' <a href="/users/'+itemires.from_u_id+'/follow_byid" class="btn btn-danger" style="padding: 0 5px;"> Follow</a>'+
                        '</div>' +
                        '<div class="description fs-15"> Started following you' +
                        '</div>' +
                        '<div data-itime="'+itemires.date+'" class="date pull-left r_inv_time">' + timeDifference( new Date(itemires.date)) +
                        '</div>' +
                        '</div>' +
                        '<div class="clearfix"></div>' +
                        '</div>' +
                        '</div>'
                    );
                }
                else{
                    $('.follow_not_area').append(
                        '<div class="follow_not_area_noti col-lg-4 col-sm-6 col-xs-6">' +
                        '<div class="notification-messages info">' +
                        '<div class="user-profile">' +
                        '<a href="/users/'+itemires.from_u_username+'"><img src="/assets/images/'+itemires.from_u_avatar+'" alt="" data-src="/assets/images/'+itemires.from_u_avatar+'" data-src-retina="/assets/images/'+itemires.from_u_avatar+'" width="35" height="35"></a>' +
                        '</div>' +
                        '<div class="message-wrapper" style="width: 45%">' +
                        '<div class="heading"> '+itemires.from_u_username +
                        '</div>' +
                        '<div class="description fs-15"> Started following you' +
                        '</div>' +
                        '<div data-itime="'+itemires.date+'" class="date pull-left r_inv_time">' + timeDifference( new Date(itemires.date)) +
                        '</div>' +
                        '</div>' +
                        '<div class="clearfix"></div>' +
                        '</div>' +
                        '</div>'
                    );
                }

            }
        });


    });

    socket.on('follow inv', function (itemires) {

    	if($( ".follow_not_area .follow_not_area_noti" ).length >= not_area_count){
            $( ".follow_not_area .follow_not_area_noti" )[0].remove();
		}


        if(sio_u_id != itemires.to_u_id){
            $('.follow_not_area').append(
                '<div class="follow_not_area_noti col-lg-4 col-sm-6 col-xs-6">' +
                '<div class="notification-messages info">' +
                '<div class="user-profile">' +
                '<a href="/users/'+itemires.from_u_username+'"><img src="/assets/images/'+itemires.from_u_avatar+'" alt="" data-src="/assets/images/'+itemires.from_u_avatar+'" data-src-retina="/assets/images/'+itemires.from_u_avatar+'" width="35" height="35"> </a>' +
                '</div>' +
                '<div class="message-wrapper" style="width: 45%">' +
                '<div class="heading"> '+itemires.from_u_username+
                '</div>' +
                '<div class="description fs-15"> Started following "'+itemires.to_u_username+'"'+
                '</div>' +
                '<div data-itime="'+itemires.date+'" class="date pull-left r_inv_time">' + timeDifference( new Date(itemires.date)) +
                '</div>' +
                '</div>' +
                '<div class="clearfix"></div>' +
                '</div>' +
                '</div>'
            );
        }


	});




	socket.on('get fr rent', function (data) {
	    if(localStorage.getItem('noty_area')){
	        return false;
        }

		var gfr = [];

        data.get_fr_rent.forEach(function(itemi){

            for (var key in itemi) {
                gfr.push(itemi[key])
            }

		});
        function compare(a,b) {
            if (a.date < b.date)
                return -1;
            if (a.date > b.date)
                return 1;
            return 0;
        }

        gfr.sort(compare);
        if(gfr.length > not_area_count){
            gfr = gfr.slice(Math.max(gfr.length - not_area_count, 1));
		}

        $('.follow_not_area').empty();

        gfr.forEach(function(itemires){

        	if(itemires.event == 'rent'){
				$('.follow_not_area').append(
					'<div class="follow_not_area_noti col-lg-4 col-sm-6 col-xs-6">' +
					'<div class="notification-messages info">' +
					'<div class="user-profile">' +
					'<a href="/users/'+itemires.u_rent_username+'"><img src="/assets/images/'+itemires.u_rent_avatar+'" alt="" data-src="/assets/images/'+itemires.u_rent_avatar+'" data-src-retina="/assets/images/'+itemires.u_rent_avatar+'" width="35" height="35"></a>' +
					'</div>' +
					'<div class="message-wrapper" style="width: 45%">' +
					'<div class="heading"> '+itemires.u_rent_username+
					'</div>' +
					'<div class="description fs-15"> Rented a movie '+itemires.u_movie_title+
					'</div>' +
					'<div data-itime="'+itemires.date+'" class="date pull-left r_inv_time">' + timeDifference( new Date(itemires.date)) +
					'</div>' +
					'</div>' +
					'<div class="clearfix"></div>' +
					'</div>' +
					'</div>'
				);
            }

            if(itemires.event == 'follow'){

        		if(sio_u_id != itemires.to_u_id){
                    $('.follow_not_area').append(
                        '<div class="follow_not_area_noti col-lg-4 col-sm-6 col-xs-6">' +
                        '<div class="notification-messages info">' +
                        '<div class="user-profile">' +
                        '<a href="/users/'+itemires.from_u_username+'"><img src="/assets/images/'+itemires.from_u_avatar+'" alt="" data-src="/assets/images/'+itemires.from_u_avatar+'" data-src-retina="/assets/images/'+itemires.from_u_avatar+'" width="35" height="35"></a>' +
                        '</div>' +
                        '<div class="message-wrapper" style="width: 45%">' +
                        '<div class="heading"> '+itemires.from_u_username+
                        '</div>' +
                        '<div class="description fs-15"> Started following "'+itemires.to_u_username+'"'+
                        '</div>' +
                        '<div data-itime="'+itemires.date+'" class="date pull-left r_inv_time">' + timeDifference( new Date(itemires.date)) +
                        '</div>' +
                        '</div>' +
                        '<div class="clearfix"></div>' +
                        '</div>' +
                        '</div>'
                    );
				}
				else{

                    $('.follow_not_area').append(
                        '<div class="follow_not_area_noti col-lg-4 col-sm-6 col-xs-6">' +
                        '<div class="notification-messages info">' +
                        '<div class="user-profile">' +
                        '<a href="/users/'+itemires.from_u_username+'"><img src="/assets/images/'+itemires.from_u_avatar+'" alt="" data-src="/assets/images/'+itemires.from_u_avatar+'" data-src-retina="/assets/images/'+itemires.from_u_avatar+'" width="35" height="35"></a>' +
                        '</div>' +
                        '<div class="message-wrapper" style="width: 45%">' +
                        '<div class="heading"> '+itemires.from_u_username+
                        '</div>' +
                        '<div class="description fs-15"> Started following you'+
                        '</div>' +
                        '<div data-itime="'+itemires.date+'" class="date pull-left r_inv_time">' + timeDifference( new Date(itemires.date)) +
                        '</div>' +
                        '</div>' +
                        '<div class="clearfix"></div>' +
                        '</div>' +
                        '</div>'
                    );
				}
            }


            if(itemires.event == 'coplay'){
                if(sio_u_id != itemires.to_u_id){


                    $('.follow_not_area').append(
                        '<div class="follow_not_area_noti col-lg-4 col-sm-6 col-xs-6">' +
                        '<div class="notification-messages info">' +
                        '<div class="user-profile">' +
                        '<a href="/users/'+itemires.from_u_username+'"><img src="/assets/images/'+itemires.from_u_avatar+'" alt="" data-src="/assets/images/'+itemires.from_u_avatar+'" data-src-retina="/assets/images/'+itemires.from_u_avatar+'" width="35" height="35"></a>' +
                        '</div>' +
                        '<div class="message-wrapper" style="width: 45%">' +
                        '<div class="heading"> '+itemires.from_u_username+
                        '</div>' +
                        '<div class="description fs-15"> has invited you to see '+itemires.movie_title+
                        '</div>' +
                        '<div data-itime="'+itemires.date+'" class="date pull-left r_inv_time">' + timeDifference( new Date(itemires.date)) +
                        '</div>' +
                        '</div>' +
                        '<div class="clearfix"></div>' +
                        '</div>' +
                        '</div>'
                    );

                }
                else{
                    $('.follow_not_area').append(
                        '<div class="follow_not_area_noti col-lg-4 col-sm-6 col-xs-6">' +
                        '<div class="notification-messages info">' +
                        '<div class="user-profile">' +
                        '<a href="/users/'+itemires.from_u_username+'"><img src="/assets/images/'+itemires.from_u_avatar+'" alt="" data-src="/assets/images/'+itemires.from_u_avatar+'" data-src-retina="/assets/images/'+itemires.from_u_avatar+'" width="35" height="35"></a>' +
                        '</div>' +
                        '<div class="message-wrapper" style="width: 45%">' +
                        '<div class="heading"> '+itemires.from_u_username+
                        '</div>' +
                        '<div class="description fs-15"> invited '+itemires.to_u_username+' to see '+itemires.movie_title+
                        '</div>' +
                        '<div data-itime="'+itemires.date+'" class="date pull-left r_inv_time">' + timeDifference( new Date(itemires.date)) +
                        '</div>' +
                        '</div>' +
                        '<div class="clearfix"></div>' +
                        '</div>' +
                        '</div>'
                    );

                }

            }

        });

	});


    socket.on('coplay inv', function (data) {


        if($( ".follow_not_area .follow_not_area_noti" ).length >= not_area_count){
            $( ".follow_not_area .follow_not_area_noti" )[0].remove();
        }

        $('.top_notif_text').text(data.from_u_username+' has invited you to see '+data.movie_title);

        $("a").attr("href", "/movies/"+data.movie_slug+"/play");

        $('.top-notif, .cta.show').toggleClass('hidden');


    });


	socket.on('get chat message', function (data) {

		data.messages.forEach(function(item) {
		    if(user_chat_history==0){
                if(item.sow == 0){
                    if(item.from_id != sio_u_id){
                        $('.chat_mess_area').append(
                            '<div class="user-details-wrapper ">' +
                            '<div class="user-profile">' +
                            '<img src="/assets/images/'+item.from_avatar+'" alt="" data-src="/assets/images/'+item.from_avatar+'" data-src-retina="/assets/images/'+item.from_avatar+'" width="35" height="35">' +
                            '</div>' +
                            '<div class="user-details">' +
                            '<div class="bubble">'+ item.mess +
                            '</div>' +
                            '</div>' +
                            '<div class="clearfix"></div>' +
                            '<div class="sent_time off"></div>' +
                            '</div>'
                        );
                    }
                    else{
                        $('.chat_mess_area').append(
                            '<div class="user-details-wrapper pull-right">' +
                            '<div class="user-details">' +
                            '<div class="bubble sender">'+ item.mess +
                            '</div>' +
                            '</div>' +
                            '<div class="clearfix"></div>' +
                            '<div class="sent_time off"></div>' +
                            '</div>'
                        );
                    }
                    $('.chat_mess_area .user-details-wrapper').delay(10000).fadeOut(400);

                }else{
                    if((Math.round( new Date().getTime()/1000) - item.date/1000) < 10){
                        if(item.from_id != sio_u_id){
                            $('.chat_mess_area').append(
                                '<div class="user-details-wrapper ">' +
                                '<div class="user-profile">' +
                                '<img src="/assets/images/'+item.from_avatar+'" alt="" data-src="/assets/images/'+item.from_avatar+'" data-src-retina="/assets/images/'+item.from_avatar+'" width="35" height="35">' +
                                '</div>' +
                                '<div class="user-details">' +
                                '<div class="bubble">'+ item.mess +
                                '</div>' +
                                '</div>' +
                                '<div class="clearfix"></div>' +
                                '<div class="sent_time off"></div>' +
                                '</div>'
                            );
                        }
                        else{

                            $('.chat_mess_area').append(
                                '<div class="user-details-wrapper pull-right">' +
                                '<div class="user-details">' +
                                '<div class="bubble sender">'+ item.mess +
                                '</div>' +
                                '</div>' +
                                '<div class="clearfix"></div>' +
                                '<div class="sent_time off"></div>' +
                                '</div>'
                            );
                        }
                    }

                    $('.chat_mess_area .user-details-wrapper').delay(5000).fadeOut(400);
                }
            }else{
                if(item.sow == 0){
                    if(item.from_id != sio_u_id){
                        $('.chat_mess_area').append(
                            '<div class="user-details-wrapper ">' +
                            '<div class="user-profile">' +
                            '<img src="/assets/images/'+item.from_avatar+'" alt="" data-src="/assets/images/'+item.from_avatar+'" data-src-retina="/assets/images/'+item.from_avatar+'" width="35" height="35">' +
                            '</div>' +
                            '<div class="user-details">' +
                            '<div class="bubble">'+ item.mess +
                            '</div>' +
                            '</div>' +
                            '<div class="clearfix"></div>' +
                            '<div class="sent_time off"></div>' +
                            '</div>'
                        );
                    }
                    else{
                        $('.chat_mess_area').append(
                            '<div class="user-details-wrapper pull-right">' +
                            '<div class="user-details">' +
                            '<div class="bubble sender">'+ item.mess +
                            '</div>' +
                            '</div>' +
                            '<div class="clearfix"></div>' +
                            '<div class="sent_time off"></div>' +
                            '</div>'
                        );
                    }
                }else{

                    if(item.from_id != sio_u_id){
                        $('.chat_mess_area').append(
                            '<div class="user-details-wrapper ">' +
                            '<div class="user-profile">' +
                            '<img src="/assets/images/'+item.from_avatar+'" alt="" data-src="/assets/images/'+item.from_avatar+'" data-src-retina="/assets/images/'+item.from_avatar+'" width="35" height="35">' +
                            '</div>' +
                            '<div class="user-details">' +
                            '<div class="bubble">'+ item.mess +
                            '</div>' +
                            '</div>' +
                            '<div class="clearfix"></div>' +
                            '<div class="sent_time off"></div>' +
                            '</div>'
                        );
                    }
                    else{

                        $('.chat_mess_area').append(
                            '<div class="user-details-wrapper pull-right">' +
                            '<div class="user-details">' +
                            '<div class="bubble sender">'+ item.mess +
                            '</div>' +
                            '</div>' +
                            '<div class="clearfix"></div>' +
                            '<div class="sent_time off"></div>' +
                            '</div>'
                        );
                    }

                }
            }

		});
		$(".chat-messages").scrollTop(9999999999999999999);
	});

	socket.on('chat message', function (data) {

        $('.chat_mess_area').append(
			'<div class="user-details-wrapper ">' +
			'<div class="user-profile">' +
			'<img src="/assets/images/'+data.from_avatar+'" alt="" data-src="/assets/images/'+data.from_avatar+'" data-src-retina="http://tv.loc/assets/img/profiles/d2x.jpg" width="35" height="35">' +
			'</div>' +
			'<div class="user-details">' +
			'<div class="bubble">'+ data.mess +
			'</div>' +
			'</div>' +
			'<div class="clearfix"></div>' +
			'<div class="sent_time off"></div>' +
			'</div>'
		);

		$('.open_mess_area').each(function(){
		    if($(this).attr('id') == data.mess_from){
		        var badge_us = $(this).find('.user-details-status-wrapper').find('.badge');

		        if(badge_us.text() == ''){
                    badge_us.text(1);
                }
                else{
                    badge_us.text(parseInt(badge_us.text()) + 1);
                }

            }
        });

		$('.chat_m_noty_t').text(data.from_username);
		$('.chat_m_noty_d').text(data.mess);
		$('.chat_m_noty').fadeIn();
		setTimeout(function(){
            $('.chat_m_noty').fadeOut();
        },3000)


        if(user_chat_history == 0){
            $('.chat_mess_area .user-details-wrapper').delay(5000).fadeOut(400);
        }

		$(".chat-messages").scrollTop(9999999999999999999);

	});


	socket.on('get chat unseen mess', function (data) {

        Object.keys(data.unseen).forEach(function (key) {

            $('.open_mess_area').each(function(){
               if($(this).attr('id') == key){
                   var badge_us = $(this).find('.user-details-status-wrapper').find('.badge');

                   if(data.unseen[key].length != 0){
                       badge_us.text(data.unseen[key].length);
                   }

                }
            });

        });



	});


	socket.on('online', function (data){
		$('.chat_online_icon').removeClass('green');
		for(var k in data.sio_online_users){
			$('.chat_online_icon').each(function(item){
				if($(this).attr('id') == data.sio_online_users[k]){
					$(this).addClass('green');
				}
			});
		}
	});

    if(typeof room_id != 'undefined'){
        socket.on('video room res', function (data){
            $('.div_onl_users_area').empty();
            $.each(data.sio_vid_room[room_id], function(index, value) {
                if(value.id != sio_u_id){
                    $('.div_onl_users_area').append(
                        '<img src="/assets/images/'+value.avatar+'" alt="" title="'+value.username+'" class="div_onl_users_img">'
                    );
                }
            });

        });
    }

    function timeDifference(previous) {

        var current = new Date().getTime();

        var msPerMinute = 60 * 1000;
        var msPerHour = msPerMinute * 60;
        var msPerDay = msPerHour * 24;
        var msPerMonth = msPerDay * 30;
        var msPerYear = msPerDay * 365;

        var elapsed = current - previous;

        if (elapsed < msPerHour) {
            if(Math.round(elapsed/msPerMinute) == 0){
                return 'now';
            }
            return Math.round(elapsed/msPerMinute) + ' minutes ago';
        }

        else if (elapsed < msPerDay ) {
            return Math.round(elapsed/msPerHour ) + ' hours ago';
        }

        else if (elapsed < msPerMonth) {
            return Math.round(elapsed/msPerDay) + ' days ago';
        }

        else if (elapsed < msPerYear) {
            return Math.round(elapsed/msPerMonth) + ' months ago';
        }

        else {
            return Math.round(elapsed/msPerYear ) + ' years ago';
        }
    }


    setTimeout(function(){
        setInterval(function(){
            var all_upd_noti_time = $('.r_inv_time');
            all_upd_noti_time.each(function(){
                $(this).text(timeDifference( new Date($(this).data('itime'))));
            })
        }, 5000)
    }, 5000)



});

	function set_user_details(username,status){
		$('#messages-wrapper .chat-messages-header .status').addClass(status);
		$('#messages-wrapper .chat-messages-header span').text(username);
	}	
	function build_conversation(msg,isOpponent,img,retina){
		if(isOpponent==1){
			$('.chat_mess_area').append('<div class="user-details-wrapper">'+
				'<div class="user-details">'+
					'<div class="user-profile">'+
					'<img src="'+ img +'"  alt="" data-src="'+ img +'" data-src-retina="'+ retina +'" width="35" height="35">'+
					'</div>'+
				  '<div class="bubble old sender">'+	
						msg+
				   '</div>'+
				'</div>'+				
				'<div class="clearfix"></div>'+
			'</div>');		
		}
		else{
		$('.chat_mess_area').append('<div class="user-details-wrapper pull-right">'+
			'<div class="user-details">'+
			  '<div class="bubble old sender">'+	
					msg+
			   '</div>'+
			'</div>'+				
			'<div class="clearfix"></div>'+
		'</div>')
		}
	}

	function send_message(msg){
		$('.chat_mess_area').append('<div class="user-details-wrapper pull-right animated fadeIn">'+
			'<div class="user-details">'+
			  '<div class="bubble old sender">'+	
					msg+
			   '</div>'+
			'</div>'+				
			'<div class="clearfix"></div>'+
		'</div>');
        $(".chat-messages").scrollTop(9999999999999999999);
	}


//TOP NOTIFI..

//CLOSE
$('.reject_top_notif').on('click', function () {
    $('.top-notif, .cta.show').toggleClass('hidden')
});

if(typeof room_id != 'undefined'){
    setInterval(function(){
        socket.emit('join video room', {room_id:room_id, sio_u_id: sio_u_id, sio_u_username:sio_u_username, sio_u_avatar: sio_u_avatar});
    },2000);
}


