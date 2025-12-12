@if ($products->isNotEmpty())
    @foreach ($products as $product)
        <div class="sf-column">
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
                        @if ($product->compare_price)
                            <div class="sf__pcard-tags absolute flex flex-wrap">
                                <span
                                    class="py-0.5 px-2 mb-2 mr-2 font-medium rounded-xl text-white prod__tag prod__tag-sale">On
                                    Sale </span>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="sf__pcard-content text-center relative">
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
                            <div class="f-price inline-flex items-center flex-wrap f-price--on-sale ">
                                @if ($product->compare_price)
                                    <div class="f-price__sale">
                                        <span class="visually-hidden visually-hidden--inline">Sale price</span>
                                        <span
                                            class="f-price-item f-price-item--sale  prod__price text-color-regular-price">
                                            Tk {{ $product->compare_price }}
                                        </span>
                                        <span class="visually-hidden visually-hidden--inline">Regular price</span>
                                        <s
                                            class="f-price-item f-price-item--regular prod__compare_price line-through text-color-secondary flex items-center">

                                            Tk {{ $product->price }}

                                        </s>
                                    </div>
                                @else
                                    <div class="f-price__regular">
                                        <span class="visually-hidden visually-hidden--inline">Regular price</span>
                                        <span class="f-price-item f-price-item--regular ">
                                            Tk {{ $product->price }}
                                        </span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="sf__pcard-action-atc flex justify-center mt-0">
                        <div class="sf__pcard-quick-add ">
                            <product-form class="f-product-form w-full product-form form"
                                data-product-id="8766631903454">
                                <form class="product-card-form"
                                    enctype="multipart/form-data">
                                    <input type="hidden" name="form_type" value="product" />
                                    <input type="hidden" name="utf8" value="✓" />
                                    <input hidden name="id" required value="46159132033246"
                                        data-selected-variant="">
                                    <button
                                        class="add-to-cart sf__btn w-full flex-grow shrink not-change relative sf__btn-secondary sf__btn-white"
                                        name="add" type="button" aria-label="Add to cart">
                                        <span class="atc-spinner inset-0 absolute items-center justify-center">
                                            <svg class="animate-spin w-[20px] h-[20px]"
                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none">
                                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                                    stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor"
                                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                                </path>
                                            </svg>
                                        </span>
                                        <span class="not-change atc-text" data-atc-text>
                                            Quick Add
                                        </span>
                                    </button>
                                    <input type="hidden" name="product-id" value="8766631903454" />
                                    <input type="hidden" name="section-id"
                                        value="template--17326543175902__6e8e8f75-6a66-47b3-863c-62c784892ed7" />
                                </form>
                            </product-form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endif

