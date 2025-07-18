<section class="p-section">
    <div class="container">
        <div class="row g-4 justify-content-center mb-5">
            <div class="col-lg-8 text-center">
                <h2 class="wow  font-section">{{ __('homepage.section_experience.title') }} {{ $appName }}</h2>
                @foreach(__('homepage.section_experience.body') as $key => $value)
                <p class="lead wow ">{{ $value }}</p>
                @endforeach
            </div>
        </div>
        <div class="row g-4">
            <!-- offer begin -->
            <div class="col-lg-12">
                <div class="owl-custom-nav menu-float px-5" data-target="#experience-carousel">
                    <a class="btn-next rounded-0"></a>
                    <a class="btn-prev rounded-0"></a>                                

                    <div id="experience-carousel" class="owl-3-cols owl-carousel owl-theme">
                        <!-- room begin -->
                        @foreach($experience as $e)
                            <div class="item">
                                <div class="hover relative overflow-hidden text-light wow fadeInUp" data-wow-delay=".2s">
                                    <img src="{{ asset($e->thumbnail?->path_portrait ?? '') }}" class="w-100 hover-scale-1-1" alt="">
                                    <div class="abs z-2 bottom-0 mb-3 w-100 padding40">
                                        <h3>{{ $e->title ?? '' }}</h3>
                                        <p class="max-line-4">
                                            {{ $e->short_description ?? '' }}
                                        </p>
                                        <a class="btn-main" href="{{ url(request()->segment(1).'/experience/'.$e->id_experience.'/'.htmlspecialchars(urlencode($e->title), ENT_QUOTES, 'UTF-8')) }}">{{ __('homepage.section_experience.btn_detail') }}</a>
                                    </div>
                                    <div class="overlay-gradient-dark-bottom abs w-100 h-80 bottom-0"></div>
                                </div>
                            </div>
                        @endforeach
                        <!-- offer end -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>