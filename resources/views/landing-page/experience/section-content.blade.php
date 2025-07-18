<section class="relative">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-lg-3 text-center">
                <div style="margin-bottom: 7rem;">
                <p class="fs-5 text">— {{ __('experience.content.title') }} —</p>
                @foreach(__('experience.content.body') as $key => $value)
                <p class="lead wow ">{{ $value }}</p>
                @endforeach
                </div>

                <h2 class="font-section mb-5">{{ __('experience.content.title2') }}</h2>
            </div>
        </div>
        <div class="row g-4">
            <!-- offer begin -->
             @foreach($experiences as $key => $exp)
            <div class="col-lg-4 col-sm-6">
                <div class="hover relative overflow-hidden text-light wow fadeInUp" data-wow-delay=".2s">
                    <img src="{{ asset($exp->thumbnail?->path_portrait ?? '' ) }}" class="w-100 hover-scale-1-1" alt="{{ $exp->title }}">
                    <div class="abs z-2 bottom-0 mb-3 w-100 padding40">
                        <h3>{{ $exp->title }}</h3>
                        <p class="max-line-4">{{ $exp->short_description }}</p>
                        <a class="btn-main" href="{{ url(request()->segment(1).'/experience/'.$exp->id_experience.'/'.strtolower(str_replace(' ','-',$exp['title']))) }}">{{ __('experience.content.btn_view') }}</a>
                    </div>
                    <div class="overlay-gradient-dark-bottom abs w-100 h-80 bottom-0"></div>
                </div>
            </div>
            @endforeach
            <!-- offer end -->
                                    
            
        </div>
    </div>
</section>