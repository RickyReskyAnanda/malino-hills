<section class="relative p-section">
    <div class="container-fluid relative z-2">
        <div class="row g-4">
            <div class="col-lg-6 offset-lg-3 text-center">
                <h2 class="wow  font-section">{{ __('homepage.section_villa.title') }}</h2>
                @foreach(__('homepage.section_villa.body') as $key => $value)
                <p>{{ $value }}</p>
                @endforeach
            </div>
            
            <div class="col-lg-12 mb-2">
                <div class="owl-custom-nav menu-float px-5" data-target="#villas-carousel">
                    <a class="btn-next"></a>
                    <a class="btn-prev"></a>                                

                    <div id="villas-carousel" class="owl-3-cols owl-carousel owl-theme">
                        @foreach($villa as $v)
                        <!-- room begin -->
                        <div class="item">
                            <div class="hover relative text-light text-center wow mb-4" data-wow-delay=".3s">
                                <img src="{{ $v->images?->path_original ? asset($v->images?->path_original) : '' }}" class="w-100 rounded" alt="">
                                <div class="abs hover-op-1 z-4 hover-mt-40 abs-centered">
                                    <div class="fs-14">Start From</div>
                                    <h3 class="fs-30 lh-1 mb-4 nowrap">{{ 'Rp '.number_format($v->price) }}</h3>
                                    <a class="btn-line" href="{{ url(request()->segment(1).'/villas/'.$v->id_villa.'/'.htmlspecialchars(urlencode($v->name), ENT_QUOTES, 'UTF-8')) }}">{{ __('homepage.section_villa.btn_detail') }}</a>
                                </div>
                            </div>
                            <h4>{{ $v['name'] }}</h4>
                            <div class="row my-3">
                                @foreach($v->highlightFacilities as $hf)
                                <div class="col-6">
                                    <div class="d-flex">
                                        <img src="{{ asset($hf?->icon?->path) }}" class="w-20px h-20px me-2" alt="">
                                        <div translate="no">{{ $hf->name }}</div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                        <!-- room end -->
                    </div>
                </div>
            </div>
            <x-mikro.button-load-more url="{{ url(request()->segment(1).'/villas') }}"  title="{{ __('homepage.section_villa.btn_more') }}"/>
        </div>
    </div>
</section>
