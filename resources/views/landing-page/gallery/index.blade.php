<x-base.landing-page isTransparentNavbar="true">
    <div class="no-bottom no-top" id="content">
        <x-layouts.page-header
            title="{{ __('gallery.page_header.title') }}"
            subtitle="{{ __('gallery.page_header.subtitle') }}"
        />
        @include('landing-page.gallery.section-content')
        
    </div>

</x-base.landing-page>
