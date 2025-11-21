@extends('admin.master')

@section('title')
Sales Reports
@endsection

@section('content')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

<!-- Buttons Extension CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">


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
            <h1 class="h3 mb-0 text-gray-800"> Sales Reports </h1>
        </div>
    
        <form method="GET" action="{{ route('sales_report') }}" class="mb-4">
            <div class="row align-items-center">
                <div class="col-md-4">
                    <label for="from_date" class="form-label">From Date</label>
                    <input type="date" id="from_date" name="from_date" class="form-control" 
                        value="{{ request('from_date') }}" required>
                </div>
                <div class="col-md-4">
                    <label for="to_date" class="form-label">To Date</label>
                    <input type="date" id="to_date" name="to_date" class="form-control" 
                        value="{{ request('to_date') }}" required>
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary mt-3 w-100">Filter Sales</button>
                </div>
            </div>
        </form>
        

        <div class="col-md-12 h-100 row dash-rows-fix">
            <div class="col-md-4 mb-4">
                <div class="card shadow h-100 py-2">
                    <a class="card-body dashboard-a">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-uppercase mb-1">
                                    Total Number of Delivered Orders</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{$orderdetails->whereIn('status', [5,8])->count()}}</div>
                            </div>
                            <div class="col-auto dash-card-icon ">
                                <i class="fa-solid fa-bag-shopping"></i>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class=" col-md-4 mb-4">
                <div class="card shadow h-100 py-2">
                    <a class="card-body dashboard-a" href="{{ route('product.index') }}">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-uppercase mb-1">
                                    Total Selling Amount</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $orderdetails->whereIn('status', [5,8] )->sum('grand_total') }}</div>
                            </div>
                            <div class="col-auto  dash-card-icon">
                                <i class="fa-solid fa-cube"></i>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card shadow h-100 py-2">
                    <a class="card-body dashboard-a" href="{{ route('product.index') }}">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-uppercase mb-1">Total Returned Orders
                                </div>
                                <div class="row no-gutters align-items-center">
                                    <div class="col-auto">
                                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ $orderdetails->where('status', 7)->count() }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto  dash-card-icon">
                                <i class="fa-solid fa-shop-lock"></i>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card shadow h-100 py-2">
                    <a class="card-body dashboard-a" href="{{ route('ordersPending') }}">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-uppercase mb-1">
                                    Total Returned Amount</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $orderdetails->where('status', 7)->sum('grand_total') }}</div>
                            </div>
                            <div class="col-auto dash-card-icon">
                                <i class="fa-solid fa-hourglass-half"></i>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            

            <div class="col-md-4 mb-4">
                <div class="card shadow h-100 py-2">
                    <a class="card-body dashboard-a">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold  text-uppercase mb-1">
                                    Total Buying Cost </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalPurchaseCost->total_purchase_cost ?? 0 }} </div>
                            </div>
                            <div class="col-auto dash-card-icon">
                                <i class="fa-solid fa-truck-ramp-box"></i>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class=" col-md-4 mb-4">
                <div class="card shadow h-100 py-2">
                    <a class="card-body dashboard-a" href="{{ route('ordersCancel') }}">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold  text-uppercase mb-1">
                                    Total Discount</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $orderdetails->whereIn('status', [5,8] )->sum('discount') }}</div>
                            </div>
                            <div class="col-auto dash-card-icon">
                                <i class="fa-solid fa-ban"></i>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card shadow h-100 py-2">
                    <a class="card-body dashboard-a" href="{{ route('ordersPending') }}">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold  text-uppercase mb-1">Total Net Profit
                                </div>
                                <div class="row no-gutters align-items-center">
                                    <div class="col-auto">
                                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"> {{ $orderdetails->whereIn('status', [5,8] )->sum('grand_total') - ( $totalPurchaseCost->total_purchase_cost  )  }} </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto dash-card-icon">
                                <i class="fa-solid fa-money-check-dollar"></i>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

        </div>

        <div class="card mt-3">
            <div class="card-body">
                <table class="table table-bordered table-hover table-striped table-responsive-md" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>Sl</th>
                        <th>Order</th>
                        <th>Customer</th>
                        <th>Phone</th>
                        <th>Status</th>
                        <th>Payment Status</th>
                        <th>Price</th>
                        <th>Order Date</th>
                        
                    </tr>
                    </thead>
                    <tbody>
                    @if($orderdetails->isNotEmpty())
                        @foreach($orderdetails as $order)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $order->order_number }}</td>
                                <td>{{ $order->first_name }}</td>
                                <td>{{ $order->phone }}</td>
                                <td>
                                    @if($order->status == 1)
                                                                Pending
                                                            @elseif($order->status == 2)
                                                                Cancelled
                                                                
                                                            @elseif($order->status == 3)
                                                                Processing
                                                            @elseif($order->status == 4)
                                                                Shipped
                                                            @elseif($order->status == 5)
                                                                Delivered
                                                            @elseif($order->status == 6)
                                                                Order Return & Refund Requested
                                                                
                                                            @elseif($order->status == 7)
                                                                Order Returened and Refunded
                                                            @elseif($order->status == 8)
                                                                Delivered
                                                                
                                                            @endif                               
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
        </div>

    </div>



@endsection

@section('customjs')
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<!-- Buttons Extension JS -->
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.copy.min.js"></script>



<script>
    $(document).ready(function () {
    $('#dataTable').DataTable({
        dom: 'Bfrtip', // Defines the button placement
        buttons: [
            'copy', // Copy to clipboard
            'csv',  // Export to CSV
            {
                extend: 'pdfHtml5', // Export to PDF
                orientation: 'portrait', // Set page orientation
                pageSize: 'A4', // Set page size
                title: 'Order Data', // PDF title
                download: 'open' // Open PDF in a new tab
            },
            'print' // Print table
        ],
        responsive: true, // Makes the table responsive
        pageLength: 20, // Default number of rows per page
        lengthMenu: [5, 10, 25, 50, 100], // Options for entries per page
    });
});
</script>

@endsection


