
<!DOCTYPE html>
<html lang="zxx">


<head>
    <title>Malino Hills - Resort & Cafe</title>
    <link rel="icon" href="{{ asset('assets/favicon.ico') }}" type="image/x-icon" sizes="16x16">
    <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
    <meta content="width=device-width, initial-scale=1.0" name="viewport" >
    <meta content="Malino Hills - Resort & Cafe" name="description" >
    <meta content="" name="keywords" >
    <meta content="" name="author" >
    <!-- CSS Files
    ================================================== -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" id="bootstrap">
    <link href="{{ asset('assets/css/plugins.css') }}" rel="stylesheet" type="text/css" >
    <link href="{{ asset('assets/css/swiper.css') }}" rel="stylesheet" type="text/css" >
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet" type="text/css" >
    <link href="{{ asset('assets/css/coloring.css') }}" rel="stylesheet" type="text/css" >
    <!-- color scheme -->
    <link id="colors" href="{{ asset('assets/css/colors/scheme-02.css') }}" rel="stylesheet" type="text/css" >

</head>

<body>
    <div id="wrapper">
        <a href="#" id="back-to-top"></a>
        <a translate="no" href="https://wa.me/{{ $landingPageData['whatsapp'] }}?text=Halo admin, Saya ingin bertanya" id="wa-floating-button" class="rounded-pill d-flex text-white align-items-center justify-content-center"><span><i class="fa-brands fa-whatsapp"></i></span></a>
        <!-- page preloader begin -->
        <!-- page preloader close -->
        <!-- <div id="de-loader"></div> -->
        <!-- header begin -->
        <x-layouts.navbar isTransparent='{{ $isTransparentNavbar }}'/>
        <!-- header close -->
        <!-- content begin -->
        {{ $slot }}
        <!-- content close -->
        
        <x-layouts.footer />
        <!-- footer close -->
    </div>
    
    <script src="{{ asset('assets/js/plugins.js') }}"></script>
    <script src="{{ asset('assets/js/designesia.js') }}"></script>
    <script>
        window.onload = function() {
            window.scrollTo(0, 0);
        };
    </script>
</body>


</html>