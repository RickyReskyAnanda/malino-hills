<section class="relative p-section">
        <div class="container">
            <div class="row g-4 justify-content-center">
                <div class="col-lg-8 text-center">
                    <h3 class="font-section mt-1 wow mb-5">More of {{ $appName }}</h3>
                </div>
            </div>
            <div class="row g-4">
                <!-- room begin -->
                @foreach ([
                    asset("assets/images/room/1.webp"),    
                    asset("assets/images/room/1.webp"),    
                    asset("assets/images/room/1.webp")    
                ] as $link)
                <div class="col-lg-4 col-sm-6">
                    <div class="hover relative text-light text-center wow fadeInUp" data-wow-delay=".3s">
                        <img src="{{ $link }}" class="img-fluid" alt="">
                        <div class="abs hover-op-1 z-4 hover-mt-40 abs-centered">
                            <a class="btn-line" href="room-single.html">View Details</a>
                        </div>
                        <div class="abs bg-color z-2 top-0 w-100 h-100 hover-op-1"></div>
                        <div class="abs z-2 bottom-0 mb-3 w-100 text-center hover-op-0">
                            <h3 class="mb-0 text-dark">Facilities</h3>
                        </div>
                    </div>
                </div>
                @endforeach
                <!-- room end -->
                                        
      
            </div>
        </div>
    </section>
</div>