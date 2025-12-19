@if ($products->isNotEmpty())
    @foreach ($products as $product)
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
@endif
