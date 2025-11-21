@extends('frontend.master')

@section('title')
    {{ $siteSettings->title }} | Checkout
@endsection

@section('content')

    <div class="page-header breadcrumb-wrap">
        <div class="container">
            <div class="breadcrumb">
                <a href="{{ route('home') }}" rel="nofollow">Home</a>
                <span></span> <a href="{{ route('shop') }}">Shop</a>
                <span></span> Checkout
            </div>
        </div>
    </div>
    <section class="mt-50 mb-50">
        <div class="container">
            @include('frontend.auth.frontMessage')
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="alert-ul">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="row">
                @if(!Auth::check())
                <div class="col-lg-6 mb-sm-15">
                    <div class="toggle_info">
                        <span><i class="fi-rs-user mr-10"></i><span class="text-muted">Already have an account?</span> <a href="#loginform" data-bs-toggle="collapse" class="collapsed" aria-expanded="false">Click here to login</a></span>
                    </div>
                    <div class="panel-collapse collapse login_form" id="loginform">
                        <div class="panel-body">
                            <p class="mb-30 font-sm">If you have shopped with us before, please enter your details below. If you are a new customer, please proceed to the Billing &amp; Shipping section.</p>
                            <form method="post" action="{{ route('user.checkout.login') }}">
                                @csrf
                                <div class="form-group">
                                    <input type="text" name="email" placeholder="Email">
                                </div>
                                <div class="form-group">
                                    <input type="password" name="password" placeholder="Password">
                                </div>
                                <div class="login_footer form-group">
                                    <div class="chek-form">
                                        <div class="custome-checkbox">
                                            <input class="form-check-input" type="checkbox" name="checkbox" id="remember" value="">
                                            <label class="form-check-label" for="remember"><span>Remember me</span></label>
                                        </div>
                                    </div>
                                    <a href="#">Forgot password?</a>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-md" name="login">Log in</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @endif
                <div class="col-lg-6">
                    <div class="toggle_info">
                        <span><i class="fi-rs-label mr-10"></i><span class="text-muted">Have a coupon?</span> <a href="#coupon" data-bs-toggle="collapse" class="collapsed" aria-expanded="false">Click here to enter your code</a></span>
                    </div>
                    <div class="panel-collapse collapse coupon_form " id="coupon">
                        <div class="panel-body">
                            <p class="mb-30 font-sm">If you have a coupon code, please apply it below.</p>
                                <div class="form-group">
                                    <input type="text" name="coupon_codes" id="coupon_codes" placeholder="Enter Coupon Code...">
                                </div>
                                <div class="form-group">
                                    <button type="button" class="btn  btn-md" id="apply_coupon">Apply Coupon</button>
                                </div>
                            <div>
                                <div id="remove_coupon_div_warpper">

                                </div>
                                <p id="show_error_message" style="color: red; font-size: 12px; display: none;">
                                    <i class="bi bi-x-circle-fill"></i>
                                    <span id="show_error_message_span"></span>
                                </p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="divider mt-50 mb-50"></div>
                </div>
{{--                @if ($errors->any())--}}
{{--                    <div class="alert alert-danger">--}}
{{--                        <ul class="alert-ul">--}}
{{--                            @foreach ($errors->all() as $error)--}}
{{--                                <li>{{ $error }}</li>--}}
{{--                            @endforeach--}}
{{--                        </ul>--}}
{{--                    </div>--}}
{{--                @endif--}}
            </div>
            <form method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-25">
                            <h4>Billing Details</h4>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <input type="text" required="" name="first_name" placeholder="First name *" value="{{ (isset($userInfo)) ? $userInfo->first_name : '' }}">
                            </div>
                            <div class="form-group col-md-6">
                                <input type="text" required="" name="last_name" placeholder="Last name *" value="{{ (!empty($userInfo)) ? $userInfo->last_name : '' }}">
                            </div>
                            <div class="form-group col-md-6">
                                <input required="" type="text" name="phone" placeholder="Phone *" value="{{ (!empty($userInfo)) ? $userInfo->phone : '' }}">
                            </div>
                            <div class="form-group col-md-6">
                                <input required="" type="text" name="email" placeholder="Email address *" value="{{ (!empty($userInfo)) ? $userInfo->email : '' }}">
                            </div>
                            <div class="form-group col-md-6">
                                <div class="custom_select">
                                     <select class="form-control" name="country" id="country">
                                        <option value="">Select a Country</option>
                                        @foreach($countries as $country)
                                            <option value="{{ $country->code }}" >{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <div class="custom_select">
                                    <select class="form-control" name="state" id="state">
                                        <option value="">Select a District</option>
                                        @foreach($states as $state)
                                            <option value="{{ $state }}">{{ $state }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-md-12">
                                <div>
                                    <div style="position: relative;">
                                        <input type="text" name="billing_address" id="selectedAddress" onclick="toggleDropdown()" placeholder="Address">
                                        <div id="addressDropdown" class="address-dropdown" style="background: white; color: black; box-shadow: 0 0 3px grey; padding: 5px 20px; display: none;position: absolute;z-index: 1;" onclick="handleDropdownClick(event)">
                                            <div onclick="setSelectedAddress('billing')">Billing Address</div>
                                            <div onclick="setSelectedAddress('shipping')">Shipping Address</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @if(!Auth::check())
                            <div class="form-group">
                                <div class="checkbox">
                                    <div class="custome-checkbox">
                                        <input class="form-check-input" type="checkbox" name="create_account" value="Yes" id="createaccount">
                                        <label class="form-check-label label_info" data-bs-toggle="collapse" href="#collapsePassword" data-target="#collapsePassword" aria-controls="collapsePassword" for="createaccount"><span>Create an account?</span></label>
                                    </div>
                                </div>
                            </div>

                            <div id="collapsePassword" class="form-group create-account collapse in">
                                <input type="password" placeholder="Password" name="password">
                            </div>

                            @endif

                            <div class="ship_detail">
                                <div class="form-group">
                                    <div class="chek-form">
                                        <div class="custome-checkbox">
                                            <input class="form-check-input" type="checkbox" name="differentaddress" id="differentaddress" value="Yes">
                                            <label class="form-check-label label_info" data-bs-toggle="collapse" data-target="#collapseAddress" href="#collapseAddress" aria-controls="collapseAddress" for="differentaddress"><span>Ship to a different address?</span></label>
                                        </div>
                                    </div>
                                </div>

                                <div id="collapseAddress" class="different_address collapse in">
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <input type="text" name="shipping_first_name" placeholder="First name *">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <input type="text" name="shipping_last_name" placeholder="Last name *">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <input type="text" name="shipping_phone" placeholder="Phone *">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <div class="custom_select">
                                                <select class="form-control" name="shipping_country" id="shipping_country">
                                                    <option value="">Select a Country</option>
                                                    @foreach($countries as $country)
                                                        <option value="{{ $country->code }}">{{ $country->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <div class="custom_select">
                                                <select class="form-control" name="shipping_state" id="shipping_state">
                                                    <option value="">Select a District</option>
                                                    @foreach($states as $state)
                                                        <option value="{{ $state }}" {{ (!empty($userInfo) && $userInfo->state == $state) ? 'selected' : '' }}>{{ $state }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <input type="text" name="shipping_address" placeholder="Address *">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-20">
                                <h5>Additional information</h5>
                            </div>

                            <div class="form-group mb-30">
                                <textarea rows="5" name="notes" placeholder="Order notes"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="order_review">
                            <div class="mb-20">
                                <h4>Your Orders</h4>
                            </div>
                            <div class="table-responsive order_table text-center">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th colspan="2">Product</th>
                                        <th>Total</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($cartContent as $item)
                                    <tr>
                                        <td class="image product-thumbnail"><img src="{{ asset($item->options['image']) }}" alt="#"></td>
                                        <td>
                                            <h5><a href="{{ route('products', $item->options['slug']) }}">{{ $item->name }}</a></h5> <span class="product-qty">x {{ $item->qty }} <br> {{ $item->options['color'] }} x {{ $item->options['size'] }}</span>
                                        </td>
                                        <td>{{ $item->price*$item->qty }}</td>
                                    </tr>
                                    @endforeach
                                    <tr>
                                        <th>SubTotal</th>
                                        <td class="product-subtotal" colspan="2">{{ Cart::subtotal() }}</td>
                                    </tr>
                                    <tr>
                                        <th>Shipping</th>
                                        <td colspan="2" id="shipping_charge_display"><em> 0.00</em></td>
                                        <input type="hidden" name="shipping_charge" id="shipping_charge" value="">
                                    </tr>
                                    <tr>
                                        <th>Discount</th>
                                        <td colspan="2" id="discount_display"><em>@if(isset($discount))
                                                    {{$discount}} @else 0.00 @endif</em>

                                            <div id="">
                                                @if(Session::has('code'))
                                                    <div class="d-flex justify-content-center align-items-center" id="remove_coupon_div">
                                                        <p style="font-size: 12px"> COUPON: <strong>{{ Session::get('code')->code }}</strong> </p>
                                                        <button class="btn btn-sm btn-danger" id="removeCoupon" style="padding: 0px 2px !important; margin-left: 5px"><i class="bi bi-trash"></i></button>
                                                    </div>
                                                @endif
                                            </div>
                                        </td>

                                        <input type="hidden" name="discount_charge" id="discount_charge" value="">
                                    </tr>
                                    <tr>
                                        <th>Total</th>
                                        <td colspan="2" class="product-total"><span id="total_display" class="font-xl text-brand fw-900">$0.00</span></td>
                                        <input type="hidden" name="subtotal" id="subtotal" value="">
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="bt-1 border-color-1 mt-30 mb-30"></div>
                            <div class="payment_method">
                                <div class="mb-25">
                                    <h5>Payment</h5>
                                </div>
                                <div class="payment_option">
                                    <div class="payment_option">
                                        @foreach($payment_methods as $method)
                                            <div class="custome-radio mt-3">
                                                <input 
                                                    class="form-check-input" 
                                                    type="radio" 
                                                    name="payment_option" 
                                                    value="{{ $method->id }}" 
                                                    id="payment_option_{{ $method->id }}" 
                                                    data-method-type="{{ $method->type }}"
                                                    data-bs-toggle="collapse" 
                                                    data-bs-target="#multiCollapseExample{{ $method->id }}" 
                                                    aria-expanded="false" 
                                                    aria-controls="multiCollapseExample{{ $method->id }}">
                                                <label class="form-check-label" for="payment_option_{{ $method->id }}">
                                                    {{ $method->name }}
                                                </label>
                                            </div>
                                        @endforeach
                                    
                                        <div class="accordion mt-3" id="paymentMethodsAccordion">
                                            @foreach($payment_methods as $method)
                                                <div class="row">
                                                    <div class="col">
                                                        <div class="collapse" 
                                                            id="multiCollapseExample{{ $method->id }}" 
                                                            data-bs-parent="#paymentMethodsAccordion">
                                                            <div class="card card-body">
                                                                <div>Note: {{ $method->note }}</div>
                                                                @if ($method->type == 'Online Banking' || $method->type == 'Bank Account' )
                                                                <div class="row py-3">
                                                                    @if ($method->type == 'Online Banking')
                                                                        <div class="col-6">{{ $method->name }} Number: {{ $method->number }}</div>
                                                                    @endif
                                                                    @if ($method->type == 'Bank Account')
                                                                        <div class="col-6">Account Number: {{ $method->number }}</div>
                                                                        <div class="col-6">Account Name: {{ $method->account_name }}</div>
                                                                        <div class="col-6">Bank Name: {{ $method->bank_name }}</div>
                                                                        <div class="col-6">Branch Name: {{ $method->branch_name }}</div>
                                                                    @endif
                                                                </div>
                                                                <div class="row">
                                                                    @if ($method->type == 'Online Banking')
                                                                        <input type="text" class="form-control" name="payment_number{{ $method->id }}" placeholder="Transaction ID*">
                                                                        <label class="mt-2" for="">Payment Receipt Screenshot*</label>
                                                                        <input type="file" name="payment_prove{{$method->id}}" class="form-control" accept="image/*">
                                                                    @endif
                                                                    @if ($method->type == 'Bank Account')
                                                                        <input type="number" class="form-control" name="payment_number{{ $method->id }}" placeholder="Sender Bank Account Number">
                                                                        <label class="mt-2" for="">Payment Receipt Screenshot*</label>
                                                                        <input type="file" name="payment_prove{{$method->id}}" class="form-control" accept="image/*">
                                                                    @endif
                                                                </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                            <button type="submit" class="btn btn-fill-out btn-block mt-30">Place Order</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>

@endsection

@section('customJs')

    @if(\Illuminate\Support\Facades\Auth::check())
        @if(isset($userInfo->billing_address))
    <script>
        function toggleDropdown() {
            var dropdown = document.getElementById('addressDropdown');
            dropdown.style.display = (dropdown.style.display === 'block') ? 'none' : 'block';
        }

        function setSelectedAddress(addressType) {
            // Assuming $userInfo is an object containing billing and shipping addresses
            var selectedAddress = (addressType === 'billing') ? "<?php echo $userInfo->billing_address; ?>" : "<?php echo $userInfo->shipping_address; ?>";

            // Update the input field with the selected address
            document.getElementById('selectedAddress').value = selectedAddress;

            // Update the name attribute based on the selected address type
            document.getElementById('selectedAddress').name = (addressType === 'billing') ? 'billing_address' : 'shipping_address';

            // Hide the dropdown after selection
            document.getElementById('addressDropdown').style.display = 'none';
        }

        // Close the dropdown if the user clicks outside of it
        window.onclick = function(event) {
            var dropdown = document.getElementById('addressDropdown');
            if (event.target !== dropdown && event.target !== document.getElementById('selectedAddress')) {
                dropdown.style.display = 'none';
            }
        };
    </script>
        @endif
    @endif

    <script>
        function calculateShipping() {
            var state = $("#state").val();
            var country = $("#country").val();
            var shipping_state = $("#shipping_state").val();
            var shipping_country = $("#shipping_country").val();
            var differentaddress = $("#differentaddress").prop("checked") ? "Yes" : "No";

            $.ajax({
                url: '{{ route("calculateShipping") }}',
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    state: state,
                    country: country,
                    shipping_country: shipping_country,
                    shipping_state: shipping_state,
                    differentaddress: differentaddress,
                },
                dataType: 'json',
                success: function (response) {
                    if (response.status == true) {
                        $("#total_display").html(response.grandTotal);
                        $("#shipping_charge_display").html(response.shippingCharge);
                        $("#discount_display").html(response.discount);
                        $("#shipping_charge").val(response.shippingCharge);
                        $("#discount_charge").val(response.discount);
                        $("#subtotal").val(response.grandTotal);
                        $("#remove_coupon_div_warpper").html(response.couponDiv);
                    }
                }
            });
        }

        // Attach the event listener to both #shipping_state, #state, and #differentaddress
        $("#shipping_state, #state, #differentaddress").change(calculateShipping);
    </script>

    <script>

        $("#apply_coupon").click(function () {

            var state = $("#state").val();
            var country = $("#country").val();
            var shipping_state = $("#shipping_state").val();
            var shipping_country = $("#shipping_country").val();
            var differentaddress = $("#differentaddress").prop("checked") ? "Yes" : "No";

            $.ajax({
                url: '{{ route("applyCoupon") }}',
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    coupons: $("#coupon_codes").val(),
                    state: state,
                    country: country,
                    shipping_country: shipping_country,
                    shipping_state: shipping_state,
                    differentaddress: differentaddress,
                },
                dataType: 'json',
                success: function (response) {
                    if (response.status == true) {
                        $("#total_display").html(response.grandTotal);
                        $("#shipping_charge_display").html(response.shippingCharge);
                        $("#discount_display").html(response.discount);
                        $("#shipping_charge").val(response.shippingCharge);
                        $("#discount_charge").val(response.discount);
                        $("#subtotal").val(response.grandTotal);
                        $("#remove_coupon_div_warpper").html(response.couponDiv);
                        $("#show_error_message").hide();
                    }
                    else{
                        $("#show_error_message").show();
                        $("#show_error_message_span").html(response.message);
                    }
                }
            });
        });

    </script>
    <script>
        $('body').on('click',"#removeCoupon",function () {
            var state = $("#state").val();
            var country = $("#country").val();
            var shipping_state = $("#shipping_state").val();
            var shipping_country = $("#shipping_country").val();
            var differentaddress = $("#differentaddress").prop("checked") ? "Yes" : "No";

            $.ajax({
                url: '{{ route("removeCoupon") }}',
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    state: state,
                    country: country,
                    shipping_country: shipping_country,
                    shipping_state: shipping_state,
                    differentaddress: differentaddress,
                },
                dataType: 'json',
                success: function (response) {
                    if (response.status == true) {
                        $("#total_display").html(response.grandTotal);
                        $("#shipping_charge_display").html(response.shippingCharge);
                        $("#discount_display").html(response.discount);
                        $("#shipping_charge").val(response.shippingCharge);
                        $("#discount_charge").val(response.discount);
                        $("#subtotal").val(response.grandTotal);
                        $("#coupon_codes").val('');
                        $("#remove_coupon_div_warpper").html('');
                    }
                }
            });
        });

        // $("#removeCoupon").click(function () {
        //
        // });

    </script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const paymentOptions = document.querySelectorAll('input[name="payment_method"]');
        const dynamicFields = document.getElementById('dynamic-fields');

        paymentOptions.forEach(option => {
            option.addEventListener('change', function () {
                const selectedType = this.dataset.methodType;

                // Hide all fields first
                document.querySelectorAll('.fields-group').forEach(group => group.classList.add('d-none'));

                // Show the relevant fields based on selected type
                if (selectedType) {
                    document.getElementById(`fields-${selectedType}`).classList.remove('d-none');
                }
            });
        });
    });
</script>

<!-- Toastr CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>


<script>
$(document).ready(function() {

    $("form").on("submit", function(e){
        e.preventDefault();

        $("#loaderOverlay").show(); // show loader

        let formData = new FormData(this);

        $.ajax({
            url: "{{ route('order') }}",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,

            success: function(res) {
                $("#loaderOverlay").hide();

                if(res.status === "error"){
                    toastr.error(res.message);
                    return;
                }

                toastr.success(res.message);

                setTimeout(() => {
                    window.location.href = res.redirect;
                }, 1000);
            },

            error: function(xhr) {
                $("#loaderOverlay").hide();

                if(xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    $.each(errors, function(key, value) {
                        toastr.error(value[0]);
                    });
                } 
                else {
                    toastr.error("Something went wrong!");
                }
            }
        });
    });

});
</script>



@endsection


