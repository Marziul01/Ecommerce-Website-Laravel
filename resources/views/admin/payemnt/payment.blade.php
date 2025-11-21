@extends('admin.master')

@section('title')
Payment Methods
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
            <h1 class="h3 mb-0 text-gray-800"> Payment Methods</h1>
            <a href="#" class=" d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#AddCouponModal">
                <i class="bi bi-file-earmark-plus"></i> Add New</a>
        </div>

        <div class="card">
            <div class="card-body">
                <table class="table table-bordered table-hover table-striped table-responsive-md">
                    <thead>
                    <tr>
                        <th>Sl</th>
                        <th>Type</th>
                        <th>Name</th>
                        <th>Number</th>
                        <th>Account Name</th>
                        <th>Bank Name</th>
                        <th>Branch Name</th>
                        <th>Note</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if($PaymentMethods->isNotEmpty())
                        @foreach($PaymentMethods as $PaymentMethod)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $PaymentMethod->type }}</td>
                                <td>{{ $PaymentMethod->name }}</td>
                                <td>{{ $PaymentMethod->number }}</td>
                                <td>{{ $PaymentMethod->account_name }}</td>
                                <td>{{ $PaymentMethod->bank_name }}</td>
                                <td>{{ $PaymentMethod->branch_name }}</td>
                                <td>{{ $PaymentMethod->note }}</td>
                                <td>
                                    @if($PaymentMethod->status == 1)
                                        <i class="bi bi-check-circle-fill" style="color: deepskyblue"></i> ACTIVE
                                    @else
                                        <i class="bi bi-x-circle-fill" style="color: red"></i> INACTIVE
                                    @endif
                                </td>
                                <td class="table-action-td">
                                    <a class="btn btn-sm btn-primary" data-toggle="modal" data-target="#EditCouponModal_{{ $PaymentMethod->id }}"><i class="bi bi-pen-fill"></i> Edit</a>
                                    @if($PaymentMethod->status == 1)
                                        <a class="btn btn-sm btn-warning" href="{{ route('payment_methods.show', $PaymentMethod->id) }}"><i class="bi bi-x-circle-fill"></i> Inactive</a>
                                    @else
                                        <a class="btn btn-sm btn-success" href="{{ route('payment_methods.show', $PaymentMethod->id) }}"><i class="bi bi-check-circle-fill"></i> Active</a>
                                    @endif

                                    <form action="{{ route('payment_methods.destroy', $PaymentMethod->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this Payment Method ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"><i class="bi bi-trash-fill"></i> Delete</button>
                                    </form>

                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="13"> No Payment Method Found !!! </td>
                        </tr>
                    @endif

                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                {{ $PaymentMethods->links() }}
            </div>
        </div>

    </div>




    {{--    Add Coupon Model--}}

    <div class="modal fade" id="AddCouponModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    Add New Payment Method
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('payment_methods.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="exampleInputEmail1">Payment Method Type</label>
                                <select name="type" class="form-control" id="">
                                    <option value="">Select Type</option>
                                    <option value="COD"  >COD</option>
                                    <option value="Online Banking"> Online Banking </option>
                                    <option value="Bank Account">Bank Account</option>
                                </select>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="exampleInputEmail1">Payment Method Name</label>
                                <input type="text" class="form-control" placeholder="Payment Method Name" name="name">
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="exampleInputEmail1">Account Number</label>
                                <input type="number" class="form-control" placeholder="Number" name="number">
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="exampleInputEmail1">Account Name</label>
                                <input type="text" class="form-control" placeholder="Account Name" name="account_name">
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="exampleInputEmail1">Bank Name</label>
                                <input type="text" class="form-control" placeholder="Bank Name" name="bank_name">
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="exampleInputEmail1">Branch Name</label>
                                <input type="text" class="form-control" placeholder="Branch Name" name="branch_name">
                            </div>
                            <div class="col-md-12 form-group">
                                <label for="exampleInputEmail1">Note</label>
                                <textarea class="form-control" name="note" placeholder=" Add a Note or Rules for this Payment Method "></textarea>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Create</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    {{--    Edit Coupon Model--}}
    @if(isset($PaymentMethod))
        @foreach($PaymentMethods as $PaymentMethod)
            <div class="modal fade" id="EditCouponModal_{{ $PaymentMethod->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <!-- Modal content goes here, make sure to customize it for each category -->
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            Edit Category
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('payment_methods.update', $PaymentMethod->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label for="exampleInputEmail1">Payment Method Type</label>
                                        <select class="form-control" name="type" id="">
                                            <option value="">Select Type</option>
                                            <option value="COD" {{ $PaymentMethod->type == 'COD' ? 'selected' : '' }} >COD</option>
                                            <option value="Online Banking" {{ $PaymentMethod->type == 'Online Banking' ? 'selected' : '' }}> Online Banking </option>
                                            <option value="Bank Account" {{ $PaymentMethod->type == 'Bank Account' ? 'selected' : '' }}>Bank Account</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="exampleInputEmail1">Payment Method Name</label>
                                        <input type="text" class="form-control" placeholder="Payment Method Name" value="{{ $PaymentMethod->name }}" name="name">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="exampleInputEmail1">Account Number</label>
                                        <input type="number" class="form-control" placeholder="Number" value="{{ $PaymentMethod->number }}" name="number">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="exampleInputEmail1">Account Name</label>
                                        <input type="text" class="form-control" placeholder="Account Name" value="{{ $PaymentMethod->account_name }}" name="account_name">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="exampleInputEmail1">Bank Name</label>
                                        <input type="text" class="form-control" placeholder="Bank Name" value="{{ $PaymentMethod->bank_name }}" name="bank_name">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="exampleInputEmail1">Branch Name</label>
                                        <input type="text" class="form-control" placeholder="Branch Name" value="{{ $PaymentMethod->branch_name }}" name="branch_name">
                                    </div>
                                    <div class="col-md-12 form-group">
                                        <label for="exampleInputEmail1">Note</label>
                                        <textarea class="form-control" name="note">{{ $PaymentMethod->note }}</textarea>
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

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Function to handle visibility of inputs based on selected type
        function handleInputVisibility(modal) {
            const typeSelect = modal.querySelector('[name="type"]');
            const inputs = {
                name: modal.querySelector('[name="name"]').closest('.form-group'),
                number: modal.querySelector('[name="number"]').closest('.form-group'),
                accountName: modal.querySelector('[name="account_name"]').closest('.form-group'),
                bankName: modal.querySelector('[name="bank_name"]').closest('.form-group'),
                branchName: modal.querySelector('[name="branch_name"]').closest('.form-group'),
                note: modal.querySelector('[name="note"]').closest('.form-group'),
            };

            // Function to show/hide inputs
            function toggleInputs(value) {
                // Show all inputs by default
                Object.values(inputs).forEach(input => input.style.display = 'none');

                // Show inputs based on the selected type
                if (value === 'COD') {
                    inputs.name.style.display = '';
                    inputs.note.style.display = '';
                } else if (value === 'Online Banking') {
                    inputs.name.style.display = '';
                    inputs.number.style.display = '';
                    inputs.note.style.display = '';
                } else if (value === 'Bank Account') {
                    Object.values(inputs).forEach(input => input.style.display = '');
                }
            }

            // Initial setup based on the current value
            toggleInputs(typeSelect.value);

            // Event listener for changes in the select
            typeSelect.addEventListener('change', (e) => {
                toggleInputs(e.target.value);
            });
        }

        // Apply the functionality to Add Modal
        const addModal = document.querySelector('#AddCouponModal');
        if (addModal) handleInputVisibility(addModal);

        // Apply the functionality to Edit Modals
        const editModals = document.querySelectorAll('[id^="EditCouponModal_"]');
        editModals.forEach(modal => handleInputVisibility(modal));
    });
</script>


@endsection


