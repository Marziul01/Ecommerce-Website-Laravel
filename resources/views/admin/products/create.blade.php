@extends('admin.master')

@section('title')
    ADD Products
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="d-sm-flex align-items-center justify-content-between mb-2">
                    
                        <h1>Add New Product</h1>
                    
                   
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
            <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <!-- Default box -->
                <div class="container " style="max-width: 100%">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="card mb-3">

                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="title">Product Name</label>
                                                <input type="text" name="name" id="name" class="form-control" placeholder="Name">
                                            </div>
                                            <div class="mb-3">
                                                <label for="title">Slug</label>
                                                <input type="text" name="slug" id="slug" class="form-control" placeholder="slug">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="description">Short Description</label>
                                                <textarea name="short_desc" class="form-control"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="description">Full Description</label>
                                                <textarea id="editor" name="full_desc" class="form-control"></textarea>
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
                                        <div id="featured-image-preview" class="image-preview"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h2 class="h4 mb-3">Product Gallery</h2>
                                    <div id="image" class="dropzone dz-clickable">
                                        <div class="dz-message needsclick">
                                            <br>Drop files here or click to upload.<br><br>
                                        </div>
                                    </div>
                                    <div class="row" id="image-wrapper">
                                </div>
                            </div>

                            <div class="card mb-3">
                                <div class="card-body">
                                    <h2 class="h4 mb-3">Pricing</h2>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="price">Making/Purchase Price</label>
                                                <input type="text" name="purchase_price" id="price" class="form-control" placeholder="Making/Purchase Price">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="price">Price</label>
                                                <input type="text" name="price" id="price" class="form-control" placeholder="Price">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="compare_price">Compare at Price</label>
                                                <input type="text" name="compare_price" id="compare_price" class="form-control" placeholder="Compare Price">
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
                                                <input type="text" name="sku" id="sku" class="form-control" placeholder="sku">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="barcode">Barcode</label>
                                                <input type="text" name="barcode" id="barcode" class="form-control" placeholder="Barcode">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="hidden" name="track_qty" value="NO">
                                                    <input class="custom-control-input" type="checkbox" id="track_qty" name="track_qty" value="YES" checked>
                                                    <label for="track_qty" class="custom-control-label">Track Quantity</label>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <input type="number" min="0" name="qty" id="qty" class="form-control" placeholder="Qty">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <h4>Additional Information</h4>
                                        <div id="additionalInfoContainer" class="mb-2"></div>
                                        <button type="button" class="btn btn-primary w-100" onclick="addNewInfo()">Add New Additional Information</button>
                                    </div>
                                </div>
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
                                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="category">Sub category</label>
                                        <select name="sub_category_id" id="sub_category" class="form-control">
                                            <option>Select a Sub Category</option>

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
                                                    <option value="{{ $brand->id }}">{{ $brand->name }}</option>
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
                                            <option value="NO">NO</option>
                                            <option value="YES">YES</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h2 class="h4 mb-3">Select Colors</h2>
                                    <div class="">
                                        <select id="colorSelect" class="form-control" name="color[]">
                                            @foreach($colors as $color)
                                                <option value="{{ $color->color }}">{{ $color->color }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <h2 class="h4 mb-3">Select Sizes</h2>
                                    <div class="mb-3">
                                        <select id="sizeSelect" class="form-control" name="size[]">
                                            @foreach($sizes as $size)
                                                <option value="{{ $size->size }}">{{ $size->size }}</option>
                                            @endforeach
                                        </select>
                                    </div>
{{--                                    <button type="button" id="generateVariationsBtn"class="btn btn-success">Generate Variations</button>--}}
                                </div>

                            </div>
                            <div class="card mb-3">
                                <div id="imageFields" class="card-body"></div>
                            </div>
                        </div>
                    </div>

                    <div class="pb-5 pt-3">
                        <button type="submit" class="btn btn-primary">Create</button>
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
        $(document).ready(function() {
            // Your JavaScript code// Function to generate a slug
            function generateSlug() {
                var name = $('#name').val().toLowerCase().trim();
                var slug = name.replace(/[^a-z0-9-]+/g, '-');
                $('#slug').val(slug);
            }

            // Initialize slug based on the name input
            generateSlug();

            // Listen for changes in the name input and update the slug input
            $('#name').on('input', function() {
                generateSlug();
            }); here
        });
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

    <script type="text/javascript">

        Dropzone.autoDiscover = false;
        const dropzone = $("#image").dropzone({
            url:  "{{ route('temp-images.create') }}",
            maxFiles: 10,
            paramName: 'image',
            addRemoveLinks: true,
            acceptedFiles: "image/jpeg,image/png,image/gif,image/jpg,image/webp",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }, success: function(file, response){
                var html = `<div class="col-md-3" id="product-image-row-${response.image_id}">
                            <div class="card image-card">
                                <a href="#" onclick="deleteImage(${response.image_id});" class="btn btn-danger">Delete</a>
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
                $("#product-image-row-"+id).remove();
            }
        }
    </script>

    <script>
        $('#colorSelect').select2({
            multiple: true
        });
        $('#sizeSelect').select2({
            multiple: true
        });

    </script>
    <script>
        function generateImages() {
            var selectedColors = $('#colorSelect').val();

            // Clear previous images
            $('#imageFields').empty();

            // Use a set to store unique colors
            var uniqueColors = new Set();

            // Add image fields based on selected options
            if (selectedColors.length > 0) {
                selectedColors.forEach(function(color) {
                    // Check if color is unique before appending image field
                    if (!uniqueColors.has(color)) {
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
        $('#colorSelect').on('change', function() {
            generateImages();
        });

        // Generate images on page load
        $(document).ready(function() {
            generateImages();
        });
    </script>

    <script>
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

        function createCloseButton() {
            var closeButton = document.createElement("button");
            closeButton.type = "button";
            closeButton.innerHTML = "Close";
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
    </script>

    @endsection

