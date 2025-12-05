@extends('frontend.master')

@section('title')
    {{ $siteSettings->title }} | WishList
@endsection


@section('content')

    <div class="page-header breadcrumb-wrap">
        <div class="container">
            <div class="breadcrumb">
                <a href="{{ route('home') }}" rel="nofollow">Home</a>
                <span></span> Shop
                <span></span> Wishlist
            </div>
        </div>
    </div>
    <section class="mt-50 mb-50">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive">
                        <table class="table shopping-summery text-center">
                            <thead>
                            <tr class="main-heading">
                                <th scope="col" colspan="2">Product</th>
                                <th scope="col">Price</th>
                                <th scope="col">Action</th>
                                <th scope="col">Remove</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(auth()->check())
                                @if($wishlists->isNotEmpty())
                                    @foreach($wishlists as $wishlist)
                                        <tr>
                                            <td class="image product-thumbnail"><img src="{{ asset($wishlist->product->featured_image) }}" alt="#"></td>
                                            <td class="product-des product-name">
                                                <h5 class="product-name"><a href="{{ route('products', $wishlist->product->slug) }}">{{ $wishlist->product->name }}</a></h5>
                                                <p class="font-xs">{{ $wishlist->product->short_desc }}
                                                </p>
                                            </td>
                                            <td class="price" data-title="Price">
                                                <span>{{ $wishlist->product->price }} Tk</span>
                                                @if ($wishlist->product->productVariations->count() > 0)

                                                    @php
                                                        $variations = $wishlist->product->productVariations;

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
                                                    @if ($wishlist->product->compare_price && $wishlist->product->compare_price > 0)
                                                        <span class="text-muted text-decoration-line-through">
                                                            {{ number_format($wishlist->product->price) }} BDT
                                                        </span>
                                                        <br>
                                                        <span class="fw-bold">
                                                            {{ number_format($wishlist->product->compare_price) }} BDT
                                                        </span>
                                                    @else
                                                        <span class="fw-bold">
                                                            {{ number_format($wishlist->product->price) }} BDT
                                                        </span>
                                                    @endif
                                                @endif
                                            </td>
                                            <td class="text-right" data-title="Cart">
                                                @if($wishlist->product->track_qty == 'YES')
                                                    @if($wishlist->product->qty > 0)
                                                        @if($wishlist->product->productVariations->count() > 0)
                                                            <a aria-label="Select options" class="action-btn hover-up" href="{{ route('products', $wishlist->product->slug) }}"> <i class="fi-rs-shopping-bag-add"></i> </a>
                                                        @else
                                                            <form method="POST" action="{{ route('addToCart', $wishlist->product->id) }}" id="addToCartForm">
                                                                @csrf
                                                                <input name="quantity" value="1" type="hidden">
                                                                <button type="button" aria-label="Add To Cart" onclick="submitForm(this)" class="action-btn hover-up"><i class="fi-rs-shopping-bag-add"></i></button>
                                                            </form>
                                                        @endif
                                                    @else
                                                        <button aria-label="Out of Stock !" class="action-btn hover-up stock-out">  <i class="fi-rs-shopping-bag-add"></i> </button>
                                                    @endif

                                                @else
                                                    @if($wishlist->product->productVariations->count() > 0)
                                                        <a aria-label="Select options" class="action-btn hover-up" href="{{ route('products', $wishlist->product->slug) }}"> <i class="fi-rs-shopping-bag-add"></i> </a>
                                                    @else
                                                        <form method="POST" action="{{ route('addToCart', $wishlist->product->id) }}" id="addToCartForm">
                                                            @csrf
                                                            <input name="quantity" value="1" type="hidden">
                                                            <button type="button" aria-label="Add To Cart" onclick="submitForm(this)" class="action-btn hover-up"><i class="fi-rs-shopping-bag-add"></i></button>
                                                        </form>
                                                    @endif
                                                @endif
                                            </td>
                                            <td class="action" data-title="Remove"><a onclick="addToWishlistAndReload({{$wishlist->product->id}})" href="javascript:void(0)"><i class="fi-rs-trash"></i></a></td>
                                        </tr>
                                    @endforeach
                                @else
                                <tr>
                                   <td colspan="6"> No Products in Wishlist </td>
                                </tr>
                                @endif
                            @else
                                @if(session('wishlist'))
                                    @foreach(session('wishlist') as $productId)
                                        @php
                                            $product = $wishlists->where('id', $productId)->first(); // Assuming you have a function to retrieve product details
                                        @endphp
                                            <tr>
                                                <td class="image product-thumbnail"><img src="{{ asset($product->featured_image) }}" alt="#"></td>
                                                <td class="product-des product-name">
                                                    <h5 class="product-name"><a href="{{ route('products', $product->slug) }}">{{ $product->name }}</a></h5>
                                                    <p class="font-xs">{{ $product->short_desc }}</p>
                                                </td>
                                                <td class="price" data-title="Price">
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
                                                </td>
                                               
                                                <td class="text-right" data-title="Cart">
                                                    @if($product->track_qty == 'YES')
                                                        @if($product->qty > 0)
                                                            @if($product->productVariations->count() > 0)
                                                                <a aria-label="Select options" class="btn btn-primary action-btn hover-up" href="{{ route('products', $product->slug) }}"> Select options </a>
                                                            @else
                                                                <form method="POST" action="{{ route('addToCart', $product->id) }}" id="addToCartForm">
                                                                    @csrf
                                                                    <input name="quantity" value="1" type="hidden">
                                                                    <button type="button" aria-label="Add To Cart" onclick="submitForm(this)" class="btn btn-primary action-btn hover-up">Add To Cart</button>
                                                                </form>
                                                            @endif
                                                        @else
                                                            <button aria-label="Out of Stock !" class="action-btn hover-up stock-out">  Out of Stock </button>
                                                        @endif

                                                    @else
                                                        @if($product->productVariations->count() > 0)
                                                            <a aria-label="Select options" class="btn btn-primary action-btn hover-up" href="{{ route('products', $product->slug) }}"> Select options </a>
                                                        @else
                                                            <form method="POST" action="{{ route('addToCart', $product->id) }}" id="addToCartForm">
                                                                @csrf
                                                                <input name="quantity" value="1" type="hidden">
                                                                <button type="button" aria-label="Add To Cart" onclick="submitForm(this)" class="btn btn-primary action-btn hover-up">Add To Cart</button>
                                                            </form>
                                                        @endif
                                                    @endif
                                                </td>
                                                <td class="action" data-title="Remove"><a onclick="addToWishlistAndReload({{$product->id}})" href="javascript:void(0)"><i class="fi-rs-trash"></i></a></td>
                                            </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="6"> No Products in Wishlist </td>
                                    </tr>
                                @endif

                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('customJs')

    <script>
        function addToWishlistAndReload(productId) {
            // Call addToWishlist function (assuming it adds the product to the wishlist)
            addToWishlist(productId);

            // Reload the page
            setTimeout(function() {
                location.reload();
            }, 2000);
        }
    </script>

@endsection
