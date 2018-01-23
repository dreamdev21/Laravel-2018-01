var app            = require('express')();
var http           = require('http').Server(app);
var io             = require('socket.io')(http);
var port           = process.env.PORT || 3000;
var url            = require('url');
var fs             = require('fs');
var express        = require("express");
var multer         = require('multer');
var multerS3       = require('multer-s3');
var cors           = require('cors');
var bodyParser     = require('body-parser');
var aws            = require('aws-sdk');
var firebase       = require("firebase-admin");
var serviceAccount = require("./frenvid-98897-firebase-adminsdk-7ponu-fdab72083a.json");
app.use(cors());
app.use(bodyParser.urlencoded({ extended: false }));
app.use(bodyParser.json());



require('dotenv').load();

var path = require('path');
var AccessToken = require('twilio').AccessToken;
var VideoGrant = AccessToken.VideoGrant;
var randomUsername = require('./randos');
var watchers = {};

// Create Express webapp

/*
 Generate an Access Token for a chat application user - it generates a random
 username for the client requesting a token, and takes a device ID as a query
 parameter.
 */
app.get('/token', function(request, response) {

    var identity = randomUsername();

    // Create an access token which we will sign and return to the client,
    // containing the grant we just created
    var token = new AccessToken(
        process.env.TWILIO_ACCOUNT_SID,
        process.env.TWILIO_API_KEY,
        process.env.TWILIO_API_SECRET
    );

    // Assign the generated identity to the token
    token.identity = identity;

    //grant the access token Twilio Video capabilities
    var grant = new VideoGrant();
    grant.configurationProfileSid = process.env.TWILIO_CONFIGURATION_SID;
    token.addGrant(grant);

    // Serialize the token to a JWT string and include it in a JSON response
    response.send({
        identity: identity,
        token: token.toJwt()
    });
});






//firebase
firebase.initializeApp({
    credential: firebase.credential.cert(serviceAccount),
    databaseURL: "https://frenvid-98897.firebaseio.com"
});
//socket io
var sio_users = new Array();
var temp_vid_array = {};
var sio_vid_rooms = {};
if(typeof sio_online_users == 'undefined'){
    var sio_online_users = {};
}
var video_chat_url = '';
checkWatchers();



io.on('connection', function(socket){

    // firebase.database().ref('/mess/utou1-14').remove();

    socket.on('message', function(message) {
        socket.broadcast.emit('message', message);
    });
	
	socket.on('test message', function(message) {
        socket.emit('test message from server', '99999999999');
    });

    socket.on('join', function (data) {
        for (var item in sio_online_users) {
            if(sio_online_users[item] == data.sio_u_id){
                socket.to(item).emit('red ses', {
                    'status': true
                });
            }
        }
        sio_online_users[socket.id] = data.sio_u_id;
        sio_users[data.sio_u_id] = {avatar:data.sio_u_avatar, username:data.sio_u_username};
        socket.join(data.sio_u_id);
    });

    socket.on('join video room', function (data) {

        if(typeof sio_vid_rooms[data.room_id] == 'undefined'){
            sio_vid_rooms[data.room_id] = {};
            temp_vid_array[data.sio_u_id] = {id: data.sio_u_id, username: data.sio_u_username, avatar: data.sio_u_avatar}
            sio_vid_rooms[data.room_id] = temp_vid_array;
        }

        else{

            if(!temp_vid_array[data.sio_u_id]){
                temp_vid_array[data.sio_u_id] = {id: data.sio_u_id, username: data.sio_u_username, avatar: data.sio_u_avatar}
            }

            sio_vid_rooms[data.room_id] = temp_vid_array;
        }

    });

    socket.on('get fr rent', function (data) {
        var this_CL = this;
        var itemsProcessed = 0;
        var genArray = new Array();
        data.user_fr_list.forEach(function (user_fr) {

            var ref = firebase.database().ref('/n10n/u_n10n' + user_fr);
            ref.once("value").then(function (snapshot) {
                itemsProcessed++;
                genArray.push(snapshot.val());
                if(itemsProcessed === data.user_fr_list.length) {
                    ufl_callback(genArray);
                }
            });

        });

        function ufl_callback(res){
            this_CL.emit('get fr rent', {
                'get_fr_rent': res
            });
        }
    });

    socket.on('chat message', function(msg){

        socket.to(msg.u_to_id).emit('chat message', {
            'mess': msg.f_b, 'mess_from': msg.u_from_id,
            'from_avatar': msg.sio_u_avatar,
            'from_username': msg.sio_u_username
        });

        var fb_u_tu   = msg.u_to_id;
        var fb_u_from = msg.u_from_id;
        if(fb_u_tu < fb_u_from){
            var fb_path = fb_u_tu+'-'+fb_u_from;
        }
        else{
            var fb_path = fb_u_from+'-'+fb_u_tu;
        }

        firebase.database().ref('/mess/utou'+fb_path).push({
            to_id: msg.u_to_id,
            from_id: msg.u_from_id,
            from_avatar: msg.sio_u_avatar,
            from_username: msg.sio_u_username,
            mess: msg.f_b,
            sow: 0,
            date: new Date().getTime()
        });

    });

    socket.on('get chat message', function(data) {

        var this_CL = this;

        var fb_u_from = data.u_from_id;
        var fb_u_tu = data.u_to_id;
        if(fb_u_tu < fb_u_from){
            var fb_path = fb_u_tu+'-'+fb_u_from;
        }
        else{
            var fb_path = fb_u_from+'-'+fb_u_tu;
        }

        var ref = firebase.database().ref('/mess/utou'+fb_path);

        ref.once("value").then(function(snapshot) {
            var chat_get_res = [];
            snapshot.forEach(function(childSnapshot) {

                var allFireBaseRes = childSnapshot.val();
                chat_get_res.push(allFireBaseRes);

                firebase.database().ref('/mess/utou'+fb_path+'/'+childSnapshot.key).update({sow:1});

            });

            this_CL.emit('get chat message', {
                'messages': chat_get_res
            });
        });

    });

    socket.on('seen mess', function(data){
        var fb_u_from = data.u_from_id;
        var fb_u_tu = data.u_to_id;
        if(fb_u_tu < fb_u_from){
            var fb_path = fb_u_tu+'-'+fb_u_from;
        }
        else{
            var fb_path = fb_u_from+'-'+fb_u_tu;
        }

        var ref = firebase.database().ref('/mess/utou'+fb_path);

        ref.once("value").then(function(snapshot) {
            snapshot.forEach(function(childSnapshot) {

                if(childSnapshot.val().to_id == fb_u_from){
                    firebase.database().ref('/mess/utou'+fb_path+'/'+childSnapshot.key).update({sow:1});
                }

            });
        });

    });

    socket.on('get chat unseen mess', function(data) {

        var this_CL = this;
        var entercount = 0;
        var itemsProcessed = 0;
        unseen_arr = {};



        data.user_fr_list.forEach(function(item){
            get_m(item, data.sio_u_id)
        });

        function get_m(from, to){
            itemsProcessed++;

            var fb_u_from = from;

            var fb_u_tu = to;

            if(fb_u_tu < fb_u_from){
                var fb_path = fb_u_tu+'-'+fb_u_from;
            }
            else{
                var fb_path = fb_u_from+'-'+fb_u_tu;
            }

            var ref = firebase.database().ref('/mess/utou'+fb_path);

            var snapshotCount = 0;

            ref.once("value").then(function(snapshot) {
                var chat_get_res = [];
                snapshot.forEach(function(childSnapshot) {
                    snapshotCount++;
                    if(childSnapshot.val().sow == 0){
                        var allFireBaseRes = childSnapshot.val();
                        chat_get_res.push(allFireBaseRes);
                    }
                });

                add_to_unseen_array(chat_get_res, from);

                if(itemsProcessed == data.user_fr_list.length && snapshotCount == snapshot.numChildren()){
                    entercount++;
                    if(entercount == data.user_fr_list.length){
                        send_unseen();
                    }

                }

            });
        }

        function add_to_unseen_array(res, from){
            unseen_arr[from] = res;
        }

        function send_unseen(){
            this_CL.emit('get chat unseen mess', {
                'unseen': unseen_arr
            });
        }

    });

    socket.on('chat room message', function(msg){


        for (var key in sio_vid_rooms[msg.room_id]) {

            socket.to(key).emit('chat message', {
                'mess': msg.f_b, 'mess_from': msg.u_from_id,
                'from_avatar': msg.sio_u_avatar,
                'from_username': msg.sio_u_username
            });

        }



        firebase.database().ref('/groupmess/'+msg.room_id).push({
            room: msg.room_id,
            from_id: msg.u_from_id,
            from_avatar: msg.sio_u_avatar,
            from_username: msg.sio_u_username,
            mess: msg.f_b,
            date: new Date().getTime()
        });

    });

    socket.on('get room chat message', function(data) {

        var this_CL = this;

        var ref = firebase.database().ref('/groupmess/'+data.room_id);

        ref.once("value").then(function(snapshot) {
            var chat_get_res = [];
            snapshot.forEach(function(childSnapshot) {
                var allFireBaseRes = childSnapshot.val();
                chat_get_res.push(allFireBaseRes);
            });
            this_CL.emit('get chat message', {
                'messages': chat_get_res
            });
        });
    });

    socket.on('live watcher', function (data) {
        var channel = data.channel_id;
        var now = new Date();
        if(!(channel in watchers)) watchers[channel] = [{id:data.user_id, date:now}];
        else{
            if(checkId(data.user_id, watchers[channel])){
                var arr = watchers[channel];
                arr.push({id:data.user_id, date:now});
                watchers[channel] = arr;
            }
            else watchers[channel] = updateValue(data.user_id, watchers[channel]);
        }
        console.log(watchers);
    });

    app.post('/rent', function(req, res){

        var r_user_fr = req.body.r_user_fr.split(",");

        r_user_fr.forEach(function(it){
            socket.to(it).emit('rent inv',{
                'u_rent_avatar': req.body.r_user_avatar,
                'u_rent': req.body.r_user_id,
                'u_rent_username': req.body.r_user_username,
                'u_movie_title': req.body.r_movie_title,
                'date': new Date().getTime()
            });
        });

        firebase.database().ref('/n10n/u_n10n'+req.body.r_user_id).push({
            event: 'rent',
            u_rent: req.body.r_user_id,
            u_rent_avatar: req.body.r_user_avatar,
            u_rent_username: req.body.r_user_username,
            u_movie: req.body.r_movie_id,
            u_movie_title: req.body.r_movie_title,
            date: new Date().getTime()
        });


        res.end();
    });

    app.post('/follow', function(req, res){

        firebase.database().ref('/n10n/u_n10n'+req.body.from_u_id).push({
            event: 'follow',
            from_u_id:req.body.from_u_id,
            from_u_username:req.body.from_u_username,
            from_u_avatar:req.body.from_u_avatar,
            to_u_id:req.body.f_u_id,
            to_u_username:req.body.f_u_username,
            to_u_avatar:req.body.f_u_avatar,
            date: new Date().getTime()
        });


        var f_user_fr = req.body.f_user_fr.split(",");

        f_user_fr.forEach(function(it){
            socket.to(it).emit('follow inv',{
                event: 'follow',
                from_u_id:req.body.from_u_id,
                from_u_username:req.body.from_u_username,
                from_u_avatar:req.body.from_u_avatar,
                to_u_id:req.body.f_u_id,
                to_u_username:req.body.f_u_username,
                to_u_avatar:req.body.f_u_avatar,
                date: new Date().getTime()
            });
        });


        socket.to(req.body.f_u_id).emit('follow inv you',{
            'event':req.body.event,
            'from_u_id':req.body.from_u_id,
            'from_u_username':req.body.from_u_username,
            'from_u_avatar':req.body.from_u_avatar,
            'date': new Date().getTime()
        });
        res.end();
    });

    app.post('/coplay', function(req, res){

        var coplay_to = req.body.cp_u_to;
        var coplay_to_username = req.body.cp_u_to_username;

        var coplay_user_res = coplay_to.split(",");
        var coplay_username_res = coplay_to_username.split(",");
        coplay_user_res.forEach(function(item, i){


            firebase.database().ref('/n10n/u_n10n'+req.body.cp_u_from).push({
                event: 'coplay',
                from_u_id:req.body.cp_u_from,
                from_u_username:req.body.cp_u_username,
                from_u_avatar:req.body.cp_u_avatar,
                to_u_id: item,
                to_u_username: coplay_username_res[i],
                movie_title:req.body.cp_m_title,
                movie_slug:req.body.cp_m_slug,
                date: new Date().getTime()
            });


            socket.to(item).emit('coplay inv',{
                event: 'coplay',
                from_u_id:req.body.cp_u_from,
                from_u_username:req.body.cp_u_username,
                from_u_avatar:req.body.cp_u_avatar,
                to_u_id: item,
                movie_title:req.body.cp_m_title,
                movie_slug:req.body.cp_m_slug,
                date: new Date().getTime()
            });


        });

        res.end();
    });

    socket.on('disconnect', function() {
        delete sio_online_users[socket.id];
    });

});

setInterval(function(){
    io.emit('online',{
        'sio_online_users':sio_online_users
    });
    //io.emit('video chat', {stream:video_chat_url});
}, 3000);

setInterval(function(){
    temp_vid_array = {};

    io.emit('video room res',{
        'sio_vid_room':sio_vid_rooms
    });
}, 15000);

http.listen(port, function(){
    console.log('listening on *:' + port);
});

aws.config.update({
    accessKeyId: 'AKIAJHPSIAKRKBSPDL7Q',
    secretAccessKey: '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',
    region: 'us-west-2'
});

s3 = new aws.S3();

var upload = multer({
    storage: multerS3({
        s3: s3,
        bucket: 'frenvid',
        acl: 'public-read', // private, public-read, bucket-owner-read
        key: function (req, file, cb) {
            var file_name_r = file.originalname.replace('.', '/');
            var file_name_res = file_name_r.replace('.', '/');
            var file_name_result = 'uploads/'+file_name_res;
            cb(null, file_name_result); //use Date.now() for unique file keys
        }
    })
});

app.post('/uploads', upload.array('s3_up_file',1), function (req, res, next) {
    res.send("Uploaded!");
});

app.get('/watchers', function (req, res) {
    res.send({watchers:watchers})
});

function checkWatchers() {
    setInterval(function () {
        for(var item in watchers){
            for(var i = 0; i < watchers[item].length; i++){
                var now = new Date();
                var dt = new Date(watchers[item][i]['date']);
                var date = dt.setSeconds(dt.getSeconds() + 10);
                if(now > date) watchers[item].pop(watchers[item][i]);
            }
        }
    }, 10000);
}

function checkId(id, array) {
    var res = true;
    for(var i = 0; i < array.length; i++){
        if(array[i]['id'] === id) res = false;
    }
    return res;
}

function updateValue(id, array){
    for(var i = 0; i < array.length; i++){
        if(array[i]['id'] === id) array[i]['date'] = new Date();
    }
    return array;
}