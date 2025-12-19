@extends('frontend.master')

@section('title')
    {{ $siteSettings->title }} | {{ $product->slug }}
@endsection

@section('content')
    <div class="page-header breadcrumb-wrap">
        <div class="container">
            <div class="breadcrumb">
                <a href="{{ route('home') }}" rel="nofollow">Home</a>
                <span></span> <a href="{{ route('categoryProduct',$product->category->slug) }}">{{ $product->category->name }}</a>
                <span></span> <a href="{{ route('subCategoryProduct',$product->subCategory->slug) }}">{{ $product->subCategory->name }}</a>
                <span></span> {{ $product->name }}
            </div>
        </div>
    </div>
    <section class="mt-50 mb-50">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="product-detail accordion-detail">
                        <div class="row mb-50">
                            <div class="col-md-6 col-sm-12 col-xs-12">
                                <div class="detail-gallery">
                                    <span class="zoom-icon"><i class="fi-rs-search"></i></span>
                                    <!-- MAIN SLIDES -->
                                    <div class="product-image-slider">
                                        <figure class="border-radius-10">
                                            <img src="{{asset($product->featured_image)}}" width="100%">
                                        </figure>
                                        @if($product->productGallery->isNotEmpty())
                                            @foreach($product->productGallery as $images)
                                        <figure class="border-radius-10">
                                            <img src="{{asset($images->images)}}" width="100%">
                                        </figure>
                                            @endforeach
                                        @endif

                                    </div>
                                    <!-- THUMBNAILS -->
                                    <div class="slider-nav-thumbnails pl-15 pr-15">
                                        <div><img src="{{asset($product->featured_image)}}" width="100%"></div>
                                        @if($product->productGallery->isNotEmpty())
                                            @foreach($product->productGallery as $images)
                                                <figure class="border-radius-10">
                                                    <div><img src="{{asset($images->images)}}" width="100%"></div>
                                                </figure>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                                <!-- End Gallery -->
                            </div>
                            <div class="col-md-6 col-sm-12 col-xs-12">
                                <div class="detail-info">
                                    <h2 class="title-detail">{{ $product->name }}</h2>
                                    <div class="product-detail-rating">
                                        <div class="pro-details-brand">
                                            <span> Brands: <a href="">{{ $product->brand->name }}</a></span>
                                        </div>
                                        <div class="product-rate-cover text-end">
                                            <div class="product-rate d-inline-block">
                                                <div class="product-rating" style="width:{{$product->ratings->where('status',1)->avg('rating') * 20}}%">
                                                </div>
                                            </div>
                                            <span class="font-small ml-5 text-muted"> ({{$product->ratings->where('status',1)->count()}} reviews)</span>
                                        </div>
                                    </div>
                                    <div class="sf-column product-card">
                                        <div class="sf__pcard sf__pcard--onsale cursor-pointer sf-prod__block sf__pcard-style-4" data-view="card"
                                            data-product-id="8766631903454">
                                            <div class="text-left">
                                                <div class="mt-3 lg:mt-5">
                                                    <div class="sf__pcard-price leading-normal">
                                                        <div class="f-price inline-flex justify-content-start flex-wrap f-price--on-sale text-left">
                                                        
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
                                                                    <span class="text-muted text-decoration-line-through  originalPrice">
                                                                        {{ number_format($minOriginal) }} - {{ number_format($maxOriginal) }}
                                                                    </span>
                                                                    
                                                                    <span class="fw-bold  sellingPrice">
                                                                        {{ number_format($minSelling) }} - {{ number_format($maxSelling) }} BDT
                                                                    </span>
                                                                @else
                                                                    <span class="fw-bold sellingPrice">
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
                                                                    <span class="text-muted text-decoration-line-through  originalPrice">
                                                                        {{ number_format($product->price) }}
                                                                    </span>
                                                                    
                                                                    <span class="fw-bold  sellingPrice">
                                                                        {{ number_format($product->compare_price) }} BDT
                                                                    </span>
                                                                @else
                                                                    <span class="fw-bold  sellingPrice">
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
                                                        <div class="sf__pcard-action-atc flex justify-start mt-2">
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


                                    <ul class="product-meta font-xs color-grey mt-50">
                                        <li class="mb-5">SKU:{{ $product->sku }} <a href="#"></a></li>
                                        {{-- <li>Availability:<span class="in-stock text-success ml-5">{{$product->qty}} Items In Stock</span></li> --}}
                                        <div class="social-icons single-share mt-2">
                                            <ul class="text-grey-5 d-inline-block">
                                                <li><strong class="mr-10">Share this:</strong></li>
                                                <li class="social-facebook"><a href="#"><img src="{{asset('frontend-assets')}}/imgs/theme/icons/icon-facebook.svg" alt=""></a></li>
                                                <li class="social-twitter"> <a href="#"><img src="{{asset('frontend-assets')}}/imgs/theme/icons/icon-twitter.svg" alt=""></a></li>
                                                <li class="social-instagram"><a href="#"><img src="{{asset('frontend-assets')}}/imgs/theme/icons/icon-instagram.svg" alt=""></a></li>
                                                <li class="social-linkedin"><a href="#"><img src="{{asset('frontend-assets')}}/imgs/theme/icons/icon-pinterest.svg" alt=""></a></li>
                                            </ul>
                                        </div>
                                    </ul>
                                </div>
                                <!-- Detail Info -->
                            </div>
                        </div>
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">Description</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">Additional Information</button>
                            </li>
                            
                            @if(isset($product->subCategory->size_chart))
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact-tab-pane" type="button" role="tab" aria-controls="contact-tab-pane" aria-selected="false">Size Chart</button>
                            </li>
                            @endif
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                                <h3 class="section-title style-1 mb-30">Description</h3>
                                <div class="description mb-50">
                                    {!! $product->full_desc !!}
                                </div>
                            </div>
                            <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                                <h3 class="section-title style-1 mb-30">Additional info</h3>
                                <table class="font-md mb-30">
                                    <tbody>
                                    @foreach($product->productAdditionalInfo as $info)
                                        <tr class="stand-up">
                                            <th>{{ $info->option }}</th>
                                            <td>
                                                <p>{{ $info->optionValue }}</p>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @if(isset($product->subCategory->size_chart))
                            <div class="tab-pane fade" id="contact-tab-pane" role="tabpanel" aria-labelledby="contact-tab" tabindex="0">
                                <h3 class="section-title style-1 mb-30">Size Chart</h3>
                                @if(isset($product->subCategory->size_chart))
                                    <img src="{{ asset($product->subCategory->size_chart) }}">
                                @else
                                    No Size Chart Available For this Product
                                @endif
                            </div>
                            @endif
                        </div>
                        <div class="row">
                            <div class="col-lg-12 m-auto entry-main-content">
                                <h3 class="section-title style-1 mb-30 mt-30">Reviews ({{ $product->ratings->where('status',1)->count() }})</h3>
                                <!--Comments-->
                                <div class="comments-area style-2">
                                    <div class="row">
                                        <div class="col-lg-8">
                                            <h4 class="mb-30">Customer Reviews</h4>
                                            <div class="comment-list">
                                            @if($product->ratings->where('status',1)->isNotEmpty())
                                                @foreach($product->ratings->where('status',1) as $review)
                                                    <div class="single-comment justify-content-between d-flex">
                                                    <div class="user justify-content-between d-flex">
                                                        <div class="thumb text-center">
                                                            <img src="{{asset('frontend-assets')}}/imgs/page/avatar-9.png" alt="">
                                                            <h6><a href="#">{{ $review->name }}</a></h6>
                                                        </div>
                                                        <div class="desc">
                                                            <div class="product-rate d-inline-block">
                                                                <div class="product-rating" style="width:{{ $review->rating * 20 }}%">
                                                                </div>
                                                            </div>
                                                            <p>{{ $review->comment }}</p>
                                                            <div class="d-flex justify-content-between">
                                                                <div class="d-flex align-items-center">
                                                                    <p class="font-xs mr-30">{{ $review->created_at->format('F d, Y \a\t h:i a') }} </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endforeach
                                                @else
                                                <p> No Reviews on this Product !! </p>
                                            @endif
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <h4 class="mb-30">Average reviews</h4>
                                            <div class="d-flex mb-30">
                                                <div class="product-rate d-inline-block mr-15">
                                                    <div class="product-rating" style="width:{{ $averageRating * 20 }}%">
                                                    </div>
                                                </div>
                                                <h6>{{ $averageRating }} out of 5</h6>
                                            </div>
                                            <div class="progress">
                                                <span>5 star</span>
                                                <div class="progress-bar" role="progressbar" style="width: {{ $star5 }}%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">{{ $star5 }}%</div>
                                            </div>
                                            <div class="progress">
                                                <span>4 star</span>
                                                <div class="progress-bar" role="progressbar" style="width: {{ $star4 }}%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">{{ $star4 }}%</div>
                                            </div>
                                            <div class="progress">
                                                <span>3 star</span>
                                                <div class="progress-bar" role="progressbar" style="width: {{ $star3 }}%;" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100">{{ $star3 }}%</div>
                                            </div>
                                            <div class="progress">
                                                <span>2 star</span>
                                                <div class="progress-bar" role="progressbar" style="width: {{ $star2 }}%;" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100">{{ $star2 }}%</div>
                                            </div>
                                            <div class="progress mb-30">
                                                <span>1 star</span>
                                                <div class="progress-bar" role="progressbar" style="width: {{ $star1 }}%;" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100">{{ $star1 }}%</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--comment form-->
                                {{-- <div class="comment-form">
                                    <h4 class="mb-15">Add a review</h4>

                                    </div>
                                    <div class="row">
                                        <div class="col-lg-8 col-md-12">
                                            @include('frontend.auth.frontMessage')
                                            @if ($errors->any())
                                                <div class="alert alert-danger">
                                                    <ul class="alert-ul">
                                                        @foreach ($errors->all() as $error)
                                                            <li>{{ $error }}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif
                                            <form class="form-contact comment_form"  id="commentForm" method="post" action="{{ route('submitReview') }}">
                                                @csrf
                                                <div class="row">
                                                    <input name="product_id" value="{{ $product->id }}" type="hidden" style="display: none">
                                                    <div class="form-group col-md-6 mb-3">
                                                        <input type="text" class="form-control" name="name" id="name" placeholder="Name" @if(auth()->check()) value="{{ auth()->user()->name }}" @endif>
                                                    </div>
                                                    <div class="form-group col-md-6 mb-3">
                                                        <input type="text" class="form-control" name="email" id="email" placeholder="Email" @if(auth()->check()) value="{{ auth()->user()->email }}" @endif>
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <label for="rating">Rating</label>
                                                        <br>
                                                        <div class="rating" id="rating_lable">
                                                            <input id="rating-5" type="radio" name="rating" value="5"/><label for="rating-5"><i class="bi bi-star"></i></label>
                                                            <input id="rating-4" type="radio" name="rating" value="4"  /><label for="rating-4"><i class="bi bi-star"></i></label>
                                                            <input id="rating-3" type="radio" name="rating" value="3"/><label for="rating-3"><i class="bi bi-star"></i></label>
                                                            <input id="rating-2" type="radio" name="rating" value="2"/><label for="rating-2"><i class="bi bi-star"></i></label>
                                                            <input id="rating-1" type="radio" name="rating" value="1"/><label for="rating-1"><i class="bi bi-star"></i></label>
                                                        </div>
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <label for="">How was your overall experience?</label>
                                                        <textarea name="comment"  id="review" class="form-control" cols="30" rows="10" placeholder="How was your overall experience?"></textarea>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <button type="submit" class="button button-contactForm">Submit Review</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div> --}}
                            </div>
                        </div>

                        {{-- <div class="row mt-60">
                            <div class="col-12">
                                <h3 class="section-title style-1 mb-30">Related products</h3>
                            </div>
                            <div class="col-12">
                                <div class="m-product-list relative sf-mixed-layout sf-mixed-layout--mobile-grid">
                                    <div class="m-product-list__wrapper">
                                        <div class="sf-mixed-layout__wrapper grid-cols-2 sf__col-5 md:grid-cols-3 xl:grid-cols-5" style="gap: 10px">
                                            @if(isset($products))
                                                @foreach($products->take(4) as $product)
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

                                                                                    
                                                                                    $sellingPrices = $variations->map(function ($v) {
                                                                                        return $v->compare_price && $v->compare_price > 0
                                                                                            ? $v->compare_price
                                                                                            : $v->price;
                                                                                    });

                                                                                    $minSelling = $sellingPrices->min();
                                                                                    $maxSelling = $sellingPrices->max();

                                                                                    
                                                                                    $hasSale = $variations->where('compare_price', '>', 0)->count() > 0;

                                                                                    
                                                                                    $minOriginal = $variations->min('price');
                                                                                    $maxOriginal = $variations->max('price');
                                                                                @endphp

                                                                                
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
                            </div>
                        </div> --}}

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection


@section('customJs')


@endsection
