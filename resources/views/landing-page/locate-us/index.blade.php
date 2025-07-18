<x-base.landing-page isTransparentNavbar="true">
    <div class="no-bottom no-top" id="content">
        <x-layouts.page-header
            title="{{ __('locate.page_header.title') }}"
            subtitle="{{ __('locate.page_header.subtitle') }}"
        />
        @include('landing-page.locate-us.section-content')
        
    </div>

</x-base.landing-page>
