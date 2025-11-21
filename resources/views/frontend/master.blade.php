<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <title>@yield('title')</title>
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta property="og:title" content="">
    <meta property="og:type" content="">
    <meta property="og:url" content="">
    <meta property="og:image" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset($siteSettings->favicon) }}">
    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('frontend-assets') }}/css/maind134.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css" integrity="sha384-b6lVK+yci+bfDmaY1u0zE8YYJt0TZxLEAFyYSLHId4xoVvsrQu3INevFKo+Xir8e" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('frontend-assets') }}/css/owl.carousel.min.css">
    <link rel="stylesheet" href="{{ asset('frontend-assets') }}/css/ion.rangeSlider.min.css">
    <link rel="stylesheet" href="{{ asset('frontend-assets') }}/css/style.css">

</head>

<body>
<!-- Modal -->
@yield('modals')
<!-- Quick view -->

<!-- Header & Mobile nav -->
@include('frontend.include.header')

<main class="main">
    @yield('content')
</main>

@include('frontend.include.footer')

<!-- Preloader Start -->
// <!-- @include('frontend.include.preloader')-->//

<div id="loaderOverlay">
    <div class="loaderOverlay-div">
        <div class="loader-spin"></div>
    </div>
</div>

<!-- Vendor JS-->

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
<!-- Add this to your HTML file -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

    function submitForm(button) {
        var form = button.closest('form'); // Find the closest form element to the clicked button
        var formData = new FormData(form);

        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
            .then(response => response.json())
            .then(data => {
                // Display SweetAlert message based on the response
                Swal.fire({
                    icon: data.type,
                    title: data.message,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 5000,
                    customClass: {
                        container: 'custom-swal-container',
                        popup: 'custom-swal-popup',
                        header: 'custom-swal-header',
                        title: 'custom-swal-title',
                        icon: 'custom-swal-icon',
                        image: 'custom-swal-image',
                        content: 'custom-swal-content',
                        input: 'custom-swal-input',
                        actions: 'custom-swal-actions',
                        confirmButton: 'custom-swal-confirm-button',
                        cancelButton: 'custom-swal-cancel-button',
                        footer: 'custom-swal-footer'
                    }
                });

                // Update header cart after successful addition
                updateHeaderCart(data.cartCount, data.cartContent, data.cartSubtotal);
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }

    function updateHeaderCart(cartCount, cartContent, cartSubtotal) {
        // Update cart count
        var cartCountElement = document.getElementById('cartCount');
        var cartCountElementMobile = document.getElementById('cartCountMobile');
        if (cartCountElement) {
            if (cartCountElement instanceof NodeList) {
                cartCountElement.forEach(element => {
                    element.textContent = cartCount;
                });
                cartCountElementMobile.forEach(element => {
                    element.textContent = cartCount;
                });
            } else {
                cartCountElement.textContent = cartCount;
                cartCountElementMobile.textContent = cartCount;
            }
        }

        // Update cart dropdown content
        var cartDropdown = document.getElementById('cartDropdown');
        var dropdownContent = '';

        if (Object.keys(cartContent).length > 0) {
            // Construct HTML for cart dropdown content
            dropdownContent += '<ul>';
            Object.keys(cartContent).forEach(key => {
                var item = cartContent[key];
                dropdownContent += `
                <li>
                    <div class="shopping-cart-img">
                        <a href="${item.options.slug}"><img alt="${item.name}" src="{{ asset('${item.options.image}') }}"></a>
                    </div>
                    <div class="shopping-cart-title">
                        <h4><a href="${item.options.slug}">${item.name}</a></h4>
                        <h4><span>${item.qty} × </span>$${item.price}</h4>
                    </div>
                    <div class="shopping-cart-delete">
                        <a href="${item.removeUrl}"><i class="fi-rs-cross-small"></i></a>
                    </div>
                </li>
            `;
            });
            dropdownContent += '</ul>';

            // Append footer
            dropdownContent += `
            <div class="shopping-cart-footer">
                <div class="shopping-cart-total">
                    <h4>Total <span>$${cartSubtotal}</span></h4>
                </div>
                <div class="shopping-cart-button">
                    <a href="{{ route('cart') }}" class="outline">View cart</a>
                    <a href="{{ route('checkout') }}">Checkout</a>
                </div>
            </div>
        `;
        } else {
            // If cart is empty, display a message
            dropdownContent = '<p>Your cart is empty.</p>';
        }

        // Update the dropdown content
        cartDropdown.innerHTML = dropdownContent;
    }



</script>




<script>
    // Function to update wishlist count
    function updateWishlistCount() {
        $.ajax({
            url: '{{ route("getWishlistCount") }}',
            type: 'post',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json',
            success: function (response) {
                if (response.status == true) {
                    var countSpan = $('#wishlist-count-now');
                    var countSpanMobile = $('#wishlist-count-now-mobile');
                    countSpan.text(response.count);
                    countSpanMobile.text(response.count);
                }
            }
        });
    }

    // Function to toggle wishlist icon and add/remove from wishlist
    function addToWishlist(id, element) {
        $.ajax({
            url: '{{ route("addToWishlist") }}',
            type: 'post',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                id: id,
            },
            dataType: 'json',
            success: function (response) {
                if (response.status == true) {
                    // Update wishlist count
                    updateWishlistCount();

                    // Toggle icon class
                    var icon = $(element).find('i');
                    icon.toggleClass('bi-heart bi-heart-fill');

                    // Display SweetAlert message based on the response
                    Swal.fire({
                        icon: response.inWishlist == true ? 'success' : 'error',
                        title: response.message,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 5000,
                        customClass: {
                            container: 'custom-swal-container',
                            popup: 'custom-swal-popup',
                            header: 'custom-swal-header',
                            title: 'custom-swal-title',
                            icon: 'custom-swal-icon',
                            image: 'custom-swal-image',
                            content: 'custom-swal-content',
                            input: 'custom-swal-input',
                            actions: 'custom-swal-actions',
                            confirmButton: 'custom-swal-confirm-button',
                            cancelButton: 'custom-swal-cancel-button',
                            footer: 'custom-swal-footer'
                        }
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
            }
        });
    }



    // Call updateWishlistCount on document ready to ensure the count is correct on page load
    $(document).ready(function() {
        updateWishlistCount();
    });
</script>


@yield('customJs')

</body>

</html>
