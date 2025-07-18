<x-base.landing-page isTransparentNavbar="true">
    <div class="no-bottom no-top" id="content">
        <x-layouts.page-header
            title="{{ __('experience.page_header.title') }}"
            subtitle="{{ __('experience.page_header.subtitle') }}"
        />
        @include('landing-page.experience.section-content')
        
    </div>

</x-base.landing-page>
