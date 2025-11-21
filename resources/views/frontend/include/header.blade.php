<header class="header-area header-style-1 header-height-2">
    <div class="header-top header-top-ptb-1 d-none d-lg-block">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-xl-3 col-lg-4">
                    <div class="header-info">
                        <ul>
                            <li><i class="fi-rs-smartphone"></i> <a href="tel:{{ $siteSettings->phone }}">{{ $siteSettings->phone }}</a></li>
                            <li><i class="fi-rs-marker"></i><a  href="{{ $siteSettings->locationLink }}">Our location</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-4">
                    <div class="text-center">
                        <div id="news-flash" class="d-inline-block">
                            <ul>
                                @if ($siteSettings->offerOne)
                                <li>{{ $siteSettings->offerOne }} <a href="{{ $siteSettings->offerOneLink }}">View details</a></li>
                                @endif 
                                @if ($siteSettings->offerTwo)
                                <li>{{ $siteSettings->offerTwo }} <a href="{{ $siteSettings->offerTwoLink }}">Shop now</a></li>
                                @endif 
                                
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4">
                    <div class="header-info header-info-right">
                        <ul>
                            {{-- <li>
                                <a class="language-dropdown-active" href="#"> <i class="fi-rs-world"></i> English <i class="fi-rs-angle-small-down"></i></a>
                                <ul class="language-dropdown">
                                    <li><a href="#"><img src="{{ asset('frontend-assets') }}/imgs/theme/flag-fr.png" alt="">Français</a></li>
                                    <li><a href="#"><img src="{{ asset('frontend-assets') }}/imgs/theme/flag-dt.png" alt="">Deutsch</a></li>
                                    <li><a href="#"><img src="{{ asset('frontend-assets') }}/imgs/theme/flag-ru.png" alt="">Pусский</a></li>
                                </ul>
                            </li> --}}
                            @if(Auth::check())
                                <li class="dropdown">
                                    <i class="fi-rs-user"></i>
                                    <p style="font-size: 13px; color: black; margin-bottom: 0px;" class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                        Welcome, {{ Auth::user()->name }}!</p>
                                    <ul class="dropdown-menu px-2 py-2" style="background: #fff;font-size: 13px;border-radius: 0px;">
                                        <li style="padding: 0px"><a class="dropdown-item" href="{{ route('user.profile') }}" style="color: black;padding-left: 10px">Profile</a></li>
                                        <li style="padding: 0px"><a class="dropdown-item" href="{{ route('user.logout') }}" style="color: black;padding-left: 10px">Logout</a></li>
                                    </ul>
                                </li>
                            @else
                                <li><i class="fi-rs-user"></i><a href="{{ route('userAuth') }}">Log In / Sign Up</a></li>
                            @endif

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="header-middle header-middle-ptb-1 d-none d-lg-block">
        <div class="container">
            <div class="header-wrap">
                <div class="logo logo-width-1">
                    <a href="{{ route('home') }}"><img src="{{ asset($siteSettings->logo) }}" alt="logo"></a>
                </div>
                <div class="header-right">
                    <div class="search-style-2">
                        <form action="{{ route('shop') }}" method="get">
                            <select class="select-active" name="category" id="search_category">
                                <option value="all_category">All Categories</option>
                                @if($categories->isNotEmpty())
                                    @foreach($categories as $category)
                                        <option value="{{ $category->slug }}">{{ $category->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                            <input type="text" placeholder="Search for items..." name="search" value="{{ Request::get('search') }}" id="search">
                        </form>
                    </div>
                    <div class="header-action-right">
                        <div class="header-action-2">
                            <div class="header-action-icon-2">
                                <a href="{{ route('wishlist') }}">
                                    <img class="svgInject" alt="Evara" src="{{ asset('frontend-assets') }}/imgs/theme/icons/icon-heart.svg">
                                    <span id="wishlist-count-now" class="pro-count blue">{{ Auth::check() ? Auth::user()->wishlist()->count() : count(session()->get('wishlist', [])) }}</span>
                                </a>

                            </div>
                            <div class="header-action-icon-2">
                                <a class="mini-cart-icon" href="{{ route('cart') }}">
                                    <img alt="Evara" src="{{ asset('frontend-assets') }}/imgs/theme/icons/icon-cart.svg">
                                    <span class="pro-count blue" id="cartCount">{{ Cart::count() }}</span>
                                </a>
                                <div class="cart-dropdown-wrap cart-dropdown-hm2" id="cartDropdown">
                                    <ul>
                                        @foreach($cartContent as $item)
                                            <li>
                                                <div class="shopping-cart-img">
                                                    <a href="{{ route('products', $item->options['slug']) }}">
                                                        <img alt="{{ $item->name }}" src="{{ asset($item->options['image']) }}">
                                                    </a>
                                                </div>
                                                <div class="shopping-cart-title">
                                                    <h4><a href="{{ route('products', $item->options['slug']) }}">{{ $item->name }}</a></h4>
                                                    <h4><span>{{ $item->qty }} × </span>${{ $item->price }}</h4>
                                                </div>
                                                <div class="shopping-cart-delete">
                                                    <a href="{{ route('removeFromCart', $item->rowId) }}"><i class="fi-rs-cross-small"></i></a>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <div class="shopping-cart-footer">
                                        <div class="shopping-cart-total">
                                            <h4>Total <span>${{ Cart::subtotal() }}</span></h4>
                                        </div>
                                        <div class="shopping-cart-button">
                                            <a href="{{ route('cart') }}" class="outline">View cart</a>
                                            <a href="{{ route('checkout') }}">Checkout</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="header-bottom header-bottom-bg-color sticky-bar">
        <div class="container">
            <div class="header-wrap header-space-between position-relative">
                <div class="logo logo-width-1 d-block d-lg-none">
                    <a href="{{ route('home') }}"><img src="{{ asset($siteSettings->logo) }}" alt="logo"></a>
                </div>
                <div class="header-nav d-none d-lg-flex">
                    <div class="main-categori-wrap d-none d-lg-block">
                        <a class="categori-button-active" href="#">
                            <span class="fi-rs-apps"></span> Browse Categories
                        </a>
                        <div class="categori-dropdown-wrap categori-dropdown-active-large">
                            <ul>
                                @if($categories->isNotEmpty())
                                    @foreach($categories as $category)
                                        <li @if($category->sub_category->isNotEmpty()) class="has-children" @endif>
                                            <a href="{{ route('categoryProduct',$category->slug) }}">{{ $category->name }}</a>
                                            @if($category->sub_category->isNotEmpty())

                                            <div class="dropdown-menu">
                                                <ul class="">
                                                    @foreach($category->sub_category as $subCategory)
                                                        <li><a href="{{ route('subCategoryProduct',$subCategory->slug) }}">{{ $subCategory->name }}</a></li>
                                                    @endforeach
                                                </ul>
                                            </div>

                                            @endif
                                        </li>
                                    @endforeach
                                @endif

                            </ul>
                        </div>
                    </div>
                    <div class="main-menu main-menu-padding-1 main-menu-lh-2 d-none d-lg-block">
                        <nav>
                            <ul>
                                <li>
                                    <a class="active" href="{{ route('home') }}">Home</a>
                                </li>
                                <li>
                                    <a href="{{ route('about') }}">About us</a>
                                </li>
                                <li>
                                    <a href="{{ route('shop') }}">Shop</a>
                                </li>
                                <li>
                                    <a href="{{ route('contact') }}">Contact us</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <div class="hotline d-none d-lg-block">
                    <p><i class="fi-rs-headset"></i><span>Hotline</span> {{ $siteSettings->hotline }} </p>
                </div>
                <p class="mobile-promotion">Happy <span class="text-brand">Mother's Day</span>. Big Sale Up to 40%</p>
                <div class="header-action-right d-block d-lg-none">
                    <div class="header-action-2">
                        <div class="header-action-icon-2">
                            <a href="{{ route('wishlist') }}">
                                <img alt="Evara" src="{{ asset('frontend-assets') }}/imgs/theme/icons/icon-heart.svg">
                                <span class="pro-count white" id="wishlist-count-now-mobile">{{ Auth::check() ? Auth::user()->wishlist()->count() : count(session()->get('wishlist', [])) }}</span>
                            </a>
                        </div>
                        <div class="header-action-icon-2">
                            <a class="mini-cart-icon" href="{{ route('cart') }}">
                                <img alt="Evara" src="{{ asset('frontend-assets') }}/imgs/theme/icons/icon-cart.svg">
                                <span class="pro-count white" id="cartCountMobile">{{ Cart::count() }}</span>
                            </a>
                            <div class="cart-dropdown-wrap cart-dropdown-hm2">
                                <ul>
                                    <li>
                                        <div class="shopping-cart-img">
                                            <a href="shop-product-right.html"><img alt="Evara" src="{{ asset('frontend-assets') }}/imgs/shop/thumbnail-3.jpg"></a>
                                        </div>
                                        <div class="shopping-cart-title">
                                            <h4><a href="shop-product-right.html">Plain Striola Shirts</a></h4>
                                            <h3><span>1 × </span>$800.00</h3>
                                        </div>
                                        <div class="shopping-cart-delete">
                                            <a href="#"><i class="fi-rs-cross-small"></i></a>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="shopping-cart-img">
                                            <a href="shop-product-right.html"><img alt="Evara" src="{{ asset('frontend-assets') }}/imgs/shop/thumbnail-4.jpg"></a>
                                        </div>
                                        <div class="shopping-cart-title">
                                            <h4><a href="shop-product-right.html">Macbook Pro 2022</a></h4>
                                            <h3><span>1 × </span>$3500.00</h3>
                                        </div>
                                        <div class="shopping-cart-delete">
                                            <a href="#"><i class="fi-rs-cross-small"></i></a>
                                        </div>
                                    </li>
                                </ul>
                                <div class="shopping-cart-footer">
                                    <div class="shopping-cart-total">
                                        <h4>Total <span>$383.00</span></h4>
                                    </div>
                                    <div class="shopping-cart-button">
                                        <a href="shop-cart.html">View cart</a>
                                        <a href="shop-checkout.html">Checkout</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="header-action-icon-2 d-block d-lg-none">
                            <div class="burger-icon burger-icon-white">
                                <span class="burger-icon-top"></span>
                                <span class="burger-icon-mid"></span>
                                <span class="burger-icon-bottom"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<script>
    $(document).ready(function () {
        // Attach hover event to the mini-cart-icon
        $('.mini-cart-icon').hover(function () {
            // Fetch cart details and update the dropdown content
            updateCartDropdown();
        });
    });

    function updateCartDropdown() {
        // Make an AJAX request to fetch cart details
        $.ajax({
            url: "{{ route('getCartDetails') }}", // Update this route to your actual route
            type: "GET",
            dataType: "json",
            success: function (data) {
                // Update the cart dropdown content with fetched data
                $('#cartDropdown').html(data.cartHtml);
            },
            error: function (error) {
                console.error('Error:', error);
            }
        });
    }
</script>
@include('frontend.include.mobilenav')
