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
                                <label for="description">Description</label>
                                <textarea name="description" id="description" class="form-control" rows="3" placeholder="Enter short description (optional)">{{ old('description') }}</textarea>
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

{{-- Edit Modal --}}
<div class="modal" id="editModal">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white-all">
                <h5 class="modal-title">Edit Budget Section</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="POST" role="form" class="needs-validation" id="formEditBudget">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="edit_name">Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="edit_name" class="form-control" required>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="edit_description">Description</label>
                                <textarea name="description" id="edit_description" class="form-control" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="edit_is_active">Status</label>
                                <select name="is_active" id="edit_is_active" class="form-control">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary btnEditSubmit">
                            <i class="fa fa-save"></i> Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
{{-- Edit Modal End --}}

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
                <form action="{{ route('admin.shop_by_budgets.update_budgets_sort') }}" method="POST">
                    @csrf
                <table class="table table-striped table-hover datatable" style="width:100%;">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Sort Index</th>
                            <th>Name</th>

                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($budgets as $budget)
                        <tr>
                            <td>{{ $budget->id }}</td>
                            <td>
                                <input type="number" name="sort_data[{{ $budget->id }}]" class="form-control" value="{{ $budget->sort_index }}" style="width: 80px;" min="0">
                            </td>
                            <td>{{ $budget->name }} </td>

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
                                        <a href="javascript:void(0)" class="dropdown-item has-icon edit-budget"
                                            data-id="{{ $budget->id }}"
                                            data-name="{{ $budget->name }}"
                                            data-description="{{ $budget->description }}"
                                            data-status="{{ $budget->is_active }}">
                                            <i class="fa fa-edit"></i> Edit
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
                            <td class="text-danger" colspan="6">
                                <h4>No Record Found..</h4>
                            </td>
                        </tr>
                        @endforelse
                        @if($budgets->total() > 50)
                        <tr class="text-center">
                            <td colspan="6">
                                {{ $budgets->links() }}
                            </td>
                        </tr>
                        @endif
                    </tbody>
                </table>
                <div class="mt-3">
                    <button type="submit" class="btn btn-success bg-success text-white"><i class="fa fa-sort"></i> Update Sort Index</button>
                </div>
                </form>
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
            },
            messages: {
                name: { required: "Please Enter Name" },
            },
            submitHandler: function (form) {
                $('.btnSubmit').attr('disabled', 'disabled');
                $(".btnSubmit").html('<span class="fa fa-spinner fa-spin"></span> Loading...');
                form.submit();
            }
        });

        $("#formEditBudget").validate({
            rules: {
                name: { required: true },
            },
            messages: {
                name: { required: "Please Enter Name" },
            },
            submitHandler: function (form) {
                $('.btnEditSubmit').attr('disabled', 'disabled');
                $(".btnEditSubmit").html('<span class="fa fa-spinner fa-spin"></span> Loading...');
                form.submit();
            }
        });

        $('.edit-budget').on('click', function() {
            var id = $(this).data('id');
            var name = $(this).data('name');
            var description = $(this).data('description');
            var status = $(this).data('status');

            $('#edit_name').val(name);
            $('#edit_description').val(description);
            $('#edit_is_active').val(status);

            var formAction = "{{ url('adranayas753/manage-shop-by-budgets/edit') }}/" + id;
            $('#formEditBudget').attr('action', formAction);

            $('#editModal').modal('show');
        });
    });
</script>
@endsection
