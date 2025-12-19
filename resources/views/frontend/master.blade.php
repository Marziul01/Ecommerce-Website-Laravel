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

    <link href="{{ asset('frontend-assets') }}/cdn/shop/t/2/assets/theme6d28.css?v=169926333737883166031707765659"
        rel="stylesheet" type="text/css" media="all" />
    <link href="{{ asset('frontend-assets') }}/cdn/shop/t/2/assets/chunk18f2.css?v=148419031456207892391707765653"
        rel="stylesheet" type="text/css" media="all" />
    <link rel="stylesheet" href="{{ asset('frontend-assets') }}/css/maind134.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css"
        integrity="sha384-b6lVK+yci+bfDmaY1u0zE8YYJt0TZxLEAFyYSLHId4xoVvsrQu3INevFKo+Xir8e" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('frontend-assets') }}/css/owl.carousel.min.css">
    <link rel="stylesheet" href="{{ asset('frontend-assets') }}/css/ion.rangeSlider.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <meta name="google-site-verification" content="plqddMKbyZUgQZHyoVAbUAqflg5TZp9oW2oDfBc-UgE">
    <meta id="shopify-digital-wallet" name="shopify-digital-wallet" content="/68513399006/digital_wallets/dialog">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="{{ asset('frontend-assets') }}/css/extra.css">
    <link rel="stylesheet" href="{{ asset('frontend-assets') }}/css/style.css">
</head>

<body>

    @include('frontend.include.header')


    @yield('content')


    @include('frontend.include.footer')

    @include('frontend.include.checkout')

    <div id="cartSidebar" class="cart-sidebar">
        <div class="cart-header">
            <h5>Your Cart</h5>
            <button onclick="closeCartSidebar()">×</button>
        </div>

        <div class="cart-items"></div>

        <div class="cart-footer">
            <div class="cart-total">
                <span>Subtotal</span>
                <strong class="cart-subtotal">0 BDT</strong>
            </div>
            <button type="button" class="btn btn-primary w-100 mt-2" id="openCheckout">
                ক্যাশ অন ডেলিভারিতে অর্ডার করুন
            </button>
            <a href="{{ route('cart') }}" class="btn btn-outline-primary w-100 mt-2">
                View Cart
            </a>
        </div>
    </div>




    <div class="cart-overlay" onclick="closeCartSidebar()"></div>

    <script>
        @if (session('success'))
            toastr.success(@json(session('success')));
        @endif

        @if (session('error'))
            toastr.error(@json(session('error')));
        @endif

        @if (session('warning'))
            toastr.warning(@json(session('warning')));
        @endif

        @if (session('info'))
            toastr.info(@json(session('info')));
        @endif

        {{-- Validation errors --}}
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                toastr.error(@json($error));
            @endforeach
        @endif
    </script>

    
    <script src="{{ asset('frontend-assets') }}/js/vendor/modernizr-3.6.0.min.js"></script>

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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        const hamburger = document.getElementById('mobileMenuToggle');
        const drawer = document.querySelector('.new-mobile-drawer');
        const overlay = document.querySelector('.mobile-overlay');

        hamburger.addEventListener('click', function() {

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
        overlay.addEventListener('click', function() {

            hamburger.classList.remove('active');
            drawer.classList.remove('open');
            overlay.classList.remove('show');


            overlay.classList.add('d-none');

            // Re-enable scroll on <html>
            document.documentElement.style.overflow = '';
        });

        // Optional: Close when clicking outside drawer (not overlay area)
        document.addEventListener('click', function(e) {
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

    <script>
        $(document).on('click', '.variation-option', function() {

            const card = $(this).closest('.product-card');

            // remove active from this product only
            card.find('.variation-option')
                .removeClass('active')
                .find('input[type="radio"]').prop('checked', false);

            // activate selected
            $(this).addClass('active');
            $(this).find('input[type="radio"]').prop('checked', true);

            // prices
            const price = $(this).data('price');
            const sale = $(this).data('sale');

            updatePrice(card, price, sale);
        });
    </script>

    <script>
        function submitForm(btn) {

            const $form = $(btn).closest('form');
            const $card = $(btn).closest('.product-card');
            const actionUrl = $form.attr('action');

            // variation validation
            if ($card.find('input[name="variation"]').length > 0) {
                if (!$card.find('input[name="variation"]:checked').length) {
                    toastr.error('Please choose an option');
                    return;
                }
            }

            $.ajax({
                url: actionUrl,
                method: 'POST',
                data: $form.serialize(),
                beforeSend() {
                    $(btn).prop('disabled', true);
                },
                success(res) {

                    if (res.type === 'error') {
                        toastr.error(res.message);
                        return;
                    }

                    toastr.success(res.message);

                    // update cart bubble
                    updateCartCount(res.cartCount);

                    // update sidebar cart
                    renderCartSidebar(res.cartContent, res.cartSubtotal);

                    // open sidebar
                    openCartSidebar();
                },
                error(xhr) {
                    toastr.error('Something went wrong!');
                },
                complete() {
                    $(btn).prop('disabled', false);
                }
            });
        }
    </script>

    <script>
        function updatePrice(card, price, sale) {

            const selling = card.find('.sellingPrice');
            const original = card.find('.originalPrice');

            if (sale && sale > 0) {
                original
                    .text(numberFormat(price))
                    .show();

                selling
                    .text(numberFormat(sale) + ' BDT');
            } else {
                original.hide();
                selling.text(numberFormat(price) + ' BDT');
            }
        }

        function numberFormat(num) {
            return parseInt(num).toLocaleString();
        }
    </script>

    <script>
        function renderCartSidebar(cartContent, subtotal) {

            const $container = $('.cart-items');
            $container.html('');

            if (!cartContent || Object.keys(cartContent).length === 0) {
                $container.html('<p class="text-muted">Cart is empty</p>');
                $('.cart-subtotal').text('0 BDT'); // ✅ RESET HERE
                return;
            }

            Object.values(cartContent).forEach(item => {

                $container.append(`
                    <div class="cart-item" data-rowid="${item.rowId}">
                        <img src="${item.options.image}" alt="${item.name}">
                        <div class="flex-grow-1">
                            <div class="d-flex justify-content-between align-items-center gap-3">
                                <div> 
                                    <strong class="cart-sidebar-name">${item.name}</strong>
                                    ${item.options.variation_name ? `<div class="cart-sidebar-option">${item.options.variation_name}</div>` : ''}
                                </div>
                                <div class="cart-sidebar-price">${item.price} BDT</div>
                            </div>
                            <div class="d-flex align-items-center justify-content-between gap-2 mt-1">
                                <div class="d-flex align-items-center gap-1 position-relative">
                                    <button class="btn btn-sm btn-outline-secondary qtyMinus" data-rowid="${item.rowId}">−</button>
                                    <input type="number" min="1"
                                        value="${item.qty}"
                                        class="form-control form-control-sm text-center cartQty"
                                        data-rowid="${item.rowId}">
                                    <button class="btn btn-sm btn-outline-secondary qtyPlus" data-rowid="${item.rowId}">+</button>
                                </div>

                                <button class="btn btn-sm btn-danger removeCartItem"
                                        data-rowid="${item.rowId}">×</button>
                            </div>
                        </div>
                    </div>
                `);
            });

            $('.cart-subtotal').text(subtotal + ' BDT');
        }

    </script>

    <script>
        function openCartSidebar() {
            $('#cartSidebar').addClass('open');
            $('.cart-overlay').addClass('show');
        }

        function closeCartSidebar() {
            $('#cartSidebar').removeClass('open');
            $('.cart-overlay').removeClass('show');
        }
    </script>

    <script>
        function updateCartCount(count) {
            $('.sf-cart-count')
                .text(count)
                .toggleClass('hidden', count == 0);
        }
    </script>

    <script>
        $(document).on('click', '.removeCartItem', function () {
            const rowId = $(this).data('rowid');

            $.post("{{ route('removeFromCart') }}", {
                _token: "{{ csrf_token() }}",
                rowId: rowId
            }, function (res) {

                if (res.type === 'error') {
                    toastr.error(res.message);
                    return;
                }

                toastr.success(res.message);
                updateCartCount(res.cartCount);
                renderCartSidebar(res.cartContent, res.cartSubtotal);
            });
        });
    </script>

    <script>
        $(document).on('change', '.cartQty', function () {
            updateQty($(this).data('rowid'), $(this).val());
        });
        $(document).on('click', '.qtyPlus', function () {
            const input = $(this).siblings('.cartQty');
            let qty = parseInt(input.val()) + 1;
            input.val(qty);
            updateQty(input.data('rowid'), qty);
        });

        $(document).on('click', '.qtyMinus', function () {
            const input = $(this).siblings('.cartQty');
            let qty = parseInt(input.val()) - 1;

            if (qty < 1) return;

            input.val(qty);
            updateQty(input.data('rowid'), qty);
        });
        function updateQty(rowId, qty) {
            $.post("{{ route('updateCart') }}", {
                _token: "{{ csrf_token() }}",
                rowId: rowId,
                qty: qty
            }, function (res) {

                if (res.type === 'error') {
                    toastr.error(res.message);
                    return;
                }

                renderCartSidebar(res.cartContent, res.cartSubtotal);
                updateCartCount(res.cartCount);
            });
        }
    </script>

    <script>
        $(document).on('click', '.openCartBtn', function() {

            $.get("{{ route('cart.sidebar') }}", function(res) {
                renderCartSidebar(res.cartContent, res.cartSubtotal);
                openCartSidebar();
            });

        });
    </script>

    <script>
        let lastScrollTop = 0;
        const header = document.querySelector('.header__wrapper');
        const offset = 200; // px from top

        window.addEventListener('scroll', function () {
            const scrollTop = window.pageYOffset || document.documentElement.scrollTop;

            // SCROLLING UP
            if (scrollTop < lastScrollTop && scrollTop > offset) {
                header.classList.add('header--fixed');

                // small timeout ensures smooth slide-in
                setTimeout(() => {
                    header.classList.add('header--show');
                }, 10);
            }

            // SCROLLING DOWN
            else if (scrollTop > lastScrollTop) {
                header.classList.remove('header--show');
            }

            // NEAR TOP → RESET
            if (scrollTop <= offset) {
                header.classList.remove('header--fixed', 'header--show');
            }

            lastScrollTop = scrollTop <= 0 ? 0 : scrollTop;
        });
    </script>

    <script>
        document.getElementById('openCheckout').addEventListener('click', function () {

            /* 1️⃣ Close all open modals */
            document.querySelectorAll('.modal.show').forEach(modal => {
                const instance = bootstrap.Modal.getInstance(modal);
                instance && instance.hide();
            });

            /* 2️⃣ Close cart sidebar */
            if (typeof closeCartSidebar === 'function') {
                closeCartSidebar();
            }

            /* 3️⃣ Show modal + loader */
            setTimeout(() => {
                const modalEl = document.getElementById('checkoutModal');
                const modal = new bootstrap.Modal(modalEl);
                modal.show();

                document.getElementById('checkoutLoader').style.display = 'flex';
                document.getElementById('checkoutContent').style.display = 'none';

                /* 4️⃣ Fetch latest cart data */
                fetch("{{ route('checkout.cart.data') }}")
                    .then(res => res.json())
                    .then(data => {

                        renderCheckoutItems(data.cartContent);
                        updateCheckoutTotals(data);

                        document.getElementById('checkoutLoader').style.display = 'none';
                        document.getElementById('checkoutContent').style.display = 'block';
                    });

            }, 250);
        });


    </script>

    @yield('customJs')
</body>

</html>
