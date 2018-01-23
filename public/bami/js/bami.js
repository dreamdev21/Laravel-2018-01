(function($) {

    'use strict';

    var Webarch = function() {
        this.VERSION = "2.8.0";
        this.AUTHOR = "Revox";
        this.SUPPORT = "support@revox.io";
        this.$body = $('body');
        //COLORS
        this.color_green="#27cebc";
        this.color_blue="#00acec";
        this.color_yellow="#FDD01C";
        this.color_red="#f35958";
        this.color_grey="#dce0e8";
        this.color_black="#1b1e24";
        this.color_purple="#6d5eac";
        this.color_primary="#6d5eac";
        this.color_success="#4eb2f5";
        this.color_danger="#f35958";
        this.color_warning="#f7cf5e";
        this.color_info="#3b4751";
    };
    // Set environment vars
    Webarch.prototype.initHorizontalMenu = function() {
        $('.horizontal-menu .bar-inner > ul > li').on('click', function () {
            $(this).toggleClass('open').siblings().removeClass('open');

        });
        if($('body').hasClass('horizontal-menu')){
            $('.content').on('click', function () {
                $('.horizontal-menu .bar-inner > ul > li').removeClass('open');
            });
        }
    };
    // Tooltip
    Webarch.prototype.initTooltipPlugin = function() {
        $.fn.tooltip && $('[data-toggle="tooltip"]').tooltip();
    };
    // Popover
    Webarch.prototype.initPopoverPlugin = function() {
        $.fn.popover && $('[data-toggle="popover"]').popover();
    };
    // Retina Images
    Webarch.prototype.initUnveilPlugin = function() {
        $.fn.unveil && $("img").unveil();
    };
    // Auto Scroll Up
    Webarch.prototype.initScrollUp = function() {
        $('[data-webarch="scrollup"]').click(function () {
            $("html, body").animate({
                scrollTop: 0
            }, 700);
            return false;
        });
        $(window).scroll(function () {
            if ($(this).scrollTop() > 100) {
                $('[data-webarch="scrollup"]').fadeIn();
            } else {
                $('[data-webarch="scrollup"]').fadeOut();
            }
        });
    };
    // Portlet / Panel Tools
    Webarch.prototype.initPortletTools = function() {
        var $this = this;
        $('.grid .tools a.remove').on('click', function () {
            var removable = jQuery(this).parents(".grid");
            if (removable.next().hasClass('grid') || removable.prev().hasClass('grid')) {
                jQuery(this).parents(".grid").remove();
            } else {
                jQuery(this).parents(".grid").parent().remove();
            }
        });

        $('.grid .tools a.reload').on('click', function () {
            var el = jQuery(this).parents(".grid");
            $this.blockUI(el);
            window.setTimeout(function () {
                $this.unblockUI(el);
            }, 1000);
        });

        $('.grid .tools .collapse, .grid .tools .expand').on('click', function () {
            var el = jQuery(this).parents(".grid").children(".grid-body");
            if (jQuery(this).hasClass("collapse")) {
                jQuery(this).removeClass("collapse").addClass("expand");
                el.slideUp(200);
            } else {
                jQuery(this).removeClass("expand").addClass("collapse");
                el.slideDown(200);
            }
        });
        $('.widget-item > .controller .reload').click(function () {
            var el = $(this).parent().parent();
            $this.blockUI(el);
            window.setTimeout(function () {
                $this.unblockUI(el);
            }, 1000);
        });
        $('.widget-item > .controller .remove').click(function () {
            $(this).parent().parent().parent().addClass('animated fadeOut');
            $(this).parent().parent().parent().attr('id', 'id_remove_temp_id');
            setTimeout(function () {
                $('#id_remove_temp_id').remove();
            }, 400);
        });

        $('.tiles .controller .reload').click(function () {
            var el = $(this).parent().parent().parent();
            $this.blockUI(el);
            window.setTimeout(function () {
                $this.unblockUI(el);
            }, 1000);
        });
        $('.tiles .controller .remove').click(function () {
            $(this).parent().parent().parent().parent().addClass('animated fadeOut');
            $(this).parent().parent().parent().parent().attr('id', 'id_remove_temp_id');
            setTimeout(function () {
                $('#id_remove_temp_id').remove();
            }, 400);
        });
        if (!jQuery().sortable) {
            return;
        }
        $(".sortable").sortable({
            connectWith: '.sortable',
            iframeFix: false,
            items: 'div.grid',
            opacity: 0.8,
            helper: 'original',
            revert: true,
            forceHelperSize: true,
            placeholder: 'sortable-box-placeholder round-all',
            forcePlaceholderSize: true,
            tolerance: 'pointer'
        });
    };
    // Scrollbar Plugin
    Webarch.prototype.initScrollBar = function(){
        $.fn.scrollbar && $('.scroller').each(function () {
            var h = $(this).attr('data-height');
            $(this).scrollbar({
                ignoreMobile:true
            });
            if(h != null  || h !=""){
                if($(this).parent('.scroll-wrapper').length > 0)
                    $(this).parent().css('max-height',h);
                else
                    $(this).css('max-height',h);
            }
        });
    };
    // Sidebar
    Webarch.prototype.initSideBar = function(){
        var sidebar = $('.page-sidebar');
        var sidebarWrapper = $('.page-sidebar .page-sidebar-wrapper');
        sidebar.find('li > a').on('click', function (e) {
            if ($(this).next().hasClass('sub-menu') === false) {
                return;
            }
            var parent = $(this).parent().parent();
            parent.children('li.open').children('a').children('.arrow').removeClass('open');
            parent.children('li.open').children('a').children('.arrow').removeClass('active');
            parent.children('li.open').children('.sub-menu').slideUp(200);
            parent.children('li').removeClass('open');

            var sub = jQuery(this).next();
            if (sub.is(":visible")) {
                jQuery('.arrow', jQuery(this)).removeClass("open");
                jQuery(this).parent().removeClass("active");
                sub.slideUp(200, function () {
                });
            } else {
                jQuery('.arrow', jQuery(this)).addClass("open");
                jQuery(this).parent().addClass("open");
                sub.slideDown(200, function () {
                });
            }
            e.preventDefault();
        });
        //Auto close open menus in Condensed menu
        if (sidebar.hasClass('mini')) {
            var elem = jQuery('.page-sidebar ul');
            elem.children('li.open').children('a').children('.arrow').removeClass('open');
            elem.children('li.open').children('a').children('.arrow').removeClass('active');
            elem.children('li.open').children('.sub-menu').slideUp(200);
            elem.children('li').removeClass('open');
        }
        $.fn.scrollbar && sidebarWrapper.scrollbar();
    };
    // Sidebar Toggler
    Webarch.prototype.initSideBarToggle = function(){
        var $this = this;
        $('[data-webarch="toggle-left-side"]').on('touchstart click', function (e) {
            e.preventDefault();
            $this.toggleLeftSideBar();
        });
        $('[data-webarch="toggle-right-side"]').on('touchstart click', function (e) {
            e.preventDefault();
            $this.toggleRightSideBar();
        });
    };
    // Left Side Bar / Chat view
    Webarch.prototype.toggleLeftSideBar = function(){
        var timer;
        if($('body').hasClass('open-menu-left')){
            $('body').removeClass('open-menu-left');
            timer= setTimeout(function(){
                $('.page-sidebar').removeClass('visible');
            }, 300);

        }
        else{
            clearTimeout(timer);
            $('.page-sidebar').addClass('visible');
            setTimeout(function(){
                $('body').addClass('open-menu-left');
            }, 50);
        }
    };
    // Right Side Bar / Mobile
    Webarch.prototype.toggleRightSideBar = function(){
        var timer;
        if($('body').hasClass('open-menu-right')){
            $('body').removeClass('open-menu-right');
            timer= setTimeout(function(){
                $('.chat-window-wrapper').removeClass('visible');
            }, 300);
        }
        else{
            clearTimeout(timer);
            $('.chat-window-wrapper').addClass('visible');
            $('body').addClass('open-menu-right');
        }
    };
    // Util Functions
    Webarch.prototype.initUtil = function(){
        $('[data-height-adjust="true"]').each(function () {
            var h = $(this).attr('data-elem-height');
            $(this).css("min-height", h);
            $(this).css('background-image', 'url(' + $(this).attr("data-background-image") + ')');
            $(this).css('background-repeat', 'no-repeat');
            if ($(this).attr('data-background-image')) {

            }
        });

        $('[data-aspect-ratio="true"]').each(function () {
            $(this).height($(this).width());
        });

        $('[data-sync-height="true"]').each(function () {
            equalHeight($(this).children());
        });

        $('[data-webarch-toggler="checkall"]').on('click', function () {
            var $el = $(this);
            var $table =  $el.closest('table');
            if ($el.is(':checked')) {
                $table.find(':checkbox').attr('checked', true);
                $table.find('tr').addClass('row_selected');
            } else {
                $table.find(':checkbox').attr('checked', false);
                $table.find('tr').removeClass('row_selected');
            }
        });

        $(window).resize(function () {
            $('[data-aspect-ratio="true"]').each(function () {
                $(this).height($(this).width());
            });
            $('[data-sync-height="true"]').each(function () {
                equalHeight($(this).children());
            });

        });
        function equalHeight(group) {
            var tallest = 0;
            group.each(function () {
                var thisHeight = $(this).height();
                if (thisHeight > tallest) {
                    tallest = thisHeight;
                }
            });
            group.height(tallest);
        }
        $('#my-task-list').popover({
            html: true,
            content: function () {
                return $('#notification-list').html();
            }
        });

        $('#user-options').click(function () {
            $('#my-task-list').popover('hide');
        });

        $('table th .checkall').on('click', function () {
            if ($(this).is(':checked')) {
                $(this).closest('table').find(':checkbox').attr('checked', true);
                $(this).closest('table').find('tr').addClass('row_selected');
                //$(this).parent().parent().parent().toggleClass('row_selected');
            } else {
                $(this).closest('table').find(':checkbox').attr('checked', false);
                $(this).closest('table').find('tr').removeClass('row_selected');
            }
        });
    };
    // Progress bar animation
    Webarch.prototype.initProgress = function(){
        $('[data-init="animate-number"], .animate-number').each(function () {
            var data = $(this).data();
            $(this).animateNumbers(data.value, true, parseInt(data.animationDuration, 10));
        });
        $('[data-init="animate-progress-bar"], .animate-progress-bar').each(function () {
            var data = $(this).data();
            $(this).css('width', data.percentage);
        });
    };
    // Select2 Plugin
    Webarch.prototype.initSelect2Plugin = function() {
        $.fn.select2 && $('[data-init-plugin="select2"]').each(function() {
            $(this).select2({
                minimumResultsForSearch: ($(this).attr('data-disable-search') == 'true' ? -1 : 1)
            }).on('select2-opening', function() {
                $.fn.scrollbar && $('.select2-results').scrollbar({
                    ignoreMobile: false
                })
            });
        });
    };
    // Form Elements
    Webarch.prototype.initFormElements = function(){
        $(".inside").children('input').blur(function () {
            $(this).parent().children('.add-on').removeClass('input-focus');
        });

        $(".inside").children('input').focus(function () {
            $(this).parent().children('.add-on').addClass('input-focus');
        });

        $(".input-group.transparent").children('input').blur(function () {
            $(this).parent().children('.input-group-addon').removeClass('input-focus');
        });

        $(".input-group.transparent").children('input').focus(function () {
            $(this).parent().children('.input-group-addon').addClass('input-focus');
        });

        $(".bootstrap-tagsinput input").blur(function () {
            $(this).parent().removeClass('input-focus');
        });

        $(".bootstrap-tagsinput input").focus(function () {
            $(this).parent().addClass('input-focus');
        });
    };
    // Validation Plugin
    Webarch.prototype.initValidatorPlugin = function() {
        $.validator && $.validator.setDefaults({
            errorPlacement: function(error, element) {
                var parent = $(element).closest('.form-group');
                if (parent.hasClass('form-group-default')) {
                    parent.addClass('has-error');
                    error.insertAfter(parent);
                } else {
                    error.insertAfter(element);
                }
            },
            onfocusout: function(element) {
                var parent = $(element).closest('.form-group');
                if ($(element).valid()) {
                    parent.removeClass('has-error');
                    parent.next('.error').remove();
                }
            },
            onkeyup: function(element) {
                var parent = $(element).closest('.form-group');
                if ($(element).valid()) {
                    $(element).removeClass('error');
                    parent.removeClass('has-error');
                    parent.next('label.error').remove();
                    parent.find('label.error').remove();
                } else {
                    parent.addClass('has-error');
                }
            },
            success: function (label, element) {
                // var parent = $(element).parent('.input-with-icon');
                // parent.removeClass('error-control').addClass('success-control');
            }
        });

        $('.validate').validate();
    };
    // Block UI
    Webarch.prototype.blockUI = function(el){
        $(el).block({
            message: '<div class="loading-animator"></div>',
            css: {
                border: 'none',
                padding: '2px',
                backgroundColor: 'none'
            },
            overlayCSS: {
                backgroundColor: '#fff',
                opacity: 0.3,
                cursor: 'wait'
            }
        });
    };
    Webarch.prototype.unblockUI = function(el){
        $(el).unblock();
    };
    // Call initializers
    Webarch.prototype.init = function() {
        // init layout
        this.initSideBar();
        this.initSideBarToggle();
        this.initHorizontalMenu();
        this.initPortletTools();
        this.initScrollUp();
        this.initProgress();
        this.initFormElements();
        // init plugins
        this.initSelect2Plugin();
        this.initUnveilPlugin();
        this.initScrollBar();
        this.initTooltipPlugin();
        this.initPopoverPlugin();
        this.initValidatorPlugin();
        this.initUtil();
    };

    $.Webarch = new Webarch();
    $.Webarch.Constructor = Webarch;

})(window.jQuery);

// DEMO STUFF
$(document).ready(function () {
    /* Do first */
    $('.video_info').each(function (){
        var info_video_tstart = $(this).find('.info_video_tstart').val();

        var info_video_tstart = new Date(info_video_tstart+' UTC');
        info_video_tstart = info_video_tstart.getTime()/1000;
        $(this).find('.info_video_tstart').val(info_video_tstart);

        var info_video_tend = $(this).find('.info_video_tend').val();
        var info_video_tend = new Date(info_video_tend+' UTC');
        info_video_tend = info_video_tend.getTime()/1000;
        $(this).find('.info_video_tend').val(info_video_tend);

    });

    $("#menu-collapse").click(function () {
        if ($('.page-sidebar').hasClass('mini')) {
            $('.page-sidebar').removeClass('mini');
            $('.page-content').removeClass('condensed-layout');
            $('.footer-widget').show();
        } else {
            $('.page-sidebar').addClass('mini');
            $('.page-content').addClass('condensed-layout');
            $('.footer-widget').hide();
        }
    });

    $(".simple-chat-popup").click(function () {
        $(this).addClass('hide');
        $('#chat-message-count').addClass('hide');
    });

    setTimeout(function () {
        $('#chat-message-count').removeClass('hide');
        $('#chat-message-count').addClass('animated bounceIn');
        $('.simple-chat-popup').removeClass('hide');
        $('.simple-chat-popup').addClass('animated fadeIn');
    }, 5000);
    setTimeout(function () {
        $('.simple-chat-popup').addClass('hide');
        $('.simple-chat-popup').removeClass('animated fadeIn');
        $('.simple-chat-popup').addClass('animated fadeOut');
    }, 8000);


    //***********************************END Grids*****************************


    //***********************************BEGIN Main Menu Toggle *****************************
    $('#layout-condensed-toggle').click(function () {
        if ($('#main-menu').attr('data-inner-menu') == '1') {
            //Do nothing
        } else {
            if ($('#main-menu').hasClass('mini')) {
                $('body').removeClass('grey');
                $('body').removeClass('condense-menu');
                $('#main-menu').removeClass('mini');
                $('.page-content').removeClass('condensed');
                $('.scrollup').removeClass('to-edge');
                $('.header-seperation').show();
                //Bug fix - In high resolution screen it leaves a white margin
                $('.header-seperation').css('height', '61px');
                $('.footer-widget').show();
            } else {
                $('body').addClass('grey');
                $('#main-menu').addClass('mini');
                $('.page-content').addClass('condensed');
                $('.scrollup').addClass('to-edge');
                $('.header-seperation').hide();
                $('.footer-widget').hide();
                $('.main-menu-wrapper').scrollbar('destroy');
            }
        }
    });

    if ($.fn.sparkline) {
        $('.sparklines').sparkline('html', {
            enableTagOptions: true
        });
    }



    setTimeout(function(){
        $('.active_video').on('click',function () {

            return false;

            $('.videos_li').removeClass('video_active');
            $(this).addClass('video_active');
            $('.list_channels').removeClass('channel_active');
            $(this).parents('.channel').find('.list_channels').addClass('channel_active');
            var video_title = $(this).parents('.episodeo').find('.video_info .info_video_title').val();
            var video_description = $(this).parents('.episodeo').find('.video_info .info_video_description').val();
            var video_url = $(this).parents('.episodeo').find('.video_info .info_video_url').val();

            var new_src = $(this).find('.info_video_url').val();
            var info_video_real_id = $(this).find('.info_video_real_id').val();
            $('.video-sidebar').find('.channel-name').html(video_title);
            $('.video-sidebar').find('.episode-title').html(video_description);

            var channel_logo = $(this).find('.info_video_channel_logo').val();
            var start_unix_time = $(this).find('.info_video_tstart').val();

            var prerolladval = {
                preroll_ad: $(this).find('.preroll_ad').val(),
                preroll_goto_link: $(this).find('.preroll_goto_link').val(),
                preroll_mp4: $(this).find('.preroll_mp4').val(),
                preroll_skip_timer: $(this).find('.preroll_skip_timer').val(),
                preroll_thumbimg: $(this).find('.preroll_thumbimg').val()
            };

            init_player(new_src, prerolladval, channel_logo, start_unix_time);
            $.ajax({
                type: 'get',
                url: '/home',
                data: {
                    info_video_real_id: info_video_real_id,
                    '_token':Laravel.csrfToken
                },
                success: function(res){
                }
            })
        });
    }, 2000);

    $('.videos_li ').click(function(event){

        $('.tt_inactiv_video').remove();

        if($(this).hasClass('active_video') == false){

            $('<p class="tt_inactiv_video"></p>')
                .text("qwew qeqwewqewqewqe qwe eqw ")
                .prependTo('body')
                .css('top', (event.pageY - 5) + 'px')
                .css('left', (event.pageX - ($('.tt_inactiv_video').width() / 2)) + 'px')
                .fadeIn('slow');

        }

    });

    $('.describe').hover(function(event){
        var titleText = $(this).attr('title');
        $(this)
            .data('tipText',titleText)
            .removeAttr('title');

        $('<p class="tooltip"></p>')
            .text(titleText)
            .appendTo('body')
            .css('top', (event.pageY - 5) + 'px')
            .css('left', (event.pageX + 20) + 'px')
            .fadeIn('slow');
    },function(){
        $(this).attr('title',$(this).data('tipText'));
        $('.tooltip').remove();

    }).mousemove(function(event){
        $('.tooltip')
            .css('top', (event.pageY - 5) + 'px')
            .css('left', (event.pageX + 20) + 'px');
    });









    $('.videos_li').each(function(i,e) {

        var end_time =  $(this).find('.video_info .info_video_tend').val();
        var start_time = $(this).find('.info_video_tstart').val();


        var sum = end_time-start_time;
        var custom_v_width = sum * 0.32666666666666666;
        // console.log(custom_v_width);
        $(this).children('.video_item').css('width',custom_v_width +'px');
        var key =  $(this).find('.key_compare').val();
        if(key == 'active'){
            $(this).addClass('active_video');
        }
        else{
            $(this).addClass('sh_po');
        }
    });
    $('.videos_li').each(function() {
        if(!$(this).hasClass( "active_video" )){
            $(this).attr('data-toggle','popover');
        }
    });

    /*TIMELINE*/
    //
    // var d = new Date();
    // var curr_hour =  d.getHours();
    // var curr_min =  d.getMinutes();
    // var first_margin = curr_min*60*0.005416666666666667 + '%';
    // $('.current-time').css('margin-left', first_margin);
    // var myVar = setInterval(  function () {
    //     var marginLeft = ( 100 * parseFloat($('.current-time').css('margin-left')) / parseFloat($('.current-time').parent().css('width')) );
    //     marginLeft = marginLeft + 0.005416666666666667 + '%';
    //     var options = {
    //         month: 'short',
    //         day  : '2-digit',
    //         hour : '2-digit',
    //         minute:'2-digit',
    //         // second:'2-digit',
    //     };
    //
    //     var n = d.toLocaleString('en-us',options);
    //     var first_time_hour =  d.getHours();
    //     var first_time = ((first_time_hour + 11) % 12 + 1);
    //     var ampm = (first_time_hour >= 12) ? "PM" : "AM";
    //     $('.hour_1 time').html(first_time + ':00 '+ampm);
    //     $('.hour_1 span').html(first_time + ':30 '+ampm);
    //
    //     $('.hour_2 time').html(first_time+1 + ':00 '+ampm);
    //     $('.hour_2 span').html(first_time+1 + ':30 '+ampm);
    //
    //     $('.hour_3 time').html(first_time+2 + ':00 '+ampm);
    //     $('.hour_3 span').html(first_time+2 + ':30 '+ampm);
    //
    //     $('.hour_4 time').html(first_time+3 + ':00 '+ampm);
    //     $('.hour_4 span').html(first_time+3 + ':30 '+ampm);
    //
    //     $('.hour_5 time').html(first_time+4 + ':00 '+ampm);
    //     $('.hour_5 span').html(first_time+4 + ':30 '+ampm);
    //
    //     $('.current_time_num').html(n);
    //     $('.current-time').css('margin-left', marginLeft);
    //     if(marginLeft >= 19.5+'%' && marginLeft <= 19.505+'%'){
    //         $('.slick-next').click();
    //     }
    //     var timer = $('.custom_timer').val();
    //     ++timer;
    //     $('.custom_timer').val(timer);
    //     if(timer >=3600){
    //         clearInterval(myVar);
    //     }
    // }, 1000);
});

//******************************* Bind Functions Jquery- LAYOUT OPTIONS API ***************

// (function ($) {
//
//     setTimeout(function () {
//
//         var active_video_title = $('.video_active').find('.video_info .info_video_title').val();
//         var active_video_description = $('.video_active').find('.video_info .info_video_description').val();
//         $('.headerinfo .channel-name').html(active_video_title);
//         $('.surface .contento  h5').html(active_video_description);
//         $('.listing .active_video:first').addClass('video_active');
//         $('.video_active').parents('.channel').find('.list_channels').addClass('channel_active');
//
//         var playlist = [];
//         var playlist_object = [];
//         var first_el;
//         $('.channel_active').parent('.channel').find($(".videos_li")).each(function(index ) {
//             if(index == 0){
//                 first_el = $(this).val();
//             }
//             var date = new Date();
//
//
//             var curr_dtime = new Date(date);
//             curr_time = curr_dtime.getTime()/ 1000 | 0;
//
//             // var curr_timesd = $(this).find('.video_info .info_video_curr_time').val();
//             var end_time =  $(this).find('.video_info .info_video_tend').val();
//
//             if(curr_time < end_time){
//
//                 var video_id = $(this).find('.video_info .info_video_url').val();
//                 var video_length = $(this).find('.video_info .info_video_time_different').val();
//                 var video_title = $(this).find('.video_info .info_video_title').val();
//                 var channel_logo = $(this).find('.video_info .info_video_channel_logo').val();
//                 playlist_object.push({
//                     video_id : video_id,
//                     video_length : video_length,
//                     name: video_title,
//                     end_time: end_time,
//                     curr_time: curr_time,
//                     channel_logo: channel_logo,
//                     preroll_ad: $(this).find('.video_info .preroll_ad').val(),
//                     preroll_goto_link: $(this).find('.video_info .preroll_goto_link').val(),
//                     preroll_mp4: $(this).find('.video_info .preroll_mp4').val(),
//                     preroll_skip_timer: $(this).find('.video_info .preroll_skip_timer').val(),
//                     preroll_thumbimg: $(this).find('.video_info .preroll_thumbimg').val(),
//                     info_video_tstart: $(this).find('.video_info .info_video_tstart').val()
//
//                 })
//             }
//         });
//
//         /* setinterval start*/
//
//         var first_src = '';
//         var el = $('.video_active').next();
//         var k = 0;
//         if(true){
//             var timer = setInterval(my ,1000);
//         }
//
//         function my() {
//             if(k < playlist_object.length){
//                 var video_item =  playlist_object[k];
//                 var time_diff = video_item['video_length'];
//                 var parts = time_diff.split(':');
//                     //var sum = (parseInt(parts[0])*3600 + parseInt(parts[1])*60 + parseInt(parts[2]))*1000;
//                 var curr_time = video_item['curr_time']*1000,
//                     end_time = video_item['end_time']*1000;
//
//                 var interval_time = end_time-curr_time;
//                 clearInterval(timer);
//                 // console.log(interval_time);
//                 timer = setInterval(my ,interval_time);
//
//                 var new_src_video = 'https://www.youtube.com/v/'+video_item['video_id']+'?version=3&loop=1&autoplay=1&controls=0&showinfo=0';
//
//                 var prerolladval = {
//                     preroll_ad: video_item['preroll_ad'],
//                     preroll_goto_link: video_item['preroll_goto_link'],
//                     preroll_mp4: video_item['preroll_mp4'],
//                     preroll_skip_timer: video_item['preroll_skip_timer'],
//                     preroll_thumbimg: video_item['preroll_thumbimg']
//                 };
//
//                 init_player(video_item['video_id'], prerolladval, video_item['channel_logo'], video_item['info_video_tstart']);
//
//                 //$('.video-main').find('iframe').attr('src', new_src_video);
//                 if(k > 0){
//                     var el = $('.videos_li.video_active');
//                     el.next().addClass('video_active');
//                     el.removeClass('video_active');
//                 }
//
//                 k++;
//             }
//             else{
//                 var tel = --k;
//                 // console.log(playlist_object);
//                 var video_item =  playlist_object[tel];
//                 // console.log(video_item);
//                 $('.list_channels').removeClass('channel_active');
//                 $(this).addClass('channel_active');
//                 $('.videos_li').removeClass('video_active');
//                 var channel_logo_yaxk = video_item['channel_logo'];
//                 // console.log(channel_logo_yaxk);
//                 init_player(false, false, channel_logo_yaxk, false);
//                 return false;
//             }
//         }
//
//         var active_channel_first_el = $('.list_channels').parent('.channel').find(".videos_li:first");
//         active_channel_first_el.each(function () {
//             var videos_first_margin = $(this).find('.info_video_tstart_tt').val();
//             var parts = videos_first_margin.split(':');
//             videos_first_margin =  parseInt(parts[1])*60 + parseInt(parts[2]);
//             videos_first_margin = (videos_first_margin*0.027777777777777776) + '%';
//
//             $(this).css('margin-left', videos_first_margin);
//         })
//     }, 500);
//
//     $('.list_channels').on('click',function () {
//
//         if($(this).attr("data-cont") != " emp_chan "){
//
//             var last_w = $(this).attr('data-chid');
//
//             $.ajax({
//                 type:'post',
//                 url:'/last_w',
//                 data: {
//                     last_w:last_w,
//                     '_token':Laravel.csrfToken
//                 }
//             });
//
//             $('.list_channels').removeClass('channel_active');
//             $(this).addClass('channel_active');
//
//             $('.videos_li').removeClass('video_active');
//             $(this).parent('.channel').find('.active_video:first').addClass('video_active');
//             var new_src = $(this).parent('.channel').find('.video_info:first .info_video_url').val();
//             var video_title = $(this).parent('.channel').find('.video_info:first .info_video_title').val();
//             var video_description = $(this).parent('.channel').find('.video_info:first .info_video_description').val();
//             var channel_logo = $(this).parent('.channel').find('.video_info:first .info_video_channel_logo').val();
//             $('.video-sidebar').find('.channel-name').html(video_title);
//             $('.video-sidebar').find('.episode-title').html(video_description);
//             //$('.video-main').find('iframe').attr('src', new_src);
//
//             var start_unix_time = $(this).parent('.channel').find('.video_info:first .info_video_tstart').val();
//
//             if(start_unix_time > Math.round(new Date().getTime()/1000)){
//                 $('.list_channels').removeClass('channel_active');
//                 $(this).addClass('channel_active');
//                 $('.videos_li').removeClass('video_active');
//                 var channel_logo_yaxk = $(this).data('chan-logo');
//                 // console.log(channel_logo_yaxk);
//                 init_player(false, false, channel_logo_yaxk, false);
//                 return false;
//             }
//
//             // console.log('u-time-is: ' + start_unix_time );
//
//             var prerolladval = {
//                 preroll_ad: $(this).parent('.channel').find('.video_info:first .preroll_ad').val(),
//                 preroll_goto_link: $(this).parent('.channel').find('.video_info:first .preroll_goto_link').val(),
//                 preroll_mp4: $(this).parent('.channel').find('.video_info:first .preroll_mp4').val(),
//                 preroll_skip_timer: $(this).parent('.channel').find('.video_info:first .preroll_skip_timer').val(),
//                 preroll_thumbimg: $(this).parent('.channel').find('.video_info:first .preroll_thumbimg').val()
//             };
//
//             init_player(new_src, prerolladval, channel_logo, start_unix_time);
//
//         }
//         else{
//             $('.list_channels').removeClass('channel_active');
//             $(this).addClass('channel_active');
//             $('.videos_li').removeClass('video_active');
//             var channel_logo_yaxk = $(this).data('chan-logo');
//             // console.log(channel_logo_yaxk);
//             init_player(false, false, channel_logo_yaxk, false);
//         }
//
//
//
//
//
//
//
//     });
//
//     var now = new Date();
//     var current_time = now.getHours()+':'+now.getMinutes()+':'+now.getSeconds();
//
//
//
//     if(typeof window.livetv != 'undefined'){
//         $('.hours').slick({
//             infinite: false,
//             slidesToShow: 1,
//             speed: 0,
//             draggable:false
//         });
//     }
//
//
//
//     setTimeout(function () {
//         $('.current-time').removeClass('slick-slide');
//         $('.current-time').removeClass('slick-current');
//         $('.current-time').removeClass('slick-active');
//
//         $('.current-time').removeAttr( "data-slick-index");
//         $('.current-time').removeAttr( "aria-hidden" );
//         $('.current-time').removeAttr( "tabindex" );
//         $('.current-time').removeAttr( "role" );
//         $('.slick-slide').removeAttr( "style" );
//
//         $('.current-time').removeAttr( "aria-describedby" )
//     }, 300);
//
//     // $('.queue').slick();
//     $('.to_now').click(function(e){
//         var slider = $('.hours');
//         slider[0].slick.slickGoTo(parseInt(0));
//     });
//
//     $('.slick-arrow , .to_now').on('click',function () {
//         var styles =  $('.slick-track').attr('style');
//         $('.queue').attr('style',styles);
//     });
//
//     //Show/Hide Main Menu
//     $.fn.toggleMenu = function () {
//         var windowWidth = window.innerWidth;
//         if(windowWidth >768){
//             $(this).toggleClass('hide-sidebar');
//         }
//     };
//
//     //Condense Main Menu
//     $.fn.condensMenu = function () {
//         var windowWidth = window.innerWidth;
//         if(windowWidth >768){
//             if ($(this).hasClass('hide-sidebar')) $(this).toggleClass('hide-sidebar');
//
//             $(this).toggleClass('condense-menu');
//             $(this).find('#main-menu').toggleClass('mini');
//         }
//     };
//
//     //Toggle Fixed Menu Options
//     $.fn.toggleFixedMenu = function () {
//         var windowWidth = window.innerWidth;
//         if(windowWidth >768){
//             $(this).toggleClass('menu-non-fixed');
//         }
//     };
//
//     $.fn.toggleHeader = function () {
//         $(this).toggleClass('hide-top-content-header');
//     };
//
//     $.fn.toggleChat = function () {
//         $.Webarch.toggleRightSideBar();
//     };
//
//     $.fn.layoutReset = function () {
//         $(this).removeClass('hide-sidebar');
//         $(this).removeClass('condense-menu');
//         $(this).removeClass('hide-top-content-header');
//         if(!$('body').hasClass('extended-layout'))
//             $(this).find('#main-menu').removeClass('mini');
//     };
//
// })(jQuery);
//
// function skip_interval_c_rs(skip_count){
//     clearInterval(window.skip_interval);
//     window.skip_interval = setInterval( function(){
//         $('.skip_ads span').text(skip_count--);
//         if(skip_count ==0){
//             $('.skip_ads span').text('');
//             clearInterval(skip_interval);
//         }
//     },1000);
// }

function init_player(vd, prerolladval, channel_logo, start_unix_time) {


    if(vd == false){


        if(channel_logo != ""){
            $('.vjs-poster').parent().children().eq(2).css('background-image','url(/assets/images/tvstation/'+channel_logo+'    )');
        }
        else{
            $('.vjs-poster').parent().children().eq(2).css('background-image','url(/assets/images/fv-logo-bg.gif)');
        }


        //ADS

        var playerads = videojs('vid_mp4');
        var playeryoutube = videojs('vid_youtube');
        var playerm3u8 = videojs('vid_stream');

        $('#vid_stream').css({'display': 'none'});
        $('#vid_mp4').css({'display': 'none'});
        $('#vid_youtube').css({'display': 'block'});
        playerm3u8.pause();
        playerads.pause();
        playeryoutube.src('');
        playeryoutube.pause();
        return false;
    }

    // console.log(Math.round( new Date().getTime()/1000 ) - start_unix_time);

    var vid_curr_time_ = Math.round( new Date().getTime()/1000 ) - start_unix_time;

    // console.log($('.vjs-poster').parent().children().eq(2));
    // console.log(channel_logo);
    //var vjs_poster = $('.vjs-poster');

    if(channel_logo != ""){
        $('.vjs-poster').parent().children().eq(2).css('background-image','url(/assets/images/tvstation/'+channel_logo+'    )');
    }
    else{
        $('.vjs-poster').parent().children().eq(2).css('background-image','url(/assets/images/fv-logo-bg.gif)');
    }


    //ADS

    var playerads = videojs('vid_mp4');
    var playeryoutube = videojs('vid_youtube');
    var playerm3u8 = videojs('vid_stream');





    if (typeof prerolladval.preroll_mp4 != 'undefined') {
        $('#vid_mp4').css({'display': 'block'});
        playeryoutube.pause();
        playerm3u8.pause();
        $('#vid_youtube').css({'display': 'none'});
        $('#vid_stream').css({'display': 'none'});
        var sources = [{"type": "video/mp4", "src": prerolladval.preroll_mp4}];
        playerads.pause();
        playerads.src(sources);
        playerads.load();
        $('#vid_mp4').css({'display': 'block'});
        $('.skip_ads').css({'display': 'block'});
        var skip_count = prerolladval.preroll_skip_timer;
        skip_interval_c_rs(skip_count);


        $('#vid_mp4').click(function(){
            init_player_ads_call(vd, vid_curr_time_);
            window.open(prerolladval.preroll_goto_link, '_blank');
        });

        playerads.on('ended', function() {
            init_player_ads_call(vd, vid_curr_time_);
        });
    }
    else{
        init_player_ads_call(vd, vid_curr_time_);
    }

    $('.skip_ads').click(function(){

        if($('.skip_ads span').text() == ''){
            init_player_ads_call(vd, vid_curr_time_);
        }

    });

}

function init_player_ads_call(vd, vid_curr_time_) {

    //info_video_channel_logo

    var playerads = videojs('vid_mp4');
    var playeryoutube = videojs('vid_youtube');
    var playerm3u8 = videojs('vid_stream');
    playerads.pause();
    $('#vid_mp4').css({'display':'none'});
    $('.skip_ads').css({'display':'none'});
    var vd_res = vd.split(".");

    if(vd_res[vd_res.length-1] == 'm3u8'){
        playeryoutube.pause();
        $('#vid_youtube').css({'display':'none'});
        var sources = [{"type": "application/x-mpegURL", "src": vd}];
        playerm3u8.pause();
        playerm3u8.src(sources);
        playerm3u8.load();
        $('#vid_stream').css({'display':'block'});
        // playerm3u8.play();
    }
    else{
        playerm3u8.pause();
        $('#vid_stream').css({'display':'none'});
        var sources = [{"type": "video/youtube", "src": vd}];
        playeryoutube.pause();
        playeryoutube.src(sources);
        playeryoutube.load();
        playeryoutube.currentTime(vid_curr_time_);

        $('#vid_youtube').css({'display':'block'});
        playeryoutube.play();
    }

}

if(typeof mplay_tit != 'undefined'){

    $("#video_player_movie").Video({
        instanceName:"player",
        instanceTheme:"dark",
        autohideControls:1,
        hideControlsOnMouseOut:"Yes",
        playerLayout: "fitToContainer",
        videoPlayerWidth: 1006,
        videoPlayerHeight: 420,
        lightBox:false,
        lightBoxAutoplay: false,
        lightBoxThumbnail:"",
        lightBoxThumbnailWidth: 400,
        lightBoxThumbnailHeight: 220,
        lightBoxCloseOnOutsideClick: true,
        playlist:"Off",
        playlistScrollType:"light",
        playlistBehaviourOnPageload:"closed",
        autoplay:true,
        colorAccent:"#cc181e",
        vimeoColor:"00adef",
        youtubeControls:"custom controls",
        youtubeSkin:"dark",
        youtubeColor:"red",
        youtubeQuality:"default",
        youtubeShowRelatedVideos:"No",
        videoPlayerShadow:"off",
        loadRandomVideoOnStart:"No",
        shuffle:"No",
        posterImg:"",
        onFinish:"Stop video",
        nowPlayingText:"No",
        fullscreen:"Fullscreen native",
        preloadSelfHosted:"none",
        rightClickMenu:true,
        hideVideoSource:false,
        showAllControls:true,
        allowSkipAd:true,
        embedShow:"No",
        infoShow:"No",
        shareShow:"No",
        facebookShow:"No",
        twitterShow:"No",
        mailShow:"No",

        //manual playlist
        videos:[
            {
                videoType: 'HTML5',
                title: mplay_tit,
                youtubeID:"",
                vimeoID:"",
                mp4: mplay_url,
                enable_mp4_download:"no",
                imageUrl:"",
                imageTimer:4,
                description:"",
                thumbImg:"",
                info:""
            }
        ]
    });
}
//
// $(window).load(function(){
//     $('.elite_vp_ytWrapper').width( $('.elite_vp_ytWrapper').height() / 100 * 177 );
// });


/*$(window).load(function(){
    $('.videos_li')[0].click();
    // setTimeout(function(){$('.videos_li')[0].click();},2000)
});



$('.to_now').css({'display':'none'});
$('.slick-prev').css({'display':'none'});*/

/*SLICK NEXT-PREW FUNC*/
var slick_click = 0;
// $('.slick-next').click(function(){
//     slick_click++;
//
//     if(slick_click > 0){
//         $('.to_now').css({'display':'block'});
//         $('.slick-prev').css({'display':'block'});
//     }
//
//     if(slick_click == 4){
//         $('.slick-next').css({'display':'none'});
//     }
//
// });

// $('.slick-prev').click(function(){
//     slick_click--;
//
//     $('.slick-next').css({'display':'block'});
//
//     if(slick_click == 0){
//         $('.to_now').css({'display':'none'});
//         $('.slick-prev').css({'display':'none'});
//     }
// });
//
// $('.to_now').click(function(){
//     slick_click = 0;
//     $('.slick-prev').css({'display':'none'});
//     $('.to_now').css({'display':'none'});
//     $('.slick-next').css({'display':'block'});
// });

$(function() {
    'use strict';
    // Initialize layouts and plugins
    $.Webarch.init();
});

$('.add_to_watch').click(function(){
    var mid = $(this).data('mid');
    var this_tag = $(this);
    var token = $('input[name="_token"]').val();

    $.ajax({
        type: 'post',
        url: '/movies/conwl',
        data: {
            mid: mid,
            '_token':token
        },
        success: function(res){
            if(res == "ins"){
                this_tag.text("Added to Watchlist");
                location.reload();
            }
            else{
                this_tag.text("Add to Watchlist");
                location.reload();
            }
        }
    })
});

$('.wlist_remove').click(function(){
    var del_mid = $(this).data('wlmid');
    var this_tag = $(this);
    var token = $('input[name="_token"]').val();

    $.ajax({
        type: 'post',
        url: '/movies/delwl',
        data: {
            del_mid: del_mid,
            '_token':token
        },
        success: function(res){
            if(res){
                this_tag.parent().fadeOut(500);
            }

        }
    })
});

$('.search_bar').click(function(){
    $('.search_cont').fadeIn('fast');
    $( ".search_bar_search" ).focus();
});

$(document).keyup(function(e) {
    if (e.keyCode == 27) {
        $('.search_cont').fadeOut('fast');
    }
});

$('.remove_search_bar').click(function(){
    $('.search_cont').fadeOut('fast');
});

//GENERAL SEARCH

$('.search_bar_search').keyup(function(){
    var search_words = $(this).val();
    search_us(search_words);
});

//COPLAY SEARCH

$('.coplay_search').keyup(function(){
    var search_words = $(this).val();
    search_coplay(search_words);
});

$('.coplay_btn').click(function(){
    if(inv_c != 0) return false;
    search_coplay('');
});

function search_us(search_words){
    $.ajax({
        type: 'post',
        dataType: 'json',
        url: '/search',
        data: {
            search_words: search_words,
            '_token':Laravel.csrfToken
        },
        success: function(data){
            $('.search_title_area').empty();
            $('.search_users_area').empty();
            $('.search_title_area').append('<h4>Titles</h4>');
            $('.search_users_area').append('<h4>Users</h4>');

            data.titles.forEach(function(item){
                var path;
                if(item.type == 'movie'){
                    path = "/movies/"+item.slug+"";
                }
                else{
                    path = "/episode/"+item.slug+"";
                }

                $('.search_title_area').append(
                    '<a href="'+path+'">'+
                    '<div class="row">' +
                    '<div class="col-md-2">' +
                    '<img src="/assets/images/'+item.poster+'" class="tit_thumb_img" alt="">' +
                    '</div>' +
                    '<div class="col-md-10">' +
                    '<p class="tit_img_l_text">'+item.title+'</p>' +
                    '</div>' +
                    '</div>'+
                    '</a>'
                );

            });

            data.users.forEach(function(item){

                $('.search_users_area').append(
                    '<a href="/users/'+item.username+'">'+
                    '<div class="row">' +
                    '<div class="col-md-2">' +
                    '<img src="/assets/images/'+item.avatar+'" class="tit_thumb_img tit_thumb_img_user" alt="">' +
                    '</div>' +
                    '<div class="col-md-10">' +
                    '<p class="tit_img_l_text">'+item.username+'</p>' +
                    '</div>' +
                    '</div>'+
                    '</a>'
                );

            })

        }
    })
}

function search_coplay(search_words){
    $.ajax({
        type: 'post',
        dataType: 'json',
        url: '/search_coplay',
        data: {
            movie_id: tm_7993wwil,
            search_words: search_words,
            '_token':Laravel.csrfToken
        },
        success: function(data){
            var search_area_count = 1;

            $('.copay_search_area').empty();

            data.forEach(function(item){
                if(item){
                    if(search_area_count <= 4){
                        search_area_count++;


                        $('.copay_search_area').append(
                            '<div class="friends-messages info coplay_sc_eu">'+
                            '<div class="pull-left m-r-10 m-t-10"><input class="inves_users" id="checkbox4" type="checkbox" value="'+item.id+'"></div>' +
                            '<div class="user-profile">' +
                            '<img src="/assets/images/'+item.avatar+'" alt="" data-src="/assets/images/'+item.avatar+'" data-src-retina="/assets/images/'+item.avatar+'" width="35" height="35">' +
                            '</div>' +
                            '<div class="message-wrapper">' +
                            '<div class="heading m-t-10">' + item.username +
                            '</div>' +
                            '</div>'+
                            '<div class="clearfix"></div>' +
                            '</div>'
                        );
                    }
                }

            })

        }
    })
}

$('.send_coplay_inv').click(function(){

    var coplayUrl = $(this).data('cophr');

    var inves_users = [];
    $('.inves_users').each(function(){
        if($(this).is(":checked") == true){
            inves_users.push($(this).val());
        }
    });

    if(inves_users != ''){

        $.ajax({
            type: 'post',
            dataType: 'json',
            url: '/coplay_inv',
            data: {
                m_id: tm_7993wwil,
                p_id: tp_1349jpqv,
                u_id: tu_8553wilo,
                inv_u_id: inves_users,
                '_token':Laravel.csrfToken
            },
            success: function(data){

                if(data == 4001){
                    location.reload();
                }
                else{
                    window.location.href = coplayUrl;
                }

            }
        })
    }

});

$('.scroll_row_right_icon').click(function(){
    $(this).prev().animate({scrollLeft: $( '.scroll_row' ).scrollLeft() + $(window).width() / 2}, 800);
});

$('.scroll_row_left_icon').click(function(){
    $(this).next().animate({scrollLeft: $( '.scroll_row' ).scrollLeft() - $(window).width() / 2}, 800);
});

var timer;
$(".play_trailer").mouseenter(function() {
    var this_video = $(this);
    timer = setTimeout(function(){
        var movie_id = this_video.attr('data-id');
        var gmid_path = '/get_trailer';
        $.ajax({
            type: 'post',
            url: gmid_path,
            data: {
                movie_id: movie_id,
                '_token': Laravel.csrfToken
            },
            success: function(res){
                this_video.find('video').html('<source src="'+res.trailer+'" type="video/mp4"></source>');
                this_video.find('video').fadeIn();
                this_video.find('video')[0].play();
            }
        });

    }, 1000);
}).mouseleave(function() {
    clearTimeout(timer);
    $('.trailer_video').fadeOut();
    $(this).find('video')[0].pause();
    $(this).find('video')[0].currentTime = 0;
});

$('.upload_up_image').click(function(){
    $('.uspimg_inp').click();
});

$('.uspimg_inp').change(function(){
    $(this).parent().submit();
});

$('.upload_up_image_cover').click(function(){
    $('.uscimg_inp').click();
});

$('.uscimg_inp').change(function(){
    $(this).parent().submit();
});

$('#watchTrailer').click(function(){

    $('.trailer_popup').fadeIn();
    $(".coverMe").fadeTo(500, 0.5);
    $('.trailer_video_popup')[0].play();
});

$('.remove_trailer_popup').click(function(){
    $('.trailer_popup').fadeOut();
    $(".coverMe").fadeOut(500);
    $('.trailer_video_popup')[0].pause();
    $('.trailer_video_popup')[0].currentTime = 0;
});

$('.remove_ph_frame').click(function(){
    $.ajax({
        type: 'post',
        url: '/remove_usphone_area',
        data: {
            rem: 1,
            '_token': Laravel.csrfToken
        }
    });
});

$('.open_rete_fr_list').click(function(){
    $('.rate_hid').show();
    $(this).hide();
});

$('.send_mess_f_u_p').click(function(){
    var u_Id = $(this).attr('id');
    if(!$('.chat-window-wrapper').hasClass('visible')){
        $('.chat-menu-toggle').click();
    }

    $('.open_mess_area').each(function(){
        if($(this).attr('id') == u_Id){
            $(this).click();
        }
    });
});

$('.show_a_f_p').click(function(){
    $('.us_hidden_av').css({'display':'block'});
    $('.show_a_f_p').css({'display':'none'});
});

//SOCIAL SHARE BUTTONS

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

//
// $(window).load(function(){
//     setTimeout(function(){
//         var active_bg_ads_goto_link = $('.channel_active').find('.bg_ads_goto_link').val();
//         var active_bg_ads_image = $('.channel_active').find('.bg_ads_image').val();
//         var hmelem = $(".chanads");
//         hmelem.css('background-image', 'url(' + active_bg_ads_image + ')');
//         hmelem.attr('thref',active_bg_ads_goto_link);
//
//         $('body').delegate('.chanads', 'click', function(){
//             window.location.href = $(this).attr('thref');
//         });
//
//     },5000);
//
//     setTimeout(function(){
//         $('.list_channels ').click(function(){
//             var active_bg_ads_goto_link = $('.channel_active').find('.bg_ads_goto_link').val();
//             var active_bg_ads_image = $('.channel_active').find('.bg_ads_image').val();
//             var hmelem = $(".chanads");
//             hmelem.css('background-image', 'url(' + active_bg_ads_image + ')');
//             hmelem.attr('thref',active_bg_ads_goto_link);
//         })
//
//
//
//     },5000);
//
// })
//
//
