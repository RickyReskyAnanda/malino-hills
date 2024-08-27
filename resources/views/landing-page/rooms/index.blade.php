<x-base.landing-page isTransparentNavbar="true">
    <div class="no-bottom no-top" id="content">
        
        <x-layouts.page-header
            title="Rooms at Malino Hills"
            subtitle="COMFORT"
        />

        <section class="p-section relative">
            <div class="container">
                @foreach($rooms as $key => $room)
                <div class="row g-3 align-items-center mb-5">
                    <div class="col-lg-6">
                        <div id="carouselExampleControlsNoTouching{{ $key }}" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                <div class="carousel-item active"  data-bs-interval="3000">
                                    <img src="https://cms-asset.ayana.com/cdn-cgi/image/f=auto,q=85,width=1024/ARSB_Ocean_View_Suite_Bed_1320x740_4_447c70d8f5.jpg" class="d-block w-100" alt="...">
                                </div>
                                <div class="carousel-item"  data-bs-interval="3000">
                                    <img src="https://cms-asset.ayana.com/cdn-cgi/image/f=auto,q=85,width=1024/ARSB_Ocean_View_Suite_Living_Room_1320x740_5_722a675964.jpg" class="d-block w-100" alt="...">
                                </div>
                                <div class="carousel-item"  data-bs-interval="3000">
                                    <img src="https://cms-asset.ayana.com/cdn-cgi/image/f=auto,q=85,width=1024/ARSB_Ocean_View_Suite_Bathtub_1320x740_1_925fa26207.jpg" class="d-block w-100" alt="...">
                                </div>
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControlsNoTouching{{ $key }}" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControlsNoTouching{{ $key }}" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            </button>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="ps-lg-3">
                            <div class="subtitle mb-4">VILLA</div>
                            <h3>{{ $room['name'] }}</h3>

                            <div class="row my-3">
                                <div class="col-6">
                                    <div class="d-flex">
                                        <img src="{{ asset('assets/images/icons/guests.png') }}" class="w-20px h-20px me-2" alt="">
                                        <div>4 Guests</div>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="d-flex">
                                        <img src="{{ asset('assets/images/icons/size.png') }}" class="w-20px h-20px me-2" alt="">
                                        <div>35 Feets Size</div>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="d-flex">
                                        <img src="{{ asset('assets/images/icons/door.png') }}" class="w-20px h-20px me-2" alt="">
                                        <div>Connecting Rooms</div>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="d-flex">
                                        <img src="{{ asset('assets/images/icons/bed.png') }}" class="w-20px h-20px me-2" alt="">
                                        <div>1 King Bed</div>
                                    </div>
                                </div>
                            </div>
                            <p>Refresh your holiday mood by checking in to AYANA's newly renovated room with superior elevated views of the Indian Ocean.</p>
                            <a href="{{ url('rooms/'.strtolower(str_replace(' ','-',$room['name']))) }}" class="border-dark  text-dark font-xss" style="padding: 6px 30px !important;     border: 1px solid !important; font-size:14px;">SEE DETAIL</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </section>
    </div>

</x-base.landing-page>
