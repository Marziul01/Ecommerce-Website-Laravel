@extends('admin.master')

@section('title')
    Reviews
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
            <h1 class="h3 mb-0 text-gray-800">Reviews</h1>
        </div>

        <div class="card">
            <div class="card-body">
                <table class="table table-bordered table-hover table-striped table-responsive-md">
                    <thead>
                    <tr>
                        <th>Sl</th>
                        <th>Product Name</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Ratings</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if($reviews->isNotEmpty())
                        @foreach($reviews as $review)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $review->product ? $review->product->name : 'Product has been Deleted' }}</td>
                                <td>{{ $review->name }}</td>
                                <td>{{ $review->email }}</td>
                                <td>{{ $review->rating }}</td>
                                <td>
                                    @if($review->status == 1)
                                        <i class="bi bi-check-circle-fill" style="color: deepskyblue"></i> Approved
                                    @else
                                        <i class="bi bi-x-circle-fill" style="color: red"></i> Rejected
                                    @endif
                                </td>
                                <td class="table-action-td">
                                    @if (Auth::guard('admin')->user()->access->review_manage == 3)
                                    <a class="btn btn-sm btn-primary" data-toggle="modal" data-target="#ViewReviewModal{{ $review->id }}"><i class="bi bi-eye"></i> View</a>
                                @if($review->status == 1)
                                        <a class="btn btn-sm btn-warning" href="{{ route('reviewShow', $review->id) }}"><i class="bi bi-x-circle-fill"></i> Reject</a>
                                    @else
                                        <a class="btn btn-sm btn-success" href="{{ route('reviewShow', $review->id) }}"><i class="bi bi-check-circle-fill"></i> Approve</a>
                                    @endif

                                    <form action="{{ route('reviewDestroy', $review->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this Review?');">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-danger"><i class="bi bi-trash-fill"></i> Delete</button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="7"> No Reviews Found !!! </td>
                        </tr>
                    @endif

                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                {{ $reviews->links() }}
            </div>
        </div>

    </div>


@foreach($reviews as $review)
    <div class="modal fade" id="ViewReviewModal{{ $review->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    "{{ $review->product->name }}" Product Review
                    <div>
                        @if($review->status == 1)
                            <i class="bi bi-check-circle-fill" style="color: deepskyblue"></i> Approved
                        @else
                            <i class="bi bi-x-circle-fill" style="color: red"></i> Rejected
                        @endif
                    </div>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6> Product Name : </h6>
                            <p>{{ $review->product->name }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6> Reviewer Name :</h6>
                            <p>{{ $review->name }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6> Reviewer Email :</h6>
                            <p>{{ $review->email }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6> Ratings :</h6>
                            <div class="product-rate d-inline-block mr-15">
                                <div class="product-rating" style="width:{{ $review->rating * 20 }}%"></div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <h6> Reviewer Email </h6>
                            <p>{{ $review->comment }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach


@endsection

@section('customjs')

@endsection


