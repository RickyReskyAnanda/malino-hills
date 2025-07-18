<section class="relative">
    <div class="row">
        <div class="col-lg-6 offset-lg-3 text-center">
            <div style="margin-bottom: 7rem;">
                <p class="fs-5 text">— {{ __('gallery.content.title') }} —</p>
                @foreach(__('gallery.content.body') as $key => $value)
                <p class="lead wow ">{{ $value }}</p>
                @endforeach
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row g-4">
            @foreach($gallery as $key => $path)
            <div class="col-xl-3 col-lg-4 col-md-6 text-center">
                <a href="{{ asset($path) }}" class="image-popup d-block hover">
                    <div class="relative overflow-hidden rounded-10">
                        <div class="absolute start-0 w-100 abs-middle fs-36 text-white text-center z-2">
                            <h4 class="mb-0 hover-scale-in-3">{{ __('gallery.content.btn_view') }}</h4>
                        </div> 
                        <div class="absolute w-100 h-100 top-0 bg-dark hover-op-05"></div>
                        <img src="{{ asset($path) }}" class="img-fluid hover-scale-1-2" alt="">
                    </div>
                </a>
            </div>
            @endforeach

        </div>
    </div>
</section>