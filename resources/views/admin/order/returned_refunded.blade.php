@extends('admin.master')

@section('title')
    Return Refunded Orders
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
            <h1 class="h3 mb-0 text-gray-800">Return Refunded Orders</h1>
        </div>
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered table-hover table-striped table-responsive-md">
                    <thead>
                    <tr>
                        <th>Sl</th>
                        <th>Order</th>
                        <th>Customer</th>
                        <th>Phone</th>
                        <th>Status</th>
                        <th>Payment Status</th>
                        <th>Price</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if($orders->isNotEmpty())
                        @foreach($orders as $order)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $order->order_number }}</td>
                                <td>{{ $order->first_name }}</td>
                                <td>{{ $order->phone }}</td>
                                <td>
                                    <button class="btn btn-sm btn-danger">Returned & Refunded</button>                                
                                </td>
                                <td>
                                    @if($order->payment_status == 1)
                                        <button class="btn btn-sm btn-primary">Pending</button>
                                    @else
                                        <button class="btn btn-sm btn-success">Paid</button>
                                    @endif
                                    <br>
                                    <span class="text-uppercase font-sm">( {{ $order->payment_option }} )</span>
                                </td>
                                <td>{{ $order->grand_total }}</td>
                                <td>{{ $order->created_at->format('Y-m-d') }}</td>
                                <td class="table-action-td">
                                    <a class="btn btn-sm btn-primary" href="{{ route('viewOrders', $order->id) }}"><i class="bi bi-eye-fill"></i> View</a>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="9"> No Orders Found !!! </td>
                        </tr>
                    @endif

                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                {{ $orders->links() }}
            </div>
        </div>

    </div>



@endsection

@section('customjs')

@endsection


