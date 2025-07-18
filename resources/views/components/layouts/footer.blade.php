<!-- footer begin -->
<footer class="text-light section-dark">
    <div class="container">
        <div class="row g-4 align-items-center">
            <div class="col-md-12">
                <div class="d-lg-flex align-items-center justify-content-between text-center">
                    <div class="col text-center mb-5">
                        <h3 class="fs-20">{{ __('footer.address') }}</h3>
                        <span translate="no">{{ $landingPageData['address'] }}</span>
                    </div>
                    <div class="col-md-6 text-center mb-5" translate="no">
                        <img src="{{ asset('assets/logo/logo-navbar.png') }}" class="w-300px" alt="Malino Hills"><br>
                        <div class="social-icons mb-sm-30 mt-4">
                            <a href="{{ $landingPageData['facebook'] }}"><i class="fa-brands fa-facebook-f"></i></a>
                            <a href="{{ $landingPageData['instagram'] }}"><i class="fa-brands fa-instagram"></i></a>
                            <a href="{{ $landingPageData['tiktok'] }}"><i class="fa-brands fa-tiktok"></i></a>
                            <a href="{{ $landingPageData['youtube'] }}"><i class="fa-brands fa-youtube"></i></a>
                        </div>

                    </div>
                    <div class="col text-center mb-5" translate="no">
                        <h3 class="fs-20">{{ __('footer.contact_us') }}</h3>
                        <a href="https://wa.me/{{ $landingPageData['whatsapp'] }}?text=Halo admin, Saya ingin bertanya"><i class="fa-brands fa-whatsapp"></i> +{{ $landingPageData['whatsapp'] }}</a><br>
                        <a href="mailto:{{ $landingPageData['email'] }}"><i class="fa fa-envelope"></i> {{ $landingPageData['email'] }}</a><br>
                    </div>
                </div>
            </div>                    
        </div>
    </div>
    <div class="subfooter">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    Copyright 2024 - Malino Hills
                </div>
            </div>
        </div>
    </div>
</footer>