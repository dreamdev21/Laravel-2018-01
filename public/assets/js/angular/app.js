(function() {
    var app = angular.module("frenvidApp",['angularUtils.directives.dirPagination','pusher-angular','angularMoment']);

    app.value('logged_user', Helpers.getMeta('usr_data'));

    app.value('utc_offset', moment().utcOffset());

    window.client = new Pusher(Helpers.getMeta('pid'));
})();