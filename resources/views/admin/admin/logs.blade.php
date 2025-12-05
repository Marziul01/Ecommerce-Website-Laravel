@extends('admin.master')

@section('title')
Admin Log Report
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
            <h1 class="h3 mb-0 text-gray-800"> Admin Log Report </h1>
        </div>
    
        <form method="GET" action="{{ route('admin.log') }}" class="mb-4">
            <div class="row align-items-center">
                <div class="col-md-3">
                    <label for="from_date" class="form-label">From Date</label>
                    <input type="date" id="from_date" name="from_date" class="form-control" 
                        value="{{ request('from_date') }}" required>
                </div>
                <div class="col-md-3">
                    <label for="to_date" class="form-label">To Date</label>
                    <input type="date" id="to_date" name="to_date" class="form-control" 
                        value="{{ request('to_date') }}" required>
                </div>
                <div class="col-md-3">
                    <label for="to_date" class="form-label">Select an Admin</label>
                    <select name="admin_id" id="" class="form-control">
                        <option value="">All Admins</option>
                        @foreach ($users as $user )
                            <option value="{{ $user->id }}" {{ request('admin_id') && request('admin_id') == $user->id ? 'selected' : '' }} >{{ $user->name }} - ( {{ $user->role_type }} ) </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary mt-3 w-100">Filter Report</button>
                </div>
            </div>
        </form>

        <div class="card mt-3">
            <div class="card-body">
                <table class="table table-bordered table-hover table-striped table-responsive-md" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>Sl</th>
                        <th>User</th>
                        <th>Accessed</th>
                        <th>Log Message</th>
                        <th>Date and Time</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if($userlogs->isNotEmpty())
                        @foreach($userlogs as $log)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $log->user->name }} - ( {{ $log->user->role_type }} )</td>
                                <td>{{ $log->notification_for }}</td>
                                <td>{{ $log->message }}</td>
                                <td>{{ $log->created_at->format('j M Y, g:i A') }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="9"> No admin log Found !!! </td>
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


