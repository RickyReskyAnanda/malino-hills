<x-base.landing-page isTransparentNavbar="true">
    
<div class="no-bottom no-top" id="content">

    <div id="top"></div>

    @include('landing-page.home.section-intro')
    @include('landing-page.home.section-slide-images')

    @include('landing-page.home.section-rooms')
    @include('landing-page.home.section-experience')
    @include('landing-page.home.section-video')
    @include('landing-page.home.section-special-offers')
<!-- 
    <section class="no-top no-bottom section-dark" aria-label="section">
        <a class="d-block hover popup-youtube" href="{{ asset('video_slide.mp4') }}">
            <div class="relative overflow-hidden">
                <div class="absolute start-0 w-100 abs-middle fs-36 text-white text-center z-2">
                    <div class="player wow scaleIn"><span>Play</span></div>
                </div> 
                <div class="absolute w-100 h-100 top-0 bg-dark hover-op-05"></div>
                <img src="{{ asset('assets/images/video-background/bg-1.png') }}" class="img-fluid w-100" alt="">
            </div>
        </a>
    </section> -->
    

</div>

</x-base.landing-page>