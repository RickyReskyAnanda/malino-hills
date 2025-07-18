<section class="">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-lg-3 text-center">
            <div style="margin-bottom: 7rem;">
                <p class="fs-5 text">— {{ __('locate.content.title') }} —</p>
                @foreach(__('locate.content.body') as $key => $value)
                <p class="lead wow ">{{ $value }}</p>
                @endforeach
            </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row g-4 ">
            <div class="col-lg-6">
                <div class="ps-lg-3 mb-5">
                    <div class="subtitle id-color wow mb-3" data-wow-delay=".2s">{{ __('locate.content_2.title') }}</div>
                    <p class="mb-1 wow" data-wow-delay=".6s">{{ $landingPageData['address'] }}</p>
                    <p class="mb-1 wow" data-wow-delay=".6s">{{ __('locate.content_2.phone') }}: +{{ $landingPageData['whatsapp'] }}</p>
                    <p class="mb-0 wow" data-wow-delay=".6s">{{ __('locate.content_2.email') }}: {{ $landingPageData['email'] }}</p>
                </div>
                <div class="ps-lg-3">
                    <div class="subtitle id-color wow mb-3" data-wow-delay=".2s">{{ __('locate.content_3.title') }}</div>
                    <p class="mb-0 wow" data-wow-delay=".6s">
                        <ul>
                            @for($i = 1; $i<=5;$i++)
                            @if(!is_null($landingPageData['position_'.$i]))
                            <li>{{ $landingPageData['position_'.$i] }}</li>
                            @endif
                            @endfor
                        </ul>
                    </p>
                </div>
            </div>
            <div class="col-lg-6">
                <a href="https://www.google.com/maps?q={{ $landingPageData['maps_lattitude'] }},{{ $landingPageData['maps_longitude'] }}({{ $appName }})" target="_blank">
                    <img src="{{  asset('assets/locate-us/1.png') }}"  style="height: 400px; width: 100%;    -webkit-border-radius: 18px !important;" class="rounded img-fluid">
                </div>
            
            </div>
        </div>
    
    </div>
</section>