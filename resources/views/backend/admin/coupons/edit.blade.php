@extends('layouts.admin-master')
@section('title', 'Update Coupon')
@section('content')

<section class="section">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-dark text-white-all">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.dashboard') }}"><i class="fas fa-home"></i>
                    Dashboard
                </a>
            </li>
            <li class="breadcrumb-item active" aria-current="page"><i class="fas fa-list"></i>Edit Coupon</li>
            <li class="breadcrumb-item"><a href="{{ route('admin.coupons.all') }}"> All Coupons</a></li>
        </ol>
    </nav>
    <div class="card">
        <div class="card-header bg-dark text-white-all">
            <h4>Update Coupon</h4>
        </div>
        <div class="card-body">
            <form method="post" action="{{ route('admin.coupons.update', $coupon->id) }}" id="formEditCoupon" class="needs-validation">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Coupon Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" class="form-control"
                                value="{{ $coupon->name }}" placeholder="Enter Coupon Name" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="code">Coupon Code <span class="text-danger">*</span></label>
                            <input type="text" name="code" id="code" class="form-control"
                                value="{{ $coupon->code }}" placeholder="Enter Coupon Code" required>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" id="description" class="form-control" placeholder="Optional description">{{ $coupon->description }}</textarea>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="type">Coupon Type <span class="text-danger">*</span></label>
                            <select name="type" id="type" class="form-control" required>
                                <option value="percentage" {{ $coupon->type == 'percentage' ? 'selected' : '' }}>Percentage Off</option>
                                <option value="flat" {{ $coupon->type == 'flat' ? 'selected' : '' }}>Flat Off</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="value">Value <span class="text-danger">*</span></label>
                            <input type="number" name="value" id="value" class="form-control"
                                value="{{ $coupon->value }}" placeholder="Enter Value" min="0" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="min_amount">Minimum Order Amount <span class="text-danger">*</span></label>
                            <input type="number" name="min_amount" id="min_amount" class="form-control"
                                value="{{ $coupon->min_amount }}" placeholder="Minimum amount for coupon" min="0" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="status">Status <span class="text-danger">*</span> </label>
                            <select name="status" id="status" class="form-control" required>
                                <option value="1" {{ $coupon->status == true ? 'selected': '' }}>Active</option>
                                <option value="0" {{ $coupon->status == false ? 'selected': '' }}>Inactive</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-12 text-center">
                        <button type="submit" class="btn btn-primary btnSubmit"> <i class="fas fa-pencil-alt"></i>
                            Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection

@section('extrajs')
<script>
    $("#formEditCoupon").validate({
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
</script>
@endsection
