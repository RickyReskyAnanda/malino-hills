<section class="">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-lg-3 text-center">
                <div style="margin-bottom: 6rem;">
                <p class="fs-5 text">— {{ __('meeting.content.title') }} —</p>
                @foreach(__('meeting.content.body') as $key => $value)
                <p class="lead wow ">{{ $value }}</p>
                @endforeach
                </div>
            </div>
        </div>
        <div class="row "  style="margin-bottom: 6rem;">
            <div class="col-lg-10 offset-lg-1">
                <div class="w-100 p-1 text-center" style="border:1px solid #ab8965;">
                    <div class="w-100 p-3 text-center" style="border:1px solid #ab8965;">
                        <p>{{ __('meeting.content.contact_text') }}</p>
                        <p translate="no"><a href="https://wa.me/{{ $landingPageData['whatsapp'] }}?text=Halo%20admin,%20Saya%20ingin%20bertanya%20terkait%20Meeting%20Room" class="border-success  text-dark font-xss" style="padding: 10px 40px !important;     border: 1px solid !important; font-size:14px;"><i class="fa-brands fa-whatsapp"></i> (+62) {{ substr($landingPageData['whatsapp'], 2) }}</a></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row g-4 align-items-center">
            <div class="col-lg-10 offset-lg-1">
                <div class="row">
                    <div class="col-lg-6 mb-5">
                        <div id="carouselMeetingRoom" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                @foreach($data->slideImages as $key => $slideImage)
                                <div class="carousel-item {{ $key != 0 ?: 'active' }}"  data-bs-interval="3000">
                                    <img src="{{ asset($slideImage->path_original ?? '') }}" class="d-block w-100" alt="...">
                                </div>
                                @endforeach
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselMeetingRoom" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselMeetingRoom" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            </button>
                        </div>
                    </div>
                    <div class="col-lg-6 mb-5">
                        <div class="ps-lg-3">
                            <div class="subtitle mb-2 id-color wow" data-wow-delay=".2s">{{ __('meeting.content.subtitle2') }}</div>
                            <h5 class="wow mb-3" data-wow-delay=".4s">{{ $data['title'] }}</h5>
                            <p
                                class="mb-0 wow"
                                data-wow-delay=".6s">{{ $data['description'] }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
