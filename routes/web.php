<?php

/*
    |--------------------------------------------------------------------------
    | Entry Routes
    |--------------------------------------------------------------------------
    */

Route::get('/test', 'LiveController@test');

Route::get('/', [
    'uses' => 'StartController@index',
    'as'   => 'welcome'
]);

Route::get('/tos', [
    'uses' => 'StartController@tos',
    'as'   => 'tos'
]);

Route::get('/partners', [
    'uses' => 'StartController@partners',
    'as'   => 'partners'
]);

Route::get('/policy', [
    'uses' => 'StartController@policy',
    'as'   => 'policy'
]);

Route::get('/ads', [
    'uses' => 'StartController@ads',
    'as'   => 'ads'
]);

Route::get('/sitemap.xml', [
    'uses' => 'StartController@sitemap',
    'as'   => 'sitemap'
]);


Route::get('/cookie-policy', function () {
    return view('front.cookie-policy');
});

Route::get('/african_TV', 'StartController@african_TV');

Route::get('/make_subscription', 'UserController@makeSubscription')->middleware('auth');
Route::post('/set_subscription', 'TvController@setSubscription')->middleware('auth');
Route::get('/set_trial', 'TvController@setTrial')->middleware('auth');
Route::post('/tv_dashboard/watchers', 'TvDashboardController@updateWatchers')->middleware('auth');
Route::get('/user_id', 'UserController@userId')->middleware('auth');
Route::get('/get_channel_user/{channel_id}', 'TvController@getChannelUser')->middleware('auth');

Auth::routes();

Route::get('/fb_login', 'FacebookController@login');
Route::get('/fb_login/callback', 'FacebookController@callback');

Route::post('/login/custom', [
    'uses' => 'LoginController@login',
    'as'   => 'login.custom'
]);

Route::post('/enteremail', [
    'uses' => 'UserController@enterEmail',
    'as'   => 'entermail'
]);

Route::get('/logout', 'LoginController@logout');

/*
    |--------------------------------------------------------------------------
    | News Routes
    |--------------------------------------------------------------------------
    */

Route::get('/news', [
    'uses' => 'NewsController@index',
    'as'   => 'news'
]);

Route::get('/news/{slug}', 'NewsController@getSinglePost');

Route::post('/get_news', 'NewsController@getNews');

Route::post('/search_news', 'NewsController@searchNews');

Route::post('/accept_cookie', 'StartController@acceptCookie');

Route::get('/details/{slug}','StartController@movies');

/*
   |--------------------------------------------------------------------------
   | Api Routes
   |--------------------------------------------------------------------------
*/

Route::group(['prefix' => 'api'], function () {

    Route::get('/test', 'ApiController@test999');

    Route::post('/login', 'ApiController@login');
    Route::post('/register', 'ApiController@register');   /*OK*/

    Route::group(['middleware' => ['TokenApi']], function () {
        Route::post('/test', 'ApiController@test');
        Route::post('/getUserData', 'ApiController@UserData');
        Route::post('/getUsers/{user}', 'ApiController@profile'); /*OK*/
        Route::post('/followers/show', 'ApiController@showFollowers'); /*OK*/
        Route::post('/users/followById', 'ApiController@followById'); /*OK*/
        Route::post('/users/unFollow', 'ApiController@unFollow'); /*OK*/
        Route::post('/users/settings/password-change', 'ApiController@settingPassChange'); /*OK*/
        Route::post('/users/settings/avatar', 'ApiController@settingAvatarChange'); /*OK*/
        Route::post('/users/settings/chathistory', 'ApiController@settingChatHistory'); /*OK*/
        Route::post('/users/settings/getchathistorystatus', 'ApiController@getChatHistoryStatus'); /*OK*/
        Route::post('/users/change/cover', 'ApiController@updateCoverImage'); /*OK*/
        Route::post('/getMovies', 'ApiController@movies'); /*OK*/
        Route::post('/movies/soplay', 'ApiController@soPlay'); /*OK*/
        Route::post('/getMovie', 'ApiController@movie');   /*OK*/
        Route::post('/movies/addWatchlist', 'ApiController@controlWatchlist');   /*OK*/
        Route::post('/movies/delWatchlist', 'ApiController@delWatchlist');   /*OK*/
        Route::post('/getTrailer','ApiController@getTrailer');   /*OK*/
        Route::post('/getSeries', 'ApiController@series'); /*OK*/
        Route::post('/getSeriesDetails', 'ApiController@series_detail'); /*OK*/
        Route::post('/getSeasonDetails', 'ApiController@season_detail');   /*OK*/
        Route::post('/getEpisodeDetails', 'ApiController@episode_details');   /*OK*/
        Route::post('/getTvDetails', 'ApiController@liveTV');   /*OK*/
        Route::post('/set_rate', 'ApiController@setRate');   /*OK*/
        Route::post('/search', 'ApiController@search');   /*OK*/
        Route::post('/search_coplay', 'ApiController@searchCoPlay');   /*OK*/
        Route::post('/addUserPhone', 'ApiController@userPhone');   /*OK*/
        Route::post('/setting/cancelMem', 'ApiController@cancelMembership');   /*OK*/
        Route::post('/movie/renting', 'ApiController@rentingProcess');   /*OK*/
        Route::post('/movie/rentWithSavePay', 'ApiController@rentingProcessWithSavedPayment');   /*OK*/
        Route::post('/movie/sendCoPlayInv', 'ApiController@sendCoPlayInv');   /*OK*/
        Route::post('/movie/coPlay', 'ApiController@coPlay');   /*OK*/
        Route::post('/genres', 'ApiController@genres');   /*OK*/
        Route::post('/movie/latestMov', 'ApiController@latestMovies');   /*OK*/
        Route::post('/movie/latestSer', 'ApiController@latestSeries');   /*OK*/
        Route::post('/brainTreeToc', 'ApiController@clientToken');   /*OK*/
        Route::post('/check_follow', 'ApiController@checkFollow');   /*OK*/
        Route::post('/watchlist', 'ApiController@getWatchlist');   /*OK*/
        Route::post('/check_rented', 'ApiController@checkRented');     /*OK*/
        Route::post('/news', 'ApiController@getNews');                 /*OK*/
        Route::post('/latestNews', 'ApiController@getLatestNews');     /*OK*/
        Route::post('/categoryNews', 'ApiController@getCategoryNews');     /*OK*/
        Route::post('/movie/friendList', 'ApiController@movieFriendList');   /*OK*/
        Route::post('/rent_paypal', 'ApiController@rentPayPal');   /*OK*/
    });
});

/*
   |--------------------------------------------------------------------------
   | User Routes
   |--------------------------------------------------------------------------
*/

Route::group(['middleware' => ['web', 'auth', 'elstudio']], function() {

    Route::post('/get_live_tv', 'LiveController@getLiveTv');


    Route::get('/home', 'LiveController@index')->name('home');
    Route::get('/test', 'LiveController@test');



    Route::post('usphone', [
        'uses' => 'UserController@usphone',
        'as'   => 'usphone'
    ]);



    Route::post('/remove_usphone_area', 'UserController@RemovePhoneArea');


    /*
    |--------------------------------------------------------------------------
    | Authenticated user Routes
    |--------------------------------------------------------------------------
    */


    Route::get('/users/{user}', [
        'uses' => 'UserController@profile',
        'as'   => 'users.profile'
    ]);

    Route::get('/users/{user}/follow', [
        'uses' => 'UserController@follow',
        'as'   => 'users.follow'
    ]);

    Route::get('/users/{id}/follow_byid', 'UserController@followById');

    Route::post('/users/check_follow', 'UserController@checkFollow');

    Route::get('/users/{user}/unfollow', [
        'uses' =>'UserController@unfollow',
        'as'   => 'users.unfollow'
    ]);

    Route::get('users/{user}/settings', [
        'uses' => 'UserController@settings',
        'as'   => 'settings'
    ]);

    Route::post('/users/settings/chathistory', [
        'uses' => 'UserController@userSettingChatHistory',
        'as'     =>'userSettingChatHistory'
    ]);

    Route::post('/users/settings/savedpayment', [
        'uses' => 'UserController@disableSavedPayment',
        'as'     =>'disableSavedPayment'
    ]);

    Route::post('/users/{username}/settings/avatar', [
        'uses' => 'UserController@updateImage',
        'as'   => 'user.settings'
    ]);

    Route::post('/users/{username}/settings/cover', 'UserController@updateCoverImage');

    Route::post('/users/settings/password-change', [
        'uses' => 'UserController@passwordChange',
        'as'     =>'passwordChange'

    ]);

    Route::post('/users/settings/cancel', [
        'uses' => 'UserController@cancel',
        'as'     =>'cancel'
    ]);

    Route::post('/rented', [
        'uses' => 'OrderController@processRent',
        'as'   => 'rented'
    ]);

    Route::post('/srented', [
        'uses' => 'OrderController@processSavePayRent',
        'as'   => 'srented'
    ]);

    /*
    |--------------------------------------------------------------------------
    | movie Page Routes
    |--------------------------------------------------------------------------
    */

    Route::get('/series', [
        'uses' => 'MoviesController@show_series',
        'as'   => 'series_show'
    ]);

    Route::get('/movies', [
        'uses' => 'MoviesController@index',
        'as'   => 'movies'
    ]);


    Route::post('/get_trailer','MoviesController@get_trailer');

    Route::post('/set_rete','MoviesController@setRate');

    Route::get('/movies/{slug}', [
        'uses' => 'MoviesController@details',
        'as'   => 'movie'
    ]);

    Route::get('/series/{slug}', [
        'uses' => 'MoviesController@details_series',
        'as'   => 'series'
    ]);

    Route::get('/series/{slug}/{season_id}', [
        'uses' => 'MoviesController@details_season',
        'as'   => 'season'
    ]);

    Route::get('/episode/{slug}', [
        'uses' => 'MoviesController@details_episode',
        'as'   => 'episode'
    ]);


    Route::get('/movies/{slug}/play', 'MoviesController@play');

    Route::get('/movies/{slug}/soplay', 'MoviesController@soplay');

    Route::post('/movies/conwl', 'MoviesController@conWl');

    Route::post('/movies/delwl', 'MoviesController@delWl');


    Route::post('/messages/get', 'MessagesController@getMess');

    Route::post('/messages/set', 'MessagesController@setMess');

    Route::get('/followers/show', 'FollowerController@showFollowers');

    Route::post('/search', 'SearchController@search');

    Route::post('/search_coplay', 'SearchController@searchCoPlay');

    Route::post('/coplay_inv', 'MoviesController@coplayInv');

    Route::get('/coplay_list', 'MoviesController@coplay');

    Route::post('/last_w', 'UserController@lastW');

    Route::get('/stream/{id}', 'LiveController@getStrVideo');

    Route::get('v_l10n/{id}/{token}', 'MoviesController@getAwsVideo');

});

/*
   |--------------------------------------------------------------------------
   | Admin Routes
   |--------------------------------------------------------------------------
*/

Route::group(['prefix' => 'admin'], function() {
    Route::group(['middleware' => ['admin']], function() {

        Route::get('/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
        Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');

        Route::get('/', 'AdminController@index')->name('admin.dashboard');

        Route::resource('/posts', 'AdminBlogController');
        Route::resource('/postscategory', 'AdminPostsCategoryController');
        Route::post('/delete_post_cat', 'AdminPostsCategoryController@delete_post_cat');
        Route::post('/edit_post_cat', 'AdminPostsCategoryController@edit_post_cat');

        Route::resource('/channelscategory', 'AdminChannelsCategoryController');
        Route::resource('/actors', 'AdminActorController');
//        Route::resource('/directors', 'AdminDirectorController');
        Route::resource('/studios', 'AdminStudioController');
        Route::resource('/genres', 'AdminGenreController');
        Route::resource('/slides', 'AdminSlidesController');

        Route::resource('/advertising', 'AdminAdvertisingController');

        Route::post('/create_bg_ads', [
            'uses' => 'AdminAdvertisingController@createBgAds',
            'as' => 'create_bg_ads'
        ]);

        Route::post('/edit_loading_pointer', [
            'uses' => 'AdminChannelsController@editLoadingPointer',
            'as' => 'edit_loading_pointer'
        ]);

        Route::get('/delete_loading_pointer', [
            'uses' => 'AdminChannelsController@deleteLoadingPointer',
            'as' => 'delete_loading_pointer'
        ]);

        Route::post('/create_banner_ads', [
            'uses' => 'AdminAdvertisingController@createBannerAds',
            'as' => 'create_banner_ads'
        ]);

        Route::post('/create_banner_ads_news1', [
            'uses' => 'AdminAdvertisingController@createBannerAdsNews1',
            'as' => 'create_banner_ads_news1'
        ]);

        Route::post('/create_banner_ads_left', [
            'uses' => 'AdminAdvertisingController@createBannerAdsLeft',
            'as' => 'create_banner_ads_left'
        ]);
        Route::post('/create_banner_ads_right', [
            'uses' => 'AdminAdvertisingController@createBannerAdsRight',
            'as' => 'create_banner_ads_right'
        ]);

        Route::resource('/media', 'AdminMediaController');
        Route::post('/media/del_s3_file', 'AdminMediaController@del_s3_file');
        Route::post('/media/add_file', 'AdminMediaController@add_file');

        Route::post('/videos/ads', 'AdminVideosController@ads');
        Route::post('/videos/ads_all', 'AdminVideosController@ads_all');
        Route::post('/videos/ads_all_bg', 'AdminVideosController@ads_all_bg');
        Route::post('edit_video_slide_pub', 'AdminVideosController@edit_video_slide_pub');


        Route::resource('/videos', 'AdminVideosController');
        Route::get('/channels/channel_data', 'AdminChannelsController@channelData');
        Route::resource('/channels', 'AdminChannelsController');

        Route::resource('/movies', 'AdminMoviesController');
        Route::resource('/episodes', 'AdminEpisodesController');
        Route::resource('/users', 'AdminUsersController');
        Route::post('/del_user', 'AdminUsersController@delUser');

        Route::post('/get_channels', 'AdminChannelsController@getChannels');
        Route::post('/create_video', 'AdminChannelsController@createVideo');
        Route::post('/create_channel', 'AdminChannelsController@createChannel');

        Route::post('/users/editrole/', 'AdminUsersController@editUserRole');
        Route::get('/users/create', 'AdminUsersController@createProducerIndex');
        Route::get('/tvStation/create', 'AdminUsersController@createTvStationIndex');
        Route::post('/users/create_producer', 'AdminUsersController@createProducer');
        Route::post('/tvStation/create_user', 'AdminUsersController@createTvStation');
        Route::get('/exportcsv', [
            'uses' => 'AdminUsersController@exportCSV',
            'as' => 'export_users_csv'
        ]);

        Route::resource('/series', 'AdminSeriesController');

        Route::get('/create_season', 'AdminSeriesController@create_season');
        Route::post('/store_season', 'AdminSeriesController@store_season');
        Route::get('/create_episode', 'AdminSeriesController@create_episode');
        Route::post('/get_seasons', 'AdminSeriesController@get_seasons');

        Route::get('/payments', 'AdminPaymentController@index');
        Route::post('/sub_stat_studio', 'AdminPaymentController@subStatStudio');

        Route::get('movieslide', 'AdminBlogController@movieslide');

        Route::post('/edit_movie_slide_pub', 'AdminMoviesController@editMovieSlidePub');

        Route::post('/mov_parental', 'AdminMoviesController@parental');

        Route::get('/hp_slide', 'AdminBlogController@hpSlideShow');

        Route::post('/add_hp_slide_image', 'AdminBlogController@addHpSlideImage');

        Route::post('/del_hp_slide_image', 'AdminBlogController@delHpSlideImage');

        Route::post('/make_public', 'AdminMoviesController@makePublic');

        Route::post('/channel/gofront', 'AdminChannelsController@sendToFront');

        Route::post('/set_geoFencing', 'AdminMoviesController@geoFencing');

        Route::post('/set_geoFencing_channel', 'AdminChannelsController@geoFencingChannel');

        Route::post('/episode/make_public', 'AdminSeriesController@makeEpisodePublic');

        /* Admin emails page */
        Route::get('/emails', 'AdminEmailController@index');
        Route::post('/emails/reg_email', 'AdminEmailController@saveRegEmail');
        Route::post('/emails/movie_email', 'AdminEmailController@saveMovieEmail');
        Route::get('/get_movie/{id}', 'AdminEmailController@getMovie');

        Route::put('/subscription', ['as' => 'edit_subscription', 'uses' => 'AdminSubscriptionController@update']);
        Route::get('/subscriptions', 'AdminSubscriptionController@index');
        Route::get('/subscription/{id}', 'AdminSubscriptionController@edit');

        Route::get('/whats_on', 'WhatsOnController@index');
        Route::post('/whats_on', ['as' => 'updateWhatsOn', 'uses' => 'WhatsOnController@update']);
    });

});

Route::group(['prefix' => 'studio'], function() {
    Route::group(['middleware' => ['studio']], function() {
        Route::resource('/movies', 'AdminMoviesController');
        Route::resource('/media', 'AdminMediaController');
        Route::get('/settings', 'StudioSettingsController@index');
        Route::post('/settings/addemail', 'StudioSettingsController@addemail');
        Route::post('/settings/editemail', 'StudioSettingsController@addemail');
        Route::get('/payment_request', 'StudioSettingsController@paymentRequest');
        Route::post('/media/getLastUploadetFile', 'AdminMediaController@getLastUploadetFile');
        Route::post('/media/add_file', 'AdminMediaController@add_file');
        Route::get('/dashboard', 'StudioDashboardController@index');

        Route::resource('/series', 'AdminSeriesController');

        Route::get('/create_season', 'AdminSeriesController@create_season');
        Route::post('/store_season', 'AdminSeriesController@store_season');
        Route::get('/create_episode', 'AdminSeriesController@create_episode');
        Route::post('/get_seasons', 'AdminSeriesController@get_seasons');

        Route::post('/get_chart_res', 'StudioDashboardController@getChartRes');

        Route::post('/mov_parental', 'AdminMoviesController@parental');

    });
});

Route::group(['prefix' => 'tv'], function() {
    Route::group(['middleware' => ['tv']], function() {

        Route::get('/dashboard', 'TvController@dashboard');

        Route::get('/videos',['as' => 'tvVideos', 'uses' => 'TvVideosController@index'] );
        Route::post('/tvvideocreate',['as' => 'tvvideocreate', 'uses' => 'TvVideosController@add_video'] );
        Route::delete('/tvdestroy/{id}',['as' => 'tvdestroy', 'uses' => 'TvVideosController@del_video'] );
//        Route::get('/tvedit/{id}',['as' => 'tvedit', 'uses' => 'TvVideosController@edit_video'] );
        Route::get('/tvadd','TvVideosController@add_video_body');
        Route::put('/tvshow/{id}',['as' => 'tvshow', 'uses' => 'TvVideosController@update_video'] );

        Route::get('/tvsettings',['as' => 'tvsettings', 'uses' => 'TvController@tv_settings'] );
        Route::post('/tvsetpasschange',['as' => 'tvSettingsPassChange', 'uses' => 'TvController@passwordChange'] );
        Route::post('/tvchangeimg',['as' => 'tvSettingsAddPlayerBackground', 'uses' => 'TvController@bgImageChange'] );

        Route::get('/create',  'TvVideosController@create');

        Route::get('/advertising',['as' => 'tvAdvertising', 'uses' => 'AdvertisingTvController@index'] );

        Route::get('/createad',['as' => 'tvAd_create', 'uses' => 'AdvertisingTvController@create'] );
        Route::post('/savead',['as' => 'tvAd_save', 'uses' => 'AdvertisingTvController@store'] );

        Route::post('/videos/ads', 'TvVideosController@ads');
        Route::get('/tvhiw', ['as' => 'tvhiw', 'uses' => 'TvController@tvhiw']);

        Route::get('/tvdel/{id}','TvVideosController@del_video_body');
        Route::get('/tvedit/{id}',['as' => 'tvedit', 'uses' => 'TvVideosController@get_edit_body'] );
        Route::get('/createad_modal',['as' => 'tvAdvertisingCreate', 'uses' => 'AdvertisingTvController@create_body'] );
        Route::post('/add_stream_modal',['as' => 'tvAdvertisingCreate', 'uses' => 'TvVideosController@add_stream_body'] );
        Route::get('/editad_modal/{id}',['as' => 'tvAdvertisingEdit', 'uses' => 'AdvertisingTvController@edit_body'] );
        Route::get('/removead_modal/{id}',['as' => 'tvAdvertisingRemove', 'uses' => 'AdvertisingTvController@remove_body'] );
        Route::delete('/removead_modal/{id}', ['as' => 'tvAdvertisingDelete', 'uses' => 'AdvertisingTvController@destroy']);
        Route::get('/switch_broadcasting', 'TvVideosController@switchChannelBroadcasting');
        Route::get('/switch_loop', 'TvVideosController@switchLoop');
        Route::post('/update_geoblock', 'TvVideosController@editGeoblocking');
        Route::post('/reorder_vid', 'TvVideosController@reorderVideos');
        Route::post('/channel_time', ['as' => 'tvSetChannelTime', 'uses' => 'TvVideosController@setChannelStart']);
        Route::get('/tv_dashboard', ['as' => 'tvdashboard', 'uses' => 'TvDashboardController@index']);
        Route::get('/get_statistics', 'TvDashboardController@getStatistics');
        Route::get('/remove_logo', 'TvController@removeLogo');
        Route::post('/set_logo', ['as' => 'updateChannelLogo', 'uses' => 'TvController@setChannelLogo']);
    });
});



