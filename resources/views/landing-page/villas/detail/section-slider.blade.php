<section class="no-top no-bottom mb-5">
    <div class="owl-custom-nav menu-float" data-target="#detail-room-carousel">
        <a class="btn-next"></a>
        <a class="btn-prev"></a>                                

        <div id="detail-room-carousel" class="owl-3-cols-autowidth owl-carousel owl-theme">
            @foreach($villa->slideImages as $v)
                @if($v->path_original && $v->path_original != '')
                    <img src="{{ asset($v->path_original) }}" class="h-600px" alt="">
                @endif
            @endforeach
        </div>
    </div>
</section>