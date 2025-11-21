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
                                            <div class="mb-3">
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
                                    <div id="featured-image" class="">
                                        <div class="dz-message needsclick">
                                            <input type="file" name="featured_image" id="featured-image-upload" accept="image/*">
                                        </div>
                                        <div id="featured-image-preview" class="image-preview">
                                            <h6>Previous Image :</h6><br>
                                            <img src="{{ asset($product->featured_image) }}" width="100px" height="100px">
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
                                                            <img src="{{ asset($productImage->images) }}" class="w-100" height="100px">
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
                                                <label for="price">Making/Purchase Price</label>
                                                <input type="text" name="purchase_price" id="price" class="form-control" placeholder="Making/Purchase Price" value="{{ $product->purchase_price }}">
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
                                                <label for="compare_price">Compare at Price</label>
                                                <input type="text" name="compare_price" id="compare_price" class="form-control" placeholder="Compare Price" value="{{ $product->compare_price }}">
                                                <p class="text-muted mt-3">
                                                    To show a reduced price, move the product’s original price into Compare at price. Enter a lower value into Price.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h2 class="h4 mb-3">Inventory</h2>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="sku">SKU (Stock Keeping Unit)</label>
                                                <input type="text" name="sku" id="sku" class="form-control" placeholder="sku" value="{{ $product->sku }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="barcode">Barcode</label>
                                                <input type="text" name="barcode" id="barcode" class="form-control" placeholder="Barcode" value="{{ $product->barcode }}">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="hidden" name="track_qty" value="NO">
                                                    <input class="custom-control-input" type="checkbox" id="track_qty" name="track_qty" value="YES" @if($product->track_qty == 'YES') checked @endif   >
                                                    <label for="track_qty" class="custom-control-label">Track Quantity</label>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <input type="number" min="0" name="qty" id="qty" class="form-control" placeholder="Qty" value="{{ $product->qty }}">
                                            </div>
                                        </div>
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
                                <div class="card-body">
                                    <h2 class="h4 mb-3">Select Colors</h2>
                                    <div class="">
                                        <select id="colorSelect1" class="form-control" name="color[]" multiple>
                                            @foreach($colors as $color)
                                                <option value="{{ $color->color }}" @if(in_array($color->color, $selectedColors)) selected @endif>
                                                    {{ $color->color }}
                                                </option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>
                                <div class="card-body">
                                    <h2 class="h4 mb-3">Select Sizes</h2>
                                    <div class="mb-3">
                                        <select id="sizeSelect1" class="form-control" name="size[]" multiple>
                                            @foreach($sizes as $size)
                                                <option value="{{ $size->size }}" @if(in_array($size->size, $selectedSizes)) selected @endif>
                                                    {{ $size->size }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="card mb-3">
{{--                                <p>** Don't upload image that are already uploaded if you change then chnage it from below **</p>--}}
                                <div id="imageFields" class="card-body"></div>
                            </div>
                            @if($product->productVariations->isNotEmpty())
                            <div class="card mb-3">
                                <div class="row card-body" style="margin-left: 0px !important;">
                                    <h5>Saved Colors Featured Image</h5>
                                    <p>** If you unselect a color also delete the image from here **</p>
                                    @foreach($product->productVariations as $image)
                                        <div class="card col-md-12 mb-3">
                                            <div class="card-body">
                                                <p>{{ $image->color }}</p>
                                                <div class="mb-2">
                                                    <img src="{{ asset($image->image) }}" height="100px">
                                                </div>
                                                <input type="hidden" value="{{ $image->id }}" name="imageId[]" >
                                                <label class="mb-2" style="display: inline-block">Change Image</label>
                                                <input type="file" name="colorImages[]" accept="image/*" class="form-control mb-2">
                                                <form action="{{ route('colorImageDelete', $image->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this colors featured image');">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-danger"><i class="bi bi-trash-fill"></i></button>
                                                </form>
                                            </div>

                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                    <div class="pb-5 pt-3">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>

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
                                <img src="${response.imagePath}" class=" w-100 " height="100px">
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
        $('#colorSelect1').select2({
            multiple: true
        });
        $('#sizeSelect1').select2({
            multiple: true
        });

    </script>
    <script>
        var selectedColors = @json($selectedColors);

        function generateImages() {
            var selectedColorsFromSelect = $('#colorSelect1').val();

            // Clear previous images
            $('#imageFields').empty();

            // Use a set to store unique colors
            var uniqueColors = new Set();

            // Add image fields based on selected options
            if (selectedColorsFromSelect.length > 0) {
                selectedColorsFromSelect.forEach(function(color) {
                    // Check if color is unique and not in $selectedColors before appending image field
                    if (!uniqueColors.has(color) && selectedColors.indexOf(color) === -1) {
                        appendImageField(color);
                        uniqueColors.add(color);
                    }
                });
            }
        }

        function appendImageField(color) {
            var imageField = '<div class="image-field mb-2">';
            imageField += '<label for="color">Upload Image for (Color: ' + color + '):</label>';
            imageField += '<input type="file" class="form-control" name="colorImage[featured][]" accept="image/*">';
            imageField += '<input type="hidden" name="variations[color1][]" value="' + color + '">';
            imageField += '</div>';

            $('#imageFields').append(imageField);
        }

        // Listen for changes in colorSelect
        $('#colorSelect1').on('change', function() {
            generateImages();
        });

        // Generate images on page load
        $(document).ready(function() {
            generateImages();
        });
    </script>





@endsection

