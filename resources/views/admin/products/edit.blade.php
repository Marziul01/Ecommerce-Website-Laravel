@extends('admin.master')

@section('title')
    Edit Products
@endsection

@section('content')
    <script>
        // Encode PHP array as a JSON string and output it as a JavaScript variable
        var existingData = @json($existingData);

        // Call the populateExistingData function with the existing data
        document.addEventListener("DOMContentLoaded", function() {
            populateExistingData(existingData);
        });
    </script>
    <script>
        // Encode PHP array as a JSON string and output it as a JavaScript variable
        var variationsData = @json($variationsData);

        // Call the populateExistingData function with the existing data
        document.addEventListener("DOMContentLoaded", function() {
            populateVariationsData(variationsData);
        });
    </script>

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="d-sm-flex align-items-center justify-content-between mb-2">
                    
                        <h1>Edit Product</h1>
                    
                        <a href="{{ route('product.index') }}" class="btn btn-primary">Back</a>
                    
                </div>
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class="content">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="alert-ul">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('product.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
            <!-- Default box -->
                <div class="container" style="max-width: 100%">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="card mb-3">

                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="title">Product Name</label>
                                                <input type="text" name="name" id="name" class="form-control" placeholder="Name" value="{{ $product->name }}">
                                            </div>
                                            <div class="mb-3 d-none">
                                                <label for="title">Slug</label>
                                                <input type="text" name="slug" id="slug" class="form-control" placeholder="slug" value="{{ $product->slug }}">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="description">Short Description</label>
                                                <textarea name="short_desc" class="form-control">{{ $product->short_desc }}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="description">Full Description</label>
                                                <textarea id="editor" name="full_desc" class="form-control">{!! $product->full_desc !!} </textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h2 class="h4 mb-3">Product Featured Image</h2>
                                    <div id="featured-image">
                                        <div class="dz-message needsclick">
                                            <input type="file" name="featured_image" id="featured-image-upload" class="form-control" accept="image/*">
                                        </div>

                                        <h6 class="mt-2">Image Preview:</h6>
                                        <div id="image-preview" class="image-preview position-relative" style="margin-top: 10px; max-width: 200px;">
                                            <img id="preview-img" 
                                                src="{{ asset($product->featured_image ?? 'path/to/default-placeholder.jpg') }}" 
                                                class="img-fluid rounded border"
                                                alt="Preview Image">
                                            <br><br>
                                            <button type="button" id="remove-image" class="btn btn-sm btn-danger" style="position: absolute; top: 5px; right: 5px; background: red; color: white; border: none; border-radius: 50%; width: 30px; height: 30px; cursor: pointer;">
                                            🗑️</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h2 class="h4 mb-3">Product Gallery</h2>
                                    <div id="product-gallery" class="">
                                        <div id="image" class="dropzone dz-clickable">
                                            <div class="dz-message needsclick">
                                                <br>Drop files here or click to upload.<br><br>
                                            </div>
                                        </div>

                                        <div id="image-wrapper" class="row py-2">
                                            @if($productImages->isNotEmpty())
                                                @foreach ($productImages as $productImage)

                                                    <div class="col-md-3 mb-3" id="product-image-row-{{ $productImage->id }}">
                                                        <div class="card image-card">
                                                            <a href="#" onclick="deleteImage({{ $productImage->id }});" class="btn btn-danger">Delete</a>
                                                            <img src="{{ asset($productImage->images) }}" class="w-100" height="150px" style="object-fit:cover;">
                                                            <div class="card-body" style="display: none">

                                                                <input type="hidden" name="image_id[]"  value="{{ $productImage->id }}" class="form-control"/>

                                                            </div>
                                                        </div>
                                                    </div>

                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card mb-3">
                                <div class="card-body">
                                    <h2 class="h4 mb-3">Pricing</h2>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="buy_price">Making/Purchase Price</label>
                                                <input type="text" name="purchase_price" id="buy_price" class="form-control" placeholder="Making/Purchase Price" value="{{ $product->purchase_price }}">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="price">Price</label>
                                                <input type="text" name="price" id="price" class="form-control" placeholder="Price" value="{{ $product->price }}">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="compare_price">Sale Price</label>
                                                <input type="text" name="compare_price" id="compare_price" class="form-control" placeholder="Sale Price" value="{{ $product->compare_price }}">
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h2 class="h4 mb-3">Inventory</h2>
                                    <div class="row">
                                        <div class="col-md-12">
                                            
                                            <div class="mb-3">
                                                <input type="hidden" name="track_qty" value="YES">
                                                <input type="number" min="0" name="qty" id="qty" class="form-control" placeholder="Qty" value="{{ $product->qty }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="variationsContainer" class="card-body">
                                            <!-- Populated by JS -->
                                        </div>

                                        <button type="button" onclick="addNewVariations()" class="btn btn-primary">Add New Variation</button>
                            </div>
                            
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <h2 class="h4  mb-3">Product category</h2>
                                    <div class="mb-3">
                                        <label for="category">Category</label>
                                        <select name="category_id" id="category" class="form-control">
                                            <option>Select A Category</option>
                                            @if($categories->isNotEmpty())
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="category">Sub category</label>
                                        <select name="sub_category_id" id="sub_category" class="form-control">
                                            <option value="">Select a Sub Category</option>
                                            @if(isset($product))
                                                <option value="{{ $product->sub_category_id }}" selected>{{ $product->subCategory->name }}</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h2 class="h4 mb-3">Product brand</h2>
                                    <div class="mb-3">
                                        <select name="brand_id" id="brand" class="form-control">
                                            <option value="">Select A Brand</option>
                                            @if($brands->isNotEmpty())
                                                @foreach($brands as $brand)
                                                    <option value="{{ $brand->id }}" {{ $product->brand_id == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h2 class="h4 mb-3">Featured product</h2>
                                    <div class="mb-3">
                                        <select name="is_featured" id="is_featured" class="form-control">
                                            <option value="NO" {{ $product->is_featured == 'NO' ? 'selected' : '' }}>NO</option>
                                            <option value="YES" {{ $product->is_featured == 'YES' ? 'selected' : '' }}>YES</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="card mb-3">
                                <div id="additionalInfoContainer" class="card-body">
                                    <!-- Existing data will be populated here by JavaScript -->
                                </div>

                                <!-- Add button to trigger adding new information -->
                                <button type="button" onclick="addNewInfo()" class="btn btn-primary">Add New Info</button>
                            </div>
                        </div>
                    </div>
                    @if (Auth::guard('admin')->user()->access->product_manage == 3)
                    <div class="pb-5 pt-3">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                    @endif
                </div>

            </form><!-- /.card -->
        </section>
        <!-- /.content -->
    </div>
@endsection


@section('customjs')
    <script>
        ClassicEditor
            .create( document.querySelector( '#editor' ),{
                ckfinder: {
                    uploadUrl: "{{ route('ck.upload',['_token'=> csrf_token()]) }}",
                }
            } )
            .then( editor => {
                console.log( editor );
            } )
            .catch( error => {
                console.error( error );
            } );
    </script>

    <script>
        $("#category").change(function () {
            var category_id = $(this).val();
            $.ajax({
                url: '{{ route("product-subcategories") }}',
                type: 'get',
                data: { category_id: category_id },
                dataType: 'json',
                success: function (response) {
                    $("#sub_category").find("option").not(":first").remove();
                    $.each(response["subCategory"], function (key, item) {
                        $("#sub_category").append(`<option value='${item.id}'>${item.name}</option>`);
                    });
                },
                error: function () {
                    console.log("Something Went Wrong!");
                }
            });
        });
    </script>

    {{-- Edit previews --}}
    <script>

        Dropzone.autoDiscover = false;
        const dropzone = $("#image").dropzone({
            url:  "{{ route('product-images.store') }}",
            maxFiles: 10,
            paramName: 'image',
            addRemoveLinks: true,
            acceptedFiles: "image/jpeg,image/png,image/gif,image/jpg,image/webp",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }, success: function(file, response){
                var html = `<div class="col-md-3 mb-3" id="product-image-row-${response.image_id}">
                            <div class="card image-card">
                                <a href="#" onclick="deleteNewImage(${response.image_id});" class="btn btn-danger">Delete</a>
                                <img src="${response.imagePath}" class=" w-100 " height="150px" style="object-fit:cover;">
                                <div class="card-body" style="display: none">
                                    <input type="hidden" name="image_id[]" value="${response.image_id}"/>
                                </div>
                            </div>
                        </div>`;
                $("#image-wrapper").append(html);
                $("button[type=submit]").prop('disabled',false);
                this.removeFile(file);
            }
        });

        function deleteImage(id){
            if (confirm("Are you sure you want to delete?")) {
                var URL = "{{ route('product-images.delete','ID') }}";
                newURL = URL.replace('ID',id)

                $("#product-image-row-"+id).remove();

                $.ajax({
                    url: newURL,
                    data: {},
                    method: 'delete',
                    dataType:'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    success: function(response){
                        window.location.href='{{ route("product.edit",$product->id) }}';
                    }
                });
            }
        }


        function deleteNewImage(id){
            if (confirm("Are you sure you want to delete?")) {
                $("#product-image-row-"+id).remove();
            }
        }
    </script>

    <script>
        function populateExistingData(existingData) {
            var container = document.getElementById("additionalInfoContainer");

            existingData.forEach(function(data) {
                var input1 = createInput("text", "information[option][]", "Option Name", "form-control w-50", data.option);
                var input2 = createInput("text", "information[optionValue][]", "Informations", "form-control w-50", data.optionValue);
                var hiddenInput = createInput("hidden", "information[existing][]", "", "", "1");

                var deleteButton = createDeleteButton(data.id); // Pass the ID of the data to be deleted

                var infoContainer = document.createElement("div");
                infoContainer.className = "additional-info d-flex mb-2";

                infoContainer.appendChild(input1);
                infoContainer.appendChild(input2);
                infoContainer.appendChild(hiddenInput);
                infoContainer.appendChild(deleteButton);

                container.appendChild(infoContainer);

                // Attach event listener to the delete button
                deleteButton.addEventListener("click", function() {
                    // Call a function to delete data from the database using data.id
                    deleteDataFromDatabase(data.id);
                    // Remove the infoContainer from the DOM
                    container.removeChild(infoContainer);
                });
            });
        }

        function addNewInfo() {
            var container = document.getElementById("additionalInfoContainer");

            var input1 = createInput("text", "information[option][]", "Option Name", "form-control w-50");
            var input2 = createInput("text", "information[optionValue][]", "Informations", "form-control w-50");
            var closeButton = createCloseButton();

            var infoContainer = document.createElement("div");
            infoContainer.className = "additional-info d-flex mb-2";

            infoContainer.appendChild(input1);
            infoContainer.appendChild(input2);
            infoContainer.appendChild(closeButton);

            container.appendChild(infoContainer);

            // Attach event listener to the close button
            closeButton.addEventListener("click", function() {
                container.removeChild(infoContainer);
            });
        }

        function createDeleteButton(id) {
            var deleteButton = document.createElement("button");
            deleteButton.type = "button";
            deleteButton.innerHTML = "<i class='bi bi-x-circle-fill'></i>";
            deleteButton.className = "btn btn-danger ml-2";
            deleteButton.dataset.id = id; // Store the ID as a data attribute

            return deleteButton;
        }

        function createCloseButton() {
            var closeButton = document.createElement("button");
            closeButton.type = "button";
            closeButton.innerHTML = "<i class='bi bi-x-circle-fill'></i>";
            closeButton.className = "btn btn-danger ml-2";

            return closeButton;
        }

        function createInput(type, name, placeholder, className, value) {
            var input = document.createElement("input");
            input.type = type;
            input.name = name;
            input.placeholder = placeholder;
            input.className = className;
            input.value = value || ""; // Set the value if it exists

            return input;
        }

        function deleteDataFromDatabase(id) {
            // Add your logic here to delete data from the database using the provided ID
            // You may use AJAX or any other method to communicate with your server
            console.log("Deleting data with ID: " + id);
        }
    </script>


<script>
    // ======== 1. Populate Existing Variations =========
    function populateVariationsData(variationsData) {
        const container = document.getElementById("variationsContainer");

        variationsData.forEach(function(data) {
            const input1 = createInput("text", "variations[type][]", "Variation Name", "form-control w-25", data.type);
            const inputBuy = createInput("text", "variations[buy_price][]", "Buying Price", "form-control w-25", data.buy_price);
            const input2 = createInput("text", "variations[price][]", "Price", "form-control w-25", data.price);
            const input4 = createInput("text", "variations[compare_price][]", "Sale Price", "form-control w-25", data.compare_price);
            const input3 = createInput("number", "variations[qty][]", "Quantity", "form-control w-25 d-none", data.qty);
            const hiddenInput = createInput("hidden", "variations[existing_ids][]", "", "", data.id);

            const deleteButton = createDeleteButton(data.id);
            const infoContainer = document.createElement("div");
            infoContainer.className = "additional-info d-flex mb-2 align-items-center gap-2";

            infoContainer.appendChild(input1);
            infoContainer.appendChild(inputBuy);
            infoContainer.appendChild(input2);
            infoContainer.appendChild(input4);
            infoContainer.appendChild(input3);
            infoContainer.appendChild(hiddenInput);
            infoContainer.appendChild(deleteButton);

            container.appendChild(infoContainer);

            // Handle delete
            deleteButton.addEventListener("click", function() {
                deleteDataFromDatabase(data.id);
                container.removeChild(infoContainer);
                toggleMainInputs();
            });
        });

        // After populating, toggle main inputs based on variation presence
        toggleMainInputs();
    }

    // ======== 2. Add New Variation =========
    function addNewVariations() {
        const container = document.getElementById("variationsContainer");

        const input1 = createInput("text", "variations[type][]", "Variation Name", "form-control w-25");
        const inputBuy = createInput("text", "variations[buy_price][]", "Buying Price", "form-control w-25");
        const input2 = createInput("text", "variations[price][]", "Price", "form-control w-25");
        const input4 = createInput("text", "variations[compare_price][]", "Sale Price", "form-control w-25");
        const input3 = createInput("number", "variations[qty][]", "Quantity", "form-control w-25");
        const closeButton = createCloseButton();

        const infoContainer = document.createElement("div");
        infoContainer.className = "additional-info d-flex mb-2 align-items-center gap-2";

        infoContainer.appendChild(input1);
        infoContainer.appendChild(inputBuy);
        infoContainer.appendChild(input2);
        infoContainer.appendChild(input4);
        infoContainer.appendChild(input3);
        infoContainer.appendChild(closeButton);

        container.appendChild(infoContainer);

        toggleMainInputs(); // Disable main inputs

        // Remove on close
        closeButton.addEventListener("click", function() {
            container.removeChild(infoContainer);
            toggleMainInputs(); // Recheck if variations left
        });
    }

    // ======== 3. Create Button/Input Helpers =========
    function createDeleteButton(id) {
        const deleteButton = document.createElement("button");
        deleteButton.type = "button";
        deleteButton.innerHTML = "Delete";
        deleteButton.className = "btn btn-danger btn-sm";
        deleteButton.dataset.id = id;
        return deleteButton;
    }

    function createCloseButton() {
        const closeButton = document.createElement("button");
        closeButton.type = "button";
        closeButton.innerHTML = "✖";
        closeButton.className = "btn btn-danger btn-sm";
        return closeButton;
    }

    function createInput(type, name, placeholder, className, value) {
        const input = document.createElement("input");
        input.type = type;
        input.name = name;
        input.placeholder = placeholder;
        input.className = className;
        if (value) input.value = value;
        return input;
    }

    // ======== 4. Delete (placeholder for AJAX logic) =========
    function deleteDataFromDatabase(id) {
        // You can add your AJAX call here if needed
        console.log("Deleting variation with ID:", id);
    }

    // ======== 5. Disable/Enable main inputs when variations exist =========
    function toggleMainInputs() {
        const container = document.getElementById("variationsContainer");
        const qtyInput = document.getElementById("qty");
        const buyPriceInput = document.getElementById("buy_price");
        const priceInput = document.getElementById("price");
        const salePriceInput = document.getElementById("compare_price");

        if (container.children.length > 0) {
            qtyInput.value = "";
            buyPriceInput.value = "";
            priceInput.value = "";
            salePriceInput.value = "";

            qtyInput.disabled = true;
            buyPriceInput.disabled = true;
            priceInput.disabled = true;
            salePriceInput.disabled = true;
        } else {
            qtyInput.disabled = false;
            buyPriceInput.disabled = false;
            priceInput.disabled = false;
            salePriceInput.disabled = false;
        }
    }

    // ======== 6. Initialize on Page Load =========
    document.addEventListener("DOMContentLoaded", function() {
        // Example: Pass variations from backend (Laravel)
        const variationsData = @json($variations ?? []);
        if (variationsData.length > 0) {
            populateVariationsData(variationsData);
        } else {
            toggleMainInputs();
        }
    });
</script>


<script>
        const fileInput = document.getElementById('featured-image-upload');
        const previewContainer = document.getElementById('image-preview');
        const previewImg = document.getElementById('preview-img');
        const removeBtn = document.getElementById('remove-image');

        // Store the default (saved) image source
        const savedImage = previewImg.src;

        fileInput.addEventListener('change', function (event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    previewImg.src = e.target.result;
                    previewContainer.style.display = 'block';
                }
                reader.readAsDataURL(file);
            }
        });

        removeBtn.addEventListener('click', function () {
            if (fileInput.value) {
                // If a new image was uploaded, clear it and restore the saved one
                fileInput.value = "";
                previewImg.src = savedImage;
            } else {
                // If no new image uploaded, keep showing saved image but just reset input
                previewImg.src = savedImage;
            }
        });
</script>


@endsection

