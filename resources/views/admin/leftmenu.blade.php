<!-- BEGIN SIDEBAR -->
      <div class="page-sidebar " id="main-menu" style="margin-top: 0px;">
          <!-- BEGIN MINI-PROFILE -->

              <div class="">

                  <!-- BEGIN LOGO -->
                  <a href="">
                      <img src="{{ Request::root() }}/assets/img/logo.png" class="logo" alt="" data-src="{{ Request::root() }}/assets/img/logo.png" data-src-retina="{{ Request::root() }}/assets/img/logo2x.png"  />
                  </a>
                  @if(Auth::user()->role == 1)
                  <a href="/home" class="dropdown-toggle active">
                      <i class="material-icons gth_adm_icon">home</i>
                  </a>
                  @endif
                  <!-- END LOGO -->


              </div>
              <!-- END MINI-PROFILE -->




        <div class="page-sidebar-wrapper scrollbar-dynamic" id="main-menu-wrapper">
          
          <!-- BEGIN SIDEBAR MENU -->

            <ul>
                @if(Auth::user()->role == 1)
                <li>
                    <a href="{{route('channels.index')}}"> <span class="title">live tv</span> </a>
                </li>
                <li>
                    <a href="{{ route('videos.index')}}"> <span class="title">videos</span> </a>
                </li>
                <li>
                    <a href="{{ route('advertising.index')}}"> <span class="title">advertising</span> </a>
                </li>
                <li>
                    <a href="{{ route('media.index')}}"> <span class="title">media</span> </a>
                </li>
                <li>
                    <a href="{{ route('posts.index')}}"> <span class="title">news</span> </a>
                </li>

                <li>
                    <a href="/admin/movies"> <span class="title">movies</span> </a>
                </li>

                <li>
                    <a href="{{ route('series.index') }}"> <span class="title">Series</span> </a>
                </li>

                {{--<li>--}}
                    {{--<a href="{{ route('episodes.index') }}"> <span class="title">episodes</span> </a>--}}
                {{--</li>--}}
                <li>
                    <a href="{{ route('users.index') }}"> <span class="title">Users</span> </a>
                </li>

                <li>
                    <a href="/admin/payments"> <span class="title">Payments</span> </a>
                </li>

                <li>
                    <a href="/admin/hp_slide"> <span class="title">Home Page Slider</span> </a>
                </li>

                <li>
                    <a href="/admin/emails"> <span class="title">Emails</span> </a>
                </li>

                <li>
                    <a href="/admin/subscriptions"> <span class="title">Subscriptions</span> </a>
                </li>

                <li>
                    <a href="/admin/whats_on"> <span class="title">whats On TV</span> </a>
                </li>
                @endif

                @if(Auth::user()->role == 2)
                    <li>
                        <a href="/studio/dashboard"> <span class="title">Dashboard</span> </a>
                    </li>
                    <li>
                        <a href="{{ route('movies.index') }}"> <span class="title">Movies</span> </a>
                    </li>

                    <li>
                        <a href="{{ route('series.index') }}"> <span class="title">Series</span> </a>
                    </li>

                    <li>
                        <a href="/studio/settings"> <span class="title">Settings</span> </a>
                    </li>
                @endif

                    @if(Auth::user()->role == 4 && Auth::user()->subscription_enabled)
                        <li>
                            <a href="{{ route('tvVideos')}}"> <span class="title">videos</span> </a>
                        </li>
                        {{--<li>--}}
                            {{--<a href="{{ route('tvAdvertising')}}"> <span class="title">advertising</span> </a>--}}
                        {{--</li>--}}
                        <li>
                            <a href="{{ route('tvsettings') }}"> <span class="title">Settings</span> </a>
                        </li>
                        <?php $subscription = \App\Subscription::where('user_id', Auth::user()->id)->orderBy('id','desc')->first(); ?>
                        @if($subscription->subscription_type === 'pro')
                            <li>
                                <a href="{{ route('tvdashboard') }}"> <span class="title">Statistics</span> </a>
                            </li>
                        @endif
                        <li>
                            <a href="{{ route('tvhiw') }}"> <span class="title">How it works</span> </a>
                        </li>
                @endif

            </ul>
            @if(Auth::user()->role == 1)
            <div class="side-bar-widgets m-t-50">
                <p class="menu-title">Create Category </p>
                <div class="status-widget">
                    <div class="status-widget-wrapper">
                        <div class="title"><a href="{{ URL::to('admin/postscategory') }}" class="text-white">News </a></div>
                        <p>click here to create news</p>
                    </div>
                </div>
                <div class="status-widget">
                    <div class="status-widget-wrapper">
                        <div class="title"><a href="{{ URL::to('admin/channelscategory') }}" class="text-white">Channels </a></div>
                        <p>click here to create Channels</p>
                    </div>
                </div>
                <div class="status-widget">
                    <div class="status-widget-wrapper">
                        <div class="title"><a href="{{ URL::to('admin/genres') }}" class="text-white">Movie Genre</a></div>
                        <p>click here to create genre</p>
                    </div>
                </div>

                <div class="status-widget">
                    <div class="status-widget-wrapper">
                        <div class="title"><a href="{{ URL::to('admin/actors') }}" class="text-white">Cast </a></div>
                        <p>create actors for a movie </p>
                    </div>
                </div>

                <div class="status-widget">
                    <div class="status-widget-wrapper">
                        <div class="title"><a href="{{ URL::to('admin/directors') }}" class="text-white">Directors </a></div>
                        <p>create movie director </p>
                    </div>
                </div>

                <div class="status-widget">
                    <div class="status-widget-wrapper">
                        <div class="title"><a href="{{ URL::to('admin/studios') }}" class="text-white">Studios </a></div>
                        <p>create a movie studio </p>
                    </div>
                </div>

            </div>
            @endif

          <div class="clearfix"></div>
          <!-- END SIDEBAR MENU -->
        </div>
      </div>
      <a href="#" class="scrollup">Scroll</a>
      <div class="footer-widget">
        <div class="pull-right">
            <a href="{{ url('/logout') }}">
                <i class="material-icons">power_settings_new</i>Logout
            </a>
          </div>
      </div>
      <!-- END SIDEBAR -->

