<x-base.landing-page isTransparentNavbar="true">
    <div class="no-bottom no-top" id="content">
        @include('landing-page.villas.detail.section-slider')
        @include('landing-page.villas.detail.section-content')
        @include('landing-page.villas.detail.section-rooms')
       
    </div>

</x-base.landing-page>

<script>
$(document).ready(function() {

    let startDate = moment("{{ $startDate }}", "YYYY-MM-DD").format("DD MMM YYYY"); // Default ke hari ini jika tidak ada start_date
    let endDate = moment("{{ $endDate }}", "YYYY-MM-DD").format("DD MMM YYYY");
    $('#date-picker').daterangepicker({
                 maxSpan: {
                    "months": 2  // Batas maksimum 2 bulan
                },
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
                },
                "linkedCalendars": true,
                "showCustomRangeLabel": false,
                startDate: startDate,
                endDate: endDate,
                autoApply: true,
                "opens": "right",
             });


    var isBookBtnEnable = false;
    function btnDisabled(){
        $('#btn-booking').removeClass("pointer");
        $('#btn-booking').removeClass("bg-success");
        $('#btn-booking').addClass("bg-secondary");
        isBookBtnEnable = false;
        $('#btn-booking').text("Not Available");

        
    }

    function btnEnabled(){
        $('#btn-booking').removeClass("bg-secondary");
        $('#btn-booking').addClass("pointer");
        $('#btn-booking').addClass("bg-success");
        $('#btn-booking').text("Book Now");
        isBookBtnEnable = true;
    }
    btnDisabled();
    checkRoomAvailable();
    function checkRoomAvailable(){
        var guests = $('#ed-guest').val();
        var villas = $('#ed-villa').val();
        var dates = $('#date-picker').val();

        // Kirim data melalui AJAX
        $('#message-checking').html("{{ __('villa_detail.label_checking') }}...");
        
        btnDisabled()
        $.ajax({
            url: '{{ url(request()->segment(1)."/check-availability/checking") }}', // URL yang dituju
            method: 'GET', // Metode pengiriman data
            data: {
                villa_id: "{{ $villa->id_villa }}",
                guests,
                villas,
                dates
            },
            success: function(res) {
                if(res.code == 200){

                    @if(request()->segment(1) == 'id')
                    $('#message-checking').html("<i class='fa fa-check'></i>&nbsp; Tersedia "+res.data.available+ " Villa");
                    @else
                    $('#message-checking').html('<i class="fa fa-check"></i>&nbsp;'+res.message);
                    @endif

                    btnEnabled();
                }
                else if(res.code == 400) {
                    $('#message-checking').html(res.message);
                    
                    btnDisabled();
                }
                
            },
            error: function(xhr, status, error) {
                $('#responseMessage').html('<p>Terjadi kesalahan: ' + error + '</p>');
            }
        });
    }

    $('#date-picker,#ed-guest,#ed-villa').change(function() {
        checkRoomAvailable()
    });



    $('#btn-booking').click(function() {
        if(!isBookBtnEnable) return false
        // Ambil data dari input
        var guests = $('#ed-guest').val();
        var villas = $('#ed-villa').val();
        var dates = $('#date-picker').val();
        
        // Format pesan WhatsApp
        var message = `Halo, saya ingin booking {{ $villa->name }}. Berikut data saya:\n\n` +
                        `Guest: ${guests} Orang\n` +
                        `Jumlah Villa: ${villas}\n` +
                        `Tanggal: ${dates}\n\n` +
                        `Apakah villanya tersedia ?`;

        // Encode URI untuk link wa.me
        var whatsappLink = 'https://wa.me/{{ $landingPageData["whatsapp"] }}?text=' + encodeURIComponent(message);
        
        // Redirect ke WhatsApp
        window.open(whatsappLink, '_blank');
    });
});
</script>