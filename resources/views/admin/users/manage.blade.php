@extends('admin.master')

@section('title')
    Users
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
            <h1 class="h3 mb-0 text-gray-800">Users</h1>
            @if (Auth::guard('admin')->user()->access->user_manage == 3)
            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#AddUserModal">
                <i class="bi bi-file-earmark-plus"></i> Add New</a>
                @endif
        </div>

        <div class="card">
            <div class="card-body">
                <table class="table table-bordered table-hover table-striped table-responsive-md">
                    <thead>
                    <tr>
                        <th>Sl</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if($users->isNotEmpty())
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td class="table-action-td">
                                    @if (Auth::guard('admin')->user()->access->user_manage == 3)
                                    <a class="btn btn-sm btn-primary" data-toggle="modal" data-target="#EditUserModal_{{ $user->id }}"><i class="bi bi-pen-fill"></i> Edit</a>

                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this User?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"><i class="bi bi-trash-fill"></i> Delete</button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="4"> No Users Found !!! </td>
                        </tr>
                    @endif

                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                {{ $users->links() }}
            </div>
        </div>

    </div>




    <div class="modal fade" id="AddUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    Add New User
                </div>
                <div class="modal-body">
                    <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="exampleInputEmail1">Name</label>
                            <input type="text" class="form-control" id="name" name="name">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Email</label>
                            <input type="email" class="form-control" id="email" name="email">
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input class="form-control square" id="password" name="password" type="password">
                        </div>
                        <div class="form-group">
                            <label>Confirm Password <span class="required">*</span></label>
                            <input class="form-control square" id="confirm-pass" name="confirm_password" type="password">
                        </div>

                        <button type="submit" class="btn btn-primary">Create</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    {{--    Edit Category Model--}}
    @if(isset($user))
        @foreach($users as $user)
            <div class="modal fade" id="EditUserModal_{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <!-- Modal content goes here, make sure to customize it for each category -->
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            Edit User
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Name</label>
                                    <input type="text" class="form-control" name="name" value="{{ $user->name }}">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Email</label>
                                    <input type="text" class="form-control" name="email" value="{{ $user->email }}">
                                </div>
                                <div class="form-group">
                                    <label>New Password</label>
                                    <input class="form-control square" id="epassword" name="password" type="password">
                                </div>
                                <div class="form-group">
                                    <label>Confirm Password <span class="required">*</span></label>
                                    <input class="form-control square" id="econfirm-pass" name="confirm_password" type="password">
                                </div>

                                <button type="submit" class="btn btn-primary">Update</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif




@endsection

@section('customjs')
    <script>
        document.getElementById('confirm-pass').addEventListener('input', function () {
            var password = document.getElementById('password').value;
            var confirmPassword = this.value;

            if (password !== confirmPassword) {
                this.setCustomValidity("Passwords do not match");
            } else {
                this.setCustomValidity("");
            }
        });
    </script>

    <script>
        document.getElementById('econfirm-pass').addEventListener('input', function () {
            var password = document.getElementById('epassword').value;
            var confirmPassword = this.value;

            if (password !== confirmPassword) {
                this.setCustomValidity("Passwords do not match");
            } else {
                this.setCustomValidity("");
            }
        });
    </script>
@endsection


