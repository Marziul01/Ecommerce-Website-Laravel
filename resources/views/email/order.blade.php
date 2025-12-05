<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Your New Order Confirmation</title>
    <style>
        .card{
            border: 1px solid darkgrey;
        }
        .card-header{
            padding: 10px;
            background: ghostwhite;
        }
        .card-body{
            padding: 10px;
        }
        .text-center{
            text-align: center;
        }
        .d-flex{
            display: flex;
            width: 100%;
            border-bottom: 1px solid darkgrey;
        }
        .align-items-center{
            align-items: center;
        }
        .justify-content-between{
            justify-content: space-between;
        }
        .justify-content-around{
            justify-content: space-around;
        }
        .col-md-8{
            width: 60%;
        }
        .col-md-2{
            width: 20%;
            padding-left: 20px;
        }
        .border-right{
            border-right: 1px solid darkgrey;
        }
        .col-md-10{
            width: 82%;
        }
        @media (max-width: 767px) {
            .col-md-10{
                width: 84%;
            }
        }
        .w-25{
            width: 25%;
            margin: 0px !important;
        }
        .flex-column{
            flex-direction: column !important;
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="card-header text-center">
            <img src="{{ asset('frontend-assets/imgs/theme/logo.svg') }}" class="text-center w-25">
            <h1 class="text-center"> Thanks for your order !! </h1>
            <p class="text-center">Order Number: {{ $orderData['order']->order_number }} </p>
        </div>
        <div class="card-body">
            <div class="d-flex align-items-center justify-content-between">
                <div class="col-md-8 border-right">
                    <p> Items </p>
                </div>
                <div class="col-md-2 border-right">
                    <p> Qty </p>
                </div>
                <div class="col-md-2" >
                    <p> Total Price </p>
                </div>
            </div>
            @foreach($orderData['order']->orderItems as $item)
                <div class="d-flex justify-content-between">
                    <div class="col-md-8 d-flex border-right" style="column-gap: 50px; border-bottom: 0px !important;">
                        <div>
                            <h4> {{ $item->product_name }} </h4>
                            <p class="">
                                 @if(isset($item->product_variations_id)) Option : {{ $item->productVariation?->type }} @endif
                            </p>
                        </div>
                    </div>
                    <div class="col-md-2 border-right">
                        <p> {{ $item->qty }} </p>
                    </div>
                    <div class="col-md-2">
                        <p> {{ $item->total }} </p>
                    </div>
                </div>
            @endforeach
                <div class="d-flex justify-content-between" style="border-bottom: 0px !important;">
                    <div class="col-md-10 border-right">
                        <h5> Shipping Details :</h5> <hr class="w-25">
                        <p> Name : {{ $orderData['order']->first_name }} {{ $orderData['order']->last_name }} </p>
                        <p> Email : {{ $orderData['order']->email }} </p>
                        <p> Phone : {{ $orderData['order']->phone }} </p>
                        <p> Address: {{ $orderData['order']->address }} , {{ $orderData['order']->state }} , {{ $orderData['order']->country->name }}</p>

                        <h5 class="mt-4"> Payment Details :</h5> <hr class="w-25">
                        <p> Payment Method : {{ $orderData['order']->payment_option }} </p>
                    </div>
                    <div class="col-md-2 flex-column align-items-center justify-content-around" style="border-bottom: 0px !important; flex-direction: column;">
                        <p class=""> SubTotal : <strong>{{ $orderData['order']->subtotal }} Tk </strong> </p>
                        <p class=""> Discount : <strong>{{ $orderData['order']->discount }} Tk </strong> <br><span class="font-sm">(Code: {{ $orderData['order']->coupon_code }})</span></p>
                        <p class=""> Shipping : <strong>{{ $orderData['order']->shipping }} Tk </strong></p>
                        <p class=""> Total Payable : <strong>{{ $orderData['order']->grand_total }} Tk </strong></p>
                    </div>
                </div>
        </div>
    </div>

</body>
</html>
