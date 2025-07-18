<x-base.landing-page isTransparentNavbar="true">
    <div class="no-bottom no-top" id="content">
        <x-layouts.page-header
            title="{{ $experience->title }}"
            subtitle="{{ __('experience_detail.subtitle_1') }}"
            url="{{ $experience->thumbnail?->path_original }}"
        />
        
       

        @include('landing-page.experience.detail.section-content')
        @if(count($others) > 0)
        <section class="relative no-top">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <div class="subtitle id-color mb-3">{{ __('experience_detail.subtitle_2') }}</div>
                        <h3 class="mb-5">{{ __('experience_detail.title_2') }}</h4>
                    </div>
                </div>
                @include('landing-page.experience.detail.section-others')
                
            </div>
        </section>
        @endif

    </div>

</x-base.landing-page>
