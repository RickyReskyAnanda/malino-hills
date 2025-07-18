<section class="p-section">
    <div class="container relative z-2">
        <div class="row g-4">
            <div class="col-lg-12 text-start">
                <h4 class="">{{ __('villa_detail.title2') }}</h4>
                <p>{{ __('villa_detail.subtitle2') }}</p>
            </div>
            
            <div class="col-lg-12 mb-2">
                <div class="owl-custom-nav menu-float px-5" data-target="#room-carousel"  style="margin-left: -50px;margin-right: -50px;">
                    <a class="btn-next"></a>
                    <a class="btn-prev"></a>                                

                    <div id="room-carousel" class="owl-3-cols owl-carousel owl-theme">
                        @foreach($othersVilla as $o)
                        <!-- room begin -->
                        <div class="item">
                            <div class="hover relative text-light text-center wow mb-4" data-wow-delay=".3s">
                                <img src="{{ $o->images?->path_original ? asset($o->images?->path_original) : '' }}" class="w-100 rounded" alt="">
                                <div class="abs hover-op-1 z-4 hover-mt-40 abs-centered">
                                    <div class="fs-14">Price</div>
                                    <h3 class="fs-30 lh-1 mb-4 nowrap">{{ 'Rp '.number_format($o->price) }}</h3>
                                    <a class="btn-line" href="{{ url(request()->segment(1).'/villas/'.$o->id_villa.'/'.htmlspecialchars(urlencode($o->name), ENT_QUOTES, 'UTF-8')) }}">{{ __('villa_detail.btn_view') }}</a>
                                </div>
                            </div>
                            
                            <a href="{{ url(request()->segment(1).'/villas/'.$o->id_villa.'/'.htmlspecialchars(urlencode($o->name), ENT_QUOTES, 'UTF-8')) }}"><h4>{{ $o->name }}</h4></a>
                            <div class="row my-3">
                                @foreach($o->highlightFacilities as $hf)
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
        </div>
    </div>
</section>
