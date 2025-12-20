@extends('frontend.master')

@section('title')
    {{ $siteSettings->title }} | Category
@endsection

@section('modals')

    @include('frontend.include.quickview', ['products' => $products])

@endsection

@section('content')
    <div class="page-header breadcrumb-wrap">
        <div class="container">
            <div class="breadcrumb">
                <a href="{{ route('home') }}" rel="nofollow">Home</a>
                <span></span> <a href="{{ route('shop') }}">Shop</a>
                <span></span> {{ $category->name }}
            </div>
        </div>
    </div>
    <section class="mt-50 mb-50">
        <div class="container">
            <div class="row flex-row-reverse">
                <div class="col-lg-9">
                    <div class="shop-product-fillter">
                        <div class="totall-product">
                            <p> We found <strong class="text-brand">{{ $products->count() }}</strong> items for you!</p>
                        </div>
                        <div class="sort-by-product-area">
                            <div class="sort-by-cover mr-10">
                                <select name="show" id="show" class="form-control m-0">

                                    <option value="">Show:</option>
                                    <option value="50" {{ $show == 50 ? 'selected' : '' }}>50</option>
                                    <option value="100" {{ $show == 100 ? 'selected' : '' }}>100</option>
                                    <option value="150" {{ $show == 150 ? 'selected' : '' }}>150</option>
                                    <option value="200" {{ $show == 200 ? 'selected' : '' }}>200</option>
                                    <option value="all" {{ $show == 'all' ? 'selected' : '' }}>All</option>

                                </select>
                            </div>
                            <div class="sort-by-cover">
                                <select name="sort" id="sort" class="form-control m-0">

                                    <option value="latest" {{ $sort == 'latest' ? 'selected' : '' }}>Latest</option>
                                    <option value="featured" {{ $sort == 'featured' ? 'selected' : '' }}>Featured</option>
                                    <option value="low" {{ $sort == 'low' ? 'selected' : '' }}>Price: Low to High</option>
                                    <option value="high" {{ $sort == 'high' ? 'selected' : '' }}>Price: High to Low</option>

                                </select>
                            </div>
                            <button id="openFilter" type="button"
                                class="btn btn-sm btn-outline-dark d-lg-none">
                                <i class="bi bi-funnel"></i> Filter
                            </button>
                        </div>
                    </div>
                    <div class="m-product-list relative sf-mixed-layout sf-mixed-layout--mobile-grid">
                        <div class="m-product-list__wrapper">
                            <div class="sf-mixed-layout__wrapper grid-cols-2 sf__col-5 md:grid-cols-3 xl:grid-cols-5" style="gap: 10px">
                                @if(isset($products))
                                    @foreach($products as $product)
                                        <div class="sf-column product-card">
                                            <div class="sf__pcard sf__pcard--onsale cursor-pointer sf-prod__block sf__pcard-style-4" data-view="card"
                                                data-product-id="8766631903454">
                                                <div class="sf__pcard-image  spc__img-only">
                                                    <div class="overflow-hidden cursor-pointer relative sf__image-box">
                                                        <div class="flex justify-center items-center">
                                                            <a href="{{ route('products', $product->slug) }}" class="block w-full">
                                                                <div class="spc_product_main-img">
                                                                    <img src="{{ asset($product->featured_image) }}" width="600px"
                                                                        style=" object-fit: cover; height: 100%;">
                                                                </div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="text-center">
                                                    <div class="mt-3 lg:mt-5">
                                                        <div class="max-w-full w-full">
                                                            <h3 class="block text-base">
                                                                <a href="{{ route('products', $product->slug) }}"
                                                                    class="block mb-[5px] leading-normal sf__pcard-name font-medium truncate-lines hover:text-color-secondary">
                                                                    {{ $product->name }}
                                                                </a>
                                                            </h3>


                                                        </div>
                                                        <ul class="product-tags-in-grid">
                                                            <li>
                                                                <a
                                                                    href="{{ $product->subCategory ? route('subCategoryProduct', $product->subCategory->slug) : route('categoryProduct', $product->category->slug) }}">
                                                                    {{ $product->subCategory ? $product->subCategory->name : $product->category->name }}
                                                                </a>
                                                            </li>
                                                        </ul>
                                                        <div class="sf__pcard-price leading-normal">
                                                            <div class="f-price inline-flex justify-content-center flex-wrap f-price--on-sale text-center">
                                                            
                                                                @if ($product->productVariations->count() > 0)
                                                                    @php
                                                                        $variations = $product->productVariations;

                                                                        // Calculate selling price for each variation
                                                                        $sellingPrices = $variations->map(function ($v) {
                                                                            return $v->compare_price && $v->compare_price > 0
                                                                                ? $v->compare_price
                                                                                : $v->price;
                                                                        });

                                                                        $minSelling = $sellingPrices->min();
                                                                        $maxSelling = $sellingPrices->max();

                                                                        // Check if ANY variation has compare_price
                                                                        $hasSale = $variations->where('compare_price', '>', 0)->count() > 0;

                                                                        // For showing crossed price, we still need original ranges
                                                                        $minOriginal = $variations->min('price');
                                                                        $maxOriginal = $variations->max('price');
                                                                    @endphp

                                                                    {{-- IF THERE ARE SALE PRICES --}}
                                                                    @if ($hasSale)
                                                                        <div class="sf__pcard-tags absolute flex flex-wrap">
                                                                            <span
                                                                                class="py-0.5 px-2 mb-2 mr-2 font-medium rounded-xl text-white prod__tag prod__tag-sale">On
                                                                                Sale </span>
                                                                        </div>
                                                                        <span class="text-muted text-decoration-line-through sale-price-range originalPrice">
                                                                            {{ number_format($minOriginal) }} - {{ number_format($maxOriginal) }}
                                                                        </span>
                                                                        
                                                                        <span class="fw-bold price-range sellingPrice">
                                                                            {{ number_format($minSelling) }} - {{ number_format($maxSelling) }} BDT
                                                                        </span>
                                                                    @else
                                                                        <span class="fw-bold price-range sellingPrice">
                                                                            {{ number_format($minSelling) }} - {{ number_format($maxSelling) }} BDT
                                                                        </span>
                                                                    @endif
                                                                @else
                                                                    {{-- NO VARIATIONS --}}
                                                                    @if ($product->compare_price && $product->compare_price > 0)
                                                                        <div class="sf__pcard-tags absolute flex flex-wrap">
                                                                            <span
                                                                                class="py-0.5 px-2 mb-2 mr-2 font-medium rounded-xl text-white prod__tag prod__tag-sale">On
                                                                                Sale </span>
                                                                        </div>
                                                                        <span class="text-muted text-decoration-line-through sale-price originalPrice">
                                                                            {{ number_format($product->price) }}
                                                                        </span>
                                                                        
                                                                        <span class="fw-bold price sellingPrice">
                                                                            {{ number_format($product->compare_price) }} BDT
                                                                        </span>
                                                                    @else
                                                                        <span class="fw-bold price sellingPrice">
                                                                            {{ number_format($product->price) }} BDT
                                                                        </span>
                                                                    @endif
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @if ($product->qty > 0)
                                                        <form method="POST" class="mt-2" action="{{ route('addToCart', $product->id) }}" id="addToCartForm">
                                                            @csrf
                                                            <div>
                                                                @if ($product->productVariations->count() > 0)
                                                                    <div class="attr-detail mb-15">
                                                                        <div>
                                                                            <ul class="list-filter size-filter font-small" id="variationList">
                                                                                @foreach ($product->productVariations as $variation)
                                                                                    <li>
                                                                                        <label class="size-label variation-option"
                                                                                            data-id="{{ $variation->id }}"
                                                                                            data-price="{{ $variation->price }}"
                                                                                            data-sale="{{ $variation->compare_price }}"
                                                                                            data-type="{{ $variation->type }}"
                                                                                            data-qty="{{ $variation->qty }}">
                                                                                            <input type="radio" name="variation"
                                                                                                value="{{ $variation->id }}" hidden>
                                                                                            <p class="variation-box">{{ $variation->type }}</p>
                                                                                        </label>
                                                                                    </li>
                                                                                @endforeach
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                            <div class="sf__pcard-action-atc flex justify-center mt-2">
                                                                <input name="quantity" value="1" type="hidden">
                                                                <button type="button" aria-label="Add To Cart" onclick="submitForm(this)"
                                                                    class="btn btn-sm btn-primary action-btn hover-up">Quick Add </button>

                                                            </div>
                                                        </form>
                                                    @else
                                                        <button aria-label="Out of Stock !"
                                                            class="btn btn-danger btn-sm action-btn hover-up stock-out mt-2">Out of stock !</button>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    No Products Available Now
                                @endif
                            </div>
                        </div>
                    </div>
                    <!--pagination-->
                    <div class="pagination-area mt-15 mb-sm-5 mb-lg-0">
                        {{ $products->withQueryString()->links() }}
                    </div>
                </div>
                <div id="filterOverlay"></div>
                <div id="mobileFilterSidebar" class="col-lg-3 primary-sidebar sticky-sidebar">
                    <button class="filter-close d-lg-none" id="closeFilter">×</button>
                    <div class="sidebar-widget price_range range mb-30">
                        <div class="widget-header position-relative mb-20 pb-10">
                            <h5 class="widget-title mb-10">Fill by price</h5>
                            <div class="bt-1 border-color-1"></div>
                        </div>
                        <div class="price-filter">
                            <div class="price-filter-inner">
                                <div class="price_slider_amount">
                                    <div class="label-input">
                                        <span>Range:</span><input type="text" class="js-range-slider" name="my_range" value="" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="widget-category mb-30">
                        <h5 class="section-title style-1 mb-30 wow fadeIn animated">Brand</h5>
                        @if(isset($brands))
                            <ul class="categories">
                                @foreach($brands as $brand)
                                    <li>
                                        <input {{ (in_array($brand->id, $brandsArray)) ? 'checked' : '' }} class="form-check-input brand-lable" type="checkbox" name="brand[]" value="{{ $brand->id }}" id="brand-{{ $brand->id }}">
                                        <label class="form-check-label" for="brand-{{ $brand->id }}">{{ $brand->name }}</label>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('customJs')
<script>
    const openBtn = document.getElementById('openFilter');
    const closeBtn = document.getElementById('closeFilter');
    const sidebar = document.getElementById('mobileFilterSidebar');
    const filterOverlay = document.getElementById('filterOverlay');

    function openFilter() {
        sidebar.classList.add('active');
        filterOverlay.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeFilter() {
        sidebar.classList.remove('active');
        filterOverlay.classList.remove('active');
        document.body.style.overflow = '';
    }

    openBtn?.addEventListener('click', openFilter);
    closeBtn?.addEventListener('click', closeFilter);
    filterOverlay?.addEventListener('click', closeFilter);
</script>
    <script>

        rangeSlider = $(".js-range-slider").ionRangeSlider({
            type: "double",
            min: 0,
            max: 10000,
            from: {{ ($priceMin) }},
            step: 100,
            to: {{ ($priceMax) }},
            skin: "round",
            max_postfix: "+",
            prefix: "$",
            onFinish : function () {
                apply_filters()
            }
        });

        var slider = $(".js-range-slider").data("ionRangeSlider");

        $(".brand-lable").change(function () {
            apply_filters();
        });

        $("#sort").change(function () {
            apply_filters();
        });

        $("#show").change(function () {
            apply_filters();
        });

        function apply_filters() {
            var brands = [];
            $(".brand-lable").each(function () {
                if($(this).is(":checked") == true){
                    brands.push($(this).val());
                }
            });

            var url = '{{ url()->current() }}?';

            //Price Range

            url += '&price_min='+slider.result.from+'&price_max='+slider.result.to;

            //brand Filter

            if(brands.length > 0){
                url += '&brand='+brands.toString()
            }

            //sorting filter
            url += '&sort='+$("#sort").val()

            //show product filter
            url += '&show='+$("#show").val()

            var keyword1 = $("#search").val();
            // var keyword2 = $("#search_category").val();
            if(keyword1.length > 0){
                url += ('&search=' + keyword1);
            }
            // if(keyword2.length > 0){
            //     url += ('&category=' + keyword2);
            // }


            window.location.href = url;

        }

    </script>
@endsection
