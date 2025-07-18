<section class="no-top no-bottom text-light jarallax relative vertical-center p-section" data-video-src="mp4:{{ asset('video-background.mp4') }}">
    <div class="container relative z-2">
        <div class="row g-4">
            <div class="col-lg-12 text-center"> 
                <div class="sw-text-wrapper">
                    <h1 class="slider-title fs-120 mb-2" translate="no">{{ $appName }}</h1>
                    <p class="slider-teaser mb-0">{{ __('homepage.intro.message') }} {{ $appName }} Resort & Cafe.</p>
                </div>

                <div class="spacer-single"></div>

                <div class="bg-blur padding40 py-4">
                    <form method="get" action="{{ url(request()->segment(1).'/check-availability') }}">
                        <div class="row g-4 align-items-center">
                            <div class="col-lg-9">
                                <div class="row g-4 align-items-center">
                                    <div class="col-lg-3 text-lg-start text-center">
                                        <h3 class="mb-0">{{ __('homepage.intro.label') }}</h3>
                                    </div>

                                    <div class="col-lg-5">
                                        <div class="text-center ">
                                            <h6 class="text-white mb-1">{{ __('homepage.intro.form1') }}</h6>
                                            <input type="text" id="date-picker" class="form-control no-border no-bg bg-focus-color text-white fs-20 text-right text-center" name="date" value="">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="text-center ">
                                            <h6 class="text-white">{{ __('homepage.intro.form2') }}</h6>
                                            <div class="de-number">
                                                <span class="d-minus" translate="no">-</span>
                                                <input type="text" class="no-border no-bg" name="guest" value="1">
                                                <span class="d-plus" translate="no">+</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 text-lg-end text-center">
                                <button type="submit" class="btn-main">{{ __('homepage.intro.button') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            
        </div>
        
    </div>
    <div class="de-overlay"></div>
</section>
