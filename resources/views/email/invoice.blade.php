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
            width: 70%;
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
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        .row1-col1{
            width: 60%;
        }
        .row1-col2 {
            width: 20%;
        }
        .row1-col3 {
            width: 80%;
        }
    </style>
</head>
<body>
<div class="card">
    <div class="card-header text-center">
        <img src="{{ asset('frontend-assets/imgs/theme/logo.svg') }}" class="text-center w-25">
        <h1 class="text-center"> Thanks for your order !! </h1>
        <p class="text-center">Order Number: {{ $order->order_number }} </p>
    </div>
    <div class="card-body">
        <table>
            <thead>
            <tr>
                <td class="row1-col1"><p>Items</p></td>
                <td class="row1-col2"><p>Qty</p></td>
                <td class="row1-col2"><p>Total Price</p></td>
            </tr>
            </thead>
            <tbody>
            @foreach($order->orderItems as $item)
                <tr>
                    <td class="row1-col1">
                        <h4> {{ $item->product_name }} </h4>
                        <p>
                            @if(isset($item->product_variations_id)) Option : {{ $item->productVariation?->type }} @endif
                        </p>
                    </td>
                    <td class="row1-col2">
                        <p> {{ $item->qty }} </p>
                    </td>
                    <td class="row1-col2">
                        <p> {{ $item->total }} </p>
                    </td>
                </tr>
            @endforeach
            <tr>
                <td colspan="3" style="padding: 0px">
                    <table style="border: none;">
                        <tr style="border: none;">
                            <td class="row1-col3" style="border: none; border-right: 1px solid black !important;">
                                <h5> Shipping Details :</h5> <hr class="w-25">
                                <p> Name : {{ $order->first_name }} {{ $order->last_name }} </p>
                                <p> Email : {{ $order->email }} </p>
                                <p> Phone : {{ $order->phone }} </p>
                                <p> Address: {{ $order->address }} , {{ $order->state }} , {{ $order->country->name }}</p>

                                <h5 class="mt-4"> Payment Details :</h5> <hr class="w-25">
                                <p> Payment Method : {{ $order->payment_option }} </p>
                            </td>
                            <td class="row1-col2" style="border: none;">
                                <p class=""> SubTotal : <strong>{{ $order->subtotal }} Tk </strong> </p>
                                <p class=""> Discount : <strong>{{ $order->discount }} Tk </strong> <br><span class="font-sm">(Code: {{ $order->coupon_code }})</span></p>
                                <p class=""> Shipping : <strong>{{ $order->shipping }} Tk </strong></p>
                                <p class=""> Total Payable : <strong>{{ $order->grand_total }} Tk </strong></p>
                            </td>
                        </tr>
                    </table>
                </td>

            </tr>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
