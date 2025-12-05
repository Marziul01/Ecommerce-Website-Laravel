@extends('admin.master')

@section('title')
    Product Shipments
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid my-2">
                @include('admin.auth.message')
                <div class="d-sm-flex align-items-center justify-content-between mb-2">
                    <h1>Product Shipments</h1>
                </div>
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered table-hover table-striped table-responsive-md" style="overflow-x: auto;">
                        <thead>
                        <tr>
                            <th>Sl</th>
                            <th>Product & Variation</th>
                            <th>Admin</th>
                            <th>Buy Price</th>
                            <th>Qunatity</th>
                            <th>Remaining Qunatity</th>
                            <th>Date</th>
                            <th width="100px">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($requests->isNotEmpty())
                            @foreach($requests as $request)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <div>
                                                <img src="{{ asset( $request->product->featured_image ) }}" width="50px" height="50px">
                                            </div>
                                            <div>
                                                <h5>{{ $request->product->name }}</h5>
                                                @if (!empty($request->variation_id) && $request->productVariation )
                                                    <p>Variation : {{ $request->productVariation?->type }}</p>
                                                @endif
                                            </div>
                                        </div>
                                        
                                    </td>
                                    <td>{{ $request->user->name }}</td>
                                    <td>{{ $request->buy_price}}</td>
                                    <td>{{ $request->quantity }}</td>
                                    <td>{{ $request->remaining_qty }}</td>
                                    <td>{{ $request->date }}</td>
                                    
                                    <td class="table-action-td">
                                        @if (Auth::guard('admin')->user()->access->shipment_manage == 3)
                                        <a class="btn btn-sm btn-primary" data-toggle="modal" data-target="#productViewModal_{{ $request->id }}"><i class="bi bi-pen-fill"></i></a>
                                        <form action="{{ route('product.shipment.delete', $product->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this Product?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"><i class="bi bi-trash-fill"></i></button>
                                        </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="13"> No Products shippments Found !!! </td>
                            </tr>
                        @endif

                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    {{ $requests->links() }}
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>

    @if($requests->isNotEmpty())
        @foreach($requests as $request)
            <div class="modal fade" id="productViewModal_{{ $request->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <!-- Modal content goes here, make sure to customize it for each category -->
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3>Update Shipments Price and Quantity</h3>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('product.shipment.edit' , $request->id ) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="">Buy Price</label>
                                    <input type="number" name="buy_price" class="form-control" value="{{ $request->buy_price }}">
                                </div>
                                <div class="form-group">
                                    <label for="">Quantity</label>
                                    <input type="number" name="quantity" class="form-control" min="0"  value="{{ $request->quantity }}">
                                </div>
                                <button type="submit" class="btn btn-success"> Submit </button>
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

