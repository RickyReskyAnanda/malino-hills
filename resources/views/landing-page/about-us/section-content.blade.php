<section class="">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-lg-3 text-center">
            <div style="margin-bottom: 7rem;">
                <p class="fs-5 text">— {{ __('about.content.title') }} —</p>
                @foreach(__('about.content.body') as $key => $value)
                <p class="lead wow ">{{ $value }}</p>
                @endforeach
            </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row g-4 align-items-center">
            <div class="col-lg-6">
                <div class="relative">
                    <img src="{{ asset('assets/about-us/1.jpg') }}" class="w-100 pe-5 pb-5 wow scaleIn" alt="">
                    <img src="{{ asset('assets/about-us/2.jpg') }}" class="w-50 abs end-0 bottom-0 z-2 wow scaleIn" data-wow-delay=".2s" alt="">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="ps-lg-3">
                    <div class="subtitle id-color wow" data-wow-delay=".2s">{{ __('about.content_2.subtitle') }}</div>
                    <h2 class="wow  font-section " data-wow-delay=".4s">{{ __('about.content_2.title') }}</h2>
                    @foreach(__('about.content_2.body') as $key => $value)
                    <p class="lead wow ">{{ $value }}</p>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
