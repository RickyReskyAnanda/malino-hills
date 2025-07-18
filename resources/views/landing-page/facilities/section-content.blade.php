<section class="relative">
    <div class="container">
        @foreach($facilities as $key => $facility)
        @if($key % 2 == 0)
        <div class="row g-0 align-items-center justify-content-center">
            <div class="col-lg-5">
                <div class="relative wow fadeInUp" data-wow-delay=".3s">   
                    <div class="shape-mask-1 jarallax">
                        <img src="{{ asset($facility->thumbnail?->path_portrait ?? '' ) }}" class="jarallax-img" alt="{{ $facility->name }}">
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="ms-lg-5 wow scaleIn">
                    <h2 class="wow fadeInUp">{{ $facility->name }}</h2>
                    <p>{{ $facility->description }}</p>
                </div>
            </div>                                                
        </div>
        @else

        <div class="row g-0 align-items-center justify-content-center">
            <div class="col-lg-5">
                <div class="me-lg-5 wow scaleIn">
                    <h2 class="wow fadeInUp">{{ $facility->name }}</h2>
                    <p>{{ $facility->description }}</p>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="relative wow fadeInUp" data-wow-delay=".3s">   
                    <div class="shape-mask-2 jarallax">
                        <img src="{{ asset($facility->thumbnail?->path_portrait ?? '' ) }}" class="jarallax-img" alt="{{ $facility->name }}">
                    </div>
                </div>
            </div>                                                
        </div>
        @endif
        @endforeach
    </div>

</section>