<section class="p-section">
    <div class="container relative z-2">
        <div class="row g-4">
            <div class="col-lg-12 text-start">
                <h4 class="">Other Rooms</h4>
                <p>Other Rooms You May Be Interested In</p>
            </div>
            
            <div class="col-lg-12 mb-2">
                <div class="owl-custom-nav menu-float px-5" data-target="#room-carousel"  style="margin-left: -50px;margin-right: -50px;">
                    <a class="btn-next"></a>
                    <a class="btn-prev"></a>                                

                    <div id="room-carousel" class="owl-2-cols owl-carousel owl-theme">
                        @foreach($rooms as $link)
                        <!-- room begin -->
                        <div class="item">
                            <div class="hover relative text-light text-center wow mb-4" data-wow-delay=".3s">
                                <img src="{{ $link['link'] }}" class="w-100 rounded" alt="">
                                <div class="abs hover-op-1 z-4 hover-mt-40 abs-centered">
                                    <div class="fs-14">From</div>
                                    <h3 class="fs-40 lh-1 mb-4">$129</h3>
                                    <a class="btn-line" href="room-single.html">View Details</a>
                                </div>
                            </div>
                            <h4>{{ $link['name'] }}</h4>
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
                        </div>
                        @endforeach
                        <!-- room end -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
