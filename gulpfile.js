var gulp = require('gulp');
var concatCss = require('gulp-concat-css');
var concat = require('gulp-concat');
var rename = require('gulp-rename');
var minifyCSS = require('gulp-minify-css');
var uglify = require('gulp-uglify');
var minify = require('gulp-minify');
var notify = require('gulp-notify');


gulp.task('start_style', function () {
    return gulp.src([
        'public/assets/plugins/bootstrapv3/css/bootstrap.css',
        'public/assets/plugins/jquery-metrojs/MetroJs.min.css',
        'public/fp312/css/owl.carousel.css',
        'public/fp312/css/main-style.css',
        'public/fp312/css/style.css',
        'public/assets/css/start.css'
    ])
        .pipe(concatCss("start.min.css"))
        .pipe(minifyCSS())
        .pipe(rename('start.min.css'))
        .pipe(gulp.dest('public/general/css/'))
        .pipe(notify('Done!'))
});

gulp.task('home_style', function () {
    return gulp.src([
        'public/assets/plugins/bootstrapv3/css/bootstrap.css',
        'public/assets/plugins/bootstrapv3/css/bootstrap-theme.css',
        'public/assets/plugins/animate.min.css',
        'public/assets/plugins/jquery-scrollbar/jquery.scrollbar.css',
        'public/bami/css/bami.css',
        'public/vendors/masterslider/style/masterslider.css',
        'public/assets/css/style.css',
        'public/el_vp/css/elite.css',
        'public/el_vp/css/jquery.mCustomScrollbar.css',
        'public/assets/css/slick.css',
        'public/assets/css/slick-theme.css'
    ])
        .pipe(concatCss("home.min.css"))
        .pipe(minifyCSS())
        .pipe(rename('home.min.css'))
        .pipe(gulp.dest('public/general/css/'))
        .pipe(notify('Done!'))
});

gulp.task('admin_style', function () {
    return gulp.src([
        'public/assets/plugins/bootstrapv3/css/bootstrap.css',
        'public/assets/plugins/bootstrapv3/css/bootstrap-theme.css',
        'public/assets/plugins/animate.min.css',
        'public/assets/plugins/jquery-scrollbar/jquery.scrollbar.css',
        'public/bami/css/bami.css',
        'public/datetimepicker/jquery.datetimepicker.css'
    ])
        .pipe(concatCss("admin.min.css"))
        .pipe(minifyCSS())
        .pipe(rename('admin.min.css'))
        .pipe(gulp.dest('public/general/css/'))
        .pipe(notify('Done!'))
});

gulp.task('start_script', function () {
    return gulp.src([
        'public/assets/plugins/jquery/jquery3.2.1.js',
        'public/fp312/js/bootstrap.js',
        'public/fp312/js/plugins/superfish.min.js',
        'public/fp312/js/jquery.ui.min.js',
        'public/fp312/js/plugins/rangeslider.min.js',
        'public/fp312/js/plugins/jquery.flexslider-min.js',
        'public/fp312/js/uou-accordions.js',
        'public/fp312/js/uou-tabs.js',
        'public/fp312/js/plugins/select2.min.js',
        'public/fp312/js/owl.carousel.min.js',
        'public/assets/plugins/jquery-metrojs/MetroJs.min.js',
        'public/assets/js/start.js'
    ])
        .pipe(concat('start.min.js'))
        .pipe(uglify())
        .pipe(rename('start.min.js'))
        .pipe(gulp.dest('public/general/js/'))
        .pipe(notify('Done!'))
});

gulp.task('player_script', function () {
    return gulp.src([
        'public/videojs/video.js',
        'public/videojs/videojs-contrib-hls.js',
        'public/videojs/media.youtube.js'

    ])
        .pipe(concat('player.min.js'))
        .pipe(uglify())
        .pipe(rename('player.min.js'))
        .pipe(gulp.dest('public/general/js/'))
        .pipe(notify('Done!'))
});

gulp.task('home_script', function () {
    return gulp.src([
        'public/assets/js/socket.io.js',
        'public/assets/plugins/jquery/jquery-1.11.3.min.js',
        'public/assets/plugins/bootstrapv3/js/bootstrap.min.js',
        'public/assets/plugins/jquery-block-ui/jqueryblockui.min.js',
        'public/assets/plugins/jquery-unveil/jquery.unveil.min.js',
        'public/assets/plugins/jquery-scrollbar/jquery.scrollbar.min.js',
        'public/assets/plugins/jquery-numberAnimate/jquery.animateNumbers.js',
        'public/assets/plugins/jquery-validation/js/jquery.validate.min.js',
        'public/assets/plugins/bootstrap-select2/select2.min.js',
        'public/assets/js/slick.min.js',
        'public/el_vp/js/froogaloop.js',
        'public/el_vp/js/jquery.mCustomScrollbar.js',
        'public/el_vp/js/THREEx.FullScreen.js',
        'public/el_vp/js/videoPlayer.js',
        'public/el_vp/js/Playlist.js',
        'public/el_vp/js/ZeroClipboard.js',
        'public/bami/js/bami.js',
        'public/assets/js/chat.js',
        'public/bami/js/bundle.js',
        'public/vendors/masterslider/masterslider.min.js'

    ])
        .pipe(concat('home.min.js'))
        .pipe(uglify())
        .pipe(rename('home.min.js'))
        .pipe(gulp.dest('public/general/js/'))
        .pipe(notify('Done!'))
});

gulp.task('admin_script', function () {
    return gulp.src([
        'public/assets/plugins/jquery/jquery-1.11.3.js',
        'public/assets/plugins/jquery.form.min.js',
        'public/assets/plugins/bootstrapv3/js/bootstrap.min.js',
        'public/assets/plugins/jquery-block-ui/jqueryblockui.min.js',
        'public/assets/plugins/jquery-unveil/jquery.unveil.min.js',
        'public/assets/plugins/jquery-scrollbar/jquery.scrollbar.min.js',
        'public/assets/plugins/jquery-numberAnimate/jquery.animateNumbers.js',
        'public/assets/plugins/jquery-validation/js/jquery.validate.min.js',
        'public/assets/plugins/bootstrap-select2/select2.min.js',
        'public/assets/plugins/jquery.dataTables.min.js',
        'public/datetimepicker/build/jquery.datetimepicker.full.min.js',
        'public/bami/js/bami.js',
        'public/js/custom_admin.js',
        'public/assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js',
        'public/assets/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js',
        'public/assets/plugins/jquery-inputmask/jquery.inputmask.min.js',
        'public/assets/plugins/jquery-autonumeric/autoNumeric.js',
        'public/assets/plugins/bootstrap-select2/select2.min.js',
        'public/assets/plugins/bootstrap-tag/bootstrap-tagsinput.min.js',
        'public/assets/plugins/dropzone/dropzone.min.js'
    ])
        .pipe(concat('admin.min.js'))
        //.pipe(uglify())
        .pipe(rename('admin.min.js'))
        .pipe(gulp.dest('public/general/js/'))
        .pipe(notify('Done!'))
});





gulp.task('admin_chart_script', function () {
    return gulp.src([
        'public/assets/plugins/jquery/jquery-1.11.3.js',
        'public/assets/plugins/jquery.form.min.js',
        'public/assets/plugins/bootstrapv3/js/bootstrap.min.js',
        'public/assets/plugins/jquery-block-ui/jqueryblockui.min.js',
        'public/assets/plugins/jquery-unveil/jquery.unveil.min.js',
        'public/assets/plugins/jquery-scrollbar/jquery.scrollbar.min.js',
        'public/assets/plugins/jquery-numberAnimate/jquery.animateNumbers.js',
        'public/assets/plugins/jquery-validation/js/jquery.validate.min.js',
        'public/assets/plugins/bootstrap-select2/select2.min.js',
        'public/assets/plugins/jquery.dataTables.min.js',
        'public/datetimepicker/build/jquery.datetimepicker.full.min.js',
        'public/bami/js/bami.js',
        'public/js/custom_admin.js',
        'public/assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js',
        'public/assets/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js',
        'public/assets/plugins/jquery-inputmask/jquery.inputmask.min.js',
        'public/assets/plugins/jquery-autonumeric/autoNumeric.js',
        'public/assets/plugins/bootstrap-select2/select2.min.js',
        'public/assets/plugins/bootstrap-tag/bootstrap-tagsinput.min.js',
        'public/assets/plugins/dropzone/dropzone.min.js',
        'public/assets/plugins/raphael-min.js',
        'public/assets/plugins/jquery-ricksaw-chart/js/d3.v2.js',
        'public/assets/plugins/jquery-ricksaw-chart/js/rickshaw.min.js',
        'public/assets/plugins/jquery-morris-chart/js/morris.min.js',
        'public/assets/plugins/jquery-easy-pie-chart/js/jquery.easypiechart.min.js',
        'public/assets/plugins/jquery-flot/jquery.flot.js',
        'public/assets/plugins/jquery-flot/jquery.flot.time.min.js',
        'public/assets/plugins/jquery-flot/jquery.flot.selection.min.js',
        'public/assets/plugins/jquery-flot/jquery.flot.animator.min.js',
        'public/assets/plugins/jquery-flot/jquery.flot.orderBars.js',
        'public/assets/plugins/jquery-sparkline/jquery-sparkline.js',
        'public/assets/plugins/jquery-easy-pie-chart/js/jquery.easypiechart.min.js'
    ])
        .pipe(concat('chart.min.js'))
        //.pipe(uglify())
        .pipe(rename('chart.min.js'))
        .pipe(gulp.dest('public/general/js/'))
        .pipe(notify('Done!'))
});







gulp.task('style', function () {
    gulp.start('start_style');
    gulp.start('home_style');
    gulp.start('admin_style');
});

gulp.task('script', function () {
    gulp.start('start_script');
    gulp.start('player_script');
    gulp.start('home_script');
    gulp.start('admin_script');
    gulp.start('admin_chart_script');
});



//
//
// gulp.task('watch', function(){
//     gulp.watch('public/assets/css/*.css', ['default']);
// });



//
//
// const elixir = require('laravel-elixir');
//
// require('laravel-elixir-vue-2');
//
// /*
//  |--------------------------------------------------------------------------
//  | Elixir Asset Management
//  |--------------------------------------------------------------------------
//  |
//  | Elixir provides a clean, fluent API for defining some basic Gulp tasks
//  | for your Laravel application. By default, we are compiling the Sass
//  | file for our application, as well as publishing vendor resources.
//  |
//  */
//
// elixir(mix => {
//     mix.sass('app.scss')
//        .webpack('app.js');
// });