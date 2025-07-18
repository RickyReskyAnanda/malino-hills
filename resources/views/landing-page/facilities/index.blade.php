<x-base.landing-page isTransparentNavbar="true">
    <div class="no-bottom no-top" id="content">
        <x-layouts.page-header
            title="{{ __('facility.page_header.title') }}"
            subtitle="{{ __('facility.page_header.subtitle') }}"
        />
        @include('landing-page.facilities.section-content')
        
    </div>

</x-base.landing-page>
