@extends('frontend.master')

@section('title')
    {{ $siteSettings->title }} | Thank You !
@endsection

@section('content')

    <div class="page-header breadcrumb-wrap">
        <div class="container">
            <div class="breadcrumb">
                <a href="{{ route('home') }}" rel="nofollow">Home</a>
                <span></span>Thank You
            </div>
        </div>
    </div>

    <section class="container pt-50">
        <h1 class="text-center text-success"> Thank You for you order ! </h1>
        <div class="d-flex align-items-center justify-content-center mt-20 flex-wrap" style="column-gap: 20px ; row-gap: 10px;">
            @if(\Illuminate\Support\Facades\Auth::check())
                <a href="{{ route('user.profile') }}" class="btn btn-sm btn-primary"> View Orders </a>
            @else
                <a href="{{ route('home') }}" class="btn btn-sm btn-primary"> Home </a>
            @endif
            <a href="{{ route('shop') }}" class="btn btn-sm btn-success"><i class="fa-solid fa-bag-shopping"></i> Continue Shopping </a>
            <a class="btn btn-sm btn-primary" href="{{ asset($order->invoice) }}" target="_blank"><i class="fa-solid fa-download"></i> Download Invoice </a>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-12 card">
                    <div class="card-header mobile-overflow-x">
                        <div>
                            <h6>Order Number:</h6>
                            <h4 class="mt-2">{{ $order->order_number }}</h4>
                        </div>
                        <div>
                            <h6>Order Date:</h6>
                            <h4 class="mt-2">{{ $order->created_at->format('Y-m-d') }}</h4>
                        </div>
                        <div>
                            <h6>Order Status:</h6>
                            <h4 class="mt-2">
                                @if($order->status == 1)
                                        Pending
                                    @elseif($order->status == 2)
                                        Cancelled
                                        <br>
                                        <span class="text-danger font-sm">(" {{ $order->reason }} ")</span>
                                    @elseif($order->status == 3)
                                        Processing
                                    @elseif($order->status == 4)
                                        Shipped
                                    @elseif($order->status == 5)
                                        Delivered
                                    @endif
                            </h4>
                        </div>
                        <div>
                            <h6>Payment Status:</h6>
                            <h4 class="mt-2">
                                @if($order->payment_status == 1)
                                    Pending
                                @else
                                    Paid
                                @endif
                                <br>
                                <span class="text-uppercase font-sm">( {{ $order->payment_option }} )</span>
                            </h4>
                        </div>
                        <div>
                            <h6>Order Amount:</h6>
                            <h4 class="mt-2">{{ $order->grand_total }} Tk</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-responsive-md no-border mobile-table">
                            <thead>
                            <tr>
                                <td class="text-center"> Items </td>
                                <td class="text-center"> Qty </td>
                                <td class="text-center"> Total Price </td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($order->orderItems as $item)
                                <tr>
                                    <td class="d-flex align-items-center mobile-item-td" style="column-gap: 50px;">
                                        @if ($item->product)
                                           <a href="{{ route('products', $item->product->slug) }}"><img src="{{ asset($item->product->featured_image) }}" width="100px"></a>
                                            <div>
                                                <a href="{{ route('products', $item->product->slug) }}"><h4> {{ $item->product_name }} </h4></a>
                                                <p class="">
                                                    @if(isset($item->product_variations_id)) Option : {{ $item->productVariation?->type }} @endif
                                                </p>
                                            </div> 
                                        @else
                                        Product has been Deleted
                                        @endif
                                    </td>
                                    <td class="text-center"> {{ $item->qty }} </td>
                                    <td class="text-center"> {{ $item->total }} </td>
                                </tr>

                            @endforeach
                            </tbody>
                        </table>

                    </div>
                    <div class="card-footer row">
                        <div class="col-md-10 p-2 mobile-ship-width">
                            <h5> Shipping Details :</h5> <hr class="w-25">
                            <p> Name : {{ $order->name }} </p>
                            <p> Email : {{ $order->email }} </p>
                            <p> Phone : {{ $order->phone }} </p>
                            <p> Address: {{ $order->address }} , {{ $order->state }} , {{ $order->country->name }}</p>

                            <h5 class="mt-4"> Payment Details :</h5> <hr class="w-25">
                            <p> Payment Method : {{ $order->payment_option }} </p>
                            @if ($order->payment_option != 'Cash on Delivery')
                                <p> Transaction Id / Bank Account Number : {{ $order->payment_number }} </p>
                                <p> Payment Screenshot : <img src="{{ asset($order->payment_prove) }}" width="100%" > </p>
                            @endif
                            
                        </div>
                        <div class="col-md-2 d-flex flex-column align-items-center mobile-price-width">
                            <p class="text-center"> SubTotal : <strong>{{ $order->subtotal }} Tk </strong></p>
                            <p class="text-center"> Discount : <strong>{{ $order->discount }} Tk </strong> <br><span class="font-sm">(Code: {{ $order->coupon_code }})</span></p>
                            <p class="text-center mt-2"> Shipping : <strong>{{ $order->shipping }} Tk </strong></p>
                            <p class="text-center mt-2"> Total Payable : <strong>{{ $order->grand_total }} Tk </strong></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('customJs')



@endsection
