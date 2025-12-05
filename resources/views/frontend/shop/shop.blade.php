@extends('frontend.master')

@section('title')
    {{ $siteSettings->title }} | Shop
@endsection

@section('modals')

    @include('frontend.include.quickview', ['products' => $products])

@endsection

@section('content')
    <div class="page-header breadcrumb-wrap">
        <div class="container">
            <div class="breadcrumb">
                <a href="{{ route('home') }}" rel="nofollow">Home</a>
                <span></span> Shop
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
                                <select name="show" id="show" class="form-control">

                                    <option value="">Show:</option>
                                    <option value="50" {{ $show == 50 ? 'selected' : '' }}>50</option>
                                    <option value="100" {{ $show == 100 ? 'selected' : '' }}>100</option>
                                    <option value="150" {{ $show == 150 ? 'selected' : '' }}>150</option>
                                    <option value="200" {{ $show == 200 ? 'selected' : '' }}>200</option>
                                    <option value="all" {{ $show == 'all' ? 'selected' : '' }}>All</option>

                                </select>
                            </div>
                            <div class="sort-by-cover">
                                <select name="sort" id="sort" class="form-control">

                                    <option value="latest" {{ $sort == 'latest' ? 'selected' : '' }}>Latest</option>
                                    <option value="featured" {{ $sort == 'featured' ? 'selected' : '' }}>Featured</option>
                                    <option value="low" {{ $sort == 'low' ? 'selected' : '' }}>Price: Low to High</option>
                                    <option value="high" {{ $sort == 'high' ? 'selected' : '' }}>Price: High to Low</option>

                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row product-grid-3" >
                        @if(isset($products))
                            @foreach($products as $product)
                                <div class="col-lg-4 col-md-4 col-12 col-sm-6">
                                    <div class="product-cart-wrap mb-30">
                                        <div class="product-img-action-wrap">
                                            <div class="product-img product-img-zoom">
                                                <a href="{{ route('products',$product->slug) }}">
                                                    <img class="default-img" src="{{ asset($product->featured_image) }}" alt="">
                                                    @foreach($product->productGallery->take(1) as $image)
                                                        <img class="hover-img" src="{{ asset($image->images) }}" alt="">
                                                    @endforeach
                                                </a>
                                            </div>
                                            <div class="product-action-1">
                                                <a aria-label="Quick view" class="action-btn hover-up" data-bs-toggle="modal" data-bs-target="#quickViewModal{{ $product->id }}"><i class="fi-rs-eye"></i></a>
                                                <a
                                                    @if(auth()->check())
                                                    @if( $product->wishlist->where('user_id', $userId)->first())
                                                    aria-label="Remove from Wishlist"
                                                    @else
                                                    aria-label="Add To Wishlist"
                                                    @endif
                                                    @else
                                                    @if(in_array($product->id, session()->get('wishlist', [])))
                                                    aria-label="Remove from Wishlist"
                                                    @else
                                                    aria-label="Add To Wishlist"
                                                    @endif
                                                    @endif
                                                    onclick="addToWishlist({{$product->id}}, this)" class="action-btn hover-up" href="javascript:void(0)">
                                                    <!-- Check if product is in wishlist -->
                                                    @if(auth()->check())
                                                        @if( $product->wishlist->where('user_id', $userId)->first())
                                                            <i id="wishlist-icon-{{$product->id}}" class="bi bi-heart-fill"></i>
                                                        @else
                                                            <i id="wishlist-icon-{{$product->id}}" class="bi bi-heart"></i>
                                                        @endif
                                                    @else
                                                        @if(in_array($product->id, session()->get('wishlist', [])))
                                                            <i id="wishlist-icon-{{$product->id}}" class="bi bi-heart-fill"></i>
                                                        @else
                                                            <i id="wishlist-icon-{{$product->id}}" class="bi bi-heart"></i>
                                                        @endif
                                                    @endif
                                                </a>

                                            </div>

                                               @if(!empty( $product->is_featured == 'YES') )
                                                <div class="product-badges product-badges-position product-badges-mrg">
                                                    <span class="hot">Featured</span>
                                                </div>
                                                @elseif($product->compare_price)
                                                <div class="product-badges product-badges-position product-badges-mrg">
                                                    <span class="sale">Sale</span>
                                                </div>
                                                @elseif(now()->diffInDays($product->created_at) <= 30)
                                                <div class="product-badges product-badges-position product-badges-mrg">
                                                    <span class="new">New</span>
                                                </div>
                                                @else
                                                <div class="product-badges product-badges-position product-badges-mrg" style="display: none">
                                                </div>
                                                @endif

                                        </div>
                                        <div class="product-content-wrap">
                                            <div class="product-category">
                                                <a href="{{ route('subCategoryProduct', $product->subCategory->slug) }}">{{ $product->subCategory->name }}</a>
                                            </div>
                                            <h2><a href="{{ route('products',$product->slug) }}">{{ $product->name }}</a></h2>
                                            <div class="product-rate-cover ">
                                                <div class="product-rate d-inline-block">
                                                    <div class="product-rating" style="width:{{$product->ratings->where('status',1)->avg('rating') * 20}}%">
                                                    </div>
                                                </div>
                                                <span class="font-small ml-5 text-muted"> {{$product->ratings->where('status',1)->count()}}</span>
                                            </div>
                                            <div class="product-price">
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
                                                        <span class="text-muted text-decoration-line-through">
                                                            {{ number_format($minOriginal) }} - {{ number_format($maxOriginal) }} BDT
                                                        </span>
                                                        <br>
                                                        <span class="fw-bold">
                                                            {{ number_format($minSelling) }} - {{ number_format($maxSelling) }} BDT
                                                        </span>

                                                    {{-- NO SALE PRICE --}}
                                                    @else
                                                        <span class="fw-bold">
                                                            {{ number_format($minSelling) }} - {{ number_format($maxSelling) }} BDT
                                                        </span>
                                                    @endif

                                                @else
                                                    {{-- NO VARIATIONS --}}
                                                    @if ($product->compare_price && $product->compare_price > 0)
                                                        <span class="text-muted text-decoration-line-through">
                                                            {{ number_format($product->price) }} BDT
                                                        </span>
                                                        <br>
                                                        <span class="fw-bold">
                                                            {{ number_format($product->compare_price) }} BDT
                                                        </span>
                                                    @else
                                                        <span class="fw-bold">
                                                            {{ number_format($product->price) }} BDT
                                                        </span>
                                                    @endif
                                                @endif
                                            </div>
                                            <div class="product-action-1 show">
                                                @if($product->track_qty == 'YES')
                                                    @if($product->qty > 0)
                                                        @if($product->productVariations->count() > 0)
                                                            <a aria-label="Select options" class="action-btn hover-up" href="{{ route('products', $product->slug) }}"> <i class="fi-rs-shopping-bag-add"></i> </a>
                                                        @else
                                                            <form method="POST" action="{{ route('addToCart', $product->id) }}" id="addToCartForm">
                                                                @csrf
                                                                <input name="quantity" value="1" type="hidden">
                                                                <button type="button" aria-label="Add To Cart" onclick="submitForm(this)" class="action-btn hover-up"><i class="fi-rs-shopping-bag-add"></i></button>
                                                            </form>
                                                        @endif
                                                    @else
                                                        <button aria-label="Out of Stock !" class="action-btn hover-up stock-out">  <i class="fi-rs-shopping-bag-add"></i> </button>
                                                    @endif

                                                @else
                                                    @if($product->productVariations->count() > 0)
                                                        <a aria-label="Select options" class="action-btn hover-up" href="{{ route('products', $product->slug) }}"> <i class="fi-rs-shopping-bag-add"></i> </a>
                                                    @else
                                                        <form method="POST" action="{{ route('addToCart', $product->id) }}" id="addToCartForm">
                                                            @csrf
                                                            <input name="quantity" value="1" type="hidden">
                                                            <button type="button" aria-label="Add To Cart" onclick="submitForm(this)" class="action-btn hover-up"><i class="fi-rs-shopping-bag-add"></i></button>
                                                        </form>
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            No Products Available Now
                        @endif
                    </div>
                    <!--pagination-->
                    <div class="pagination-area mt-15 mb-sm-5 mb-lg-0">
                            {{ $products->withQueryString()->links() }}

{{--                        <nav aria-label="Page navigation example">--}}
{{--                            <ul class="pagination justify-content-start">--}}
{{--                                <li class="page-item active"><a class="page-link" href="#">01</a></li>--}}
{{--                                <li class="page-item"><a class="page-link" href="#">02</a></li>--}}
{{--                                <li class="page-item"><a class="page-link" href="#">03</a></li>--}}
{{--                                <li class="page-item"><a class="page-link dot" href="#">...</a></li>--}}
{{--                                <li class="page-item"><a class="page-link" href="#">16</a></li>--}}
{{--                                <li class="page-item"><a class="page-link" href="#"><i class="fi-rs-angle-double-small-right"></i></a></li>--}}
{{--                            </ul>--}}
{{--                        </nav>--}}
                    </div>
                </div>

                <div class="col-lg-3 primary-sidebar sticky-sidebar">
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
                        <h5 class="section-title style-1 mb-30 wow fadeIn animated">Category</h5>
                        @if(isset($categories))
                        @foreach($categories as $category)
                            @if($category->sub_category->isNotEmpty())
                        <a class="" data-bs-toggle="collapse" href="#collapse{{ $category->id }}" role="button" aria-expanded="false" aria-controls="collapseExample">
                            <p class="mt-2">{{ $category->name }}<i class="bi bi-chevron-down" style="margin-left: 30px"></i></p>
                        </a>
                                @else
                                    <a href="{{route('shop', $category->slug) }}"><p class="mt-2" style="{{ ($categorySelected == $category->id) ? 'color: #088178;' : '' }}">{{ $category->name }}</p></a>
                                @endif
                        <div class="collapse {{ ($categorySelected == $category->id) ? 'show' : '' }}" id="collapse{{ $category->id }}">
                            <div class="">
                                <ul class="categories">
                                    @foreach($category->sub_category->where('status', 1) as $subCategory)
                                    <li><a href="{{route('shop', [$category->slug,$subCategory->slug]) }}" style="{{ ($subCategorySelected == $subCategory->id) ? 'color: #088178;' : '' }}">{{ $subCategory->name }}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                        @endforeach
                        @endif

                    </div>
                    <!-- Fillter By Brand -->
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
            var keyword2 = $("#search_category").val();
            if(keyword1.length > 0){
                url += ('&search=' + keyword1);
            }
            if(keyword2.length > 0){
                url += ('&category=' + keyword2);
            }


            window.location.href = url;

        }

    </script>
@endsection
