
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
                            <button type="button" data-bs-toggle="modal" data-bs-target="#searchModal">
                            <span class="sf__search-mb-icon">
                                <svg class="w-[20px] h-[20px]" fill="currentColor" stroke="currentColor"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                    <path
                                        d="M508.5 468.9L387.1 347.5c-2.3-2.3-5.3-3.5-8.5-3.5h-13.2c31.5-36.5 50.6-84 50.6-136C416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c52 0 99.5-19.1 136-50.6v13.2c0 3.2 1.3 6.2 3.5 8.5l121.4 121.4c4.7 4.7 12.3 4.7 17 0l22.6-22.6c4.7-4.7 4.7-12.3 0-17zM208 368c-88.4 0-160-71.6-160-160S119.6 48 208 48s160 71.6 160 160-71.6 160-160 160z" />
                                </svg>
                            </span>
                            </button>
                        </m-search-popup>

                        <a href="javascript:void(0)" class="relative py-2 px-2 cursor-pointer cart-icon sf-cart-icon m-cart-icon-bubble openCartBtn">
                            <span class="sf__tooltip-item block sf__tooltip-bottom sf__tooltip-style-2">
                                <svg class="w-[20px] h-[20px]" fill="currentColor" stroke="currentColor"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                    <path
                                        d="M352 128C352 57.42 294.579 0 224 0 153.42 0 96 57.42 96 128H0v304c0 44.183 35.817 80 80 80h288c44.183 0 80-35.817 80-80V128h-96zM224 48c44.112 0 80 35.888 80 80H144c0-44.112 35.888-80 80-80zm176 384c0 17.645-14.355 32-32 32H80c-17.645 0-32-14.355-32-32V176h48v40c0 13.255 10.745 24 24 24s24-10.745 24-24v-40h160v40c0 13.255 10.745 24 24 24s24-10.745 24-24v-40h48v256z" />
                                </svg>
                                <span class="sf__tooltip-content">Cart</span>
                            </span>
                            <span class="m-cart-count-bubble sf-cart-count font-medium {{ $cartCount > 0 ? '' : 'hidden' }}">
                                    {{ $cartCount }}
                            </span>
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

                                    <button class="flex items-center py-2 px-3" data-bs-toggle="modal" data-bs-target="#searchModal">
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



                                <a href="javascript:void(0)" class="relative py-2 px-2 cursor-pointer cart-icon sf-cart-icon m-cart-icon-bubble openCartBtn">
                                    <span class="sf__tooltip-item block sf__tooltip-bottom sf__tooltip-style-2">
                                        <svg class="w-[20px] h-[20px]" fill="currentColor" stroke="currentColor"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                            <path
                                                d="M352 128C352 57.42 294.579 0 224 0 153.42 0 96 57.42 96 128H0v304c0 44.183 35.817 80 80 80h288c44.183 0 80-35.817 80-80V128h-96zM224 48c44.112 0 80 35.888 80 80H144c0-44.112 35.888-80 80-80zm176 384c0 17.645-14.355 32-32 32H80c-17.645 0-32-14.355-32-32V176h48v40c0 13.255 10.745 24 24 24s24-10.745 24-24v-40h160v40c0 13.255 10.745 24 24 24s24-10.745 24-24v-40h48v256z" />
                                        </svg>
                                        <span class="sf__tooltip-content">Cart</span>
                                    </span>
                                    <span class="m-cart-count-bubble sf-cart-count font-medium {{ $cartCount > 0 ? '' : 'hidden' }}">
                                        {{ $cartCount }}
                                    </span>
                                </a>

                            </div>
                        </div>
                    </div>
                    <div class="sf__header-main-menu bg-color-menubar-background text-color-menubar relative">
                        <div class="-mx-4 flex justify-center items-center sf-no-scroll-bar sf-menu-wrapper__desktop">
                            
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



                            <a href="javascript:void(0)" class="relative py-2 px-2 cursor-pointer cart-icon sf-cart-icon m-cart-icon-bubble openCartBtn">
                                <span class="sf__tooltip-item block sf__tooltip-bottom sf__tooltip-style-2">
                                    <svg class="w-[20px] h-[20px]" fill="currentColor" stroke="currentColor"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                        <path
                                            d="M352 128C352 57.42 294.579 0 224 0 153.42 0 96 57.42 96 128H0v304c0 44.183 35.817 80 80 80h288c44.183 0 80-35.817 80-80V128h-96zM224 48c44.112 0 80 35.888 80 80H144c0-44.112 35.888-80 80-80zm176 384c0 17.645-14.355 32-32 32H80c-17.645 0-32-14.355-32-32V176h48v40c0 13.255 10.745 24 24 24s24-10.745 24-24v-40h160v40c0 13.255 10.745 24 24 24s24-10.745 24-24v-40h48v256z" />
                                    </svg>
                                    <span class="sf__tooltip-content">Cart</span>
                                </span>
                                <span class="m-cart-count-bubble sf-cart-count font-medium {{ $cartCount > 0 ? '' : 'hidden' }}">
                                    {{ $cartCount }}
                                </span>
                            </a>

                        </div>
                    </div>

                </header>
            </div>
        </section>
    </div>


    <div class="modal fade search-modal" id="searchModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="false" data-bs-keyboard="true">
        <div class="modal-dialog modal-dialog-centered modal-fullscreen-sm-down">
            <div class="modal-content border-0 rounded-0">

                <div class="modal-body p-3">
                    <form action="{{ route('shop') }}" method="get" class="d-flex align-items-center gap-2">

                        <input type="text"
                            class="form-control m-0"
                            placeholder="Search for items..."
                            name="search"
                            value="{{ Request::get('search') }}"
                            id="search"
                            autofocus>

                        <button type="submit" class="btn btn-dark d-flex align-items-center gap-1 px-2">
                            <svg class="w-[18px] h-[18px]" fill="currentColor" stroke="currentColor"
                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                <path
                                                    d="M508.5 468.9L387.1 347.5c-2.3-2.3-5.3-3.5-8.5-3.5h-13.2c31.5-36.5 50.6-84 50.6-136C416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c52 0 99.5-19.1 136-50.6v13.2c0 3.2 1.3 6.2 3.5 8.5l121.4 121.4c4.7 4.7 12.3 4.7 17 0l22.6-22.6c4.7-4.7 4.7-12.3 0-17zM208 368c-88.4 0-160-71.6-160-160S119.6 48 208 48s160 71.6 160 160-71.6 160-160 160z" />
                                            </svg>
                        </button>
                        <button type="button" class=" btn btn-danger btn-close px-2 text-dark" data-bs-dismiss="modal" aria-label="Close"></button>
                    </form>
                </div>

            </div>
        </div>
    </div>
