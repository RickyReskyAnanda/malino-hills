<section class="p-section">
    <div class="container-fluid">
        


        <div class="row g-4 align-items-center">
            <div class="col-lg-6 offset-lg-3 text-center">
                <h2 class="wow  font-section">{{ __('homepage.section_facilities.title') }}</h2>
                @foreach(__('homepage.section_facilities.body') as $key => $value)
                <p class="lead wow ">{{ $value }}</p>
                @endforeach
            </div>
            
            <div class="col-lg-12 mb-3">
                <div id="facility-carousel" class="owl-3-cols-autowidth owl-carousel owl-theme">
                    @foreach($slideFacility as $f)
                        <img src="{{ asset($f) }}" class="border border-white h-300px" alt="">
                    @endforeach
                </div>
            </div>
            <x-mikro.button-load-more url="{{ url(request()->segment(1).'/facilities') }}"  title="{{ __('homepage.section_facilities.btn_more') }}"/>
        </div>
    </div>
</section>