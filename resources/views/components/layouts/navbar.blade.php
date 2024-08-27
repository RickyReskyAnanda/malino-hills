<header 
@class([
    'scroll-blur'.
    'has-topbar',
    'transparent' => $isTransparent == 'true',
])>
@if($isTransparent != 'true')
<div id="topbar">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="d-flex justify-content-between xs-hide">
                        <div class="header-widget d-flex">                                    
                            <div class="topbar-widget"><a href="#"><i class="icofont-location-pin"></i>742 Evergreen Terrace Brooklyn, NY 11201</a></div>
                            <div class="topbar-widget"><a href="#"><i class="icofont-phone"></i>+929 333 9296</a></div>
                            <div class="topbar-widget"><a href="#"><i class="icofont-envelope"></i>contact@almaris.com</a></div>
                        </div>

                        <div class="social-icons">
                            <a href="#"><i class="fa-brands fa-facebook fa-lg"></i></a>
                            <a href="#"><i class="fa-brands fa-x-twitter fa-lg"></i></a>
                            <a href="#"><i class="fa-brands fa-youtube fa-lg"></i></a>
                            <a href="#"><i class="fa-brands fa-pinterest fa-lg"></i></a>
                            <a href="#"><i class="fa-brands fa-instagram fa-lg"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
    @endif
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="de-flex sm-pt10">
                    <div class="de-flex-col">
                        <!-- logo begin -->
                        <div id="logo">
                            <a href="{{ url('/') }}">
                                <img class="logo-main" src="{{ asset('assets/images/logo-white.webp') }}" alt="" >
                                <img class="logo-scroll" src="{{ asset('assets/images/logo-black.webp') }}" alt="" >
                                <img class="logo-mobile" src="{{ asset('assets/images/logo-white.webp') }}" alt="" >
                            </a>
                        </div>
                        <!-- logo close -->
                    </div>
                    <div class="de-flex-col header-col-mid">
                        <ul id="mainmenu">
                            <li><a class="menu-item" href="{{ url('rooms') }}">ROOMS</a></li>
                            <li><a class="menu-item" href="{{ url('offers') }}">OFFERS</a></li>
                            <li><a class="menu-item" href="{{ url('dining') }}">DINING</a></li>
                            <li><a class="menu-item" href="{{ url('experience') }}">EXPERIENCE</a></li>
                            <li><a class="menu-item" href="{{ url('facilities') }}">FACILITIES</a></li>
                            <li><a class="menu-item" href="#">MORE</a>
                                <ul>
                                    <li><a href="{{ url('about-malino-hills') }}">About Malino Hills</a></li>
                                    <li><a href="{{ url('locate-us') }}">Locate Us</a></li>
                                    <li><a href="{{ url('contact-us') }}">Contact Us</a></li>
                                    <li><a href="{{ url('privacy-policy') }}">Privacy Policy</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="de-flex-col">
                        <div class="menu_side_area">          
                            <a href="{{ url('reservation') }}" class="btn-main btn-line">Reservation</a>
                            <span id="menu-btn"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>