<!-- BEGIN HEADER -->
<div class="search_cont">
    <style>
        .speech { padding: 0; margin: 0}
        .speech input {border: 0;  display: inline-block; height: 30px;}
        .speech img {width: 33px; position: absolute; top: 8px; left: 3px;}
    </style>

    <!-- Search Form -->

        <div class="speech">
            <input type="text" name="q" id="transcript" class="search_bar_search" placeholder="Search..." />
            <img onclick="startDictation()" src="{{asset('assets/images/micRed.png')}}" />
            <span class="remove_search_bar glyphicon glyphicon-remove-circle"></span>
        </div>

    <div class="content search_cont_mini">
        <h3 class="search_res_tit">Search Results</h3>
        <div class="col-md-4 search_title_area">
            <h4>Titles</h4>
        </div>
        <div class="col-md-4 search_users_area">
            <h4>Users</h4>
        </div>
    </div>
</div>

<script>



    function startDictation() {

        if (window.hasOwnProperty('webkitSpeechRecognition')) {

            var recognition = new webkitSpeechRecognition();

            recognition.continuous = false;
            recognition.interimResults = false;

            recognition.lang = "en-US";
            recognition.start();

            recognition.onresult = function(e) {
                document.getElementById('transcript').value
                    = e.results[0][0].transcript;
                search_us(e.results[0][0].transcript);
                recognition.stop();
                document.getElementById('labnol').submit();
            };

            recognition.onerror = function(e) {
                recognition.stop();
            }

        }
    }
</script>
<div class="header navbar navbar-inverse ">
    <!-- BEGIN TOP NAVIGATION BAR -->
    <div class="navbar-inner">
        <div class="header-seperation">
            <ul class="nav pull-left notifcation-center visible-xs visible-sm">
                <li class="dropdown">
                    <a href="#main-menu" data-webarch="toggle-left-side">
                        <i class="material-icons">menu</i>
                    </a>
                </li>
            </ul>
            <!-- BEGIN LOGO -->
            <a href="{{ Request::root()}}/home">
                <img src="{{ Request::root() }}/assets/img/logo.png" class="logo" alt=""
                     data-src="{{ Request::root() }}/assets/img/logo.png"
                     data-src-retina="{{ Request::root() }}/assets/img/logo2x.png"/>
            </a>
            <!-- END LOGO -->
            <ul class="nav pull-right notifcation-center">

                <li class="dropdown hidden-xs hidden-sm">
                    @if(Auth::user()->id == 1)
                        <a title="Home" href="/admin/movies" class="dropdown-toggle active" data-toggle="">
                            <i class="glyphicon glyphicon-th-large"></i>
                        </a>
                    @endif

                </li>

                <li class="dropdown visible-xs visible-sm">
                    <a href="#" data-webarch="toggle-right-side">
                        <i class="material-icons">chat</i>
                    </a>
                </li>
            </ul>
        </div>
        <!-- END RESPONSIVE MENU TOGGLER -->

        <div class="header-quick-nav">
            <!-- BEGIN TOP NAVIGATION MENU -->
            <div class="pull-left">
                <ul class="nav quick-section">
                    <li class="quicklinks">
                        <a href="#" class="" id="layout-condensed-toggle">
                            <i class="material-icons">menu</i>
                        </a>
                    </li>
                </ul>
                <ul class="nav quick-section">

                    <li class="quicklinks"><span class="h-seperate"></span></li>
                    <li class="search_bar m-r-10 input-prepend inside search-form no-boarder" data-toggle="search">
                        <span class="add-on"> <i class="material-icons" style="font-weight: 600">search</i></span>
                        <span class="search_bar_t" style="color: #6f7b8a; font-weight: 600;">Search movies, people...</span>
                    </li>
                </ul>
            </div>

            <!-- END TOP NAVIGATION MENU -->


            <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right">
                <!-- Authentication Links -->
                @if (Auth::guest())
                    <li><a href="{{ url('/login.custom') }}">Login</a></li>
                    <li><a href="{{ url('/register') }}">Register</a></li>
                @else

                <!-- BEGIN CHAT TOGGLER -->
                    <div class="pull-right">
                        <div class="chat-toggler sm">
                            <div class="profile-pic">
                                <img src="/assets/images/{{ Auth::user()->avatar }}" alt=""
                                     data-src="/assets/images/{{ Auth::user()->avatar }}"
                                     data-src-retina="/assets/images/{{ Auth::user()->avatar }}" width="35"
                                     height="35"/>
                                <div class="availability-bubble online"></div>
                            </div>
                        </div>
                        <ul class="nav quick-section ">
                            <li class="quicklinks"><span class="h-seperate"></span></li>
                            <li class="quicklinks">
                                <a href="#" class="chat-menu-toggle" data-webarch="toggle-right-side"><i
                                            class="material-icons">chat</i><span
                                            class="badge badge-important hide">1</span>
                                </a>

                                <div class="chat-menu-toggle chat_m_noty">
                                    <div class="simple-chat-popup-arrow"></div>
                                    <div class="simple-chat-popup-inner">
                                        <div style="width:180px">
                                            <div class="semi-bold chat_m_noty_t"></div>
                                            <div class="message chat_m_noty_d"></div>
                                        </div>
                                    </div>
                                </div>


                            </li>
                        </ul>
                    </div>
                    <!-- END CHAT TOGGLER -->


                @endif
            </ul>

        </div>
        <!-- END TOP NAVIGATION MENU -->
    </div>
    <!-- END TOP NAVIGATION BAR -->
</div>
<!-- END HEADER -->