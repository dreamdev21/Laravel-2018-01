(function($){
    "use strict";
    $('.get_channel_data').click(function(){
        var value = $(".get_v_data").val();
        var token = $('input[name="_token"]').val();
        $('.loading_gif').css('display', 'inline-block');
        $.ajax({
            type: "POST",
            url: "/admin/get_channels",
            data: {url : value,'_token':token},
            success: function(data){
                $('.loading_gif').css('display', 'none');
                $('.channel_all_data').html(data);
            }
        });
        return false;
    });

    $(document).on('click','.add_video', function(){
        var __this = $(this);
        var id = $(this).attr('id');
        var channel_id = $(this).parents('tr').find('.channel_id').val();
        var video_title = $(this).parents('tr').find('.video_title').html();
        var video_description = $(this).parents('tr').find('.video_description').html();
        var video_url = $(this).parents('tr').find('.video_url').html();
        var channel_title = $(this).parents('tr').find('.channel_title').html();

        var token = $('input[name="_token"]').val();
        $.ajax({
            type: "POST",
            url: "/admin/create_video",
            data: {
                id : id,
                channel_id : channel_id,
                title : video_title,
                description : video_description,
                url : video_url,
                channel_title : channel_title,
                '_token':token
            },
            success: function(data){
                if(data == 1){
                    __this.html('Added');
                    __this.attr('disabled', true);
                }
            }
        });
        return false;
    });

    $(document).on('click','.add_channel', function(){
        var __this = $(this);
        var channel_category = $('.channel_category').val();
        var id = $(this).attr('id');
        var channel_thumb = $('.channel_thumb').attr('src');
        var channel_title = $('.channel_title').html();
        var channel_description = $('.channel_description').html();
        var channel_url = $('.channel_url').html();

        var token = $('input[name="_token"]').val();
        $.ajax({
            type: "POST",
            url: "/admin/create_channel",
            data: {
                id : id,
                channel_thumb : channel_thumb,
                channel_title : channel_title,
                channel_description : channel_description,
                channel_url : channel_url,
                channel_category : channel_category,
                '_token':token
            },
            success: function(data){
                if(data == 1){
                    __this.html('Added');
                    __this.attr('disabled', true);
                }
            }
        });
        return false;
    });


    $('#datetimepicker_start').datetimepicker({
        format:'Y-m-d H:i:s',
        allowTimes: [
            '01:00', '01:10', '01:20', '01:30', '01:40', '01:50',
            '02:00', '02:10', '02:20', '02:30', '02:40', '02:50',
            '03:00', '03:10', '03:20', '03:30', '03:40', '03:50',
            '04:00', '04:10', '04:20', '04:30', '04:40', '04:50',
            '05:00', '05:10', '05:20', '05:30', '05:40', '05:50',
            '06:00', '06:10', '06:20', '06:30', '06:40', '06:50',
            '07:00', '07:10', '07:20', '07:30', '07:40', '07:50',
            '08:00', '08:10', '08:20', '08:30', '08:40', '08:50',
            '09:00', '09:10', '09:20', '09:30', '09:40', '09:50',
            '10:00', '10:10', '10:20', '10:30', '10:40', '10:50',
            '11:00', '11:10', '11:20', '11:30', '11:40', '11:50',
            '12:00', '12:10', '12:20', '12:30', '12:40', '12:50',
            '13:00', '13:10', '13:20', '13:30', '13:40', '13:50',
            '14:00', '14:10', '14:20', '14:30', '14:40', '14:50',
            '15:00', '15:10', '15:20', '15:30', '15:40', '15:50',
            '16:00', '16:10', '16:20', '16:30', '16:40', '16:50',
            '17:00', '17:10', '17:20', '17:30', '17:40', '17:50',
            '18:00', '18:10', '18:20', '18:30', '18:40', '18:50',
            '19:00', '19:10', '19:20', '19:30', '19:40', '19:50',
            '20:00', '20:10', '20:20', '20:30', '20:40', '20:50',
            '21:00', '21:10', '21:20', '21:30', '21:40', '21:50',
            '22:00', '22:10', '22:20', '22:30', '22:40', '22:50',
            '23:00', '23:10', '23:20', '23:30', '23:40', '23:50',
            '24:00', '24:10', '24:20', '24:30', '24:40', '24:50'

        ]
    });

    $('#datetimepicker_end').datetimepicker({
        format:'Y-m-d H:i:s',
        allowTimes: [
            '01:00', '01:10', '01:20', '01:30', '01:40', '01:50',
            '02:00', '02:10', '02:20', '02:30', '02:40', '02:50',
            '03:00', '03:10', '03:20', '03:30', '03:40', '03:50',
            '04:00', '04:10', '04:20', '04:30', '04:40', '04:50',
            '05:00', '05:10', '05:20', '05:30', '05:40', '05:50',
            '06:00', '06:10', '06:20', '06:30', '06:40', '06:50',
            '07:00', '07:10', '07:20', '07:30', '07:40', '07:50',
            '08:00', '08:10', '08:20', '08:30', '08:40', '08:50',
            '09:00', '09:10', '09:20', '09:30', '09:40', '09:50',
            '10:00', '10:10', '10:20', '10:30', '10:40', '10:50',
            '11:00', '11:10', '11:20', '11:30', '11:40', '11:50',
            '12:00', '12:10', '12:20', '12:30', '12:40', '12:50',
            '13:00', '13:10', '13:20', '13:30', '13:40', '13:50',
            '14:00', '14:10', '14:20', '14:30', '14:40', '14:50',
            '15:00', '15:10', '15:20', '15:30', '15:40', '15:50',
            '16:00', '16:10', '16:20', '16:30', '16:40', '16:50',
            '17:00', '17:10', '17:20', '17:30', '17:40', '17:50',
            '18:00', '18:10', '18:20', '18:30', '18:40', '18:50',
            '19:00', '19:10', '19:20', '19:30', '19:40', '19:50',
            '20:00', '20:10', '20:20', '20:30', '20:40', '20:50',
            '21:00', '21:10', '21:20', '21:30', '21:40', '21:50',
            '22:00', '22:10', '22:20', '22:30', '22:40', '22:50',
            '23:00', '23:10', '23:20', '23:30', '23:40', '23:50',
            '24:00', '24:10', '24:20', '24:30', '24:40', '24:50'

        ]
    });



    if(typeof tv_select_video_ads != 'undefined'){
        $('.select_video_ads').change(function(){
            var ads_id = $(this).val();
            var video_id = $(this).attr('id');
            var token = $('input[name="_token"]').val();
            $.ajax({
                type: 'post',
                url: '/tv/videos/ads',
                data: {
                    ads_id: ads_id,
                    video_id: video_id,
                    '_token':token
                },
                success: function(res){
                    $('.ads_save').fadeIn(0);
                    setTimeout(function(){
                        $('.ads_save').fadeOut("slow");
                    }, 500)
                }
            })
        });
    }
    else{
        $('.select_video_ads').change(function(){
            var ads_id = $(this).val();
            var video_id = $(this).attr('id');
            var token = $('input[name="_token"]').val();
            $.ajax({
                type: 'post',
                url: '/admin/videos/ads',
                data: {
                    ads_id: ads_id,
                    video_id: video_id,
                    '_token':token
                },
                success: function(res){
                    $('.ads_save').fadeIn(0);
                    setTimeout(function(){
                        $('.ads_save').fadeOut("slow");
                    }, 500)
                }
            })
        });
    }

    $('.select_channel_ads').change(function(){
       var ads_id = $(this).val();
       var channel_id = $(this).attr('id');
       var token = $('input[name="_token"]').val();
       $.ajax({
           type: 'post',
           url: '/admin/videos/ads_all',
           data: {
               ads_id: ads_id,
               channel_id: channel_id,
               '_token':token
           },
           success: function(res){
                $('.ads_save').fadeIn(0);
               setTimeout(function(){
                   $('.ads_save').fadeOut("slow");
               }, 500)
           }
       })
    });

    $('.select_channel_ads_bg').change(function(){
       var ads_id = $(this).val();
       var channel_id = $(this).attr('id');
       var token = $('input[name="_token"]').val();
       $.ajax({
           type: 'post',
           url: '/admin/videos/ads_all_bg',
           data: {
               ads_id: ads_id,
               channel_id: channel_id,
               '_token':token
           },
           success: function(res){
                $('.ads_save').fadeIn(0);
               setTimeout(function(){
                   $('.ads_save').fadeOut("slow");
               }, 500)
           }
       })
    });

    $('.del_aws_t_f_file').click(function(){
        if(!confirm("Are you sure?")) return false;
        var delurl = $(this).data('delurl');
        var this_tag = $(this);
        var token = $('input[name="_token"]').val();



        $.ajax({
            type: 'post',
            url: '/admin/media/del_s3_file',
            data: {
                delurl: delurl,
                '_token':token
            },
            success: function(res){
                this_tag.parent().parent().fadeOut(500);
            }
        })


    });


    //UPLOAD FORM ADMIN GENERAL
    $('#uploadForm').submit(function() {
        var UNIX_now = + new Date();
        $('.media_prog_bar').width('0%');
        $('.media_prog_bar').text('0%');

        var file = $('#s3_up_file')[0].files[0];
        var studio = $('#studio').val();
        var m_type = $('#m_type').val();
        var fd = new FormData();

        var file_name = studio+'.'+m_type+'.'+UNIX_now+'_'+file.name;

        fd.set("s3_up_file", file, file_name);

        //fd.append("s3_up_file", file);
        // These extra params aren't necessary but show that you can include other data.
        //fd.set(filename, file_name);
        var xhr = new XMLHttpRequest();
        xhr.open('POST', baseurl + ':3000/uploads', true);

        xhr.upload.onprogress = function(e) {
            if (e.lengthComputable) {
                console.log(e.loaded +'/'+ e.total);
                var percentComplete = (e.loaded / e.total) * 100;
                $('.media_prog_bar').css({'width':percentComplete+'%'});
                $('.media_prog_bar').text(Math.round(percentComplete).toFixed(0)+'%');
            }
        };
        xhr.onload = function() {
            if (this.status == 200) {

                //console.log(this);
                // var resp = JSON.parse(this.response);
                // console.log('Server got:', resp);
                // var image = document.createElement('img');
                // image.src = resp.dataUrl;
                // document.body.appendChild(image);
            }
        };
        var qweqwe = xhr.send(fd);

        return false;
    });



    //UPLOAD FORM FILM
    $('#uploadForm_film').submit(function() {
        var UNIX_now = + new Date();
        $('.media_prog_bar_film').width('0%');
        $('.media_prog_bar_film').text('0%');
        var file = $('#s3_up_file_film')[0].files[0];
        var studio = $('#studio').val();
        var m_type = $('#uploadForm_film_inp').val();
        var fd = new FormData();
        var file_name = studio+'.'+m_type+'.'+UNIX_now+'_'+file.name;
        fd.set("s3_up_file", file, file_name);
        var xhr = new XMLHttpRequest();
        xhr.open('POST', baseurl + ':3000/uploads', true);
        xhr.upload.onprogress = function(e) {
            if (e.lengthComputable) {
                $('.adm_media_upl_text_film').css({'display':'block'});
                var percentComplete = (e.loaded / e.total) * 100;
                $('.media_prog_bar_film').css({'width':percentComplete+'%'});
                $('.media_prog_bar_film').text(Math.round(percentComplete).toFixed(0)+'%');
                if(percentComplete == 100){
                    $('.adm_media_upl_text_film').text('we are currently checking the uploaded file');
                    $('.adm_media_upl_text_film').removeClass('label-warning');
                    $('.adm_media_upl_text_film').addClass('label-info');
                    $('.adm_media_upl_img_film').css({'display':'block'});
                }
            }
        };
        xhr.onload = function() {
            if (this.status == 200) {
                done_upload_film();
            }
        };
        var qweqwe = xhr.send(fd);

        return false;
    });



    //UPLOAD FORM TRAILER
    $('#uploadForm_trailer').submit(function() {
        var UNIX_now = + new Date();
        $('.media_prog_bar_trailer').width('0%');
        $('.media_prog_bar_trailer').text('0%');
        var file = $('#s3_up_file_trailer')[0].files[0];
        var studio = $('#studio').val();
        var m_type = $('#uploadForm_trailer_inp').val();
        var fd = new FormData();
        var file_name = studio+'.'+m_type+'.'+UNIX_now+'_'+file.name;
        fd.set("s3_up_file", file, file_name);
        var xhr = new XMLHttpRequest();
        xhr.open('POST', baseurl + ':3000/uploads', true);
        xhr.upload.onprogress = function(e) {
            if (e.lengthComputable) {
                $('.adm_media_upl_text_trailer').css({'display':'block'});
                var percentComplete = (e.loaded / e.total) * 100;
                $('.media_prog_bar_trailer').css({'width':percentComplete+'%'});
                $('.media_prog_bar_trailer').text(Math.round(percentComplete).toFixed(0)+'%');
                if(percentComplete == 100){
                    $('.adm_media_upl_text_trailer').text('we are currently checking the uploaded file');
                    $('.adm_media_upl_text_trailer').removeClass('label-warning');
                    $('.adm_media_upl_text_trailer').addClass('label-info');
                    $('.adm_media_upl_img_trailer').css({'display':'block'});

                }
            }
        };
        xhr.onload = function() {
            if (this.status == 200) {
                done_upload_trailer();
            }
        };
        var qweqwe = xhr.send(fd);

        return false;
    });



    //UPLOAD FORM IMAGE
    $('#uploadForm_image').submit(function() {
        var UNIX_now = + new Date();
        $('.media_prog_bar_image').width('0%');
        $('.media_prog_bar_image').text('0%');

        var file = $('#s3_up_file_image')[0].files[0];
        var studio = $('#studio').val();
        var m_type = $('#uploadForm_image_inp').val();

        var fd = new FormData();

        var file_name = studio+'.'+m_type+'.'+UNIX_now+'_'+file.name;

        fd.set("s3_up_file", file, file_name);


        var xhr = new XMLHttpRequest();
        xhr.open('POST', baseurl + ':3000/uploads', true);

        xhr.upload.onprogress = function(e) {
            if (e.lengthComputable) {
                console.log(e.loaded +'/'+ e.total);
                var percentComplete = (e.loaded / e.total) * 100;
                $('.media_prog_bar_image').width(percentComplete+'%');
                $('.media_prog_bar_image').text(percentComplete+'%');
            }
        };
        xhr.onload = function() {
            if (this.status == 200) {
                done_upload_image();

            }
        };
        var qweqwe = xhr.send(fd);

        return false;
    });

    function done_upload_film(){
        var token = $('input[name="_token"]').val();
        $.ajax({
            type: 'post',
            url: '/studio/media/getLastUploadetFile',
            data: {
                getlast_update: 'film',
                '_token':token
            },
            success: function(res){
                var res_f = res.split("/uploads/");
                res_f = res_f[1];
                res_f = res_f.replace('%20', " ");
                $('.adm_media_upl_img_film').css({'display':'none'});
                $('.adm_media_upl_img_check_film').css({'display':'block'});
                $('.adm_media_upl_text_film').text('File uploaded to server');
                $('.adm_media_upl_text_film').removeClass('label-info');
                $('.adm_media_upl_text_film').addClass('label-success');

                $('#url').val(res);
                $('#url_f').val(res_f);
            }
        })
    }

    function done_upload_trailer(){
        var token = $('input[name="_token"]').val();
        $.ajax({
            type: 'post',
            url: '/studio/media/getLastUploadetFile',
            data: {
                getlast_update: 'trailer',
                '_token':token
            },
            success: function(res){
                var res_f = res.split("/uploads/");
                res_f = res_f[1];
                res_f = res_f.replace('%20', " ");
                $('.adm_media_upl_img_trailer').css({'display':'none'});
                $('.adm_media_upl_img_check_trailer').css({'display':'block'});
                $('.adm_media_upl_text_trailer').text('File uploaded to server');
                $('.adm_media_upl_text_trailer').removeClass('label-info');
                $('.adm_media_upl_text_trailer').addClass('label-success');
                $('#trailer').val(res);
                $('#trailer_f').val(res_f);
            }
        })
    }

    function done_upload_image(){
        var token = $('input[name="_token"]').val();
        $.ajax({
            type: 'post',
            url: '/studio/media/getLastUploadetFile',
            data: {
                getlast_update: 'image',
                '_token':token
            },
            success: function(res){
                console.log(res);
            }
        })
    }

    $('.scr_tt').click(function(){
        $("html, body").animate({ scrollTop: 0 }, "slow");
    });

    $('.prod_moviup_form').submit(function(){

        if( $('#title').val() != '' &&
            $('#year').val() != '' &&
            $('#price').val() != '' &&
            $('#period').val() != '' &&
            $('#type').val() != '' &&
            $('#poster').val() != '' &&
            $('#studio').val() != '' &&
            $('#director').val() != '' &&
            $('#url').val() != '' )
        {
            console.log('Submit')
        }
        else{
            $('.adm_form_req_mess').css({'display':'block'});
            return false;
            console.log('false1');
        }

        if(typeof $('#series_name') != 'undefined'){
            if($('#series_name').val() != ''){
                console.log('Submit')
            }
            else{
                $('.adm_form_req_mess').css({'display':'block'});
                return false;
                console.log('false2');
            }
        }
        else{
            $('.adm_form_req_mess').css({'display':'block'});
            return false;
            console.log('false3');
        }

        if(typeof $('#seasons') != 'undefined'){
            if($('#seasons').val() != ''){
                console.log('Submit')
            }
            else{
                $('.adm_form_req_mess').css({'display':'block'});
                return false;
                console.log('false4');
            }

        }
        else{
            $('.adm_form_req_mess').css({'display':'block'});
            return false;
            console.log('false5');

        }

    });

    $('.close-top-notif-studio').click(function(){
        $(this).parent().parent().fadeOut();
    });

    $( ".series_sel" ).change(function() {
        if($(this).val()){

            var token = $('input[name="_token"]').val();
            $.ajax({
                type: 'post',
                dataType: 'json',
                url: user_ajax_select_url_i10n,
                data: {
                    serie_id: $(this).val(),
                    '_token':token
                },
                success: function(res){
                    $('.season_sel').empty();
                    var count_series_sel_res = 0;
                    $.each(res, function (i, item) {
                        if(i == 0){
                            $('.season_sel').append($('<option>', {
                                value: '',
                                text : '---'
                            }));
                        }
                        count_series_sel_res++;
                        $('.season_sel').append($('<option>', {
                            value: item.id,
                            text : item.number
                        }));
                    });
                    if(count_series_sel_res == 0){
                        $('.season_sel').append($('<option>', {
                            value: '',
                            text : '---'
                        }));
                    }
                }
            })

        }
        else{
            $('.season_sel').empty();
            $('.season_sel').append($('<option>', {
                value: '',
                text : '---'
            }));
        }
    });

    $('.create_ads_type').on('change', function(){
        var ads_type__ = $(this).val();

        if(ads_type__ == 'channel_bg'){
            $('.create_ads_preroll').fadeOut(500);
            setTimeout(function(){
                $('.create_ads_channel_bg').fadeIn(200);
            },500);
        }
        else{
            $('.create_ads_channel_bg').fadeOut(500);
            setTimeout(function(){
                $('.create_ads_preroll').fadeIn(200);
            },500);
        }
        //create_ads_preroll
        //create_ads_channel_bg
    });

    $('.ads_add_banner_ads_area').click(function(){
        $(this).parent().parent().parent().parent().toggleClass('ads_add_banner_ads_area_hidden')
    });

    $('.ads_type_radio').on('change', function(){
        if($(this).val() == 'banner'){
            $('.ads_type_google').css({'opacity':'0.1'});
            $('.ads_type_banner').css({'opacity':'1'});
        }
        else{
            $('.ads_type_google').css({'opacity':'1'});
            $('.ads_type_banner').css({'opacity':'0.1'});
        }
    });

    $('.del_posts_category').click(function(){
        if(!confirm('If you delete this category it delete all posts inside category. Are you sure?')) return false;

        var catid = $(this).data('cid');

        var this_tag = $(this);

        var token = $('input[name="_token"]').val();

        $.ajax({
            type: 'post',
            url: '/admin/delete_post_cat',
            data: {
                catid: catid,
                '_token':token
            },
            success: function(res){
                this_tag.parent().parent().fadeOut();
            }
        })
    });

    $('.edit_post_category').click(function(){

        var catid = $(this).data('cid');
        var catname = $(this).data('val');
        var this_tag = $(this);
        var token = $('input[name="_token"]').val();

        var cat_name = prompt("Edit category name", catname);
        if (cat_name != null) {
            $.ajax({
                type: 'post',
                url: '/admin/edit_post_cat',
                data: {
                    catid: catid,
                    cat_name: cat_name,
                    '_token':token
                },
                success: function(res){
                    this_tag.parent().prev().text(cat_name);
                    this_tag.data('val', cat_name);
                }
            })
        }

    });

    $('.subm_news_slide_img').on('change',function(){
        var vidid = $(this).data('vidid');
        var event_pub = $(this).val();
        var this_tag = $(this);

        var title = $('.slide_text_'+vidid).val();
        var desc = $('.slide_desc_'+vidid).val();
        console.log(title, desc);
        $.ajax({
            type: 'post',
            url: '/admin/edit_video_slide_pub',
            data: {
                title:title,
                desc:desc,
                vidid: vidid,
                event_pub: event_pub,
                '_token':Laravel.csrfToken
            }
        })

    });


    $('.subm_movei_slide_img').on('change',function(){
        var movid = $(this).data('movid');
        var event_pub = $(this).val();
        var this_tag = $(this);

        console.log(event_pub);
        $.ajax({
            type: 'post',
            url: '/admin/edit_movie_slide_pub',
            data: {
                movid: movid,
                event_pub: event_pub,
                '_token':Laravel.csrfToken
            }
        })

    });

    $('.adm_del_user').click(function(){

        if(!confirm('Are you sure?')) return false;

        var uid = $(this).attr('id');
        var this_tag = $(this);

        $.ajax({
            type: 'post',
            url: '/admin/del_user',
            data: {
                uid: uid,
                '_token':Laravel.csrfToken
            },
            success: function(res){
                this_tag.parent().parent().fadeOut();
            }
        })
    });

    $('.sel_parental').change(function(){
        var m_id = $(this).attr('id');
        var par_id = $(this).val();
        $.ajax({
            type: 'post',
            url: '/admin/mov_parental',
            data: {
                m_id: m_id,
                par_id: par_id,
                '_token': Laravel.csrfToken
            },
            success: function(){

            }
        });
    });

    $('.sel_parental_stud').change(function(){
        var m_id = $(this).attr('id');
        var par_id = $(this).val();
        $.ajax({
            type: 'post',
            url: '/studio/mov_parental',
            data: {
                m_id: m_id,
                par_id: par_id,
                '_token': Laravel.csrfToken
            },
            success: function(){

            }
        });
    });

    $('.del_hp_slide_image').click(function(){
        var img_id = $(this).attr('id');
        var this_tag = $(this);
        $.ajax({
            type: 'post',
            url: '/admin/del_hp_slide_image',
            data: {
                img_id:img_id,
                '_token': Laravel.csrfToken
            },
            success: function(){
                this_tag.parent().fadeOut();
            }
        });
    });

})(jQuery);



function subStatForStudio(payreqid, this_tag) {
    var value = this_tag.value;

    $.ajax({
        type:'post',
        url:'/admin/sub_stat_studio',
        data:{
            payreqid: payreqid,
            value: value,
            '_token':Laravel.csrfToken
        },
        success:function(){
            $('.sub_stud_status_mess').fadeIn(1000);
            setTimeout(function(){
                $('.sub_stud_status_mess').fadeOut(1000);
            },3000)
        }
    })
}


