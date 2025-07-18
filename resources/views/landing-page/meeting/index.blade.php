<x-base.landing-page isTransparentNavbar="true">
    <div class="no-bottom no-top" id="content">
       
        <x-layouts.page-header
            title="{{ __('meeting.page_header.title') }}"
            subtitle="{{ __('meeting.page_header.subtitle') }}"
        />
        @include('landing-page.meeting.section-content')
        
    </div>

</x-base.landing-page>
