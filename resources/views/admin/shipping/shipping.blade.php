

@extends('admin.master')

@section('title')
    Shipping Methods
@endsection

@section('content')

    <div class="container-fluid">
        @include('admin.auth.message')
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="alert-ul">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
    @endif
    <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Shipping Methods</h1>
            <a href="#" class="d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#AddShippingModal">
                <i class="bi bi-file-earmark-plus"></i> Add New</a>
        </div>

        <div class="card">
            <div class="card-body">
                <table class="table table-bordered table-hover table-striped table-responsive-md">
                    <thead>
                    <tr>
                        <th>Sl</th>
                        <th>Country</th>
                        <th>Shipping Area</th>
                        <th>Price</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if($shippings->isNotEmpty())
                        @foreach($shippings as $shipping)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $shipping->country->name }}</td>
                                <td>{{ $shipping->shipping_area }}</td>
                                <td>{{ $shipping->price }}</td>
                                <td class="table-action-td">
                                    <a class="btn btn-sm btn-primary" data-toggle="modal" data-target="#EditShippingModal_{{ $shipping->id }}"><i class="bi bi-pen-fill"></i> Edit</a>

                                    <form action="{{ route('shippingDelete', $shipping->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this Shipping Method?');">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-danger"><i class="bi bi-trash-fill"></i> Delete</button>
                                    </form>

                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="5"> No Shipping Methods Found !!! </td>
                        </tr>
                    @endif

                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                {{ $shippings->links() }}
            </div>
        </div>

    </div>




    {{--    Add Category Model--}}

    <div class="modal fade" id="AddShippingModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    Add New Shipping Methods
                </div>
                <div class="modal-body">
                    <form action="{{ route('shippingStore') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>Select Country</label>
                            <select class="form-control" name="country_code" id="country_select">
                                <option value="">Select a Country *</option>
                                @foreach($countries as $country)
                                    <option value="{{ $country->code}}">{{ $country->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group admin-shipping-form">
                            <label>Select Area</label><br>
                            <select class="form-control select2 w-100" name="district[]" id="district" multiple="multiple">
                                <option value="">Select Area *</option>
                                @foreach($districts as $district)
                                    <option value="{{ $district->name }}">{{ $district->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        {{-- <div class="form-group" id="shipping_area_group" style="display: none;">
                            <label for="exampleInputEmail1">Shipping Area *</label>
                            <select class="form-control" name="shipping_area" id="shipping_type">
                                <option value="">Select Area</option>
                                <option value="Inside Dhaka">Inside Dhaka</option>
                                <option value="Outside Dhaka">Outside Dhaka</option>
                            </select>
                        </div> --}}
                        <div class="form-group" id="price_group">
                            <label for="exampleInputEmail1">Price *</label>
                            <input type="number" class="form-control" name="price">
                        </div>
                        <button type="submit" class="btn btn-primary">Create</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{--    Edit Category Model--}}
    @if(isset($shipping))
        @foreach($shippings as $shipping)
            <div class="modal fade" id="EditShippingModal_{{ $shipping->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <!-- Modal content goes here, make sure to customize it for each category -->
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            Edit Shipping Methods
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('shippingUpdate', $shipping->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label>Select Country</label>
                                    <select class="form-control country_select" disabled>
                                        <option value="">Select a Country *</option>
                                        @foreach($countries as $country)
                                            <option value="{{ $country->code }}" {{ $shipping->country_id == $country->id ? 'selected' : '' }}>{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                    <input type="hidden" value="{{ $shipping->country->code }}" name="country_code">
                                </div>
                                <div class="form-group shipping_area_group" id="shipping_area_group_edit">
                                    <label for="exampleInputEmail1">Shipping Area *</label>
                                    <select class="form-control shipping_type" disabled>
                                        <option value="">Select Area</option>
                                        <option value="Inside Dhaka" {{ $shipping->shipping_area == 'Inside Dhaka' ? 'selected' : '' }}>Inside Dhaka</option>
                                        <option value="Outside Dhaka" {{ $shipping->shipping_area == 'Outside Dhaka' ? 'selected' : '' }}>Outside Dhaka</option>
                                    </select>
                                    <input type="hidden" value="{{ $shipping->shipping_area }}" name="shipping_area">
                                </div>

                                <div class="form-group fixed_price_group" id="fixed_price_group_edit">
                                    <label for="exampleInputEmail1">Price *</label>
                                    <input type="number" class="form-control" name="price" value="{{ $shipping->price }}">
                                </div>
                                <button type="submit" class="btn btn-primary">Update</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        {{--    <div class="modal fade" id="EditCategoryModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"--}}
        {{--         aria-hidden="true">--}}
        {{--        --}}
        {{--    </div>--}}
    @endif



@endsection

@section('customjs')
    <script>
        $(document).ready(function() {
            // Initially hide the minimum price input and the Shipping Area input
            $("#min_price_group, #shipping_area_group").hide();

            // Add change event listener to both the shipping type select and the country select
            $("#shipping_type, #country_select").change(function() {
                // Check if the changed element is the shipping type select
                if ($(this).attr('id') === 'shipping_type') {
                    // Get the selected value
                    var selectedShippingType = $(this).val();

                    // Show/hide the input fields based on the selected shipping type
                    if (selectedShippingType === "Free Shipping") {
                        $("#fixed_price_group").hide();
                        $("#min_price_group").show();
                    } else if (selectedShippingType === "Fixed Price") {
                        $("#fixed_price_group").show();
                        $("#min_price_group").hide();
                    }
                } else if ($(this).attr('id') === 'country_select') {
                    // Get the selected value
                    var selectedCountry = $(this).val();

                    // Show/hide the input fields based on the selected country
                    if (selectedCountry === "BD") {
                        $("#region_group").hide();
                        $("#restCountry_price_group").hide();
                        $("#shipping_area_group").show();
                    } else {
                        $("#region_group").show();
                        $("#restCountry_price_group").show();
                        $("#shipping_area_group").hide();
                    }
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            // Disable user interaction with the select
            $("#example").attr("disabled", true);

            // Optionally, prevent the select from being visually altered
            $("#example").css("pointer-events", "none");
        });
    </script>
    <script>
        $(document).ready(function() {
            // Disable user interaction with the select
            $("#exampleType").attr("disabled", true);

            // Optionally, prevent the select from being visually altered
            $("#exampleType").css("pointer-events", "none");
        });
    </script>
<script>
    $(document).ready(function() {
    $('#district').select2({
        placeholder: "Select Area *",
        allowClear: true,
    });
});
</script>


@endsection


