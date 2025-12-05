@extends('admin.master')

@section('title')
    Products
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid my-2">
                @include('admin.auth.message')
                <div class="d-sm-flex align-items-center justify-content-between mb-2">
                    
                        <h1>Products</h1>
                        @if (Auth::guard('admin')->user()->access->product_manage == 3)
                            <a href="{{ route('product.create') }}" class="btn btn-primary">Add New</a>
                        @endif
                    
                </div>
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered table-hover table-striped table-responsive-md" style="overflow-x: auto;">
                        <thead>
                        <tr>
                            <th>Sl</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Qunatity</th>
                            <th>Price</th>
                            <th>Featured</th>
                            <th>Status</th>
                            <th width="400px">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($products->isNotEmpty())
                            @foreach($products as $product)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td><img src="{{ asset( $product->featured_image ) }}" width="50px" height="50px"></td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->category->name }} - ( @if(isset($product->subCategory->name)){{ $product->subCategory->name }}@else No Subcategory Selected @endif )
                                        <br>
                                        {{ $product->brand->name }}
                                    </td>
                                    <td>
                                        @if ($product->productVariations->count() > 0)
                                            @foreach ( $product->productVariations as $variation)
                                                <span class="badge bg-primary"> {{ $variation->type }} - ( {{ $variation->qty }} ) </span>
                                            @endforeach
                                        @else
                                            <span class="badge bg-primary"> {{ $product->qty }}  </span>
                                        @endif
                                    </td>
                                    <td>
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
                                                <span class="fw-bold text-success">
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
                                                <span class="fw-bold text-success">
                                                    {{ number_format($product->compare_price) }} BDT
                                                </span>
                                            @else
                                                <span class="fw-bold">
                                                    {{ number_format($product->price) }} BDT
                                                </span>
                                            @endif
                                        @endif

                                    </td>
                                    <td>{{ $product->is_featured }}</td>
                                    <td>
                                        @if($product->status == 1)
                                            <i class="bi bi-check-circle-fill" style="color: deepskyblue"></i> ACTIVE
                                        @else
                                            <i class="bi bi-x-circle-fill" style="color: red"></i> INACTIVE
                                        @endif
                                    </td>
                                    <td class="table-action-td">
                                        @if (Auth::guard('admin')->user()->access->product_manage == 3)
                                            <button class="btn btn-sm btn-success addQuantityBtn me-1 my-1" data-id="{{ $product->id }}">+ Add Quantity</button>
                                            <a class="btn btn-sm btn-primary" href="{{ route('product.shipment', $product->id) }}">See All Qty Shipments</a>
                                            <a class="btn btn-sm btn-primary" href="{{ route('product.edit', $product->id) }}"><i class="bi bi-pen-fill"></i></a>
                                            @if($product->status == 1)
                                                <a class="btn btn-sm btn-warning" href="{{ route('product.show', $product->id) }}"><i class="bi bi-x-circle-fill"></i> Inactive</a>
                                            @else
                                                <a class="btn btn-sm btn-success" href="{{ route('product.show', $product->id) }}"><i class="bi bi-check-circle-fill"></i> Active</a>
                                            @endif

                                            <form action="{{ route('product.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this Product?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"><i class="bi bi-trash-fill"></i></button>
                                            </form>
                                        @endif
                                        <a class="btn btn-sm btn-success" data-toggle="modal" data-target="#productViewModal_{{ $product->id }}"><i class="bi bi-eye"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="13"> No Products Found !!! </td>
                            </tr>
                        @endif

                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    {{ $products->links() }}
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>

    @if(isset($product))
        @foreach($products as $product)
            <div class="modal fade" id="productViewModal_{{ $product->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <!-- Modal content goes here, make sure to customize it for each category -->
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5>{{ $product->name }}</h5>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <img src="{{ asset($product->featured_image) }}" height="100px" class="mb-2">
                                    <p>Slug: {{ $product->slug }}</p>
                                    <p>Featured: {{ $product->is_featured }}</p>
                                    <p>Status: {{ $product->status == 1 ? 'ACTIVE' : 'INACTIVE'}}</p>
                                    <p>Quantity: {{ $product->qty}}</p>
                                    <p>Product SKU: {{ $product->sku}}</p>
                                    <p>Product Barcode: {{ $product->barcode}}</p>
                                </div>
                                <div class="col-md-6">
                                    <p>Category: {{ $product->category->name }}</p>
                                    <p>Sub Category: {{ $product->Subcategory->name }}</p>
                                    <p>Brand: {{ $product->brand->name }}</p>
                                    <p>Discount Price: {{ $product->price }}</p>
                                    <p style="text-decoration: line-through">Price: {{ $product->compare_price }}</p>
                                    <p>Available Colors: {{ $product->colors }}</p>
                                    <p>Available Sizes: {{ $product->sizes }}</p>
                                    <p>Short Description:</p>
                                    <textarea class="form-control" readonly>{{ $product->short_desc }}</textarea>
                                </div>
                                <div class="col-md-12">
                                    <p>Full Description:</p>
                                    <textarea class="form-control" readonly> {!! $product->full_desc !!} </textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        {{--    <div class="modal fade" id="EditCategoryModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"--}}
        {{--         aria-hidden="true">--}}
        {{--        --}}
        {{--    </div>--}}

        @if (Auth::guard('admin')->user()->access->product_manage == 3)
        <!-- 🔹 Add Quantity Modal --> 
    <div class="modal fade" id="addQuantityModal" tabindex="-1" aria-hidden="true"> 
        <div class="modal-dialog modal-lg">
            <div class="modal-content"> 
                <div class="modal-header d-flex justify-content-between align-items-center"> 
                    <h5 class="modal-title">Add Quantity</h5> 
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button> 
                </div> 
                <div class="modal-body" id="addQuantityBody"> 
                    <div class="text-center py-5" id="addQuantityLoader"> 
                        <div class="spinner-border text-primary"></div> 
                        <p class="mt-2">Loading product details...</p> 
                    </div> 
                </div> 
                <div class="modal-footer d-flex justify-content-between"> 
                    <button class="btn btn-primary" id="saveQuantityBtn">Save Changes</button> 
                </div> 
            </div> 
        </div> 
    </div>
    @endif


    @endif

@endsection


@section('customjs')
<script>
$(document).ready(function() {

    // ======== 1. On Button Click =========
    $(document).on('click', '.addQuantityBtn', function() {
        const productId = $(this).data('id');
        const modal = $('#addQuantityModal');
        const modalBody = $('#addQuantityBody');
        let loader = $('#preloader');

        // Reset modal
        modalBody.html(loader);
        loader.show();
        let modalEl = document.getElementById('addQuantityModal');
        let bsModal = new bootstrap.Modal(modalEl);
        bsModal.show();

        // ======== 2. Fetch Product Data =========
        $.ajax({
            url: "{{ route('products.view', ':id') }}".replace(':id', productId),
            method: "GET",
            data: { id: productId },
            success: function(product) {
                loader.hide();

                // ======== 3. Build Modal Content =========
                const assetBase = "{{ asset('') }}";
                const imageUrl = assetBase + product.featured_image.replace(/^\/+/, '');

                let html = `
                    <div class="d-flex align-items-center mb-3 border-bottom pb-2">
                        <img src="${imageUrl}" height="80" class="rounded me-3 border">
                        <div>
                            <h5>${product.name}</h5>
                            <p class="mb-1 text-muted">SKU: ${product.sku}</p>
                            <p class="mb-0">Current Qty: <strong>${product.qty}</strong></p>
                        </div>
                    </div>

                    <form id="addQuantityForm">
                        @csrf
                        <input type="hidden" name="product_id" value="${product.id}">
                        <div id="variationsContainer" class="mb-3"></div>
                        <div id="mainQtyFields" class="${product.product_variations.length > 0 ? 'd-none' : ''}">
                            <div class="">
                                <label>Quantity</label>
                                <input type="number" class="form-control" name="qty" id="qty" value="0" placeholder="Enter Quantity">
                            </div>
                        </div>
                    </form>
                `;
                modalBody.html(html);

                // ======== 4. Populate Variations if Exist =========
                if (product.product_variations && product.product_variations.length > 0) {
                    populateVariationsData(product.product_variations);
                } else {
                    toggleMainInputs();
                }
            },
            error: function() {
                loader.html('<p class="text-danger">Failed to load product data.</p>');
            }
        });
    });

    // ======== 5. Save Changes =========
    $(document).on('click', '#saveQuantityBtn', function () {

    const form = $('#addQuantityForm');
    let productId = form.find("input[name='product_id']").val();
    let items = [];
    let valid = true; // initialize

    // ----- 1. Collect main product qty -----
    let mainQty = parseInt($("#qty").val());
    if (!isNaN(mainQty) && mainQty > 0) {
        items.push({
            product_id: productId,
            variation_id: null,
            quantity: mainQty
        });
    }

    // ----- 2. Collect variations -----
    $("#variationsContainer .variation-item").each(function () {

        let variationId = $(this).data("variation-id") || null;
        let qty = parseInt($(this).find(".variation-qty").val());

        // only push if > 0
        if (!isNaN(qty) && qty > 0) {
            items.push({
                product_id: productId,
                variation_id: variationId,
                quantity: qty
            });
        }
    });

    // empty data protection
    if (items.length === 0) {
        toastr.error("Enter at least one quantity greater than 0!");
        return;
    }

    // ----- 3. Send ONE clean request -----
    $('#fullscreenLoader').fadeIn();

    $.ajax({
        url: "{{ route('products.updateQuantity') }}",
        method: "POST",
        contentType: "application/json",
        data: JSON.stringify({
            _token: "{{ csrf_token() }}",
            items: items
        }),
        success: function(res) {
            $('#fullscreenLoader').fadeOut();
            toastr.success("Quantity updated successfully!");
            
            setTimeout(() => location.reload(), 1000);
        },
        error: function(xhr) {
            $('#fullscreenLoader').fadeOut();

            if (xhr.status === 422) {
                let errors = xhr.responseJSON.errors;
                for (let key in errors) {
                    toastr.error(errors[key][0]);
                }
            } else {
                toastr.error("Failed to update quantity!");
            }
        }
    });

});



    // ======== 6. Variation Management =========
    function populateVariationsData(variationsData) {
        const container = document.getElementById("variationsContainer");

        variationsData.forEach(function(data) {

            const row = document.createElement("div");
            row.className = "variation-item additional-info d-flex mb-2 align-items-center gap-2";
            row.dataset.variationId = data.id;

            const input1 = createInput("text", "variations[type][]", "Variation Name", "form-control w-50", data.type + ' ( Available : ' + data.qty + ')', "readonly");
            const inputBuy = createInput("text", "variations[buy_price][]", "Buying Price", "form-control w-25 d-none", data.buy_price);
            const input2 = createInput("text", "variations[price][]", "Price", "form-control w-25 d-none", data.price);

            const input3 = createInput("number", "variations[qty][]", "Add Quantity", "form-control variation-qty w-50", "0");

            const hiddenInput = createInput("hidden", "variations[existing_ids][]", "", "", data.id);
            

            row.append(input1, inputBuy, input2, input3, hiddenInput);
            container.appendChild(row);

            
        });

        toggleMainInputs();
    }

    function createInput(type, name, placeholder, className, value , readonly = "") {
        const input = document.createElement("input");
        input.type = type;
        input.name = name;
        input.placeholder = placeholder;
        input.className = className;
        if (value) input.value = value;
        if (readonly) input.setAttribute("readonly", readonly);

        return input;
    }

    function deleteDataFromDatabase(id) {
        console.log("Deleting variation with ID:", id);
    }

    function toggleMainInputs() {
        const container = document.getElementById("variationsContainer");
        const qtyInput = document.getElementById("qty");
        

        if (container && container.children.length > 0) {
            if (qtyInput) qtyInput.disabled = true;
            
        } else {
            if (qtyInput) qtyInput.disabled = false;
            
        }
    }
});
</script>
@endsection

