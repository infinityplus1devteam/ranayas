@extends('layouts.admin-master')
@section('title', 'Manage Shop By Budgets')
@section('content')

{{-- Add Modal --}}
<div class="modal" id="addModal">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white-all">
                <h5 class="modal-title">Add Budget Section</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.shop_by_budgets.index') }}" method="POST" role="form" class="needs-validation" id="formAddBudget">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="name">Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="name" class="form-control"
                                    value="{{ old('name') }}" placeholder="e.g. Under 99" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="budget">Budget Amount <span class="text-danger">*</span></label>
                                <input type="number" name="budget" id="budget" class="form-control"
                                    value="{{ old('budget') }}" placeholder="e.g. 99" required>
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
{{-- Modal End --}}

<section class="section">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-dark text-white-all">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fas fa-home"></i> Home</a></li>
            <li class="breadcrumb-item active" aria-current="page"><i class="fas fa-tag"></i> Shop by Budgets</li>
            <li class="breadcrumb-item"><a href="#addModal" data-toggle="modal" data-target="#addModal"><i class="fas fa-plus"></i> Add Budget</a></li>
        </ol>
    </nav>
    <div class="card">
        <div class="card-header bg-dark text-white-all">
            <h4>Manage Shop by Budgets</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover datatable" style="width:100%;">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Budget</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($budgets as $budget)
                        <tr>
                            <td>{{ $budget->id }}</td>
                            <td>{{ $budget->name }} </td>
                            <td>₹ {{ $budget->budget }} </td>
                            <td>
                                @if($budget->is_active)
                                    <span class="badge badge-success">Active</span>
                                @else
                                    <span class="badge badge-danger">Inactive</span>
                                @endif
                            </td>
                            <td>
                                <div class="dropdown d-inline">
                                    <button class="btn btn-outline-primary dropdown-toggle" type="button"
                                        id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        Action
                                    </button>
                                    <div class="dropdown-menu">
                                        <a href="{{ route('admin.shop_by_budgets.assign', $budget->id) }}"
                                            class="dropdown-item has-icon" title="View & Assign Products">
                                            <i class="fa fa-eye"></i> View
                                        </a>
                                        <form action="{{ url('adranayas753/manage-shop-by-budgets/delete/'.$budget->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this budget?');">
                                            @csrf
                                            <button type="submit" class="dropdown-item has-icon text-danger" title="Delete" style="border: none; background: transparent; cursor: pointer; width: 100%; text-align: left;">
                                                <i class="fa fa-trash"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr class="text-center">
                            <td class="text-danger" colspan="5">
                                <h4>No Record Found..</h4>
                            </td>
                        </tr>
                        @endforelse
                        @if($budgets->total() > 50)
                        <tr class="text-center">
                            <td colspan="5">
                                {{ $budgets->links() }}
                            </td>
                        </tr>
                        @endif
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
        $("#formAddBudget").validate({
            rules: {
                name: { required: true },
                budget: { required: true, number: true },
            },
            messages: {
                name: { required: "Please Enter Name" },
                budget: { required: "Please Enter Budget Amount" },
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
