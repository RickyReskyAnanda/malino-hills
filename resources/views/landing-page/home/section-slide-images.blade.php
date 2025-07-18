<section class="p-section">
    <div class="container-fluid">
        


        <div class="row g-4 align-items-center">
            <div class="col-lg-6 offset-lg-3 text-center">
                <h2 class="wow  font-section">{{ __('homepage.section_slide_image.title') }}</h2>
                @foreach(__('homepage.section_slide_image.body') as $key => $value)
                <p>{{ $value }}</p>
                @endforeach
            </div>
            
            <div class="col-lg-12 mb-3">
                <div id="gallery-carousel" class="owl-3-cols-autowidth owl-carousel owl-theme">
                    @foreach($gallery as $g)
                        <img src="{{ asset($g) }}" class="border border-white h-400px" alt="">
                    @endforeach
                </div>
            </div>
            <x-mikro.button-load-more url="{{ url(request()->segment(1).'/facilities') }}"  title="{{ __('homepage.section_slide_image.btn_more') }}"/>
        </div>
    </div>
</section>