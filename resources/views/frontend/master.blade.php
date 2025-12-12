<!doctype html>
<html class="" lang="en">

<head>
    <meta name="google-site-verification" content="B6SnImGpUHvzJzO9zud5CxbgoPsVGwWyqgEUPELjzCE" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=0">
    <meta name="theme-color" content="#fc8934">
    <link rel="canonical" href="{{ route('home') }}">
    <link rel="shortcut icon" href="{{ asset($siteSettings->favicon) }}" type="image/png">
    <title class="index">{{ $siteSettings->title }} | @yield('title')</title>
    <meta property="og:site_name" content="{{ $siteSettings->title }}">
    <meta property="og:url" content="{{ route('home') }}">
    <meta property="og:title" content="{{ $siteSettings->title }}">
    <meta property="og:type" content="website">
    <meta property="og:description" content="{{ $siteSettings->tagline }}">
    <meta property="og:image" content="{{ asset($siteSettings->favicon) }}">
    <meta property="og:image:secure_url" content="{{ asset($siteSettings->favicon) }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="628">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $siteSettings->title }}">
    <meta name="twitter:description" content="{{ $siteSettings->tagline }}">

    <link href="{{ asset('frontend-assets') }}/cdn/shop/t/2/assets/theme6d28.css?v=169926333737883166031707765659" rel="stylesheet" type="text/css"
        media="all" />
    <link href="{{ asset('frontend-assets') }}/cdn/shop/t/2/assets/chunk18f2.css?v=148419031456207892391707765653" rel="stylesheet" type="text/css"
        media="all" />
    <link rel="stylesheet" href="{{ asset('frontend-assets') }}/css/maind134.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css"
        integrity="sha384-b6lVK+yci+bfDmaY1u0zE8YYJt0TZxLEAFyYSLHId4xoVvsrQu3INevFKo+Xir8e" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('frontend-assets') }}/css/owl.carousel.min.css">
    <link rel="stylesheet" href="{{ asset('frontend-assets') }}/css/ion.rangeSlider.min.css">
    <link rel="stylesheet" href="https://unpkg.com/swiper@9/swiper-bundle.min.css" />
    <meta name="google-site-verification" content="plqddMKbyZUgQZHyoVAbUAqflg5TZp9oW2oDfBc-UgE">
    <meta id="shopify-digital-wallet" name="shopify-digital-wallet" content="/68513399006/digital_wallets/dialog">

    <link rel="stylesheet" href="../cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="{{ asset('frontend-assets') }}/css/extra.css">
    <link rel="stylesheet" href="{{ asset('frontend-assets') }}/css/style.css">
</head>

<body>
    
    @include('frontend.include.header')

    
    @yield('content')
   

    @include('frontend.include.footer')

    <m-cart-drawer class="m-cart-drawer m-cart--empty">
        <div id="MinimogCartDrawer" class="h-full scd__wrapper">
            <div class="m-cart-drawer--inner scd__content h-full">
            <button class="m-cart-drawer--close-icon">
                <svg class="w-[24px] h-[24px]" fill="currentColor" stroke="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                <path d="M193.94 256L296.5 153.44l21.15-21.15c3.12-3.12 3.12-8.19 0-11.31l-22.63-22.63c-3.12-3.12-8.19-3.12-11.31 0L160 222.06 36.29 98.34c-3.12-3.12-8.19-3.12-11.31 0L2.34 120.97c-3.12 3.12-3.12 8.19 0 11.31L126.06 256 2.34 379.71c-3.12 3.12-3.12 8.19 0 11.31l22.63 22.63c3.12 3.12 8.19 3.12 11.31 0L160 289.94 262.56 392.5l21.15 21.15c3.12 3.12 8.19 3.12 11.31 0l22.63-22.63c3.12-3.12 3.12-8.19 0-11.31L193.94 256z"/>
                </svg>
            </button>
            <div class="flex flex-col h-full">
                <div class="m-cart-drawer--header scd__header  mx-6 py-4 md:pt-6">
                <h3 class="text-2xl font-medium">Shopping Cart</h3>
                
                    <div class="foxkit-cart-countdown-hook foxkit-cart-countdown-hook-drawer"></div>
                
                <div class="foxkit-cart-goal-hook"></div>
                </div>
                <m-cart-drawer-items data-minimog-cart-items  class="m-cart-drawer--body scd__body sf__custom_scroll overscroll-contain px-6 pb-4 flex flex-col flex-1">
                <form action="https://ghorerbazar.com/cart" method="post" id="cart-drawer-form" class="checkout-form w-full" novalidate><div class="scd-empty-msg">
                    Your cart is currently empty.
                    </div></form>
                </m-cart-drawer-items>
                <div class="m-cart-drawer--footer scd__footer py-4 px-6" id="MinimogCartDrawerFooter">
                
        <m-cart-addons>
            <div class="m-cart--addons-action scd__footer-actions">
            
                <button data-open="note" class="m-cart-addon--trigger-button sf__tooltip-item sf__tooltip-top">
                <svg class="w-[20px] h-[20px]" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 19 19"><path fill="currentColor" d="M17.3672 2.21875c.4453.44531.668.98437.668 1.61719 0 .60937-.2227 1.13672-.668 1.58203L4.99219 17.793l-4.007815.457H.878906c-.257812 0-.46875-.0938-.632812-.2812-.164063-.1876-.234375-.4102-.210938-.668l.457032-4.0078L12.8672.917969C13.3125.472656 13.8398.25 14.4492.25c.6328 0 1.1719.222656 1.6172.667969l1.3008 1.300781zM4.46484 16.7383l9.28126-9.28127-2.918-2.91797-9.28122 9.28124-.35157 3.2695 3.26953-.3515zM16.5938 4.60938c.2109-.21094.3164-.46875.3164-.77344 0-.32813-.1055-.59766-.3164-.8086l-1.336-1.33593c-.2109-.21094-.4805-.31641-.8086-.31641-.3047 0-.5625.10547-.7734.31641l-2.0391 2.03906 2.918 2.91797 2.0391-2.03906z"/></svg>
                <span>Note</span>
                <span class="sf__tooltip-content text-[12px]">Add note for seller</span>
                </button>
            
            
            
                <button data-open="coupon" class="m-cart-addon--trigger-button sf__tooltip-item sf__tooltip-top">
                <span data-discount-noti class="hidden absolute border-2 border-white shadow-md rounded-full w-4 h-4 -top-2 right-1/2 translate-x-5 bg-[#334bfa]"></span>
                <svg class="w-[22px] h-[22px]" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 21 14"><path fill="currentColor" d="M15.2812 3.875c.2344 0 .4336.08203.5977.24609.1641.16407.2461.36328.2461.59766v5.0625c0 .23435-.082.43355-.2461.59765-.1641.1641-.3633.2461-.5977.2461H5.71875c-.23437 0-.43359-.082-.59766-.2461-.16406-.1641-.24609-.3633-.24609-.59765v-5.0625c0-.23438.08203-.43359.24609-.59766.16407-.16406.36329-.24609.59766-.24609h9.56245zM15 9.5V5H6v4.5h9zm4.5-3.375c-.3047 0-.5742.11719-.8086.35156-.2109.21094-.3164.46875-.3164.77344s.1055.57422.3164.80859c.2344.21094.5039.31641.8086.31641h1.125v3.9375c0 .4687-.1641.8672-.4922 1.1953-.3281.3281-.7266.4922-1.1953.4922H2.0625c-.46875 0-.86719-.1641-1.195312-.4922C.539062 13.1797.375 12.7812.375 12.3125V8.375H1.5c.30469 0 .5625-.10547.77344-.31641.23437-.23437.35156-.5039.35156-.80859s-.11719-.5625-.35156-.77344C2.0625 6.24219 1.80469 6.125 1.5 6.125H.375V2.1875c0-.46875.164062-.86719.492188-1.195312C1.19531.664063 1.59375.5 2.0625.5h16.875c.4687 0 .8672.164063 1.1953.492188.3281.328122.4922.726562.4922 1.195312V6.125H19.5zm0 3.375c-.6094 0-1.1367-.22266-1.582-.66797-.4453-.44531-.668-.97265-.668-1.58203s.2227-1.13672.668-1.58203C18.3633 5.22266 18.8906 5 19.5 5V2.1875c0-.16406-.0586-.29297-.1758-.38672-.0937-.11719-.2226-.17578-.3867-.17578H2.0625c-.16406 0-.30469.05859-.42188.17578-.09374.09375-.14062.22266-.14062.38672V5c.60938 0 1.13672.22266 1.58203.66797.44531.44531.66797.97265.66797 1.58203s-.22266 1.13672-.66797 1.58203C2.63672 9.27734 2.10938 9.5 1.5 9.5v2.8125c0 .1641.04688.3047.14062.4219.11719.0937.25782.1406.42188.1406h16.875c.1641 0 .293-.0469.3867-.1406.1172-.1172.1758-.2578.1758-.4219V9.5z"/></svg>
                <span>Coupon</span>
                <span class="sf__tooltip-content text-[12px]">Add a discount code</span>
                </button>
            
            </div>
            
            <div class="m-cart-addon--content scd__addon" id="m-addons-note">
                <div class="scd__addon-title font-medium">
                <svg class="w-[20px] h-[20px]" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 19 19"><path fill="currentColor" d="M17.3672 2.21875c.4453.44531.668.98437.668 1.61719 0 .60937-.2227 1.13672-.668 1.58203L4.99219 17.793l-4.007815.457H.878906c-.257812 0-.46875-.0938-.632812-.2812-.164063-.1876-.234375-.4102-.210938-.668l.457032-4.0078L12.8672.917969C13.3125.472656 13.8398.25 14.4492.25c.6328 0 1.1719.222656 1.6172.667969l1.3008 1.300781zM4.46484 16.7383l9.28126-9.28127-2.918-2.91797-9.28122 9.28124-.35157 3.2695 3.26953-.3515zM16.5938 4.60938c.2109-.21094.3164-.46875.3164-.77344 0-.32813-.1055-.59766-.3164-.8086l-1.336-1.33593c-.2109-.21094-.4805-.31641-.8086-.31641-.3047 0-.5625.10547-.7734.31641l-2.0391 2.03906 2.918 2.91797 2.0391-2.03906z"/></svg>
                <span>Add note for seller</span>
                </div>
                <div class="scd__addon-content">
                <textarea name="note" class="form-control" form="cart-drawer-form" rows="3" placeholder="Special instructions for seller"></textarea>
                </div>
                <div class="m-cart-addon--actions scd__addon-actions flex flex-col">
                <button class="sf__btn sf__btn-primary m-cart-addon--save-button btn-save" data-action="note">Save</button>
                <button class="sf__btn sf__btn-plain m-cart-addon--close-button btn-cancel" data-action="note">Cancel</button>
                </div>
            </div>
            
            
            
            <div class="m-cart-addon--content scd__addon" id="m-addons-coupon">
                <div class="scd__addon-title font-medium">
                <svg class="w-[20px]" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 21 14"><path fill="currentColor" d="M15.2812 3.875c.2344 0 .4336.08203.5977.24609.1641.16407.2461.36328.2461.59766v5.0625c0 .23435-.082.43355-.2461.59765-.1641.1641-.3633.2461-.5977.2461H5.71875c-.23437 0-.43359-.082-.59766-.2461-.16406-.1641-.24609-.3633-.24609-.59765v-5.0625c0-.23438.08203-.43359.24609-.59766.16407-.16406.36329-.24609.59766-.24609h9.56245zM15 9.5V5H6v4.5h9zm4.5-3.375c-.3047 0-.5742.11719-.8086.35156-.2109.21094-.3164.46875-.3164.77344s.1055.57422.3164.80859c.2344.21094.5039.31641.8086.31641h1.125v3.9375c0 .4687-.1641.8672-.4922 1.1953-.3281.3281-.7266.4922-1.1953.4922H2.0625c-.46875 0-.86719-.1641-1.195312-.4922C.539062 13.1797.375 12.7812.375 12.3125V8.375H1.5c.30469 0 .5625-.10547.77344-.31641.23437-.23437.35156-.5039.35156-.80859s-.11719-.5625-.35156-.77344C2.0625 6.24219 1.80469 6.125 1.5 6.125H.375V2.1875c0-.46875.164062-.86719.492188-1.195312C1.19531.664063 1.59375.5 2.0625.5h16.875c.4687 0 .8672.164063 1.1953.492188.3281.328122.4922.726562.4922 1.195312V6.125H19.5zm0 3.375c-.6094 0-1.1367-.22266-1.582-.66797-.4453-.44531-.668-.97265-.668-1.58203s.2227-1.13672.668-1.58203C18.3633 5.22266 18.8906 5 19.5 5V2.1875c0-.16406-.0586-.29297-.1758-.38672-.0937-.11719-.2226-.17578-.3867-.17578H2.0625c-.16406 0-.30469.05859-.42188.17578-.09374.09375-.14062.22266-.14062.38672V5c.60938 0 1.13672.22266 1.58203.66797.44531.44531.66797.97265.66797 1.58203s-.22266 1.13672-.66797 1.58203C2.63672 9.27734 2.10938 9.5 1.5 9.5v2.8125c0 .1641.04688.3047.14062.4219.11719.0937.25782.1406.42188.1406h16.875c.1641 0 .293-.0469.3867-.1406.1172-.1172.1758-.2578.1758-.4219V9.5z"/></svg>
                <span>Add a discount code</span>
                </div>
                <div class="scd__addon-content">
                <div id="coupon-messages" class="mb-4">
                    <p className="my-4"></p>
                </div>
                <input
                    form="cart-drawer-form"
                    placeholder="Enter discount code here"
                    type="text"
                    name="discount"
                    class="scd__discount_code form-control"
                />
                </div>
                <div class="m-cart-addon--actions scd__addon-actions flex flex-col">
                <button class="sf__btn sf__btn-primary m-cart-addon--save-button btn-save" data-action="coupon">Save</button>
                <button class="sf__btn sf__btn-plain m-cart-addon--close-button btn-cancel" data-action="coupon">Cancel</button>
                </div>
            </div>
            
        </m-cart-addons>


                <div class="scd__gift-wrapping" data-minimog-gift-wrapping></div>

                <div class="m-cart--summary scd__summary mb-4 pt-4">
                    <div data-foxkit-cart-summary></div>
                    <div data-minimog-cart-discounts></div>
                    
                    <div class="m-cart--totals scd__subtotal flex justify-between" data-cart-subtotal>
                    <span class="m-cart--subtotal font-medium">Subtotal</span>
                    <span class="m-cart--subtotal-value scd__subtotal-price font-medium sf-currency" data-cart-subtotal-price>
                        
                        Tk 0.00
                        
                    </span>
                    </div>
                    
                </div>
                <div class="cart-drawer__checkout">
                    
                    <p>Your cart is empty</p>
                    
                </div>
                <div class="flex flex-col items-center">
                    
                    
                    <button type="submit" form="cart-drawer-form" class="sf__btn sf__btn-primary w-full scd__checkout relative" name="checkout">
                    <span>Check out</span>
                    <svg class="animate-spin w-[18px] h-[18px]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    </button><a class="underline mt-2" href="cart.html">
                    View Cart
                    </a>
                </div>
                
                </div>
                <div class="m-cart--overlay"></div>
            </div>
            </div>
        </div>
    </m-cart-drawer>


    <script src="{{ asset('frontend-assets') }}/js/vendor/modernizr-3.6.0.min.js"></script>
    <script src="{{ asset('frontend-assets') }}/js/vendor/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('frontend-assets') }}/js/vendor/jquery-migrate-3.3.0.min.js"></script>
    <script src="{{ asset('frontend-assets') }}/js/vendor/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('frontend-assets') }}/js/plugins/slick.js"></script>
    <script src="{{ asset('frontend-assets') }}/js/plugins/jquery.syotimer.min.js"></script>
    <script src="{{ asset('frontend-assets') }}/js/plugins/wow.js"></script>
    <script src="{{ asset('frontend-assets') }}/js/plugins/jquery-ui.js"></script>
    <script src="{{ asset('frontend-assets') }}/js/plugins/perfect-scrollbar.js"></script>
    <script src="{{ asset('frontend-assets') }}/js/plugins/magnific-popup.js"></script>
    <script src="{{ asset('frontend-assets') }}/js/plugins/select2.min.js"></script>
    <script src="{{ asset('frontend-assets') }}/js/plugins/waypoints.js"></script>
    <script src="{{ asset('frontend-assets') }}/js/plugins/counterup.js"></script>
    <script src="{{ asset('frontend-assets') }}/js/plugins/jquery.countdown.min.js"></script>
    <script src="{{ asset('frontend-assets') }}/js/plugins/images-loaded.js"></script>
    <script src="{{ asset('frontend-assets') }}/js/plugins/isotope.js"></script>
    <script src="{{ asset('frontend-assets') }}/js/plugins/scrollup.js"></script>
    <script src="{{ asset('frontend-assets') }}/js/plugins/jquery.vticker-min.js"></script>
    <script src="{{ asset('frontend-assets') }}/js/plugins/jquery.theia.sticky.js"></script>
    <script src="{{ asset('frontend-assets') }}/js/plugins/jquery.elevatezoom.js"></script>
    <!-- Template  JS -->
    <script src="{{ asset('frontend-assets') }}/js/maind134.js?v=3.4"></script>
    <script src="{{ asset('frontend-assets') }}/js/shopd134.js?v=3.4"></script>
    <script src="{{ asset('frontend-assets') }}/js/owl.carousel.min.js"></script>
    <script src="{{ asset('frontend-assets') }}/js/ion.rangeSlider.min.js"></script>
    <script src="https://unpkg.com/swiper@9/swiper-bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
    const hamburger = document.getElementById('mobileMenuToggle');
    const drawer = document.querySelector('.new-mobile-drawer');
    const overlay = document.querySelector('.mobile-overlay');

    hamburger.addEventListener('click', function () {

        // Toggle hamburger animation
        this.classList.toggle('active');

        // Toggle drawer
        drawer.classList.toggle('open');
        

        // Toggle overlay
        overlay.classList.toggle('show');
        overlay.classList.toggle('d-none');

        // Disable or enable scroll on <html> tag
        if (drawer.classList.contains('open')) {
            document.documentElement.style.overflow = 'hidden';
        } else {
            document.documentElement.style.overflow = '';
        }
    });

    // Close when clicking overlay
    overlay.addEventListener('click', function () {

        hamburger.classList.remove('active');
        drawer.classList.remove('open');
        overlay.classList.remove('show');

        
        overlay.classList.add('d-none');

        // Re-enable scroll on <html>
        document.documentElement.style.overflow = '';
    });

    // Optional: Close when clicking outside drawer (not overlay area)
    document.addEventListener('click', function (e) {
        if (
            drawer.classList.contains('open') &&
            !drawer.contains(e.target) &&
            !hamburger.contains(e.target)
        ) {
            hamburger.classList.remove('active');
            drawer.classList.remove('open');
            overlay.classList.remove('show');
            
            overlay.classList.add('d-none');
            document.documentElement.style.overflow = '';
        }
    });
</script>


    @yield('customJs')
</body>

</html>
