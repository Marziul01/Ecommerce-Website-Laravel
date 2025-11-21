<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="_token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset($siteSettings->favicon) }}">
    <title>@yield('title')</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('admin-assets') }}/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css" integrity="sha384-b6lVK+yci+bfDmaY1u0zE8YYJt0TZxLEAFyYSLHId4xoVvsrQu3INevFKo+Xir8e" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Custom styles for this template-->
    <link href="{{ asset('admin-assets') }}/css/sb-admin-2.min.css" rel="stylesheet">
    <link href="{{ asset('admin-assets') }}/dropzone/css/dropzone.min.css" rel="stylesheet">


    <link href="{{ asset('admin-assets') }}/css/style.css" rel="stylesheet">

</head>

<body id="page-top">
@php
    $notifications = \Illuminate\Support\Facades\DB::table('notifications')->where('read_at', NULL)
    ->where('type', '<>', 'App\Notifications\NewContactNotification')
    ->get();
    $messages = \Illuminate\Support\Facades\DB::table('notifications')->where('read_at', NULL)
    ->where('type','App\Notifications\NewContactNotification')
    ->get();
    $totalNotification = $notifications->count();
    $totalMessages = $messages->count();
@endphp
<!-- Page Wrapper -->
<div id="wrapper" class="admin-main-wrapper">

    <!-- Sidebar -->
    @include('admin.include.sidebar')
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            <!-- Topbar -->
            @include('admin.include.header',[
                'notifications' => $notifications,
                'totalNotification' => $totalNotification,
                'messages' => $messages,
                'totalMessages' => $totalMessages,
                ])
            <!-- End of Topbar -->

            <!-- Begin Page Content -->
            @yield('content')
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->

        <!-- Footer -->
        @include('admin.include.footer')
        <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" href="{{ route('admin.logout') }}">Logout</a>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap core JavaScript-->
<script src="{{ asset('admin-assets') }}/vendor/jquery/jquery.min.js"></script>
<script src="{{ asset('admin-assets') }}/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="{{ asset('admin-assets') }}/vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="{{ asset('admin-assets') }}/js/sb-admin-2.min.js"></script>

<!-- Page level plugins -->
<script src="{{ asset('admin-assets') }}/vendor/chart.js/Chart.min.js"></script>

<!-- Page level custom scripts -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="{{ asset('admin-assets') }}/js/demo/chart-area-demo.js"></script>
<script src="{{ asset('admin-assets') }}/js/demo/chart-pie-demo.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>
<script src="{{ asset('admin-assets') }}/dropzone/jquery-3.6.4.min.js"></script>
<script src="{{ asset('admin-assets') }}/dropzone/js/dropzone.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('#envelopeIcon').click(function(event) {
            event.preventDefault(); // Prevent default link behavior

            // Send AJAX request to mark all messages as read
            $.ajax({
                url: '{{ route('messages.markAllAsRead') }}',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(response) {
                    // Update UI if necessary
                    console.log('All messages marked as read');
                    $('.badge-counter').text('0'); // Assuming you want to update the badge counter to 0
                },
                error: function(xhr, status, error) {
                    // Handle error
                    console.error(error);
                }
            });
        });
    });
</script>

<script>
    document.getElementById("sidebarToggleTop").addEventListener("click", function () {
    const sidebarii = document.getElementById("accordionSidebar");
    sidebarii.classList.toggle("show-sidebar"); // Toggle the custom show class
    console.log("Toggled show-sidebar class:", sidebarii.classList.contains("show-sidebar"));
});
</script>

@yield('customjs')
</body>

</html>
