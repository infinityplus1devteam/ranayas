@extends('layouts.admin-master')
@section('title', 'Manage Coupons')
@section('content')

<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="formModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white-all">
                <h5 class="modal-title" id="formModal">Add Coupon</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.coupons.store') }}" method="POST" role="form" class="needs-validation"
                    id="formAddCoupon">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="name">Coupon Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" id="name" class="form-control"
                                        value="{{ old('name') }}" placeholder="Enter Coupon Name" required>
                                </div>
                            </div>
                            
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="code">Coupon Code <span class="text-danger">*</span></label>
                                    <input type="text" name="code" id="code" class="form-control"
                                        value="{{ old('code') }}" placeholder="Enter Coupon Code (e.g. SAVE10)" required>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="description">Description </label>
                                    <textarea name="description" id="description" class="form-control" placeholder="Optional description">{{ old('description') }}</textarea>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="type">Coupon Type <span class="text-danger">*</span></label>
                                    <select name="type" id="type" class="form-control" required>
                                        <option value="percentage" {{ old('type') == 'percentage' ? 'selected' : '' }}>Percentage Off</option>
                                        <option value="flat" {{ old('type') == 'flat' ? 'selected' : '' }}>Flat Off</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="value">Value <span class="text-danger">*</span></label>
                                    <input type="number" name="value" id="value" class="form-control"
                                        value="{{ old('value') }}" placeholder="Enter Value (e.g. 10 or 100)" min="0" required>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="min_amount">Minimum Order Amount <span class="text-danger">*</span></label>
                                    <input type="number" name="min_amount" id="min_amount" class="form-control"
                                        value="{{ old('min_amount', 0) }}" placeholder="Minimum amount for coupon" min="0" required>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="status">Status <span class="text-danger">*</span></label>
                                    <select name="status" id="status" class="form-control" required>
                                        <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12 text-danger">
                                Note : All * Mark Fields are Compulsory !
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary btnSubmit">
                            <i class="fa fa-plus"></i> Add
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<section class="section">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-dark text-white-all">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fas fa-home"></i>
                    Home</a></li>
            <li class="breadcrumb-item active" aria-current="page"><i class="fas fa-list"></i> Coupons</li>
            <li class="breadcrumb-item"><a href="#addModal" data-toggle="modal" data-target="#addModal"><i
                        class="fas fa-plus"></i> Add Coupon</a></li>
        </ol>
    </nav>
    <div class="card">
        <div class="card-header bg-dark text-white-all">
            <h4>Manage Coupons</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover datatable" style="width:100%;">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Code</th>
                            <th>Type</th>
                            <th>Value</th>
                            <th>Min Amount</th>
                            <th>Status</th>
                            <th>Added On</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($coupons as $coupon)
                        <tr>
                            <td>{{ $coupon->id }}</td>
                            <td>{{ $coupon->name }}</td>
                            <td><span class="badge badge-success">{{ $coupon->code }}</span></td>
                            <td>{{ ucfirst($coupon->type) }} Off</td>
                            <td>{{ $coupon->type == 'percentage' ? $coupon->value . '%' : '₹' . $coupon->value }}</td>
                            <td>₹{{ $coupon->min_amount }}</td>
                            <td>
                                {{ $coupon->status == true ? 'Active' : 'Blocked' }}
                            </td>
                            <td>{{ date('d-M-Y', strtotime($coupon->created_at)) }}</td>
                            <td>
                                <div class="dropdown d-inline">
                                    <button class="btn btn-outline-primary dropdown-toggle" type="button"
                                        id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        Action
                                    </button>
                                    <div class="dropdown-menu">
                                        <a href="{{ route('admin.coupons.edit', $coupon->id) }}"
                                            class="dropdown-item has-icon" title="Edit Detail">
                                            <i class="fa fa-edit"></i> Edit
                                        </a>
                                        <form action="{{ route('admin.coupons.delete', $coupon->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this coupon?');">
                                            @csrf
                                            <button type="submit" class="dropdown-item has-icon text-danger" title="Delete Coupon" style="cursor: pointer;">
                                                <i class="fa fa-trash"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr class="text-center">
                            <td class="text-danger" colspan="9">
                                <h5>No Record Found. <a href="#addModal" data-toggle="modal" data-target="#addModal">
                                        Click here to Add
                                    </a></h5>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

@endsection

@section('extrajs')
<script>
    $(document).ready(function () {
        $("#formAddCoupon").validate({
            rules: {
                name: { required: true },
                code: { required: true },
                type: { required: true },
                value: { required: true },
                min_amount: { required: true },
                status: { required: true }
            },
            messages: {
                name: { required: "Please Enter Coupon Name" },
                code: { required: "Please Enter Coupon Code" },
                type: { required: "Please Select Type" },
                value: { required: "Please Enter Value" },
                min_amount: { required: "Please Enter Min Amount" },
                status: { required: "Please Select Status" }
            },
            submitHandler: function (form) {
                $('.btnSubmit').attr('disabled', 'disabled');
                $(".btnSubmit").html('<span class="fa fa-spinner fa-spin"></span> Loading...');
                form.submit();
            }
        });
    });
</script>
@endsection
