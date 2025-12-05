@extends('admin.master')

@section('title')
    Coupons
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
            <h1 class="h3 mb-0 text-gray-800">Coupons</h1>
            @if (Auth::guard('admin')->user()->access->coupon == 3)
            <a href="#" class=" d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#AddCouponModal">
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
                        <th>Code</th>
                        <th>Description</th>
                        <th>Disc. Amount</th>
                        <th>Disc. Type</th>
                        <th>Min. Amount</th>
                        <th>Max Uses</th>
                        <th>Per User</th>
                        <th>Starts</th>
                        <th>Expires</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if($coupons->isNotEmpty())
                        @foreach($coupons as $coupon)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $coupon->name }}</td>
                                <td>{{ $coupon->code }}</td>
                                <td>{{ $coupon->description }}</td>
                                <td>{{ $coupon->max_uses }}</td>
                                <td>{{ $coupon->max_uses_user }}</td>
                                <td>{{ $coupon->type }}</td>
                                <td>{{ $coupon->discount_amount }}</td>
                                <td>{{ $coupon->min_amount }}</td>
                                <td>{{ $coupon->starts_at }}</td>
                                <td>{{ $coupon->expires_at }}</td>
                                <td>
                                    @if($coupon->status == 1)
                                        <i class="bi bi-check-circle-fill" style="color: deepskyblue"></i> ACTIVE
                                    @else
                                        <i class="bi bi-x-circle-fill" style="color: red"></i> INACTIVE
                                    @endif
                                </td>
                                <td class="table-action-td">
                                    @if (Auth::guard('admin')->user()->access->coupon == 3)
                                    <a class="btn btn-sm btn-primary" data-toggle="modal" data-target="#EditCouponModal_{{ $coupon->id }}"><i class="bi bi-pen-fill"></i> Edit</a>
                                    @if($coupon->status == 1)
                                        <a class="btn btn-sm btn-warning" href="{{ route('coupons.show', $coupon->id) }}"><i class="bi bi-x-circle-fill"></i> Inactive</a>
                                    @else
                                        <a class="btn btn-sm btn-success" href="{{ route('coupons.show', $coupon->id) }}"><i class="bi bi-check-circle-fill"></i> Active</a>
                                    @endif

                                    <form action="{{ route('coupons.destroy', $coupon->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this Coupon?');">
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
                            <td colspan="13"> No Coupons Found !!! </td>
                        </tr>
                    @endif

                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                {{ $coupons->links() }}
            </div>
        </div>

    </div>




    {{--    Add Coupon Model--}}

    <div class="modal fade" id="AddCouponModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    Add New Coupon
                </div>
                <div class="modal-body">
                    <form action="{{ route('coupons.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="exampleInputEmail1">Coupon Name</label>
                                <input type="text" class="form-control" placeholder="Coupon Name" name="name">
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="exampleInputEmail1">Coupon Code</label>
                                <input type="text" class="form-control" placeholder="Discount Code" name="code">
                            </div>
                            <div class="col-md-12 form-group">
                                <label for="exampleInputEmail1">Description</label>
                                <textarea class="form-control" name="description"></textarea>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="exampleInputEmail1">Max Uses</label>
                                <input type="number" class="form-control" placeholder="Max Uses" name="max_uses">
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="exampleInputEmail1">Max Uses User</label>
                                <input type="number" class="form-control" placeholder="Max Uses User" name="max_uses_user">
                            </div>
                            <div class="col-md-4 form-group">
                                <label>Type</label>
                                <select name="type" class="form-control">
                                    <option value="percentage">Percentage</option>
                                    <option value="fixed">Fixed</option>
                                </select>
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="exampleInputEmail1">Discount Amount</label>
                                <input type="number" class="form-control" placeholder="Discount Amount" name="discount_amount">
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="exampleInputEmail1">Min Amount</label>
                                <input type="number" class="form-control" placeholder="Min Amount" name="min_amount">
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="exampleInputEmail1">Starts at</label>
                                <input type="date" class="form-control" placeholder="Starts at" name="starts_at">
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="exampleInputEmail1">Expires at</label>
                                <input type="date" class="form-control" placeholder="expires_at" name="expires_at">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Create</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    {{--    Edit Coupon Model--}}
    @if(isset($coupon))
        @foreach($coupons as $coupon)
            <div class="modal fade" id="EditCouponModal_{{ $coupon->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <!-- Modal content goes here, make sure to customize it for each category -->
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            Edit Category
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('coupons.update', $coupon->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label for="exampleInputEmail1">Coupon Name</label>
                                        <input type="text" class="form-control" placeholder="Coupon Name" value="{{ $coupon->name }}" name="name">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="exampleInputEmail1">Coupon Code</label>
                                        <input type="text" class="form-control" placeholder="Discount Code" value="{{ $coupon->code }}" name="code">
                                    </div>
                                    <div class="col-md-12 form-group">
                                        <label for="exampleInputEmail1">Description</label>
                                        <textarea class="form-control" name="description">{{ $coupon->description }}</textarea>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="exampleInputEmail1">Max Uses</label>
                                        <input type="number" class="form-control" placeholder="Max Uses" value="{{ $coupon->max_uses }}" name="max_uses">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="exampleInputEmail1">Max Uses User</label>
                                        <input type="number" class="form-control" placeholder="Max Uses User" value="{{ $coupon->max_uses_user }}" name="max_uses_user">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>Type</label>
                                        <select name="type" class="form-control">
                                            <option value="percentage" {{ $coupon->type == 'percentage' ? 'selected' : '' }}>Percentage</option>
                                            <option value="fixed" {{ $coupon->type == 'fixed' ? 'selected' : '' }}>Fixed</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label for="exampleInputEmail1">Discount Amount</label>
                                        <input type="number" class="form-control" placeholder="Discount Amount" value="{{ $coupon->discount_amount }}" name="discount_amount">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label for="exampleInputEmail1">Min Amount</label>
                                        <input type="number" class="form-control" placeholder="Min Amount" value="{{ $coupon->min_amount }}" name="min_amount">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="exampleInputEmail1">Starts at</label>
                                        <input type="date" class="form-control" placeholder="Starts at" value="{{ $coupon->starts_at }}" name="starts_at">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="exampleInputEmail1">Expires at</label>
                                        <input type="date" class="form-control" placeholder="expires_at" value="{{ $coupon->expires_at }}" name="expires_at">
                                    </div>
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

@endsection


