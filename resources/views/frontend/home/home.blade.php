@extends('frontend.master')

@section('title')
    {{ $siteSettings->tagline }}
@endsection

@section('content')

    <main>
        <div>
            <div>
                <div class="swiper mySwiper" aria-label="Image slider">
                    <div class="swiper-wrapper">
                        @if ($sliders->isNotEmpty())
                            @foreach ($sliders as $slider)
                                <div class="swiper-slide">
                                    <img src="{{ asset($slider->image) }}" alt="Slide {{ $loop->index + 1 }}" width="100%"
                                        height="100%" style="object-fit: cover" />
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <div class="swiper-pagination" role="navigation" aria-label="Slider pagination"></div>
                </div>
            </div>

            <m-featured-collection
                style=" background-color: rgba(0,0,0,0); --column-gap: 30px; --column-gap-mobile: 16px; --row-gap: 40px; --items: 5;  --section-padding-top: 0px;  --section-padding-bottom: 0px;  ">
                <div class="container mt-4">
                    <div class="section__header text-center">
                        <h2 class="section__heading">ALL PRODUCT</h2>
                    </div>
                    <div class="m-product-list relative sf-mixed-layout sf-mixed-layout--mobile-grid">
                        <div class="m-product-list__wrapper">
                            <link
                                href="{{ asset('frontend-assets') }}/cdn/shop/t/2/assets/component-product-cardec07.css?v=99309051667405447581707765654"
                                rel="stylesheet" type="text/css" media="all" />
                            <div class="sf-mixed-layout__wrapper grid-cols-2 sf__col-5 md:grid-cols-3 xl:grid-cols-5"
                                id="productContainer" data-products-container>
                                @include('frontend.products.product_loop', ['products' => $products])
                            </div>
                            <div id="spinner" style="display:none;text-align:center;">
                                <img src="{{ asset('frontend-assets/imgs/Trail loading.gif') }}" style="width: 100%;height: 100px; object-fit: contain;">
                            </div>

                            <input type="hidden" id="page" value="1">
                        </div>
                    </div>
                </div>
            </m-featured-collection>

        </div>
    </main>
@endsection


@section('customJs')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const swiper = new Swiper('.mySwiper', {
                loop: true,
                slidesPerView: 1,

                autoplay: {
                    delay: 5000,
                    disableOnInteraction: false,
                },

                // ✅ REQUIRED FOR DRAGGING
                simulateTouch: true,     // enable mouse drag
                allowTouchMove: true,    // enable swipe
                grabCursor: true,        // show grab cursor

                keyboard: {
                    enabled: true,
                    onlyInViewport: true,
                },

                a11y: {
                    enabled: true,
                    prevSlideMessage: 'Previous slide',
                    nextSlideMessage: 'Next slide',
                },

                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
            });
        });
    </script>

    <script>
        let page = 1;
        let loading = false;
        let allLoaded = false; // flag to stop when all products are loaded

        $(window).scroll(function() {
            if (loading || allLoaded) return;

            if ($(window).scrollTop() + $(window).height() >= $(document).height() - 100) {
                loading = true;
                page++;

                $("#spinner").show();

                $.get("{{ route('load-more-products') }}", {
                    page: page
                }, function(res) {
                    if (res.html) {
                        $("#productContainer").append(res.html);
                    }

                    $("#spinner").hide();
                    loading = false;

                    // If no more products, stop further requests
                    if (!res.hasMore) {
                        allLoaded = true;
                    }
                });
            }
        });
    </script>

    

@endsection
