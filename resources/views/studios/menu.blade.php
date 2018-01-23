<!-- BEGIN SIDEBAR -->
<div class="page-sidebar " id="main-menu" style="margin-top: 0px;">
    <!-- BEGIN MINI-PROFILE -->

    <div class="">

        <!-- BEGIN LOGO -->
        <a href="">
            <img src="{{ Request::root() }}/assets/img/logo.png" class="logo" alt="" data-src="{{ Request::root() }}/assets/img/logo.png" data-src-retina="{{ Request::root() }}/assets/img/logo2x.png" width="106" height="21" />
        </a>
        <!-- END LOGO -->

    </div>
    <!-- END MINI-PROFILE -->


    <div class="page-sidebar-wrapper scrollbar-dynamic" id="main-menu-wrapper">

        <!-- BEGIN SIDEBAR MENU -->

        <ul>
            <li>
                <a href="{{route('channels.index')}}"> <span class="title">Upload Titles</span> </a>
            </li>
            <li>
                <a href="{{ route('media.index')}}"> <span class="title">media</span> </a>
            </li>

        </ul>




        <div class="clearfix"></div>
        <!-- END SIDEBAR MENU -->
    </div>
</div>
<a href="#" class="scrollup">Scroll</a>
<div class="footer-widget">
    <div class="pull-right">

    </div>
</div>
<!-- END SIDEBAR -->

