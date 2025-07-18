
<section class="no-bottom">
    <div class="container">
        <div class="row g-4 gx-5">
            <div class="col-lg-10 offset-lg-1">
                <h2>{{ $experience->title ?? '' }}</h2>

                <div class="spacer-single"></div>
               
            </div>
        </div>
    </div>
</section>
@if(count($experience->slideImages) > 0)
<section class="relative no-bottom no-top">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="owl-custom-nav menu-float" data-target="#experience-carousel">
                    <a class="btn-next"></a>
                    <a class="btn-prev"></a>                                

                    <div id="experience-carousel" class="owl-3-cols-autowidth owl-carousel owl-theme">
                        @foreach($experience->slideImages as $img)
                        <img src="{{ asset($img?->path) }}" class="border border-white h-400px" alt="">
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif

<section class="no-top">
    <div class="container">
        <div class="row g-4 gx-5">
            <div class="col-lg-10 offset-lg-1">
                <div class="spacer-single"></div>
                <p><?= $experience->content ?? '' ?></p>
               
            </div>
        </div>
    </div>
</section>