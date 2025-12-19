<footer class="main">
    {{--    <section class="newsletter p-30 text-white wow fadeIn animated"> --}}
    {{--        <div class="container"> --}}
    {{--            <div class="row align-items-center"> --}}
    {{--                <div class="col-lg-7 mb-md-3 mb-lg-0"> --}}
    {{--                    <div class="row align-items-center"> --}}
    {{--                        <div class="col flex-horizontal-center"> --}}
    {{--                            <img class="icon-email" src="{{ asset('frontend-assets') }}/imgs/theme/icons/icon-email.svg" alt=""> --}}
    {{--                            <h4 class="font-size-20 mb-0 ml-3">Sign up to Newsletter</h4> --}}
    {{--                        </div> --}}
    {{--                        <div class="col my-4 my-md-0 des"> --}}
    {{--                            <h5 class="font-size-15 ml-4 mb-0">...and receive <strong>$25 coupon for first shopping.</strong></h5> --}}
    {{--                        </div> --}}
    {{--                    </div> --}}
    {{--                </div> --}}
    {{--                <div class="col-lg-5"> --}}
    {{--                    <!-- Subscribe Form --> --}}
    {{--                    <form class="form-subcriber d-flex wow fadeIn animated"> --}}
    {{--                        <input type="email" class="form-control bg-white font-small" placeholder="Enter your email"> --}}
    {{--                        <button class="btn bg-dark text-white" type="submit">Subscribe</button> --}}
    {{--                    </form> --}}
    {{--                    <!-- End Subscribe Form --> --}}
    {{--                </div> --}}
    {{--            </div> --}}
    {{--        </div> --}}
    {{--    </section> --}}
    <section class="section-padding footer-mid custom-footer">
        <div class="container pt-15 pb-20">
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="widget-about font-md mb-md-5 mb-lg-0">
                        <div class="logo logo-width-1 wow fadeIn animated">
                            <a href="{{ route('home') }}"><img src="{{ asset($siteSettings->logo) }}" alt="logo"></a>
                        </div>
                        <h5 class="mt-20 mb-10 fw-600 text-grey-4 wow fadeIn animated">Contact</h5>
                        <p class="wow fadeIn animated">
                            <strong>Address: </strong>{{ $siteSettings->address }}
                        </p>
                        <p class="wow fadeIn animated">
                            <strong>Phone: </strong>{{ $siteSettings->phone }}
                        </p>
                        <p class="wow fadeIn animated">
                            <strong>Email: </strong>{{ $siteSettings->email }}
                        </p>
                        <h5 class="mb-10 mt-30 fw-600 text-grey-4 wow fadeIn animated">Follow Us</h5>
                        <div class="d-flex mobile-social-icon wow mb-sm-5 mb-md-0">
                            <a href="{{ $siteSettings->facebook }}"><i class="fa-brands fa-facebook"></i></a>
                            <a href="{{ $siteSettings->twitter }}"><i class="fa-brands fa-x-twitter"></i></a>
                            <a href="{{ $siteSettings->instagram }}"><i class="fa-brands fa-instagram"></i></a>
                            <a href="{{ $siteSettings->youtube }}"><i class="fa-brands fa-youtube"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-3">
                    <h5 class="widget-title wow fadeIn animated">About</h5>
                    <ul class="footer-list wow fadeIn animated mb-sm-5 mb-md-0">
                        <li><a href="{{ route('about') }}">About Us</a></li>
                        <li><a href="{{ route('contact') }}">Contact Us</a></li>
                        <li><a href="{{ route('privacy') }}">Privacy Policy</a></li>
                        <li><a href="{{ route('terms_condition') }}">Terms &amp; Conditions</a></li>
                    </ul>
                </div>
                <div class="col-lg-2  col-md-3">
                    <h5 class="widget-title wow fadeIn animated">Helping Links</h5>
                    <ul class="footer-list wow fadeIn animated">
                        {{-- <li><a href="{{ route('userAuth') }}">Sign In</a></li> --}}
                        <li><a href="{{ route('user.profile') }}">My account</a></li>
                        <li><a href="{{ route('cart') }}">View Cart</a></li>
                        {{-- <li><a href="{{ route('wishlist') }}">My Wishlist</a></li> --}}
                    </ul>
                </div>
                <div class="col-lg-4">
                    {{-- <h5 class="widget-title wow fadeIn animated">Install App</h5> --}}
                    <div class="row">
                        {{-- <div class="col-md-8 col-lg-12">
                            <p class="wow fadeIn animated">From App Store or Google Play</p>
                            <div class="download-app wow fadeIn animated">
                                <a href="{{ $siteSettings->appStoreLink }}" class="hover-up mb-sm-4 mb-lg-0"><img
                                        class="active" src="{{ asset('frontend-assets') }}/imgs/theme/app-store.jpg"
                                        alt=""></a>
                                <a href="{{ $siteSettings->googleStoreLink }}" class="hover-up"><img
                                        src="{{ asset('frontend-assets') }}/imgs/theme/google-play.jpg"
                                        alt=""></a>
                            </div>
                        </div> --}}
                        <div class="col-md-4 col-lg-12 mt-md-3 mt-lg-0">
                            <p class="mb-20 wow fadeIn animated">Secured Payment Gateways</p>
                            <img class="wow fadeIn animated" src="{{ asset($siteSettings->paymentImage) }}"
                                alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="container pb-20 wow fadeIn animated">
        <div class="row">
            <div class="col-12 mb-20">
                <div class="footer-bottom"></div>
            </div>
            <div class="col-lg-6">
                <p class="float-md-left font-sm text-muted mb-0">&copy; 2025, <strong
                        class="text-brand">{{ $siteSettings->title }}</strong> </p>
            </div>
            <div class="col-lg-6">
                <p class="text-lg-end text-start font-sm text-muted mb-0">
                    {{-- Designed by <a href="http://marziul.com/" target="_blank">Marziul.com</a>. --}} All rights reserved.
                </p>
            </div>
        </div>
    </div>
</footer>


<div class="footer-mobile__common md:hidden flex justify-between bg-white">

    <div class="footer__common-item">
        <a href="{{ route('home') }}">
            <svg class="w-[24px]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 22 17">
                <path fill="currentColor"
                    d="M20.9141 7.93359c.1406.11719.2109.26953.2109.45703 0 .14063-.0469.25782-.1406.35157l-.3516.42187c-.1172.14063-.2578.21094-.4219.21094-.1406 0-.2578-.04688-.3515-.14062l-.9844-.77344V15c0 .3047-.1172.5625-.3516.7734-.2109.2344-.4687.3516-.7734.3516h-4.5c-.3047 0-.5742-.1172-.8086-.3516-.2109-.2109-.3164-.4687-.3164-.7734v-3.6562h-2.25V15c0 .3047-.11719.5625-.35156.7734-.21094.2344-.46875.3516-.77344.3516h-4.5c-.30469 0-.57422-.1172-.80859-.3516-.21094-.2109-.31641-.4687-.31641-.7734V8.46094l-.94922.77344c-.11719.09374-.24609.14062-.38672.14062-.16406 0-.30468-.07031-.42187-.21094l-.35157-.42187C.921875 8.625.875 8.50781.875 8.39062c0-.1875.070312-.33984.21094-.45703L9.73438.832031C10.1094.527344 10.5312.375 11 .375s.8906.152344 1.2656.457031l8.6485 7.101559zm-3.7266 6.50391V7.05469L11 1.99219l-6.1875 5.0625v7.38281h3.375v-3.6563c0-.3046.10547-.5624.31641-.7734.23437-.23436.5039-.35155.80859-.35155h3.375c.3047 0 .5625.11719.7734.35155.2344.211.3516.4688.3516.7734v3.6563h3.375z" />
            </svg>
        </a>
    </div>


    <div class="footer__common-item">
        <a href="{{ route('shop') }}">
            <svg class="w-[20px] h-[20px]" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                <path
                    d="M416 32H32A32 32 0 0 0 0 64v384a32 32 0 0 0 32 32h384a32 32 0 0 0 32-32V64a32 32 0 0 0-32-32zm-16 48v152H248V80zm-200 0v152H48V80zM48 432V280h152v152zm200 0V280h152v152z" />
            </svg>
        </a>
    </div>


    <div class="footer__common-item">
        <a href="javascript:void(0)"
            class="relative py-2 px-2 cursor-pointer cart-icon sf-cart-icon m-cart-icon-bubble openCartBtn">
            <span class="sf__tooltip-item block sf__tooltip-bottom sf__tooltip-style-2">
                <svg class="w-[20px] h-[20px]" fill="currentColor" stroke="currentColor"
                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                    <path
                        d="M352 128C352 57.42 294.579 0 224 0 153.42 0 96 57.42 96 128H0v304c0 44.183 35.817 80 80 80h288c44.183 0 80-35.817 80-80V128h-96zM224 48c44.112 0 80 35.888 80 80H144c0-44.112 35.888-80 80-80zm176 384c0 17.645-14.355 32-32 32H80c-17.645 0-32-14.355-32-32V176h48v40c0 13.255 10.745 24 24 24s24-10.745 24-24v-40h160v40c0 13.255 10.745 24 24 24s24-10.745 24-24v-40h48v256z" />
                </svg>
                <span class="sf__tooltip-content">Cart</span>
            </span>
            <span class="m-cart-count-bubble sf-cart-count font-medium {{ $cartCount > 0 ? '' : 'hidden' }}">
                {{ $cartCount }}
            </span>
        </a>

    </div>



    <m-search-popup class="footer__common-item" data-open-search-popup>
        <button type="button" data-bs-toggle="modal" data-bs-target="#searchModal">
            <span class="sf__search-footer-common">
                <svg class="w-[20px] h-[20px]" fill="currentColor" stroke="currentColor"
                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                    <path
                        d="M508.5 468.9L387.1 347.5c-2.3-2.3-5.3-3.5-8.5-3.5h-13.2c31.5-36.5 50.6-84 50.6-136C416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c52 0 99.5-19.1 136-50.6v13.2c0 3.2 1.3 6.2 3.5 8.5l121.4 121.4c4.7 4.7 12.3 4.7 17 0l22.6-22.6c4.7-4.7 4.7-12.3 0-17zM208 368c-88.4 0-160-71.6-160-160S119.6 48 208 48s160 71.6 160 160-71.6 160-160 160z" />
                </svg>
            </span>
        </button>
    </m-search-popup>

</div>

<a href="https://wa.me/{{ $siteSettings->phone }}" target="_blank" class="whatsapp-wave">
    <i class="bi bi-whatsapp"></i>
</a>