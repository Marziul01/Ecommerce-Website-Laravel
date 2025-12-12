{{-- <header class="header-area header-style-1 header-height-2">
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
                                                    <h4><span>{{ $item->qty }} × </span>{{ $item->price }} BDT</h4>
                                                </div>
                                                <div class="shopping-cart-delete">
                                                    <a href="{{ route('removeFromCart', $item->rowId) }}"><i class="fi-rs-cross-small"></i></a>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <div class="shopping-cart-footer">
                                        <div class="shopping-cart-total">
                                            <h4>Total <span>{{ Cart::subtotal() }} BDT</span></h4>
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
</header> --}}

    <div id="shopify-section-sections--17326543765726__annoucement" class="shopify-section shopify-section-group-header-group">
        <section class="announcement-bar">
            <div class="announcement-bar__content md:text-center py-2.5 text-base">
                <div style="text-align: center; padding: 10px;">
                    <p class="">
                        আমাদের যে কোন পণ্য অর্ডার করতে কল বা WhatsApp করুন:
                        <a href="tel:{{ $siteSettings->phone }}" style="text-decoration: none;">
                            <i class="fas fa-phone"></i> {{ $siteSettings->phone }}
                        </a>
                        @if ($siteSettings->hotline)
                            |
                            <a href="tel:{{ $siteSettings->hotline }}" style="text-decoration: none;">
                                <i class="fas fa-phone-alt"></i> হট লাইন: {{ $siteSettings->hotline }}
                            </a>
                        @endif
                    </p>
                </div>
            </div>
        </section>
    </div>

    <div id="shopify-section-sections--17326543765726__header" class="shopify-section shopify-section-group-header-group m-section-header">
        <section data-section-id="sections--17326543765726__header" data-section-type="header" data-page="/"
            data-header-design="logo-center__2l" class="sf-header" data-transparent="false" data-sticky="true">

            <div class=" inset-x-0 z-[70] header__wrapper ">
                <header class="flex lg:hidden sf-header__mobile container-fluid bg-white items-center"
                    data-screen="sf-header__mobile" data-transparent="false">
                    <span class="flex flex-1 w-1/4 py-3.5 sf-menu-button">
                        <div class="m-hamburger-box" id="mobileMenuToggle">
                            <div class="m-hamburger-box__inner"></div>
                        </div>
                    </span>

                    <div class="sf-logo sf-logo--mobile px-4 w-1/2 justify-center has-logo-img">
                        <a href="{{ route('home') }}" class="block py-2.5 logo-img relative" title="{{ $siteSettings->title }}">
                            <div class="">
                                <img src="{{ asset($siteSettings->logo) }}" alt="{{ $siteSettings->title }}" class="inline-block">
                            </div>
                        </a>
                    </div>

                    <div class="w-1/4 flex flex-1 items-center justify-end sf-header__mobile-right">
                        <m-search-popup class="flex justify-center items-center p-2" data-open-search-popup>
                            <span class="sf__search-mb-icon">
                                <svg class="w-[20px] h-[20px]" fill="currentColor" stroke="currentColor"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                    <path
                                        d="M508.5 468.9L387.1 347.5c-2.3-2.3-5.3-3.5-8.5-3.5h-13.2c31.5-36.5 50.6-84 50.6-136C416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c52 0 99.5-19.1 136-50.6v13.2c0 3.2 1.3 6.2 3.5 8.5l121.4 121.4c4.7 4.7 12.3 4.7 17 0l22.6-22.6c4.7-4.7 4.7-12.3 0-17zM208 368c-88.4 0-160-71.6-160-160S119.6 48 208 48s160 71.6 160 160-71.6 160-160 160z" />
                                </svg>
                            </span>
                        </m-search-popup>

                        <a href=""
                            class="relative py-2 px-2 whitespace-nowrap cursor-pointer cart-icon sf-cart-icon m-cart-icon-bubble"
                            id="m-cart-icon-bubble">
                            <span class="sf__tooltip-item block sf__tooltip-bottom sf__tooltip-style-2">
                                <svg class="w-[20px] h-[20px]" fill="currentColor" stroke="currentColor"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                    <path
                                        d="M352 128C352 57.42 294.579 0 224 0 153.42 0 96 57.42 96 128H0v304c0 44.183 35.817 80 80 80h288c44.183 0 80-35.817 80-80V128h-96zM224 48c44.112 0 80 35.888 80 80H144c0-44.112 35.888-80 80-80zm176 384c0 17.645-14.355 32-32 32H80c-17.645 0-32-14.355-32-32V176h48v40c0 13.255 10.745 24 24 24s24-10.745 24-24v-40h160v40c0 13.255 10.745 24 24 24s24-10.745 24-24v-40h48v256z" />
                                </svg>
                                <span class="sf__tooltip-content">Cart</span>
                            </span>
                            <span class="m-cart-count-bubble sf-cart-count font-medium hidden">0</span>
                        </a>
                    </div>
                    
                    <div class="mobile-overlay d-none"></div>
                    <div class="new-mobile-drawer">
                        <div class="m-menu-drawer sf-scrollbar">
                            <div class="m-menu-drawer__content">
                                <ul class="m-menu-drawer__navigation m-menu-mobile">
                                    @if ($categories->isNotEmpty())
                                    @foreach ($categories as $category)
                                        @php
                                            $hasSub = $category->sub_category->count() > 0;
                                        @endphp

                                        <li class="m-menu-mobile__item {{ $hasSub ? 'has-submenu' : 'm-menu-mobile__item--no-submenu' }}"
                                            data-url="{{ url('category/' . $category->slug) }}">

                                            <a href="{{ url('category/' . $category->slug) }}" class="m-menu-mobile__link">
                                                {{ $category->name }}
                                            </a>
                                            @if ($hasSub)
                                                    <span class="submenu-icon">▾</span>
                                                @endif
                                            @if ($hasSub)
                                                <ul class="mobile-submenu">
                                                    @foreach ($category->sub_category as $sub)
                                                        <li>
                                                            <a href="{{ route('subCategoryProduct' , $sub->slug) }}">
                                                                {{ $sub->name }}
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @endif

                                        </li>
                                    @endforeach
                                    @endif
                                </ul>

                                <div class="m-menu-customer">
                                    <div class="m-menu-customer__wrapper">
                                        <div class="m-menu-customer__label">My Account</div>

                                        <a href="{{ route('userAuth') }}"
                                            class="sf__btn sf__btn-primary my-account-btn m-button--signin"
                                            data-tab="signin">
                                            Log in
                                        </a>
                                        <a href="{{ route('userAuth') }}"
                                            class="sf__btn sf__btn-secondary my-account-btn m-button--register"
                                            data-tab="register">
                                            Register
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </header>


                <header class="hidden lg:block bg-white sf-header__desktop relative logo-center__2l"
                    data-screen="sf-header__desktop" data-transparent="false">
                    <div class="sf-header__bg pointer-events-none"></div>
                    <div class="sf-header__dropdown-bg absolute top-full left-0 right-0 pointer-events-none"></div>

                    <div class="container sf__header-main-top relative">
                        <div class="flex sf-menu-logo-bar items-center">
                            <div class="w-2/5 flex flex-grow items-center">

                                <m-search-popup class="sf-search-form flex items-center pr-4  " data-open-search-popup>

                                    <button class="flex items-center py-2 px-3">
                                        <span class="sf__tooltip-item block sf__tooltip-bottom sf__tooltip-style-2">
                                            <svg class="w-[18px] h-[18px]" fill="currentColor" stroke="currentColor"
                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                <path
                                                    d="M508.5 468.9L387.1 347.5c-2.3-2.3-5.3-3.5-8.5-3.5h-13.2c31.5-36.5 50.6-84 50.6-136C416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c52 0 99.5-19.1 136-50.6v13.2c0 3.2 1.3 6.2 3.5 8.5l121.4 121.4c4.7 4.7 12.3 4.7 17 0l22.6-22.6c4.7-4.7 4.7-12.3 0-17zM208 368c-88.4 0-160-71.6-160-160S119.6 48 208 48s160 71.6 160 160-71.6 160-160 160z" />
                                            </svg>
                                            <span class="sf__tooltip-content">Search</span>
                                        </span>
                                    </button>


                                </m-search-popup>


                            </div>


                            <h1 class="sf-logo px-4 w-1/5 justify-center has-logo-img">


                                <a href="{{ route('home') }}" class="block py-2.5 logo-img relative" title="{{ $siteSettings->title }}">

                                    <div class="sf-image sf-logo-default">

                                        <img src="{{ asset($siteSettings->logo) }}" alt="{{ $siteSettings->title }}" class="inline-block">

                                    </div>



                                </a>


                            </h1>


                            <div class="w-2/5 flex justify-end sf-options-wrapper__desktop items-center">


                                <a href="{{ route('userAuth') }}"
                                    class="px-2 py-3.5">
                                    <span class="sf__tooltip-item block sf__tooltip-bottom sf__tooltip-style-2">
                                        <svg class="w-[20px] h-[20px]" fill="currentColor" stroke="currentColor"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                            <path
                                                d="M313.6 304c-28.7 0-42.5 16-89.6 16-47.1 0-60.8-16-89.6-16C60.2 304 0 364.2 0 438.4V464c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48v-25.6c0-74.2-60.2-134.4-134.4-134.4zM400 464H48v-25.6c0-47.6 38.8-86.4 86.4-86.4 14.6 0 38.3 16 89.6 16 51.7 0 74.9-16 89.6-16 47.6 0 86.4 38.8 86.4 86.4V464zM224 288c79.5 0 144-64.5 144-144S303.5 0 224 0 80 64.5 80 144s64.5 144 144 144zm0-240c52.9 0 96 43.1 96 96s-43.1 96-96 96-96-43.1-96-96 43.1-96 96-96z" />
                                        </svg>
                                        <span class="sf__tooltip-content">Account</span>
                                    </span>
                                </a>



                                <a href=""
                                    class="relative py-2 px-2 whitespace-nowrap cursor-pointer cart-icon sf-cart-icon m-cart-icon-bubble"
                                    id="m-cart-icon-bubble">
                                    <span class="sf__tooltip-item block sf__tooltip-bottom sf__tooltip-style-2">
                                        <svg class="w-[20px] h-[20px]" fill="currentColor" stroke="currentColor"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                            <path
                                                d="M352 128C352 57.42 294.579 0 224 0 153.42 0 96 57.42 96 128H0v304c0 44.183 35.817 80 80 80h288c44.183 0 80-35.817 80-80V128h-96zM224 48c44.112 0 80 35.888 80 80H144c0-44.112 35.888-80 80-80zm176 384c0 17.645-14.355 32-32 32H80c-17.645 0-32-14.355-32-32V176h48v40c0 13.255 10.745 24 24 24s24-10.745 24-24v-40h160v40c0 13.255 10.745 24 24 24s24-10.745 24-24v-40h48v256z" />
                                        </svg>
                                        <span class="sf__tooltip-content">Cart</span>
                                    </span>
                                    <span class="m-cart-count-bubble sf-cart-count font-medium hidden">0</span>
                                </a>

                            </div>
                        </div>
                    </div>
                    <div class="sf__header-main-menu bg-color-menubar-background text-color-menubar relative">
                        <div class="-mx-4 flex justify-center items-center sf-no-scroll-bar sf-menu-wrapper__desktop">
                            {{-- <ul
                                class="sf-nav flex flex-wrap text-base font-medium whitespace-nowrap sf-no-scroll-bar ">







                                <li class="sf-menu-item list-none sf-menu-item--no-mega sf-menu-item-parent"
                                    data-index="0">
                                    <a href="collections/offer.html"
                                        class="block px-4 py-5 flex items-center sf__parent-item">
                                        OFFER ZONE

                                    </a>

                                </li>









                                <li class="sf-menu-item list-none sf-menu-item--no-mega sf-menu-item-parent"
                                    data-index="1">
                                    <a href="collections/best-seller.html"
                                        class="block px-4 py-5 flex items-center sf__parent-item">
                                        Best Seller

                                    </a>

                                </li>









                                <li class="sf-menu-item list-none sf-menu-item--no-mega sf-menu-item-parent"
                                    data-index="2">
                                    <a href="collections/oil-1.html"
                                        class="block px-4 py-5 flex items-center sf__parent-item">
                                        Oil

                                    </a>

                                </li>









                                <li class="sf-menu-item list-none sf-menu-item--no-mega sf-menu-item-parent"
                                    data-index="3">
                                    <a href="collections/ghee.html"
                                        class="block px-4 py-5 flex items-center sf__parent-item">
                                        Ghee (ঘি)

                                    </a>

                                </li>









                                <li class="sf-menu-item list-none sf-menu-item--no-mega sf-menu-item-parent"
                                    data-index="4">
                                    <a href="collections/dates.html"
                                        class="block px-4 py-5 flex items-center sf__parent-item">
                                        Dates (খেজুর)

                                    </a>

                                </li>









                                <li class="sf-menu-item list-none sf-menu-item--no-mega sf-menu-item-parent"
                                    data-index="5">
                                    <a href="collections/khejur-gurr.html"
                                        class="block px-4 py-5 flex items-center sf__parent-item">
                                        খেজুর গুড়

                                    </a>

                                </li>









                                <li class="sf-menu-item list-none sf-menu-item--no-mega sf-menu-item-parent"
                                    data-index="6">
                                    <a href="collections/honey.html"
                                        class="block px-4 py-5 flex items-center sf__parent-item">
                                        Honey

                                    </a>

                                </li>









                                <li class="sf-menu-item list-none sf-menu-item--no-mega sf-menu-item-parent"
                                    data-index="7">
                                    <a href="collections/masala.html"
                                        class="block px-4 py-5 flex items-center sf__parent-item">
                                        Masala

                                    </a>

                                </li>









                                <li class="sf-menu-item list-none sf-menu-item--no-mega sf-menu-item-parent"
                                    data-index="8">
                                    <a href="collections/nuts-amp-seeds.html"
                                        class="block px-4 py-5 flex items-center sf__parent-item">
                                        Nuts & Seeds

                                    </a>

                                </li>









                                <li class="sf-menu-item list-none sf-menu-item--no-mega sf-menu-item-parent"
                                    data-index="9">
                                    <a href="collections/tea-coffee.html"
                                        class="block px-4 py-5 flex items-center sf__parent-item">
                                        Tea/Coffee

                                    </a>

                                </li>









                                <li class="sf-menu-item list-none sf-menu-item--no-mega sf-menu-item-parent"
                                    data-index="10">
                                    <a href="collections/natural-honeycomb.html"
                                        class="block px-4 py-5 flex items-center sf__parent-item">
                                        Honeycomb

                                    </a>

                                </li>









                                <li class="sf-menu-item list-none sf-menu-item--no-mega sf-menu-item-parent"
                                    data-index="11">
                                    <a href="collections/gb-organic-products.html"
                                        class="block px-4 py-5 flex items-center sf__parent-item">
                                        Organic Zone

                                    </a>

                                </li>









                                <li class="sf-menu-item list-none sf-menu-item--no-mega sf-menu-item-parent"
                                    data-index="12">
                                    <a href="collections/pickle.html"
                                        class="block px-4 py-5 flex items-center sf__parent-item">
                                        Pickle

                                    </a>

                                </li>



                            </ul> --}}
                            <ul class="d-flex m-menu-drawer__navigation m-menu-mobile">
                                    @if ($categories->isNotEmpty())
                                    @foreach ($categories as $category)
                                        @php
                                            $hasSub = $category->sub_category->count() > 0;
                                        @endphp

                                        <li class="m-menu-mobile__item {{ $hasSub ? 'has-submenu' : 'm-menu-mobile__item--no-submenu' }}"
                                            data-url="{{ url('category/' . $category->slug) }}">

                                            <a href="{{ url('category/' . $category->slug) }}" class="m-menu-mobile__link">
                                                {{ $category->name }}

                                                @if ($hasSub)
                                                    <span class="submenu-icon">▾</span>
                                                @endif
                                            </a>

                                            @if ($hasSub)
                                                <ul class="mobile-submenu">
                                                    @foreach ($category->sub_category as $sub)
                                                        <li>
                                                            <a href="{{ url('sub_category/' . $sub->slug) }}">
                                                                {{ $sub->name }}
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @endif

                                        </li>
                                        
                                    @endforeach
                                    @endif
                                </ul>
                        </div>

                        <div class="flex justify-end sf-options-wrapper__desktop items-center">


                            <a href="https://shopify.com/68513399006/account?locale=en&amp;region_country=BD"
                                class="px-2 py-3.5">
                                <span class="sf__tooltip-item block sf__tooltip-bottom sf__tooltip-style-2">
                                    <svg class="w-[20px] h-[20px]" fill="currentColor" stroke="currentColor"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                        <path
                                            d="M313.6 304c-28.7 0-42.5 16-89.6 16-47.1 0-60.8-16-89.6-16C60.2 304 0 364.2 0 438.4V464c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48v-25.6c0-74.2-60.2-134.4-134.4-134.4zM400 464H48v-25.6c0-47.6 38.8-86.4 86.4-86.4 14.6 0 38.3 16 89.6 16 51.7 0 74.9-16 89.6-16 47.6 0 86.4 38.8 86.4 86.4V464zM224 288c79.5 0 144-64.5 144-144S303.5 0 224 0 80 64.5 80 144s64.5 144 144 144zm0-240c52.9 0 96 43.1 96 96s-43.1 96-96 96-96-43.1-96-96 43.1-96 96-96z" />
                                    </svg>
                                    <span class="sf__tooltip-content">Account</span>
                                </span>
                            </a>



                            <a href="cart.html"
                                class="relative py-2 px-2 whitespace-nowrap cursor-pointer cart-icon sf-cart-icon m-cart-icon-bubble"
                                id="m-cart-icon-bubble">
                                <span class="sf__tooltip-item block sf__tooltip-bottom sf__tooltip-style-2">
                                    <svg class="w-[20px] h-[20px]" fill="currentColor" stroke="currentColor"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                        <path
                                            d="M352 128C352 57.42 294.579 0 224 0 153.42 0 96 57.42 96 128H0v304c0 44.183 35.817 80 80 80h288c44.183 0 80-35.817 80-80V128h-96zM224 48c44.112 0 80 35.888 80 80H144c0-44.112 35.888-80 80-80zm176 384c0 17.645-14.355 32-32 32H80c-17.645 0-32-14.355-32-32V176h48v40c0 13.255 10.745 24 24 24s24-10.745 24-24v-40h160v40c0 13.255 10.745 24 24 24s24-10.745 24-24v-40h48v256z" />
                                    </svg>
                                    <span class="sf__tooltip-content">Cart</span>
                                </span>
                                <span class="m-cart-count-bubble sf-cart-count font-medium hidden">0</span>
                            </a>

                        </div>
                    </div>

                </header>
            </div>
        </section>
    </div>
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
