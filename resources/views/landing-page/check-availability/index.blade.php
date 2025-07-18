<x-base.landing-page isTransparentNavbar="true" isShowBtnCheckAvailability="false">
    
       
        <!-- header close -->
        <section class="relative pb-5 jarallax text-dark" style="padding-top:150px!important;">
            <img src="{{ $url ?? asset('assets/image/page-header/background2.jpg') }}" class="jarallax-img" alt="">
    
            <div class="container position-relative pt-3" style="z-index:1200;">
                <h2 class="mb-5 text-white text-center">{{ __('check_availability.page_header.title') }}</h2>
                <div class="bg-white padding40 py-4" style="border-radius: 5px !important;">
                    <form method="get" action="{{ url(request()->segment(1).'/check-availability') }}">
                        <div class="row g-4 align-items-center">
                            <div class="col-lg-9">
                                <div class="row g-4 align-items-center">
                                    <div class="col-lg-3 text-lg-start text-center">
                                        <h3 class="mb-0">{{ __('homepage.intro.label') }}</h3>
                                    </div>
                                    <div class="col-lg-5">
                                        <div class="text-center ">
                                            <h6 class="id-color mb-1">{{ __('homepage.intro.form1') }}</h6>
                                            <input
                                                type="text"
                                                id="date-picker"
                                                 translate="no"
                                                class="form-control no-border bg-focus-color text-dark fs-20 text-right text-center "
                                                name="date"
                                                value="{{ request()->query('date') }}"
                                            >
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="text-center ">
                                            <h6 class="id-color">{{ __('homepage.intro.form2') }}</h6>
                                            <div class="de-number">
                                                <span class="d-minus" translate="no">-</span>
                                                <input
                                                    type="text"
                                                    class="no-border text-dark"
                                                    name="guest"
                                                    value="{{ request()->query('guest',1) }}"
                                                    id="ed-guest"
                                                >
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
            <div class="de-overlay"></div>
        </section>

        <!-- content begin -->
        <div class="no-bottom no-top" id="content">
        <section class="p-section relative">
            <div class="container">
                @php 
                    $jumlahDataShow = 0;
                @endphp

                @foreach($data as $key => $villa)
                    @if($villa->villa_count - count($villa->booking) > 0)
                    @php $jumlahDataShow++ @endphp
                    <div class="mb-5">
                        <div class="row  gap-3">
                            <div class="col-lg-5 me-0">
                                <div id="carouselExampleControlsNoTouching{{ $key }}" class="carousel slide" data-bs-ride="carousel">
                                    <div class="carousel-inner">
                                        @foreach($villa->slideImages as $si => $img)
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
                            <div class="col-lg-6 m-0 align-self-stretch d-flex flex-column justify-content-between">
                                <div class="d-flex flex-column justify-content-between">
                                    
                                    <div class="py-2  mb-2 subtitle text-primary">{{ __('check_availability.content.availability',['number'=>$villa->villa_count - count($villa->booking)] )  }}</div>
                                    <a href="{{ url(request()->segment(1).'/villas/'.$villa->id_villa.'/'.htmlspecialchars(urlencode($villa->name), ENT_QUOTES, 'UTF-8')) }}">
                                        <h3 translate="no">{{ $villa->name }}</h3>
                                    </a>
                                    <div class="d-flex gap-3 flex-wrap my-2 mb-3">
                                        @foreach($villa->highlightFacilities as $hi => $facility)
                                        <div class="d-flex align-items-center">
                                            <img src="{{ asset( $facility?->icon?->path ?? 'assets/image/icons/size.png' ) }}" class="w-16px h-16px me-2" alt=""/>
                                            <div>{{ $facility->name }}</div>
                                        </div>
                                        @endforeach
                                    </div>
                                    <div class="mb-3">
                                        <span class="m-0">{{ __('check_availability.content.label_price') }}</span>
                                        <h3 class="fw-bold nowrap">Rp {{ number_format($villa->price,0,'.',',') }}</h3>
                                    </div>
                                    
                                    <div class="m-0 d-flex flex-wrap align-items-center gap-3">
                                        <span
                                            data-value="{{ $villa->name ?? '' }}"
                                            class="btn-booking border-dark d-flex justify-content-center  text-dark font-xss bg-success text-white gap-1 pointer"
                                            style="padding: 6px 30px !important; border: 2px solid #198754 !important; font-size:14px;max-width:200px"
                                        >
                                            <span><i class="fa-brands fa-whatsapp"></i></span>
                                            <span>{{ __('check_availability.content.btn') }}</span>
                                        </span>
                                        
                                        <a href="{{ url(request()->segment(1).'/villas/'.$villa->id_villa.'/'.strtolower(str_replace(' ','-',$villa['name']))) }}" class="border-dark  text-dark font-xss" style="padding: 6px 30px !important;     border: 1px solid !important; font-size:14px;">
                                        {{ __('check_availability.content.btn2') }}
                                        </a>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                @endforeach
                    
                @if($jumlahDataShow == 0)
                        <h5 class="text-center text-secondary" style="margin: 12rem 0;">{{ __('check_availability.content.not_availability') }}</h5>
                @endif
            </div>
        </section>
            
        </div>
        </x-base.landing-page>
        
<script>
    let startDate = moment("{{ $startDate }}", "YYYY-MM-DD").format("DD MMM YYYY"); // Default ke hari ini jika tidak ada start_date
    let endDate = moment("{{ $endDate }}", "YYYY-MM-DD").format("DD MMM YYYY"); // Default ke hari ini jika tidak ada end_date

    $('#date-picker').daterangepicker({
        "showISOWeekNumbers": true,
        "timePicker": false,
        minDate: moment(),
        maxSpan: {
            "months": 2
        },
        "locale": {
            "format": "DD MMM YYYY",
            "separator": " - ",
            "fromLabel": "From",
            "toLabel": "To",
            "customRangeLabel": "Custom",
            "weekLabel": "W",
            "daysOfWeek": [
                "Su",
                "Mo",
                "Tu",
                "We",
                "Th",
                "Fr",
                "Sa"
            ],
            "monthNames": [
                "January",
                "February",
                "March",
                "April",
                "May",
                "June",
                "July",
                "August",
                "September",
                "October",
                "November",
                "December"
            ],
            "firstDay": 1
        },
        "linkedCalendars": true,
        "showCustomRangeLabel": false,
        startDate: startDate,
        endDate: endDate,
        autoApply: true,
        "opens": "right"
    });

    $('.btn-booking').click(function() {
        // Ambil data dari input
        var guests = $('#ed-guest').val();
        var dates = $('#date-picker').val();
        
        // Format pesan WhatsApp
        var message = `Halo, saya ingin booking ${$(this).attr('data-value')}. Berikut data saya:\n\n` +
                        `Guest: ${guests} Orang\n` +
                        `Tanggal: ${dates}\n\n` +
                        `Apakah villanya tersedia ?`;

        // Encode URI untuk link wa.me
        var whatsappLink = 'https://wa.me/{{ $landingPageData["whatsapp"] }}?text=' + encodeURIComponent(message);
        
        // Redirect ke WhatsApp
        window.open(whatsappLink, '_blank');
    });
             
</script>