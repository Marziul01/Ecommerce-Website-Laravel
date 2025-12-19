@extends('frontend.master')

@section('title')
    {{ $siteSettings->title }} | Cart
@endsection

@section('content')
    <div class="page-header breadcrumb-wrap">
        <div class="container">
            <div class="breadcrumb">
                <a href="{{ route('home') }}" rel="nofollow">Home</a>
                <span></span> <a href="{{ route('shop') }}">Shop</a>
                <span></span> Your Cart
            </div>
        </div>
    </div>

    <section class="mt-50 mb-50">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <form action="{{ route('updateCart') }}" method="POST">
                        @csrf
                        <div class="table-responsive">

                            <table class="table shopping-summery text-center clean">
                                <thead>
                                <tr class="main-heading">
                                    <th scope="col">Image</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Subtotal</th>
                                    {{-- <th scope="col">Remove</th> --}}
                                </tr>
                                </thead>
                                <tbody>
                                @if($cartContent->isNotEmpty())
                                    @foreach($cartContent as $item)
                                        <tr>
                                            <td class="image product-thumbnail"><img src="{{ asset($item->options['image']) }}"></td>
                                            <td class="product-des product-name">
                                                <h5 class="product-name"><a href="{{ route('products', $item->options['slug']) }}">{{ $item->name }}</a></h5>
                                                @if (!empty($item->options['variation_id']))
                                                    <p class="font-xs">
                                                        Selected Option: {{ $item->options['variation_name'] }}
                                                    </p>
                                                @endif
                                            </td>
                                            <td class="price" data-title="Price"><span>{{ $item->price }} Tk</span></td>
                                            <td class="text-center" data-title="Stock">
                                                <div style="display: flex; align-items: center;justify-content: center">
                                                    <div style="width:25%">
                                                        {{-- <input type="number" class="form-control" name="quantity[{{ $item->rowId }}]" value="{{ $item->qty }}" min="1"> --}}
                                                        <span>{{ $item->qty }}</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center" data-title="Cart">
                                                <span>{{ $item->price*$item->qty }} Tk</span>
                                            </td>
                                            {{-- <td class="action" data-title="Remove"><a href="{{ route('removeFromCart', $item->rowId) }}" class=""><i class="fi-rs-trash"></i></a></td> --}}
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="6">
                                            No Products in the Cart !!
                                        </td>
                                    </tr>
                                @endif
                                <tr>
                                    <td colspan="6" class="text-end">
                                        <a href="{{ route('clearCart') }}"> <i class="fi-rs-cross-small"></i> Clear Cart</a>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="row mb-50">
                            <div class="col-lg-6 col-md-12"></div>
                            <div class="col-lg-6 col-md-12">
                                <div class="border p-md-4 p-30 border-radius cart-totals">
                                    <div class="heading_s1 mb-3">
                                        <h4>Cart Totals</h4>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tbody>
                                            <tr>
                                                <td class="cart_total_label">Cart Subtotal</td>
                                                <td class="cart_total_amount"><span class="font-lg fw-900 text-brand">{{ Cart::subtotal() }}</span></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            {{-- <button type="submit" class="btn mr-10 mb-sm-15"><i class="fi-rs-shuffle mr-10"></i>Update Cart</button> --}}
                            {{-- <a href="{{ route('checkout') }}" class="btn "> <i class="fi-rs-box-alt mr-10"></i> Proceed To CheckOut</a> --}}
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('customJs')
    <script>
        function updateCart() {
            console.log('Update button clicked');

            var data = {};
            var rows = document.querySelectorAll('input[name="quantity"]');
            rows.forEach(function (row) {
                var tr = row.closest('tr');
                data[tr.dataset.rowId] = row.value;
            });

            fetch("{{ route('updateCart') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(data)
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        console.log('Cart updated successfully');
                    } else {
                        console.error('Failed to update cart:', data.error);
                    }
                })
                .catch(error => {
                    console.error('Error updating cart:', error.message);
                });
        }
    </script>
@endsection
