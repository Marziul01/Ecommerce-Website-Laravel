<div class="modal fade checkout-modal" id="checkoutModal" tabindex="-1" aria-hidden="true">

    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0">
            <div id="checkoutLoader" class="text-center py-5">
                    <div class="spinner-border text-primary" role="status"></div>
                    <p class="mt-2">Loading checkout...</p>
                </div>
            <!-- HEADER -->
            <div class="modal-header">
                <h5 class="modal-title">Checkout</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- BODY -->
            <div class="modal-body">
                
                <div id="checkoutContent" style="display:none;">
                    <form id="checkoutContentForm" action="{{ route('order') }}" method="POST">
                        @csrf

                        <div class="row g-4">
                            <div class="col-lg-7">
                                <h6 class="mb-3">Billing Details</h6>
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <input type="text" name="name" placeholder="Full Name *"
                                            value="{{ Auth::check() && Auth::user()->userInfo ? Auth::user()->userInfo->first_name . ' ' . Auth::user()->userInfo->last_name : '' }} "
                                            required>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <input type="text" name="phone" placeholder="Phone *"
                                            value="{{ Auth::check() && Auth::user()->userInfo ? Auth::user()->userInfo->phone : '' }}"
                                            required>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <input type="text" name="email" placeholder="Email address"
                                            value="{{ Auth::check() && Auth::user()->userInfo ? Auth::user()->userInfo->email : '' }}">
                                    </div>
                                    
                                    <input type="hidden" value="BD" name="country">

                                    <div class="form-group col-md-12">
                                        <div class="custom_select">
                                            <select class="form-control mt-0 mb-0" name="state" id="state">
                                                <option value="">Select a District</option>
                                                @foreach ($states as $state)
                                                    <option value="{{ $state }}">{{ $state }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <input type="text" name="billing_address" placeholder="Address" required>
                                    </div>
                                    <div class="mb-20">
                                        <h5>Additional information</h5>
                                    </div>
                                    <div class="form-group mb-30">
                                        <textarea rows="4" name="notes" placeholder="Order notes"></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-5">
                                <h6 class="mb-3">Your Order</h6>
                                <div class="w-100" id="checkoutItems">
                                    {{-- @foreach ($cartContent as $item)
                                    <div class="d-flex justify-content-between align-items-start mt-2 gap-3 border-bottom-1 w-100">
                                        <div class="d-flex justify-content-start align-items-start w-75 gap-3">
                                            <img src="{{ asset($item->options['image']) }}" alt="#"
                                                width="30%">
                                            <div class="w-70">
                                                <h6>
                                                    <a href="{{ route('products', $item->options['slug']) }}">
                                                        {{ $item->name }}
                                                    </a>
                                                </h6>

                                                <span class="product-qty font-sm">
                                                    Qty : {{ $item->qty }} <br>
                                                    {{ !empty($item->options['variation_id']) ? $item->options['variation_name'] : '' }}
                                                </span>
                                            </div>
                                        </div>

                                        <div class="w-25">{{ $item->price * $item->qty }} BDT</div>
                                    </div>
                                @endforeach --}}
                                </div>
                                <div>

                                    <div class="panel-collapse coupon_form p-2" id="coupon">
                                        <div class=" mt-0">
                                            <p class="mb-2 font-sm">If you have a coupon code, please apply it below.
                                            </p>
                                            <div class="form-group">
                                                <input type="text" name="coupon_codes" id="coupon_codes"
                                                    placeholder="Enter Coupon Code...">
                                            </div>
                                            <div class="form-group">
                                                <button type="button" class="btn btn-sm" id="apply_coupon">Apply
                                                    Coupon</button>
                                            </div>
                                            <div>
                                                <div id="remove_coupon_div_warpper">

                                                </div>
                                                <p id="show_error_message"
                                                    style="color: red; font-size: 12px; display: none;">
                                                    <i class="bi bi-x-circle-fill"></i>
                                                    <span id="show_error_message_span"></span>
                                                </p>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <div
                                        class="d-flex justify-content-between align-items-center mt-15 pb-2 border-bottom-1">
                                        <div>SubTotal</div>
                                        <div class="product-subtotal">{{ Cart::subtotal() }} BDT</div>
                                    </div>

                                    <!-- Shipping -->
                                    <div
                                        class="d-flex justify-content-between align-items-center mt-15 pb-2 border-bottom-1">
                                        <div>Shipping</div>
                                        <div>
                                            <em id="shipping_charge_display">0.00 BDT</em>
                                            <input type="hidden" name="shipping_charge" id="shipping_charge"
                                                value="">
                                        </div>
                                    </div>

                                    <!-- Discount -->
                                    <div
                                        class="d-flex justify-content-between align-items-center mt-15 pb-2 border-bottom-1">
                                        <th>Discount</th>
                                        <div>
                                            <em id="discount_display">
                                                @if (isset($discount))
                                                    {{ $discount }} BDT
                                                @else
                                                    0.00 BDT
                                                @endif
                                            </em>

                                            @if (Session::has('code'))
                                                <div class="d-flex justify-content-center align-items-center"
                                                    id="remove_coupon_div">
                                                    <p style="font-size: 12px">
                                                        COUPON: <strong>{{ Session::get('code')->code }}</strong>
                                                    </p>
                                                    <button class="btn btn-sm btn-danger" id="removeCoupon"
                                                        style="padding: 0px 2px !important; margin-left: 5px">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </div>
                                            @endif

                                            <input type="hidden" name="discount_charge" id="discount_charge"
                                                value="">
                                        </div>
                                    </div>

                                    <!-- Total -->
                                    <div class="d-flex justify-content-between align-items-center mt-15 fw-900 font-xl">
                                        <div>Total</div>
                                        <div class="product-total">
                                            <span id="total_display" class="font-xl text-brand fw-900">0.00 BDT</span>
                                            <input type="hidden" name="subtotal" id="subtotal" value="">
                                        </div>
                                    </div>
                                </div>

                                <div class="payment_method card card-body mt-3">
                                    <div class="mb-2">
                                        <p>Payment Methods</p>
                                    </div>
                                    <div class="payment_option">

                                        @foreach ($payment_methods as $index => $method)
                                            <div class="custome-radio mb-2">
                                                <input
                                                    class="form-check-input payment-radio"
                                                    type="radio"
                                                    name="payment_option"
                                                    value="{{ $method->id }}"
                                                    data-id="{{ $method->id }}"
                                                    id="payment_option_{{ $method->id }}"
                                                    {{ $index === 0 ? 'checked' : '' }}
                                                >

                                                <label class="form-check-label p-0"
                                                    for="payment_option_{{ $method->id }}">
                                                    {{ $method->name }}
                                                </label>
                                            </div>
                                        @endforeach

                                        <!-- Payment Details -->
                                        <div class="mt-3">
                                            @foreach ($payment_methods as $method)
                                                <div class="payment-collapse"
                                                    data-id="{{ $method->id }}">

                                                    <div class="card card-body">
                                                        <div class="mb-2">
                                                            <strong>Note:</strong> {{ $method->note }}
                                                        </div>

                                                        @if ($method->type == 'Online Banking' || $method->type == 'Bank Account')

                                                            <div class="row py-2">

                                                                @if ($method->type == 'Online Banking')
                                                                    <div class="col-12">
                                                                        {{ $method->name }} Number: {{ $method->number }}
                                                                    </div>
                                                                @endif

                                                                @if ($method->type == 'Bank Account')
                                                                    <div class="col-6">Account Number: {{ $method->number }}</div>
                                                                    <div class="col-6">Account Name: {{ $method->account_name }}</div>
                                                                    <div class="col-6">Bank Name: {{ $method->bank_name }}</div>
                                                                    <div class="col-6">Branch Name: {{ $method->branch_name }}</div>
                                                                @endif

                                                            </div>

                                                            <div class="mt-3">
                                                                <input type="text"
                                                                    class="form-control mb-2"
                                                                    name="payment_number_{{ $method->id }}"
                                                                    placeholder="Transaction / Account Number*">

                                                                <label class="mb-1">Payment Receipt Screenshot*</label>
                                                                <input type="file"
                                                                    name="payment_prove_{{ $method->id }}"
                                                                    class="form-control"
                                                                    accept="image/*">
                                                            </div>

                                                        @endif
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>

                                    </div>
                                </div>
                                <button type="submit" class="btn btn-fill-out btn-block mt-30">Place Order</button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>

        </div>

    </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', function () {

    const radios = document.querySelectorAll('.payment-radio');
    const collapses = document.querySelectorAll('.payment-collapse');

    function showCollapse(id) {
        collapses.forEach(collapse => {
            collapse.classList.remove('active');
        });

        const target = document.querySelector(
            `.payment-collapse[data-id="${id}"]`
        );

        if (target) {
            target.classList.add('active');
        }
    }

    // Click / change handler
    radios.forEach(radio => {
        radio.addEventListener('change', function () {
            showCollapse(this.dataset.id);
        });
    });

    // 🔥 Auto select & open FIRST option
    const firstRadio = document.querySelector('.payment-radio');

    if (firstRadio) {
        firstRadio.checked = true;
        showCollapse(firstRadio.dataset.id);
    }

});
</script>


@if (\Illuminate\Support\Facades\Auth::check())
    @if (isset($userInfo->billing_address))
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
                document.getElementById('selectedAddress').name = (addressType === 'billing') ? 'billing_address' :
                    'shipping_address';

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




        $.ajax({
            url: '{{ route('calculateShipping') }}',
            type: 'post',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                state: state,
                country: country,



            },
            dataType: 'json',
            success: function(response) {
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
    $("#state").change(calculateShipping);
</script>

<script>
    $("#apply_coupon").click(function() {

        var state = $("#state").val();
        var country = $("#country").val();


        $.ajax({
            url: '{{ route('applyCoupon') }}',
            type: 'post',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                coupons: $("#coupon_codes").val(),
                state: state,
                country: country,

            },
            dataType: 'json',
            success: function(response) {
                if (response.status == true) {
                    $("#total_display").html(response.grandTotal);
                    $("#shipping_charge_display").html(response.shippingCharge);
                    $("#discount_display").html(response.discount);
                    $("#shipping_charge").val(response.shippingCharge);
                    $("#discount_charge").val(response.discount);
                    $("#subtotal").val(response.grandTotal);
                    $("#remove_coupon_div_warpper").html(response.couponDiv);
                    $("#show_error_message").hide();
                } else {
                    $("#show_error_message").show();
                    $("#show_error_message_span").html(response.message);
                }
            }
        });
    });
</script>
<script>
    $('body').on('click', "#removeCoupon", function() {
        var state = $("#state").val();
        var country = $("#country").val();


        $.ajax({
            url: '{{ route('removeCoupon') }}',
            type: 'post',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                state: state,
                country: country,

            },
            dataType: 'json',
            success: function(response) {
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
    document.addEventListener('DOMContentLoaded', function() {
        const paymentOptions = document.querySelectorAll('input[name="payment_method"]');
        const dynamicFields = document.getElementById('dynamic-fields');

        paymentOptions.forEach(option => {
            option.addEventListener('change', function() {
                const selectedType = this.dataset.methodType;

                // Hide all fields first
                document.querySelectorAll('.fields-group').forEach(group => group.classList.add(
                    'd-none'));

                // Show the relevant fields based on selected type
                if (selectedType) {
                    document.getElementById(`fields-${selectedType}`).classList.remove(
                    'd-none');
                }
            });
        });
    });
</script>
<script>
    $(document).ready(function() {

        $("#checkoutContentForm").on("submit", function(e) {
            e.preventDefault();

            document.getElementById('checkoutLoader').style.display = 'flex'; // show loader

            let formData = new FormData(this);

            $.ajax({
                url: "{{ route('order') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,

                success: function(res) {
                    document.getElementById('checkoutLoader').style.display = 'none';

                    if (res.status === "error") {
                        toastr.error(res.message);
                        return;
                    }

                    toastr.success(res.message);

                    setTimeout(() => {
                        window.location.href = res.redirect;
                    }, 1000);
                },

                error: function(xhr) {
                    document.getElementById('checkoutLoader').style.display = 'none';

                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        $.each(errors, function(key, value) {
                            toastr.error(value[0]);
                        });
                    } else {
                        toastr.error("Something went wrong!");
                    }
                }
            });
        });

    });
</script>

<script>
    function renderCheckoutItems(cartContent) {

        const container = document.getElementById('checkoutItems');
        container.innerHTML = '';

        if (!cartContent || Object.keys(cartContent).length === 0) {
            container.innerHTML = '<p class="text-muted">Your cart is empty</p>';
            return;
        }

        Object.values(cartContent).forEach(item => {
            container.innerHTML += `
            <div class="d-flex justify-content-between align-items-start mt-2 pb-2 gap-3 border-bottom-1">
                <div class="d-flex gap-3 w-75">
                    <img src="${item.options.image}" width="30%" style="object-fit: cover; border-radius: 5px;" alt="#">
                    <div class="w-70">
                        <h6>${item.name}</h6>
                        <small class="product-qty font-sm">
                            Qty: ${item.qty}<br>
                            ${item.options.variation_name ?? ''}
                        </small>
                    </div>
                </div>
                <div class="w-25 text-end">
                    ${(item.price * item.qty).toFixed(2)} BDT
                </div>
            </div>
        `;
        });
    }

    function updateCheckoutTotals(data) {

        document.querySelector('.product-subtotal').innerText =
            data.cartSubtotal + ' BDT';

        document.getElementById('total_display').innerText =
            data.cartTotal + ' BDT';

        document.getElementById('subtotal').value = data.cartTotal;
    }
</script>
