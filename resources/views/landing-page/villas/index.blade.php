<x-base.landing-page isTransparentNavbar="true">
    <div class="no-bottom no-top" id="content">

        <x-layouts.page-header
            title="{{ __('villa.page_header.title',['appName'=>$appName]) }}"
            subtitle="{{ __('villa.page_header.subtitle') }}"
        />

        <section class="p-section relative">
            <div class="container">
                @foreach($villa as $key => $v)
                <div class="row g-3 align-items-center mb-5">
                    <div class="col-lg-5">
                    <div id="carouselExampleControlsNoTouching{{ $key }}" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                @foreach($v->slideImages as $si => $img)
                                <div class="carousel-item @if($si == 0)  active @endif"  data-bs-interval="3000">
                                    <img src="{{ url($img->path_original ?? '') }}" class="d-block w-100" alt="...">
                                </div>
                                @endforeach
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControlsNoTouching{{ $key }}" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControlsNoTouching{{ $key }}" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            </button>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="ps-lg-3">
                            <div class="subtitle mb-4">VILLA</div>
                            <a href="{{ url(request()->segment(1).'/villas/'.$v['id_villa'].'/'.htmlspecialchars(urlencode($v['name']), ENT_QUOTES, 'UTF-8')) }}"><h3>{{ $v['name'] }}</h3></a>

                            <div class="d-flex flex-wrap gap-3 my-3">
                                @foreach($v->highlightFacilities as $hf)
                                <div class="">
                                    <div class="d-flex">
                                        <img src="{{ asset($hf?->icon?->path) }}" class="w-20px h-20px me-2" alt="">
                                        <div translate="no">{{ $hf->name }}</div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <p>
                                <p class="m-0">{{ __('villa.content.label_price') }}</p>
                                <h3 class="fw-bold">{{ 'Rp '.number_format($v->price,0,'.',',') }}</h3>
                            </p>
                            <a
                                href="{{ url(request()->segment(1).'/villas/'.$v->id_villa.'/'.strtolower(str_replace(' ','-',$v['name']))) }}"
                                class="border-dark  text-dark font-xss"
                                style="padding: 6px 30px !important; border: 1px solid !important; font-size:14px;"
                            >{{ __('villa.content.btn') }}</a>
                        </div>
                    </div>
                </div>
                @endforeach
                @if(count($villa) == 0) 
                <h5 class="text-center text-secondary" style="margin: 12rem 0;">Villa not available</h5>
                @endif
            </div>
        </section>
    </div>
  
</x-base.landing-page>
