<section class="relative p-section">
    <div class="container-fluid relative z-2">
        <div class="row g-4">
            <div class="col-lg-6 offset-lg-3 text-center">
                <h2 class="wow  font-section">Rooms</h2>
                <p class="lg:mx-auto px-20 mb-16 text-hl-1 text-left lg:text-center lg:max-w-540 lg:mb-32">With views across lush tropical gardens toward the Indian Ocean, the suites and rooms at AYANA are perfectly positioned to enjoy Bali's famed sunset. Each of AYANA Resorts newly renovated, serene rooms and suites are decorated with rich, deep toned materials and intricate traditional wood carvings that celebrate the artisan culture of Bali.</p>
                <p>For those seeking a more contemporary, looser kind of luxury, explore AYANA’s newest hotel, AYANA Segara.</p>
            </div>
            
            <div class="col-lg-12 mb-2">
                <div class="owl-custom-nav menu-float px-5" data-target="#room-carousel">
                    <a class="btn-next"></a>
                    <a class="btn-prev"></a>                                

                    <div id="room-carousel" class="owl-3-cols owl-carousel owl-theme">
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
                        </div>
                        @endforeach
                        <!-- room end -->
                    </div>
                </div>
            </div>
            <x-mikro.button-load-more  title="SEE ALL ROOMS"/>
        </div>
    </div>
</section>
