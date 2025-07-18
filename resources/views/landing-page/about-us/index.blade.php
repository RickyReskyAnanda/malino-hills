<x-base.landing-page isTransparentNavbar="true">
    <div class="no-bottom no-top" id="content">
        <x-layouts.page-header
            title="{{ __('about.page_header.title',['appName'=>$appName]) }}"
            subtitle="{{ __('about.page_header.subtitle') }}"
        />

        @include('landing-page.about-us.section-content')
        
    </div>

</x-base.landing-page>
