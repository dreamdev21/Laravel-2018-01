    $('.accept_cookie').click(function(){
        $.ajax({
            type: 'post',
            url: '/accept_cookie',
            data: {
                rem: 1,
                '_token': Laravel.csrfToken
            },
            success: function(){
                $('.accept_cookie_area').hide(500, function(){
                    $('.accept_cookie_area').remove();
                });
            }
        });
    });

    $('.news_load_button').click(function(){
        var cat_id = $(this).data('cid');
        var cat_count = $(this).data('count');
        var this_tag = $(this);
        var cat_new_count = cat_count;
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: '/get_news',
            data: {
                cat_id: cat_id,
                cat_count: cat_count,
                '_token': Laravel.csrfToken
            },
            success: function(res){
                res.forEach(function(item){
                    this_tag.parent().find('.n_l_area').append('<a href="/news/'+item.slug+'">' +
                        '<div class="col-md-6" style="margin-top: 20px">' +
                        '<div class="col-md-6">' +
                        '<img src="/assets/images/'+item.image+'" alt="">' +
                        '</div>' +
                        '<div class="col-md-6">' +
                        '<p style="font-size: 18px;margin: 0 0 11px;color: #666;">' +
                        item.title.substring(0, 15) +
                        '</p>' +
                        '<p style="font-size: 16px;margin: 0 0 11px;color: #666;">' +
                        item.body.replace(/<(?:.|\n)*?>/gm, '').substring(0, 120) +
                        '</p>' +
                        '</div>' +
                        '</div>' +
                        '</a>');
                    cat_new_count++;
                });
                this_tag.data('count', cat_new_count);
                this_tag.parent().find('.movie_slider_hide').css({'display':'block'})
            }
        });

    });

    $('.search__input').focus(function(){
        $('.search').addClass('search_active');
        $('.search_area').fadeIn();
    });

    $('.close_search').click(function(){
        $('.search').removeClass('search_active');
        $('.search_area').fadeOut();
        $('.search__input').val('');
        $('.search_area_row').empty();
    });

    $(document).keyup(function(e) {
        if (e.keyCode == 27) {
            $('.search').removeClass('search_active');
            $('.search_area').fadeOut();
            $('.search__input').val('');
            $('.search_area_row').empty();
        }
    });

    $('.search__input').keyup(function(){
        var search_words = $(this).val();
        if(search_words == '') return false;
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: '/search_news',
            data: {
                search_words: search_words,
                '_token':Laravel.csrfToken
            },
            success: function(data){
                $('.search_area_row').empty();
                data.forEach(function(item){

                    $('.search_area_row').append('<a href="/news/'+item.slug+'">' +
                        '<div class="col-md-4" style="margin-top: 20px">' +
                        '<div class="col-md-6">' +
                        '<img src="/assets/images/'+item.image+'" alt="">' +
                        '</div>' +
                        '<div class="col-md-6">' +
                        '<p style="font-size: 18px;margin: 0 0 11px;color: #666;">' +
                        item.title.substring(0, 15) +
                        '</p>' +
                        '<p style="font-size: 16px;margin: 0 0 11px;color: #666;">' +
                        item.body.replace(/<(?:.|\n)*?>/gm, '').substring(0, 120) +
                        '</p>' +
                        '</div>' +
                        '</div>' +
                        '</a>');
                })

            }
        })
    });

    $('.slider_href').click(function(){
        location.href = $(this).data('href');
    });

    if(typeof slider_run != 'undefined'){
        var auto_len2 = $('.news_slider_auto_cons2 label').length;
        var auto_count2 = 0;
        setInterval(function(){
            if(auto_count2 == auto_len2) auto_count2 = 0;
            $('.news_slider_auto_cons2 label')[auto_count2].click();
            auto_count2++;
        }, 5000);
    }
    var ulliwidth = 0;
    $('.news_scroll_menu ul li').each(function(){
        ulliwidth = ulliwidth + $(this).width()+2;
    });

    if(ulliwidth > $('.news_scroll_menu ul').parent().width()){
        $('.news_scroll_menu ul').width(ulliwidth);
    }

    (function(){

        var shareButtons = document.querySelectorAll(".share-btn");

        if (shareButtons) {
            [].forEach.call(shareButtons, function(button) {
                button.addEventListener("click", function(event) {
                    var width = 650,
                        height = 450;

                    event.preventDefault();

                    window.open(this.href, 'Share Dialog', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,width='+width+',height='+height+',top='+(screen.height/2-height/2)+',left='+(screen.width/2-width/2));
                });
            });
        }

    })();

    var fTemp;

    $.getJSON("https://freegeoip.net/json/", function (data) {

        var city = data.region_name;

        if(city == ''){
            city = data.country_name
        }

        var url = "https://api.apixu.com/v1/current.json?key=48c781e85f6b46bbb8d111904172405&q=" + city;

        $.getJSON(url, function (data) {


            var localtime_ep = data.location.localtime_epoch;

            var loc_a = new Date(localtime_ep*1000);
            var loc_days = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
            var dayOfWeek = loc_days[loc_a.getDay()];



            fTemp = data.current.temp_f;
            var windSpeed = data.current.wind_mph;
            var windDeg = data.current.wind_degree;

            var city_city = data.location.region;

            var icon = data.current.condition.icon;

            var icon = icon.split("/");

            icon = icon[icon.length - 1];

            icon = icon.split(".");

            icon = icon[0];

            var wwi_1 = ['200', '386', '389', '392', '395'];
            var wwi_2 = ['176', '182', '263', '266', '293', '296', '299', '302', '305', '308', '317', '320', '353', '356', '359', '362', '365'];
            var wwi_3 = ['179', '227', '230', '323', '326', '329', '332', '335', '338', '368', '371'];
            var wwi_4 = ['116', '374', '377'];
            var wwi_6 = ['119', '122', '143', '185', '248', '260', '281', '284', '331', '314', '350'];

            if (typeof $('#weat_c') != 'undefined') {
                $('#weat_c').text(Math.round(fTemp) + '°');
                $('#weat_kmh').text('~' + windSpeed);
                $('#weat_deg').text(windDeg);
                $('#weat_location').text(city_city);
                $('#d_name').text(dayOfWeek);

                if (wwi_1.indexOf(icon) != -1) {
                    $('#wi_1').css({'display': 'block'});
                }

                if (wwi_2.indexOf(icon) != -1) {
                    $('#wi_2').css({'display': 'block'});
                }

                if (wwi_3.indexOf(icon) != -1) {
                    $('#wi_3').css({'display': 'block'});
                }

                if (wwi_4.indexOf(icon) != -1) {
                    $('#wi_4').css({'display': 'block'});
                }

                if (icon == 113) {
                    $('#wi_5').css({'display': 'block'});
                }

                if (wwi_6.indexOf(icon) != -1) {
                    $('#wi_6').css({'display': 'block'});
                }

            }
        });
    });

    if(typeof m_slider != 'undefined'){
        $('.scroll_row_right_icon').click(function(){
            $(this).prev().animate({scrollLeft: $( '.scroll_row' ).scrollLeft() + $(window).width() / 2}, 800);
        });
        $('.scroll_row_left_icon').click(function(){
            $(this).next().animate({scrollLeft: $( '.scroll_row' ).scrollLeft() - $(window).width() / 2}, 800);
        });
    }

    if(typeof hpslider != 'undefined'){
        var slider = $('.hp_slider_image');
        var sdcount = 0;
        var sdlength = hpslider.length;


        if(sdlength > 0){
            slider.attr('src', '/assets/images/'+hpslider[0]);
        }

        if(sdlength != 1){
            setInterval(function(){
                sdcount++;
                if(sdcount == sdlength){
                    sdcount = 0;
                    change_hp_slider_image(slider, hpslider[sdcount]);
                }
                else{
                    change_hp_slider_image(slider, hpslider[sdcount]);
                }

            }, 7000)
        }
    }

    function change_hp_slider_image(slider, img){
        slider.css({'opacity':'0'});

        setTimeout(function(){
            slider.attr('src', '/assets/images/'+img);
        },1000);

        setTimeout(function(){
            slider.css({'opacity':'1'});
        },1500);

    }
//     $(document).ready(function() {
//         var iOS = !!navigator.platform && /iPad|iPhone|iPod/.test(navigator.platform);
//         var countElem = 0;
//         var sElem = $('.news_slider_auto_cons2 label').length;
//
//         if(iOS){
// alert('its a ios');
//             setInterval(function(){
//                 $('.news_slider_auto_cons2 label')[countElem].click();
//                 countElem++;
//                 if(countElem == sElem){
//                     countElem = 0;
//                 }
//
//             }, 2000);
//
//         }
//     });