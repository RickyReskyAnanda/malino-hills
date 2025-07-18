<section class="no-bottom no-top mt-5">
    <div class="container">
        <div class="row g-4 gx-5">
            <div class="col-lg-7 ">
                <h2 translate="no">{{ $villa->name ?? '' }}</h2>
                <div class="d-flex gap-3 flex-wrap">
                    @foreach($villa->highlightFacilities as $hf)
                    <div class="relative">
                        <img src="{{ asset($hf?->icon?->path) }}" class="w-20px abs mt-1" alt="">
                        <p class="ml30 text-dark fw-500">{{ $hf->name }}</p>
                    </div>
                    @endforeach
                    
                </div>
                <div class="spacer-single"></div>
                <h3 class="mb-4">{{ __('villa_detail.title1') }}</h3>
                <p><?= $villa->content ?? '' ?></p>
                <div class="spacer-single"></div>
                @if(count($villa->facilities) > 0)
                <h4 class="mb-4">{{ __('villa_detail.amenities') }}</h4>
                <ul class="ul-style-2">
                    @foreach($villa->facilities as $f)
                    <li><strong>{{ $f->name }}</strong></li>
                    @endforeach
                </ul>
                @endif
            </div>
            <div class="col-lg-5">
                <div class="bg-dark text-light p-5">
                    <div class="d-flex justify-content-between align-items-center">
                        <span>{{ __('villa_detail.label_price') }}</span>
                        <div>
                            <h3 class="d-inline">{{ 'Rp '.number_format($villa->price,0,'.',',') }}</h3>
                            <span>/{{ __('villa_detail.night') }}</span>
                        </div>
                    </div>
                    <div class="spacer-single"></div>

                    <div class="row g-3">
                        <div class="col-lg-12">
                            <h6 class="mb-2">{{ __('villa_detail.form1') }}</h6>
                            <input type="text" id="date-picker" class="form-control no-bg bg-focus-color text-light text-center" name="date" value="">
                        </div>
                    </div>
                    <div class="spacer-single"></div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="text-center ">
                                <h6>{{ __('villa_detail.form2') }}</h6>
                                <div class="de-number">
                                    <span class="d-minus">-</span>
                                    <input type="text" class="no-border no-bg" id="ed-guest" value="1">
                                    <span class="d-plus">+</span>
                                </div>
                            </div>
                        </div>
                   
                        <div class="col-lg-6">
                            <div class="text-center ">
                                <h6>{{ __('villa_detail.form3') }}</h6>
                                <div class="de-number">
                                    <span class="d-minus">-</span>
                                    <input type="text" class="no-border no-bg" id="ed-villa" value="1" min="1" max="{{ $villa->villa_count }}">
                                    <span class="d-plus">+</span>
                                </div>
                            </div>
                        </div>
                    </div>


                    <p class="text-center h6 py-3 hide" id="message-checking"></p>
                    <div
                        class="border-dark d-flex justify-content-center pointer text-dark font-xss bg-success text-white gap-1 p-2 d-flex justify-content-center align-items-center"
                        id="btn-booking"
                    >
                        <span><i class="fa-brands fa-whatsapp"></i></span>
                        <span id="btn-booking-text">{{ __('villa_detail.btn_booking') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
