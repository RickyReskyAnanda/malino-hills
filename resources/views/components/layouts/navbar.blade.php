
<header 
@class([
    'scroll-blur'.
    'has-topbar',
    'transparent' => $isTransparent == 'true',
])>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="de-flex sm-pt10">
                    <div class="de-flex-col">
                        <!-- logo begin -->
                        <div id="logo">
                            <a href="{{ url(request()->segment(1).'/') }}">
                                <img class="logo-main" src="{{ asset('assets/logo/logo-navbar.png') }}" alt="Malino Hills" >
                                <img class="logo-scroll" src="{{ asset('assets/logo/logo-navbar.png') }}" alt="Malino Hills" >
                                <img class="logo-mobile" src="{{ asset('assets/logo/logo-navbar.png') }}" alt="Malino Hills" >
                            </a>
                        </div>
                        <!-- logo close -->
                    </div>
                    <div class="de-flex-col header-col-mid">
                        <ul id="mainmenu">
                            <li><a class="menu-item" href="{{ url(request()->segment(1).'/villas') }}">{{ __('header.villa') }}</a></li>
                            <li><a class="menu-item" href="{{ url(request()->segment(1).'/facilities') }}">{{ __('header.facility') }}</a></li>
                            <li><a class="menu-item" href="{{ url(request()->segment(1).'/gallery') }}">{{ __('header.gallery') }}</a></li>
                            <li><a class="menu-item" href="{{ url(request()->segment(1).'/meeting') }}">{{ __('header.meeting') }}</a></li>
                            <li><a class="menu-item" href="{{ url(request()->segment(1).'/experience') }}">{{ __('header.experience') }}</a></li>
                            <li>
                                <a class="menu-item" href="#">{{ __('header.more') }}</a>
                                <ul>
                                    <li><a href="{{ url(request()->segment(1).'/about-us') }}">{{ __('header.about_us') }}</a></li>
                                    <li><a href="{{ url(request()->segment(1).'/locate-contact') }}">{{ __('header.locate') }}</a></li>
                                    <li><a href="{{ url(request()->segment(1).'/privacy-policy') }}">{{ __('header.privacy') }}</a></li>
                                </ul>
                            </li>
                            <li translate="no">
                                <a class="menu-item" href="#">
                                    @if(request()->segment(1) == 'id')
                                    <img style="width: 20px;" src="{{ asset('assets/icon/flag.png') }}"/>
                                    @else
                                    <img style="width: 20px;" src="{{ asset('assets/icon/globe.png') }}"/>
                                    @endif
                                </a>
                                <ul>
                                    <li><a href="{{ url('id/'.str_replace(request()->segment(1).'/','',request()->path()) ) }}">Bahasa Indonesia</a></li>
                                    <li><a href="{{ url('en/'.str_replace(request()->segment(1).'/','',request()->path()) ) }}">English</a></li>
                                </ul>
                            </li>
                            
                        </ul>
                    </div>
                    <div class="de-flex-col">
                        <div class="menu_side_area">          
                            <a href="{{ url(request()->segment(1).'/check-availability') }}" class="btn-main btn-line">{{ __('header.btn') }}</a>
                            <span id="menu-btn"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
