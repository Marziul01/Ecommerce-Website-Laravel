@extends('frontend.master')

@section('title')
    {{ $siteSettings->title }} | {{ $siteSettings->tagline }}
@endsection

@section('modals')

    @if($popup_model->status == 1)
        @include('frontend.include.offermodal')
    @endif

    @include('frontend.include.quickview', ['products' => $products])

@endsection

@section('content')
    @include('frontend.auth.frontMessage')
    <section class="home-slider position-relative pt-50">
        <div class="hero-slider-1 dot-style-1 dot-style-1-position-1">
            @if($homeSettings->status == 1)
                <div class="single-hero-slider single-animation-wrap">
                <div class="container">
                    <div class="row align-items-center slider-animated-1">
                        <div class="col-lg-5 col-md-6">
                            <div class="hero-slider-content-2">
                                <h4 class="animated" style="color: {{ $homeSettings->color }};">{{ $homeSettings->title }}</h4>
                                <h2 class="animated fw-900" style="color: {{ $homeSettings->color }};">{{ $homeSettings->subtitle }}</h2>
                                <h1 class="animated fw-900 text-brand" style="color: {{ $homeSettings->detailsColor }};">{{ $homeSettings->details }}</h1>
                                <p class="animated" style="color: {{ $homeSettings->color }};">{{ $homeSettings->description }}</p>
                                <a class="animated btn btn-brush btn-brush-3" href="{{ $homeSettings->offerLink }}">  {{ $homeSettings->offerText }} </a>
                            </div>
                        </div>
                        <div class="col-lg-7 col-md-6">
                            <div class="single-slider-img single-slider-img-1">
                                <img class="animated slider-1-1" src="{{ asset($homeSettings->image) }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            @if($slider2->status == 1)
                <div class="single-hero-slider single-animation-wrap">
                        <div class="container">
                            <div class="row align-items-center slider-animated-1">
                                <div class="col-lg-5 col-md-6">
                                    <div class="hero-slider-content-2">
                                        <h4 class="animated" style="color: {{ $slider2->color }};">{{ $slider2->title }}</h4>
                                        <h2 class="animated fw-900" style="color: {{ $slider2->color }};">{{ $slider2->subtitle }}</h2>
                                        <h1 class="animated fw-900 text-brand" style="color: {{ $slider2->detailsColor }};">{{ $slider2->details }}</h1>
                                        <p class="animated" style="color: {{ $slider2->color }};">{{ $slider2->description }}</p>
                                        <a class="animated btn btn-brush btn-brush-3" href="{{ $slider2->offerLink }}">  {{ $slider2->offerText }} </a>
                                    </div>
                                </div>
                                <div class="col-lg-7 col-md-6">
                                    <div class="single-slider-img single-slider-img-1">
                                        <img class="animated slider-1-1" src="{{ asset($slider2->image) }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            @endif

            @if($slider3->status == 1)
                <div class="single-hero-slider single-animation-wrap">
                        <div class="container">
                            <div class="row align-items-center slider-animated-1">
                                <div class="col-lg-5 col-md-6">
                                    <div class="hero-slider-content-2">
                                        <h4 class="animated" style="color: {{ $slider3->color }};">{{ $slider3->title }}</h4>
                                        <h2 class="animated fw-900" style="color: {{ $slider3->color }};">{{ $slider3->subtitle }}</h2>
                                        <h1 class="animated fw-900 text-brand" style="color: {{ $slider3->detailsColor }};">{{ $slider3->details }}</h1>
                                        <p class="animated" style="color: {{ $slider3->color }};">{{ $slider3->description }}</p>
                                        <a class="animated btn btn-brush btn-brush-3" href="{{ $slider3->offerLink }}">  {{ $slider3->offerText }} </a>
                                    </div>
                                </div>
                                <div class="col-lg-7 col-md-6">
                                    <div class="single-slider-img single-slider-img-1">
                                        <img class="animated slider-1-1" src="{{ asset($slider3->image) }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            @endif

        </div>
        <div class="slider-arrow hero-slider-1-arrow"></div>
    </section>
    <section class="popular-categories section-padding mt-15 mb-25">
        <div class="container wow fadeIn animated">
            <h3 class="section-title mb-20"><span>Popular</span> Categories1</h3>
            <div class="owl-carousel slider_carousel">
{{--                <div class="slider-arrow slider-arrow-2 carausel-6-columns-arrow" id="carausel-6-columns-arrows"></div>--}}
{{--                <div class="carausel-6-columns" id="carausel-6-columns">--}}
                    @foreach($sub_category as $sub_categoryHome)
                        <div class="card-1">
                            <figure class=" img-hover-scale overflow-hidden">
                                <a href="{{ route('subCategoryProduct', $sub_categoryHome->slug) }}"><img src="{{ asset($sub_categoryHome->image) }}"></a>
                            </figure>
                            <h5><a href="{{ route('subCategoryProduct', $sub_categoryHome->slug) }}">{{ $sub_categoryHome->name }}</a></h5>
                        </div>
                    @endforeach
{{--                </div>--}}
            </div>
        </div>
    </section>
    <section class="section-padding"  >
        <div class="container pt-25 pb-25">
            <div class="heading-tab d-flex">
                <div class="heading-tab-left wow fadeIn animated">
                    <h3 class="section-title mb-20"><span>@if(isset($category1products)) {{ $category1products->name }} @else No Category Selected @endif</span> Best Sell</h3>
                </div>
                <div class="heading-tab-right wow fadeIn animated">
                    <ul class="nav nav-tabs right no-border" id="myTab-1" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="nav-tab-one-1" data-bs-toggle="tab" data-bs-target="#tab-one-1" type="button" role="tab" aria-controls="tab-one" aria-selected="true">Featured</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="nav-tab-three-1" data-bs-toggle="tab" data-bs-target="#tab-three-1" type="button" role="tab" aria-controls="tab-three" aria-selected="false">New added</button>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="row">
                @if($offer8->status == 1)
                    <div class="col-lg-3 d-none d-lg-flex">
                        <div class="banner-img style-2 wow fadeIn animated">
                            <img src="{{ asset($offer8->image) }}" alt="">
                            <div class="banner-text">
                                <span>{{ $offer8->title }}</span>
                                <h4 class="mt-5 w-75">{{ $offer8->details }}</h4>
                                <a href="{{ $offer8->offerLink }}" class="text-white">Shop Now <i class="fi-rs-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="@if($offer8->status == 1) col-lg-9 @else col-lg-12 @endif">
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="tab-content wow fadeIn animated" id="myTabContent-1">
                                <div class="tab-pane fade show active" id="tab-one-1" role="tabpanel" aria-labelledby="tab-one-1">
                                    <div class="owl-carousel slider_carousel">
{{--                                        <div class="slider-arrow slider-arrow-2 carausel-4-columns-arrow arrow-left-extra" id="carausel-4-columns-arrows"></div>--}}
{{--                                        <div class="carausel-4-columns carausel-arrow-center" id="carausel-4-columns">--}}
                                            @if(isset($category1products))
                                                @foreach($category1products->product->where('status',1)->where('is_featured', 'YES')->take(8) as $products)
                                                    <div class="product-cart-wrap">
                                                        <div class="product-img-action-wrap">
                                                            <div class="product-img product-img-zoom">
                                                                <a href="{{ route('products',$products->slug) }}">
                                                                    <img class="default-img" src="{{ asset($products->featured_image) }}" alt="">
                                                                    @foreach($products->productGallery->take(1) as $images)
                                                                        <img class="hover-img" src="{{ asset( $images->images ) }}">
                                                                    @endforeach
                                                                </a>
                                                            </div>
                                                            <div class="product-action-1">
                                                                <a aria-label="Quick view" class="action-btn small hover-up" data-bs-toggle="modal" data-bs-target="#quickViewModal{{ $products->id }}">
                                                                    <i class="fi-rs-eye"></i></a>
                                                                <a
                                                                    @if(auth()->check())
                                                                    @if( $products->wishlist->where('user_id', $userId)->first())
                                                                    aria-label="Remove from Wishlist"
                                                                    @else
                                                                    aria-label="Add To Wishlist"
                                                                    @endif
                                                                    @else
                                                                    @if(in_array($products->id, session()->get('wishlist', [])))
                                                                    aria-label="Remove from Wishlist"
                                                                    @else
                                                                    aria-label="Add To Wishlist"
                                                                    @endif
                                                                    @endif
                                                                    onclick="addToWishlist({{$products->id}}, this)" class="action-btn small hover-up" href="javascript:void(0)">
                                                                    <!-- Check if product is in wishlist -->
                                                                    @if(auth()->check())
                                                                        @if( $products->wishlist->where('user_id', $userId)->first())
                                                                            <i id="wishlist-icon-{{$products->id}}" class="bi bi-heart-fill"></i>
                                                                        @else
                                                                            <i id="wishlist-icon-{{$products->id}}" class="bi bi-heart"></i>
                                                                        @endif
                                                                    @else
                                                                        @if(in_array($products->id, session()->get('wishlist', [])))
                                                                            <i id="wishlist-icon-{{$products->id}}" class="bi bi-heart-fill"></i>
                                                                        @else
                                                                            <i id="wishlist-icon-{{$products->id}}" class="bi bi-heart"></i>
                                                                        @endif
                                                                    @endif
                                                                </a>
                                                            </div>

                                                            <div class="product-badges product-badges-position product-badges-mrg">
                                                                    <span class="hot">Hot</span>
                                                            </div>
                                                        </div>
                                                        <div class="product-content-wrap">
                                                            <div class="product-category">
                                                                <a href="{{ route('subCategoryProduct', $products->subCategory->slug) }}">{{ $products->subCategory->name }}</a>
                                                            </div>
                                                            <h2><a href="{{ route('products',$products->slug) }}">{{ $products->name }}</a></h2>
                                                            <div class="product-rate-cover ">
                                                                <div class="product-rate d-inline-block">
                                                                    <div class="product-rating" style="width:{{$products->ratings->where('status',1)->avg('rating') * 20}}%">
                                                                    </div>
                                                                </div>
                                                                <span class="font-small ml-5 text-muted"> {{$products->ratings->where('status',1)->count()}}</span>
                                                            </div>
                                                            <div class="product-price">
                                                                <span>{{ $products->price }} Tk</span>
                                                                @if(isset($products->compare_price))
                                                                    <span class="old-price">{{ $products->compare_price }} Tk</span>
                                                                @endif
                                                            </div>
                                                            <div class="product-action-1 show">
                                                                @if($products->track_qty == 'YES')
                                                                    @if($products->qty > 0)
                                                                        @if(!empty($products->colors) || !empty($products->sizes))
                                                                            <a aria-label="Select options" class="action-btn hover-up" href="{{ route('products', $products->slug) }}"> <i class="fi-rs-shopping-bag-add"></i> </a>
                                                                        @else
                                                                            <form method="POST" action="{{ route('addToCart', $products->id) }}" id="addToCartForm">
                                                                                @csrf
                                                                                <input name="quantity" value="1" type="hidden">
                                                                                <button type="button" aria-label="Add To Cart" onclick="submitForm(this)" class="action-btn hover-up"><i class="fi-rs-shopping-bag-add"></i></button>
                                                                            </form>
                                                                        @endif
                                                                    @else
                                                                        <button aria-label="Out of Stock !" class="action-btn hover-up stock-out">  <i class="fi-rs-shopping-bag-add"></i> </button>
                                                                    @endif

                                                                @else
                                                                    @if(!empty($products->colors) || !empty($products->sizes))
                                                                        <a aria-label="Select options" class="action-btn hover-up" href="{{ route('products', $products->slug) }}"> <i class="fi-rs-shopping-bag-add"></i> </a>
                                                                    @else
                                                                        <form method="POST" action="{{ route('addToCart', $products->id) }}" id="addToCartForm">
                                                                            @csrf
                                                                            <input name="quantity" value="1" type="hidden">
                                                                            <button type="button" aria-label="Add To Cart" onclick="submitForm(this)" class="action-btn hover-up"><i class="fi-rs-shopping-bag-add"></i></button>
                                                                        </form>
                                                                    @endif
                                                                @endif

                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @else
                                                <h5>No Products in this Category</h5>
                                            @endif
{{--                                        </div>--}}
                                    </div>
                                </div>
                                <!--End tab-pane-->
                                <div class="tab-pane fade" id="tab-three-1" role="tabpanel" aria-labelledby="tab-three-1">
                                    <div class="owl-carousel slider_carousel">
{{--                                        <div class="slider-arrow slider-arrow-2 carausel-4-columns-arrow" id="carausel-4-columns-3-arrows"></div>--}}
{{--                                        <div class="carausel-4-columns carausel-arrow-center" id="carausel-4-columns-3">--}}
                                            @if(isset($category1products))
                                                @foreach($category1products->product->where('status',1)->sortByDesc('created_at')->take(8) as $products)
                                                    <div class="product-cart-wrap">
                                                        <div class="product-img-action-wrap">
                                                            <div class="product-img product-img-zoom">
                                                                <a href="{{ route('products',$products->slug) }}">
                                                                    <img class="default-img" src="{{ asset($products->featured_image) }}" alt="">
                                                                    @foreach($products->productGallery->take(1) as $images)
                                                                        <img class="hover-img" src="{{ asset( $images->images ) }}">
                                                                    @endforeach
                                                                </a>
                                                            </div>
                                                            <div class="product-action-1">
                                                                <a aria-label="Quick view" class="action-btn small hover-up" data-bs-toggle="modal" data-bs-target="#quickViewModal{{ $products->id }}">
                                                                    <i class="fi-rs-eye"></i></a>
                                                                <a
                                                                    @if(auth()->check())
                                                                    @if( $products->wishlist->where('user_id', $userId)->first())
                                                                    aria-label="Remove from Wishlist"
                                                                    @else
                                                                    aria-label="Add To Wishlist"
                                                                    @endif
                                                                    @else
                                                                    @if(in_array($products->id, session()->get('wishlist', [])))
                                                                    aria-label="Remove from Wishlist"
                                                                    @else
                                                                    aria-label="Add To Wishlist"
                                                                    @endif
                                                                    @endif
                                                                    onclick="addToWishlist({{$products->id}}, this)" class="action-btn small hover-up" href="javascript:void(0)">
                                                                    <!-- Check if product is in wishlist -->
                                                                    @if(auth()->check())
                                                                        @if( $products->wishlist->where('user_id', $userId)->first())
                                                                            <i id="wishlist-icon-{{$products->id}}" class="bi bi-heart-fill"></i>
                                                                        @else
                                                                            <i id="wishlist-icon-{{$products->id}}" class="bi bi-heart"></i>
                                                                        @endif
                                                                    @else
                                                                        @if(in_array($products->id, session()->get('wishlist', [])))
                                                                            <i id="wishlist-icon-{{$products->id}}" class="bi bi-heart-fill"></i>
                                                                        @else
                                                                            <i id="wishlist-icon-{{$products->id}}" class="bi bi-heart"></i>
                                                                        @endif
                                                                    @endif
                                                                </a>
                                                            </div>

                                                            <div class="product-badges product-badges-position product-badges-mrg">
                                                                <span class="hot">Hot</span>
                                                            </div>
                                                        </div>
                                                        <div class="product-content-wrap">
                                                            <div class="product-category">
                                                                <a href="{{ route('subCategoryProduct', $products->subCategory->slug) }}">{{ $products->subCategory->name }}</a>
                                                            </div>
                                                            <h2><a href="{{ route('products',$products->slug) }}">{{ $products->name }}</a></h2>
                                                            <div class="product-rate-cover ">
                                                                <div class="product-rate d-inline-block">
                                                                    <div class="product-rating" style="width:{{$products->ratings->where('status',1)->avg('rating') * 20}}%">
                                                                    </div>
                                                                </div>
                                                                <span class="font-small ml-5 text-muted"> {{$products->ratings->where('status',1)->count()}}</span>
                                                            </div>
                                                            <div class="product-price">
                                                                <span>{{ $products->price }} Tk</span>
                                                                @if(isset($products->compare_price))
                                                                    <span class="old-price">{{ $products->compare_price }} Tk</span>
                                                                @endif
                                                            </div>
                                                            <div class="product-action-1 show">
                                                                @if($products->track_qty == 'YES')
                                                                    @if($products->qty > 0)
                                                                        @if(!empty($products->colors) || !empty($products->sizes))
                                                                            <a aria-label="Select options" class="action-btn hover-up" href="{{ route('products', $products->slug) }}"> <i class="fi-rs-shopping-bag-add"></i> </a>
                                                                        @else
                                                                            <form method="POST" action="{{ route('addToCart', $products->id) }}" id="addToCartForm">
                                                                                @csrf
                                                                                <input name="quantity" value="1" type="hidden">
                                                                                <button type="button" aria-label="Add To Cart" onclick="submitForm(this)" class="action-btn hover-up"><i class="fi-rs-shopping-bag-add"></i></button>
                                                                            </form>
                                                                        @endif
                                                                    @else
                                                                        <button aria-label="Out of Stock !" class="action-btn hover-up stock-out">  <i class="fi-rs-shopping-bag-add"></i> </button>
                                                                    @endif

                                                                @else
                                                                    @if(!empty($products->colors) || !empty($products->sizes))
                                                                        <a aria-label="Select options" class="action-btn hover-up" href="{{ route('products', $products->slug) }}"> <i class="fi-rs-shopping-bag-add"></i> </a>
                                                                    @else
                                                                        <form method="POST" action="{{ route('addToCart', $products->id) }}" id="addToCartForm">
                                                                            @csrf
                                                                            <input name="quantity" value="1" type="hidden">
                                                                            <button type="button" aria-label="Add To Cart" onclick="submitForm(this)" class="action-btn hover-up"><i class="fi-rs-shopping-bag-add"></i></button>
                                                                        </form>
                                                                    @endif
                                                                @endif

                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @else
                                                <h5>No Products in this Category</h5>
                                            @endif
{{--                                        </div>--}}
                                    </div>
                                </div>
                            </div>
                            <!--End tab-content-->
                        </div>
                    </div>
                </div>

                <!--End Col-lg-9-->
            </div>
        </div>
    </section>
    @if($offer2->status == 1)
        <section class="banner-2 section-padding pb-0">
            <div class="container">
                <div class="banner-img banner-big wow fadeIn animated f-none">
                    <img src="{{ asset($offer2->image) }}" alt="">
                    <div class="banner-text d-md-block d-none">
                        <h4 class="mb-15 mt-40 text-brand">{{ $offer2->title }}</h4>
                        <h1 class="fw-600 mb-20 w-75">{{ $offer2->details }}</h1>
                        <a href="{{ $offer2->offerLink }}" class="btn">Learn More <i class="fi-rs-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </section>
    @endif
    <section class="section-padding py-5">
        <div class="container wow fadeIn animated">
            <div class="tab-header">
                <h3 class="section-title mb-20"><span>@if(isset($category2products)) {{ $category2products->name }} @else No Category Selected @endif</span></h3>
                <a href="{{ route('categoryProduct',$category2products->slug ) }}" class="view-more d-none d-md-flex">View More<i class="fi-rs-angle-double-small-right"></i></a>
            </div>
            <div class="row">
                @if($offer9->status == 1)
                    <div class="col-lg-3 d-none d-lg-flex">
                        <div class="banner-img style-2 wow fadeIn animated">
                            <img src="{{ asset($offer9->image) }}" alt="">
                            <div class="banner-text">
                                <span>{{ $offer9->title }}</span>
                                <h4 class="mt-5 w-75">{{ $offer9->details }}</h4>
                                <a href="{{ $offer9->offerLink }}" class="text-white">Shop Now <i class="fi-rs-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="@if($offer9->status == 1) col-lg-9 @else col-lg-12 @endif">
                    <div class="row">
                        <div class="owl-carousel slider_carousel extraMObileSliderNewxt">
{{--                            <div class="slider-arrow slider-arrow-2 carausel-4-columns-arrow" id="carausel-4-columns-2-arrows"></div>--}}
{{--                            <div class="carausel-4-columns carausel-arrow-center" id="carausel-4-columns-2">--}}
                                @if(isset($category2products))
                                    @foreach($category2products->product->where('status',1)->where('is_featured', 'YES') as $products)
                                        <div class="product-cart-wrap">
                                            <div class="product-img-action-wrap">
                                                <div class="product-img product-img-zoom">
                                                    <a href="{{ route('products',$products->slug) }}">
                                                        <img class="default-img" src="{{ asset($products->featured_image) }}" alt="">
                                                        @foreach($products->productGallery->take(1) as $images)
                                                            <img class="hover-img" src="{{ asset( $images->images ) }}">
                                                        @endforeach
                                                    </a>
                                                </div>
                                                <div class="product-action-1">
                                                    <a aria-label="Quick view" class="action-btn small hover-up" data-bs-toggle="modal" data-bs-target="#quickViewModal{{ $products->id }}">
                                                        <i class="fi-rs-eye"></i></a>
                                                    <a
                                                        @if(auth()->check())
                                                        @if( $products->wishlist->where('user_id', $userId)->first())
                                                        aria-label="Remove from Wishlist"
                                                        @else
                                                        aria-label="Add To Wishlist"
                                                        @endif
                                                        @else
                                                        @if(in_array($products->id, session()->get('wishlist', [])))
                                                        aria-label="Remove from Wishlist"
                                                        @else
                                                        aria-label="Add To Wishlist"
                                                        @endif
                                                        @endif
                                                        onclick="addToWishlist({{$products->id}}, this)" class="action-btn small hover-up" href="javascript:void(0)">
                                                        <!-- Check if product is in wishlist -->
                                                        @if(auth()->check())
                                                            @if( $products->wishlist->where('user_id', $userId)->first())
                                                                <i id="wishlist-icon-{{$products->id}}" class="bi bi-heart-fill"></i>
                                                            @else
                                                                <i id="wishlist-icon-{{$products->id}}" class="bi bi-heart"></i>
                                                            @endif
                                                        @else
                                                            @if(in_array($products->id, session()->get('wishlist', [])))
                                                                <i id="wishlist-icon-{{$products->id}}" class="bi bi-heart-fill"></i>
                                                            @else
                                                                <i id="wishlist-icon-{{$products->id}}" class="bi bi-heart"></i>
                                                            @endif
                                                        @endif
                                                    </a>
                                                </div>

                                                <div class="product-badges product-badges-position product-badges-mrg">
                                                    <span class="hot">Hot</span>
                                                </div>
                                            </div>
                                            <div class="product-content-wrap">
                                                <div class="product-category">
                                                    <a href="{{ route('subCategoryProduct', $products->subCategory->slug) }}">{{ $products->subCategory->name }}</a>
                                                </div>
                                                <h2><a href="{{ route('products',$products->slug) }}">{{ $products->name }}</a></h2>
                                                <div class="product-rate-cover ">
                                                    <div class="product-rate d-inline-block">
                                                        <div class="product-rating" style="width:{{$products->ratings->where('status',1)->avg('rating') * 20}}%">
                                                        </div>
                                                    </div>
                                                    <span class="font-small ml-5 text-muted"> {{$products->ratings->where('status',1)->count()}}</span>
                                                </div>
                                                <div class="product-price">
                                                    <span>{{ $products->price }} Tk</span>
                                                    @if(isset($products->compare_price))
                                                        <span class="old-price">{{ $products->compare_price }} Tk</span>
                                                    @endif
                                                </div>
                                                <div class="product-action-1 show">
                                                    @if($products->track_qty == 'YES')
                                                        @if($products->qty > 0)
                                                            @if(!empty($products->colors) || !empty($products->sizes))
                                                                <a aria-label="Select options" class="action-btn hover-up" href="{{ route('products', $products->slug) }}"> <i class="fi-rs-shopping-bag-add"></i> </a>
                                                            @else
                                                                <form method="POST" action="{{ route('addToCart', $products->id) }}" id="addToCartForm">
                                                                    @csrf
                                                                    <input name="quantity" value="1" type="hidden">
                                                                    <button type="button" aria-label="Add To Cart" onclick="submitForm(this)" class="action-btn hover-up"><i class="fi-rs-shopping-bag-add"></i></button>
                                                                </form>
                                                            @endif
                                                        @else
                                                            <button aria-label="Out of Stock !" class="action-btn hover-up stock-out">  <i class="fi-rs-shopping-bag-add"></i> </button>
                                                        @endif

                                                    @else
                                                        @if(!empty($products->colors) || !empty($products->sizes))
                                                            <a aria-label="Select options" class="action-btn hover-up" href="{{ route('products', $products->slug) }}"> <i class="fi-rs-shopping-bag-add"></i> </a>
                                                        @else
                                                            <form method="POST" action="{{ route('addToCart', $products->id) }}" id="addToCartForm">
                                                                @csrf
                                                                <input name="quantity" value="1" type="hidden">
                                                                <button type="button" aria-label="Add To Cart" onclick="submitForm(this)" class="action-btn hover-up"><i class="fi-rs-shopping-bag-add"></i></button>
                                                            </form>
                                                        @endif
                                                    @endif

                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <h5>No Products in this Category</h5>
                            @endif
{{--                            </div>--}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="banners mb-15">
        <div class="container">
            <div class="row">

                @if($offer3->status == 1)
                    <div class="col-lg-4 col-md-6">
                        <div class="banner-img wow fadeIn animated">
                            <img src="{{ asset( $offer3->image) }}" alt="">
                            <div class="banner-text">
                                <span>{{ $offer3->title }}</span>
                                <h4 class="w-75">{{ $offer3->details}}</h4>
                                <a href="{{ $offer3->offerLink }}">Shop Now <i class="fi-rs-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                @endif

                @if($offer4->status == 1)
                    <div class="col-lg-4 col-md-6">
                        <div class="banner-img wow fadeIn animated">
                            <img src="{{ asset($offer4->image) }}" alt="">
                            <div class="banner-text">
                                <span>{{ $offer4->title }}</span>
                                <h4 class="w-75">{{ $offer4->details }}</h4>
                                <a href="{{ $offer4->offerLink }}">Shop Now <i class="fi-rs-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                @endif

                @if($offer5->status == 1)
                    <div class="col-lg-4 d-md-none d-lg-flex">
                        <div class="banner-img wow fadeIn animated  mb-sm-0">
                            <img src="{{ asset($offer5->image) }}" alt="">
                            <div class="banner-text">
                                <span>{{ $offer5->title }}</span>
                                <h4 class="w-75">{{ $offer5->details }}</h4>
                                <a href="{{ $offer5->offerLink }}">Shop Now <i class="fi-rs-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </section>
    <section class="py-5">
        <div class="card_wrapper">
            <div class="container">
                <div class="tab-header">
                    <h3 class="section-title mb-20"><span>@if(isset($category3products)) {{ $category3products->name }} @else No Category Selected @endif</span></h3>
                    <a href="{{ route('categoryProduct',$category3products->slug ) }}" class="view-more d-none d-md-flex">View More<i class="fi-rs-angle-double-small-right"></i></a>
                </div>
                <div class="row">
                    @if($offer10->status == 1)
                        <div class="col-lg-3 d-none d-lg-flex">
                            <div class="banner-img style-2 wow fadeIn animated">
                                <img src="{{ asset($offer10->image) }}" alt="">
                                <div class="banner-text">
                                    <span>{{ $offer10->title }}</span>
                                    <h4 class="mt-5 w-75">{{ $offer10->details }}</h4>
                                    <a href="{{ $offer10->offerLink }}" class="text-white">Shop Now <i class="fi-rs-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="@if($offer10->status == 1) col-lg-9 @else col-lg-12 @endif">
                        <div class="owl-carousel slider_carousel">
                            @if(isset($category3products))
                                @foreach($category3products->product->where('status',1)->where('is_featured', 'YES') as $products)
                                    <div class="product-cart-wrap">
                                        <div class="product-img-action-wrap">
                                            <div class="product-img product-img-zoom">
                                                <a href="{{ route('products',$products->slug) }}">
                                                    <img class="default-img" src="{{ asset($products->featured_image) }}" alt="">
                                                    @foreach($products->productGallery->take(1) as $images)
                                                        <img class="hover-img" src="{{ asset( $images->images ) }}">
                                                    @endforeach
                                                </a>
                                            </div>
                                            <div class="product-action-1">
                                                <a aria-label="Quick view" class="action-btn small hover-up" data-bs-toggle="modal" data-bs-target="#quickViewModal{{ $products->id }}">
                                                    <i class="fi-rs-eye"></i></a>
                                                <a
                                                    @if(auth()->check())
                                                    @if( $products->wishlist->where('user_id', $userId)->first())
                                                    aria-label="Remove from Wishlist"
                                                    @else
                                                    aria-label="Add To Wishlist"
                                                    @endif
                                                    @else
                                                    @if(in_array($products->id, session()->get('wishlist', [])))
                                                    aria-label="Remove from Wishlist"
                                                    @else
                                                    aria-label="Add To Wishlist"
                                                    @endif
                                                    @endif
                                                    onclick="addToWishlist({{$products->id}}, this)" class="action-btn small hover-up" href="javascript:void(0)">
                                                    <!-- Check if product is in wishlist -->
                                                    @if(auth()->check())
                                                        @if( $products->wishlist->where('user_id', $userId)->first())
                                                            <i id="wishlist-icon-{{$products->id}}" class="bi bi-heart-fill"></i>
                                                        @else
                                                            <i id="wishlist-icon-{{$products->id}}" class="bi bi-heart"></i>
                                                        @endif
                                                    @else
                                                        @if(in_array($products->id, session()->get('wishlist', [])))
                                                            <i id="wishlist-icon-{{$products->id}}" class="bi bi-heart-fill"></i>
                                                        @else
                                                            <i id="wishlist-icon-{{$products->id}}" class="bi bi-heart"></i>
                                                        @endif
                                                    @endif
                                                </a>
                                            </div>

                                            <div class="product-badges product-badges-position product-badges-mrg">
                                                <span class="hot">Hot</span>
                                            </div>
                                        </div>
                                        <div class="product-content-wrap">
                                            <div class="product-category">
                                                <a href="{{ route('subCategoryProduct', $products->subCategory->slug) }}">{{ $products->subCategory->name }}</a>
                                            </div>
                                            <h2><a href="{{ route('products',$products->slug) }}">{{ $products->name }}</a></h2>
                                            <div class="product-rate-cover ">
                                                <div class="product-rate d-inline-block">
                                                    <div class="product-rating" style="width:{{$products->ratings->where('status',1)->avg('rating') * 20}}%">
                                                    </div>
                                                </div>
                                                <span class="font-small ml-5 text-muted"> {{$products->ratings->where('status',1)->count()}}</span>
                                            </div>
                                            <div class="product-price">
                                                <span>{{ $products->price }} Tk</span>
                                                @if(isset($products->compare_price))
                                                    <span class="old-price">{{ $products->compare_price }} Tk</span>
                                                @endif
                                            </div>
                                            <div class="product-action-1 show">
                                                @if($products->track_qty == 'YES')
                                                    @if($products->qty > 0)
                                                        @if(!empty($products->colors) || !empty($products->sizes))
                                                            <a aria-label="Select options" class="action-btn hover-up" href="{{ route('products', $products->slug) }}"> <i class="fi-rs-shopping-bag-add"></i> </a>
                                                        @else
                                                            <form method="POST" action="{{ route('addToCart', $products->id) }}" id="addToCartForm">
                                                                @csrf
                                                                <input name="quantity" value="1" type="hidden">
                                                                <button type="button" aria-label="Add To Cart" onclick="submitForm(this)" class="action-btn hover-up"><i class="fi-rs-shopping-bag-add"></i></button>
                                                            </form>
                                                        @endif
                                                    @else
                                                        <button aria-label="Out of Stock !" class="action-btn hover-up stock-out">  <i class="fi-rs-shopping-bag-add"></i> </button>
                                                    @endif

                                                @else
                                                    @if(!empty($products->colors) || !empty($products->sizes))
                                                        <a aria-label="Select options" class="action-btn hover-up" href="{{ route('products', $products->slug) }}"> <i class="fi-rs-shopping-bag-add"></i> </a>
                                                    @else
                                                        <form method="POST" action="{{ route('addToCart', $products->id) }}" id="addToCartForm">
                                                            @csrf
                                                            <input name="quantity" value="1" type="hidden">
                                                            <button type="button" aria-label="Add To Cart" onclick="submitForm(this)" class="action-btn hover-up"><i class="fi-rs-shopping-bag-add"></i></button>
                                                        </form>
                                                    @endif
                                                @endif

                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <h5>No Products in this Category</h5>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="section-padding">
        <div class="container">
            <h3 class="section-title mb-20 wow fadeIn animated"><span>Featured</span> Brands</h3>
            <div class="owl-carousel slider_carousel">
{{--                <div class="slider-arrow slider-arrow-2 carausel-6-columns-arrow" id="carausel-6-columns-3-arrows"></div>--}}
{{--                <div class="carausel-6-columns text-center" id="carausel-6-columns-3">--}}
                    @foreach($brands as $brand)
                        <div class="brand-logo">
                            <img class="img-grey-hover" src="{{ asset($brand->image) }}" alt="">
                        </div>
                    @endforeach
{{--                </div>--}}
            </div>
        </div>
    </section>
    <section class="deals section-padding">
        <div class="container">
            <div class="row">

                @if($offer6->status == 1)
                    <div class="col-lg-6 deal-co">
                        <div class="deal wow fadeIn animated mb-md-4 mb-sm-4 mb-lg-0" style="background-image: url('{{ asset($offer6->image) }}');">
                            <div class="deal-top">
                                <h2 class="text-brand">{{ $offer6->title }}</h2>
                                <h5>{{ $offer6->subtitle }}</h5>
                            </div>
                            <div class="deal-content">
                                <h6 class="product-title"><a href="{{ $offer6->offerLink }}">{{ $offer6->details }}</a></h6>
                                <div class="product-price"><span class="new-price">${{ $offer6->price }}</span></div>
                            </div>
                            <div class="deal-bottom">
                                <p>Hurry Up! Offer End In:</p>
                                <div class="deals-countdown" data-countdown="{{ $offer6->offerTime }}"></div>
                                <a href="{{ $offer6->offerLink }}" class="btn hover-up">Shop Now <i class="fi-rs-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                @endif

                @if($offer7->status == 1)
                    <div class="col-lg-6 deal-co">
                        <div class="deal wow fadeIn animated" style="background-image: url('{{ asset($offer7->image) }}');">
                            <div class="deal-top">
                                <h2 class="text-brand">{{ $offer7->title }}</h2>
                                <h5>{{ $offer7->subtitle }}</h5>
                            </div>
                            <div class="deal-content">
                                <h6 class="product-title"><a href="{{ $offer7->offerLink }}">{{ $offer7->details }}</a></h6>
                                <div class="product-price"><span class="new-price">${{ $offer7->price }}</span></div>
                            </div>
                            <div class="deal-bottom">
                                <p>Hurry Up! Offer End In:</p>
                                <div class="deals-countdown" data-countdown="{{ $offer7->offerTime }}"></div>
                                <a href="{{ $offer7->offerLink }}" class="btn hover-up">Shop Now <i class="fi-rs-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </section>
    <section class="product-tabs section-padding position-relative wow fadeIn animated">
        <div class="bg-square"></div>
        <div class="container">
            <div class="tab-header">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="nav-tab-one" data-bs-toggle="tab" data-bs-target="#tab-one" type="button" role="tab" aria-controls="tab-one" aria-selected="true">Featured</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="nav-tab-two" data-bs-toggle="tab" data-bs-target="#tab-two" type="button" role="tab" aria-controls="tab-two" aria-selected="false">Popular</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="nav-tab-three" data-bs-toggle="tab" data-bs-target="#tab-three" type="button" role="tab" aria-controls="tab-three" aria-selected="false">New added</button>
                    </li>
                </ul>
                <a href="#" class="view-more d-none d-md-flex">View More<i class="fi-rs-angle-double-small-right"></i></a>
            </div>
            <!--End nav-tabs-->
            <div class="tab-content wow fadeIn animated" id="myTabContent">
                <div class="tab-pane fade show active" id="tab-one" role="tabpanel" aria-labelledby="tab-one">
                    <div class="row product-grid-4">
                        @if(isset($Products))
                            @foreach($Products->where('is_featured', 'YES')->take(8) as $product)
                                <div class="col-lg-3 col-md-4 col-12 col-sm-6">
                                    <div class="product-cart-wrap mb-30">
                                        <div class="product-img-action-wrap">
                                            <div class="product-img product-img-zoom">
                                                <a href="{{ route('products',$product->slug) }}">
                                                    <img class="default-img" src="{{ asset($product->featured_image) }}" alt="" height="280px">
                                                    @foreach($product->productGallery->take(1) as $image)
                                                        <img class="hover-img" src="{{ asset($image->images) }}" alt="" height="280px">
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
                                                <span>{{ $product->price }} Tk</span>
                                                @if(isset($product->compare_price))
                                                    <span class="old-price">{{ $product->compare_price }} Tk</span>
                                                @endif
                                            </div>
                                            <div class="product-action-1 show">
                                                @if($product->track_qty == 'YES')
                                                    @if($product->qty > 0)
                                                        @if(!empty($product->colors) || !empty($product->sizes))
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
                                                    @if(!empty($product->colors) || !empty($product->sizes))
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
                    <!--End product-grid-4-->
                </div>
                <!--En tab one (Featured)-->
                <div class="tab-pane fade" id="tab-two" role="tabpanel" aria-labelledby="tab-two">
                    <div class="row product-grid-4">
                        @foreach($mostOrderedProducts as $product)
                        <div class="col-lg-3 col-md-4 col-12 col-sm-6">
                            <div class="product-cart-wrap mb-30">
                                <div class="product-img-action-wrap">
                                    <div class="product-img product-img-zoom">
                                        <a href="{{ route('products',$product->slug) }}">
                                            <img class="default-img" src="{{ asset($product->featured_image) }}" alt="" height="280px">
                                            @foreach($product->productGallery->take(1) as $image)
                                                <img class="hover-img" src="{{ asset($image->images) }}" alt="" height="280px">
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
                                        <span>{{ $product->price }} Tk</span>
                                        @if(isset($product->compare_price))
                                            <span class="old-price">{{ $product->compare_price }} Tk</span>
                                        @endif
                                    </div>
                                    <div class="product-action-1 show">
                                        @if($product->track_qty == 'YES')
                                            @if($product->qty > 0)
                                                @if(!empty($product->colors) || !empty($product->sizes))
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
                                            @if(!empty($product->colors) || !empty($product->sizes))
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
                    </div>
                    <!--End product-grid-4-->
                </div>
                <!--En tab two (Popular)-->
                <div class="tab-pane fade" id="tab-three" role="tabpanel" aria-labelledby="tab-three">
                    <div class="row product-grid-4">
                        @if(isset($Products))
                            @foreach($Products->take(8) as $product)
                                <div class="col-lg-3 col-md-4 col-12 col-sm-6">
                                    <div class="product-cart-wrap mb-30">
                                        <div class="product-img-action-wrap">
                                            <div class="product-img product-img-zoom">
                                                <a href="{{ route('products',$product->slug) }}">
                                                    <img class="default-img" src="{{ asset($product->featured_image) }}" alt="" height="280px">
                                                    @foreach($product->productGallery->take(1) as $image)
                                                        <img class="hover-img" src="{{ asset($image->images) }}" alt="" height="280px">
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
                                                <span>{{ $product->price }} Tk</span>
                                                @if(isset($product->compare_price))
                                                    <span class="old-price">{{ $product->compare_price }} Tk</span>
                                                @endif
                                            </div>
                                            <div class="product-action-1 show">
                                                @if($product->track_qty == 'YES')
                                                    @if($product->qty > 0)
                                                        @if(!empty($product->colors) || !empty($product->sizes))
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
                                                    @if(!empty($product->colors) || !empty($product->sizes))
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
                    <!--End product-grid-4-->
                </div>
                <!--En tab three (New added)-->
            </div>
            <!--End tab-content-->
        </div>
    </section>
    <section class="featured section-padding position-relative">
        <div class="container">
            <div class="row">
                <div class="col-lg-2 col-md-4 mb-md-3 mb-lg-0">
                    <div class="banner-features wow fadeIn animated hover-up">
                        <img src="{{ asset('frontend-assets') }}/imgs/theme/icons/feature-1.png" alt="">
                        <h4 class="bg-1">Free Shipping</h4>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 mb-md-3 mb-lg-0">
                    <div class="banner-features wow fadeIn animated hover-up">
                        <img src="{{ asset('frontend-assets') }}/imgs/theme/icons/feature-2.png" alt="">
                        <h4 class="bg-3">Online Order</h4>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 mb-md-3 mb-lg-0">
                    <div class="banner-features wow fadeIn animated hover-up">
                        <img src="{{ asset('frontend-assets') }}/imgs/theme/icons/feature-3.png" alt="">
                        <h4 class="bg-2">Save Money</h4>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 mb-md-3 mb-lg-0">
                    <div class="banner-features wow fadeIn animated hover-up">
                        <img src="{{ asset('frontend-assets') }}/imgs/theme/icons/feature-4.png" alt="">
                        <h4 class="bg-4">Promotions</h4>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 mb-md-3 mb-lg-0">
                    <div class="banner-features wow fadeIn animated hover-up">
                        <img src="{{ asset('frontend-assets') }}/imgs/theme/icons/feature-5.png" alt="">
                        <h4 class="bg-5">Happy Sell</h4>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 mb-md-3 mb-lg-0">
                    <div class="banner-features wow fadeIn animated hover-up">
                        <img src="{{ asset('frontend-assets') }}/imgs/theme/icons/feature-6.png" alt="">
                        <h4 class="bg-6">24/7 Support</h4>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection


@section('customJs')
    <script>

        function slider_carouselInit() {
            $('.owl-carousel.slider_carousel').owlCarousel({
                dots: false,
                loop: true,
                margin: 30,
                stagePadding: 2,
                autoplay: true,
                nav: true,
                navText: ["<i class='bi bi-chevron-left'></i>","<i class='bi bi-chevron-right'></i>"],
                autoplayTimeout: 4500,
                autoplayHoverPause: true,
                responsive: {
                    0: {
                        items: 1
                    },
                    768: {
                        items: 2,
                    },
                    992: {
                        items: 4
                    }
                }
            });
        }
        slider_carouselInit();

    </script>
@endsection
