<x-base.landing-page isTransparentNavbar="true">
    
<div class="no-bottom no-top" id="content">

    <div id="top"></div>

    @include('landing-page.home.section-intro')
    @include('landing-page.home.section-slide-images')

    @include('landing-page.home.section-villas')
    @include('landing-page.home.section-experience')
    @include('landing-page.home.section-slide-images-facility')
    @include('landing-page.home.section-video')
<!-- 
    <section class="no-top no-bottom section-dark" aria-label="section">
        <a class="d-block hover popup-youtube" href="{{ asset('video_slide.mp4') }}">
            <div class="relative overflow-hidden">
                <div class="absolute start-0 w-100 abs-middle fs-36 text-white text-center z-2">
                    <div class="player wow scaleIn"><span>Play</span></div>
                </div> 
                <div class="absolute w-100 h-100 top-0 bg-dark hover-op-05"></div>
                <img src="{{ asset('assets/images/video-background/bg-1.png') }}" class="img-fluid w-100" alt="">
            </div>
        </a>
    </section> -->
    

</div>

</x-base.landing-page>
<script>
    let startDate = moment("{{ date('Y-m-d') }}", "YYYY-MM-DD").format("DD MMM YYYY"); // Default ke hari ini jika tidak ada start_date
        let endDate = moment("{{ date('Y-m-d',strtotime('+ 1 day')) }}", "YYYY-MM-DD").format("DD MMM YYYY");; // Default ke hari ini jika tidak ada end_date

    $('#date-picker').daterangepicker({
                 "showISOWeekNumbers": true,
                 "timePicker": false,
                 "autoUpdateInput": true,
                 minDate: moment(),
                 "locale": {
                     "format": "DD MMM YYYY",
                     "separator": " - ",
                     "fromLabel": "From",
                     "toLabel": "To",
                     "customRangeLabel": "Custom",
                     "weekLabel": "W",
                     "daysOfWeek": [
                         "Su",
                         "Mo",
                         "Tu",
                         "We",
                         "Th",
                         "Fr",
                         "Sa"
                     ],
                     "monthNames": [
                         "January",
                         "February",
                         "March",
                         "April",
                         "May",
                         "June",
                         "July",
                         "August",
                         "September",
                         "October",
                         "November",
                         "December"
                     ],
                     "firstDay": 1
                 },
                 "linkedCalendars": true,
                 "showCustomRangeLabel": false,
                 startDate: startDate,
                    endDate: endDate,
                    autoApply: true,
                 "opens": "right"
             });

        // Cari elemen yang relevan dan tambahkan atribut
   
</script>