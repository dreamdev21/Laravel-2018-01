var socket = io.connect(baseurl + ':3000');
var sel_channel = null,
    video_interval = null,
    recording_video_id = null,
    channel_poster = null,
    current_channel_id = null,
    current_user_id = null,
    current_channel_logo = "";
$(document).ready(function () {
    $.ajax({
        type: "post",
        dataType: "json",
        url: "get_live_tv",
        data: {_token:Laravel.csrfToken},
        success: function(data){
            console.log(data);
            init_timeline(data);
        }
    });
    $.ajax({
        type:"get",
        url: "user_id",
        success: function (data) {
            current_user_id = data;
        }
    });
    function init_timeline(data){
        var groups = new vis.DataSet();
        var items = new vis.DataSet();
        var s_group_id = 0;
        for(var f=0; f<data.categories.length; f++){
            for(var h=0; h<data.categories[f].channels.length; h++){
                var chan_emp_res = null;
                if(typeof data.categories[f].channels[h].videos == 'undefined'){
                    chan_emp_res = false;
                }
                else{
                    chan_emp_res = true;
                }
                if(data.categories[f].channels[h].id == localStorage.getItem('lwv')){
                    s_group_id = 1;
                }
                else{
                    s_group_id = makeid();
                }
                function makeid() {
                    var text = "";
                    var possible = '123456789';
                    for (var i = 0; i < 5; i++)
                        text += possible.charAt(Math.floor(Math.random() * possible.length));
                    return text;
                }
                groups.add({
                    order:s_group_id,
                    id: data.categories[f].channels[h].id,
                    content: '<div class="channelNumber">CHANNEL <span class="chNumber" >'+data.categories[f].channels[h].ch_num+'</span></div><span data-emp="'+chan_emp_res+'" class="hidden-id">'+data.categories[f].channels[h].id+'</span>'+data.categories[f].channels[h].title
                });
                if(data.categories[f].channels[h].videos){
                    for(var r=0; r<data.categories[f].channels[h].videos.length; r++){
                        var temp_video_arr = data.categories[f].channels[h].videos[r];
                        var start_t = edit_date_to_local(temp_video_arr.start_time);
                        var end_t = edit_date_to_local(temp_video_arr.end_time);
                        items.add({
                            id: temp_video_arr.id,
                            group: data.categories[f].channels[h].id,
                            start: start_t,
                            end: end_t,
                            content: temp_video_arr.title,
                            style: "height: 50px;"
                        });
                    }
                }
            }
        }

        var de = new Date();
        de = de.setDate(de.getDate() - 1);
        var options = {
            stack: false,
            start:de,
            end: new Date(1000*60*60*24 + (new Date()).valueOf()),
            editable: false,
            zoomable: false,
            zoomMin: 15000000,
            zoomMax: 15000000,
            verticalScroll: true,
            horizontalScroll: false,
            margin: {
                item: 10,
                axis: 5
            },
            rollingMode: {
                follow: true,
                offset: 0.5
            },
            orientation: 'top'
        };

        var container = document.getElementById('mytimeline');
        timeline = new vis.Timeline(container, null, options);
        timeline.setGroups(groups);
        timeline.setItems(items);
        $(document).delegate('.vis-label', 'click', function (e) {
            setTimeout(function () {
                setChannelId(e);
            }, 3000);
            $('.vis-label').removeClass('ltv_active_channel');
            $(this).addClass('ltv_active_channel');
            var channel_id = $(this).find('.hidden-id').text();
            if(video_interval != null){
                var playerads = videojs('vid_mp4');
                var playeryoutube = videojs('vid_youtube');
                playerads.pause();
                playeryoutube.pause();
                $('#vid_stream_playwire').html('');
                $('#vid_mp4').css({'display':'none'});
                $('#vid_youtube').css({'display':'none'});
                $('#vid_stream_playwire').css({'display':'none'});
                recording_video_id = null;
                clearInterval(video_interval);
            }
            setLocation(e);
            video_interval = setInterval(function () {
                localStorage.setItem('lwv', channel_id);
                init_live_tv(data, channel_id);
            }, 1000)
            channel_interval = setInterval(function () {
                setLiveWatchers();
            }, 10000)
        });

        var lwv_res = false;
        $('.hidden-id').each(function(){
            var lwv =  localStorage.getItem('lwv');
            if(lwv != null){
                if($(this).text() == lwv && $(this).attr('data-emp') != 'false'){
                    lwv_res = true;
                    $(this).parent().parent().click();
                }
            }
        });

        if(lwv_res == false){
            $('.hidden-id').each(function(){
                if($(this).attr('data-emp') != 'false'){
                    $(this).parent().parent().click();
                }
            });
        }
    }
});

function setLocation(e) {
    setTimeout(function () {
        var id = e.target.childNodes[0].childNodes[1].innerText;
        $.ajax({
            type: "post",
            dataType: "json",
            url: "tv_dashboard/watchers",
            data: {_token:Laravel.csrfToken, channel:id},
            success: function(r){
                console.log(r);
            }
        });
    }, 2000);
}

function setChannelId(e) {
    current_channel_id = e.target.childNodes[0].childNodes[1].innerText;
}

function setLiveWatchers(){
    if((current_channel_id !== null) && (current_channel_id !== null)) socket.emit('live watcher', {user_id:current_user_id, channel_id: current_channel_id});
}

function sel_channel_vid_time(date) {
    date = date.replace(/-/g, '/');
    date = new Date(date + ' UTC');
    return date;
}

function edit_date_to_local(date){
    var format = 'YYYY-MM-DD HH:mm:ss';
    date = date.replace(/-/g, '/');
    date = new Date(date+' UTC');
    return date;
}


function init_live_tv(data, channel_id){
    for(var t=0; t<data.categories.length; t++){
        for(var k=0; k<data.categories[t].channels.length; k++){
            if(data.categories[t].channels[k].id == channel_id) {
                sel_channel = data.categories[t].channels[k];
                channel_poster = sel_channel.logo;
                setChannelLogo(sel_channel.id, sel_channel);
                if(typeof sel_channel.videos == 'undefined'){
                    //alert('empty_channel');
                    clearInterval(video_interval);
                }
                else{
                    var now_recording = false;
                    for(var b=0; b<sel_channel.videos.length;b++){
                        var vid_start_time = sel_channel_vid_time(sel_channel.videos[b].start_time);
                        var vid_end_time   = sel_channel_vid_time(sel_channel.videos[b].end_time);
                        var time_now = new Date();
                        if(time_now > vid_start_time && time_now < vid_end_time){
                            if(recording_video_id != sel_channel.videos[b].id){
                                if(sel_channel.videos[b].ads_id != null){ init_player_ads(sel_channel.videos[b], sel_channel.mid_roll); }
                                else{ init_player(sel_channel.videos[b], false); }
                                recording_video_id = sel_channel.videos[b].id;
                            }
                            now_recording = true;
                        }
                    }
                    if(now_recording == false){
                        console.log('video record time is pasted');
                        var playerads = videojs('vid_mp4');
                        var playeryoutube = videojs('vid_youtube');
                        playerads.pause();
                        playeryoutube.pause();
                        $('#vid_stream_playwire').html('');
                        $('#vid_mp4').css({'display':'none'});
                        $('#vid_youtube').css({'display':'none'});
                        $('#vid_stream_playwire').css({'display':'none'});
                        recording_video_id = null;
                        clearInterval(video_interval);
                    }
                }
            }
        }
    }
}

function init_player(video, after_ads) {
    var vid_curr_time_ = Math.round( new Date().getTime()/1000 ) - Math.round( new Date(video.start_time+' UTC').getTime()/1000 );
    if(after_ads) vid_curr_time_ = 0;
    var vd = video.url;
    console.log(vd);
    var playerads = videojs('vid_mp4');
    var playeryoutube = videojs('vid_youtube');
    var youtubeads = videojs('vid_adv_youtube');
    playerads.pause();
    playeryoutube.pause();
    $('#vid_mp4').css({'display':'none'});
    $('#vid_adv_youtube').css({'display':'none'});
    $('.skip_ads').css({'display':'none'});
    var vd_res = vd.split(".");
    if(vd_res[1] == 'youtube'){
        $('#vid_stream_playwire').html('');
        $('#vid_stream_playwire').css({'display':'none'});
        var sources = [{"type": "video/youtube", "src": vd}];
        playeryoutube.pause();
        playeryoutube.src(sources);
        playeryoutube.load();
        if (channel_poster != null && channel_poster != ''){
            $('.vjs-poster').parent().children().eq(2).css('background-image','url(/assets/images/tvstation/'+channel_poster+')');
        }
        else{
            $('.vjs-poster').parent().children().eq(2).css('background-image','url("/assets/images/fv-logo-bg.gif")');
        }
        playeryoutube.on('play', function() {
            console.log(this.currentTime());
        });
        playeryoutube.play();
        $('#vid_youtube').css({'display':'block'});
        $('.vjs-poster').css({'display':'none'});
    } else{
        playeryoutube.pause();
        $('#vid_youtube').css({'display':'none'});
        if (channel_poster != null && channel_poster != ''){
            $('.vjs-poster').parent().children().eq(2).css('background-image','url(/assets/images/tvstation/'+channel_poster+')');
        }
        else{
            $('.vjs-poster').parent().children().eq(2).css('background-image','url("/assets/images/fv-logo-bg.gif")');
        }
        $('#vid_stream_playwire').css({'display':'block'});
        $('#vid_stream_playwire').html(vd);
        $('#vid_stream_playwire').css({'display':'block'});
    }
}

function init_player_ads(video, mid_roll) {
    console.log('-------------------'+mid_roll);
    var vid_curr_time_ = Math.round( new Date().getTime()/1000 ) - Math.round( new Date(video.start_time+' UTC').getTime()/1000 );
    if(vid_curr_time_ < 10){
        localStorage.setItem('watc_vid',video.id);
        var playerads = videojs('vid_mp4');
        var youtubeads = videojs('vid_adv_youtube');
        var playeryoutube = videojs('vid_youtube');
        var preroll = video.ads_id;
        playeryoutube.pause();
        $('#vid_stream_playwire').html('');
        $('#vid_mp4').css({'display': 'none'});
        $('#vid_youtube').css({'display': 'none'});
        $('#vid_stream_playwire').css({'display': 'none'});
        var sources = [];
        var adv_type = 'url';
        if((preroll.preroll_mp4 !== null) && (preroll.preroll_mp4 !== "")) adv_type = 'mp4';
        if(adv_type === 'mp4') sources = [{"type": "video/mp4", "src": "https://frenvid.s3-us-west-2.amazonaws.com/ads/videos/"+preroll.preroll_mp4}];
        else sources = [{"type": "video/youtube", "src": preroll.url}];
        if(adv_type === 'mp4'){
            playerads.pause();
            playerads.src(sources);
            playerads.load();
            $('#vid_mp4').css({'display': 'block'});
            $('.skip_ads').css({'display': 'block'});
            var skip_count = preroll.preroll_skip_timer;
            skip_interval_c_rs(skip_count);
            $('#vid_mp4').click(function(){
                init_player(video, true);
                window.open(preroll.preroll_goto_link, '_blank');
            });
            playerads.on('ended', function() {
                init_player(video, true);
            });
        }
        else{
            youtubeads.pause();
            youtubeads.src(sources);
            youtubeads.load();
            $('#vid_adv_youtube').css({'display': 'block'});
            $('.skip_ads').css({'display': 'block'});
            var skip_count = preroll.preroll_skip_timer;
            skip_interval_c_rs(skip_count);
            $('#vid_adv_youtube').click(function(){
                init_player(video, true);
                window.open(preroll.preroll_goto_link, '_blank');
            });
            youtubeads.on('ended', function() {
                init_player(video, true);
            });
        }
        $('.skip_ads').click(function(){
            if($('.skip_ads span').text() == '') init_player(video, true);
        });
    }
    else{
        if(localStorage.getItem('watc_vid') == null){
            if(mid_roll === 1){
                localStorage.setItem('watc_vid',video.id);
                var playerads = videojs('vid_mp4');
                var playeryoutube = videojs('vid_youtube');
                var preroll = video.ads_id;
                var youtubeads = videojs('vid_adv_youtube');
                playeryoutube.pause();
                $('#vid_stream_playwire').html('');
                $('#vid_mp4').css({'display': 'none'});
                $('#vid_youtube').css({'display': 'none'});
                $('#vid_stream_playwire').css({'display': 'none'});
                var adv_type = 'url';
                if((preroll.preroll_mp4 !== null) && (preroll.preroll_mp4 !== "")) adv_type = 'mp4';
                if(adv_type === 'mp4') sources = [{"type": "video/mp4", "src": "https://frenvid.s3-us-west-2.amazonaws.com/ads/videos/"+preroll.preroll_mp4}];
                else sources = [{"type": "video/youtube", "src": preroll.url}];
                if(adv_type === 'mp4'){
                    playerads.pause();
                    playerads.src(sources);
                    playerads.load();
                    $('#vid_mp4').css({'display': 'block'});
                    $('.skip_ads').css({'display': 'block'});
                    var skip_count = preroll.preroll_skip_timer;
                    skip_interval_c_rs(skip_count);
                    $('#vid_mp4').click(function(){
                        init_player(video, true);
                        window.open(preroll.preroll_goto_link, '_blank');
                    });
                    playerads.on('ended', function() {
                        init_player(video, true);
                    });
                }
                else{
                    youtubeads.pause();
                    youtubeads.src(sources);
                    youtubeads.load();
                    $('#vid_adv_youtube').css({'display': 'block'});
                    $('.skip_ads').css({'display': 'block'});
                    var skip_count = preroll.preroll_skip_timer;
                    skip_interval_c_rs(skip_count);
                    $('#vid_adv_youtube').click(function(){
                        init_player(video, true);
                        window.open(preroll.preroll_goto_link, '_blank');
                    });
                    youtubeads.on('ended', function() {
                        init_player(video, true);
                    });
                }
                $('.skip_ads').click(function(){
                    if($('.skip_ads span').text() == '') init_player(video, true);
                });
            }
            else{
                localStorage.setItem('watc_vid',video.id);
                init_player(video, true);
            }
        }else init_player(video, false);
    }
}

function skip_interval_c_rs(skip_count){
    clearInterval(window.skip_interval);
    window.skip_interval = setInterval( function(){
        $('.skip_ads span').text(skip_count--);
        if(skip_count ==0){
            $('.skip_ads span').text('');
            clearInterval(skip_interval);
        }
    },1000);
}

function setChannelLogo(id, sel_channel) {
    $.ajax({
        type:"get",
        url: "get_channel_user/"+id,
        success: function (data) {
            console.log(data);
            if(parseInt(data) !== 0){
                current_channel_logo = "https://frenvid.s3-us-west-2.amazonaws.com/tv_users/logo/"+ data +'/'+ sel_channel.channel_logo;
                console.log(current_channel_logo);
                $('#channel-logo').attr('src', current_channel_logo);
                $('#channel-logo-div').removeClass('hidden');
            }
            else $('#channel-logo-div').addClass('hidden');
        }
    });
}