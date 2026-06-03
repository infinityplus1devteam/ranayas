@extends('layouts.admin-master')
@section('title', 'Assign Products to Budget')
@section('content')

<section class="section">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-dark text-white-all">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fas fa-home"></i> Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.shop_by_budgets.index') }}"><i class="fas fa-tag"></i> Shop by Budgets</a></li>
            <li class="breadcrumb-item active" aria-current="page"><i class="fas fa-eye"></i> Assign</li>
        </ol>
    </nav>

    {{-- Top Box: Update Budget Info --}}
    <div class="card">
        <div class="card-header bg-dark text-white-all">
            <h4>Update Budget: {{ $budget->name }}</h4>
        </div>
        <div class="card-body">
            <form action="{{ url('adranayas753/manage-shop-by-budgets/edit/'.$budget->id) }}" method="POST">
                @csrf
                <div class="row align-items-end">
                    <div class="col-md-3">
                        <div class="form-group mb-0">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" value="{{ $budget->name }}" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group mb-0">
                            <label>Budget Amount</label>
                            <input type="number" name="budget" class="form-control" value="{{ $budget->budget }}" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group mb-0">
                            <label>Status</label>
                            <select name="is_active" class="form-control">
                                <option value="1" {{ $budget->is_active ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ !$budget->is_active ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-save"></i> Update Budget</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- 30:70 Split Layout --}}
    <div class="row">
        {{-- Left Side (30%): Assigned Products --}}
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-dark text-white-all">
                    <h4>Assigned Products</h4>
                </div>
                <div class="card-body">
                    <form action="{{ url('adranayas753/manage-shop-by-budgets/update-sort/'.$budget->id) }}" method="POST">
                        @csrf
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm">
                                <thead>
                                    <tr>
                                        <th>Sort</th>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Remove</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($assignedProducts as $map)
                                    <tr>
                                        <td style="width: 70px;">
                                            <input type="number" name="sort_data[{{ $map->id }}]" value="{{ $map->sort_index }}" class="form-control form-control-sm text-center">
                                        </td>
                                        <td>
                                            @php
                                                $img = $map->product->images->first();
                                                $imgPath = $img ? '/storage/images/products/'.$img->image_url : '/assets/image/placeholder.png';
                                            @endphp
                                            <img src="{{ $imgPath }}" alt="product" style="width: 40px; height: 40px; object-fit: cover;">
                                        </td>
                                        <td style="font-size: 12px; line-height: 1.2;">{{ Str::limit($map->product->ProductName, 30) }}</td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-sm btn-danger remove-btn" data-id="{{ $map->id }}"><i class="fa fa-times"></i></button>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">No products assigned yet.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        @if($assignedProducts->count() > 0)
                            <button type="submit" class="btn btn-success btn-sm btn-block mt-2"><i class="fa fa-sort"></i> Update Sort Order</button>
                        @endif
                    </form>

                    {{-- Hidden Form for Removing --}}
                    <form id="removeForm" action="{{ url('adranayas753/manage-shop-by-budgets/remove-assign/'.$budget->id) }}" method="POST" style="display:none;">
                        @csrf
                        <input type="hidden" name="remove_assign[]" id="removeInput">
                    </form>
                </div>
            </div>
        </div>

        {{-- Right Side (70%): All Products --}}
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-dark text-white-all">
                    <h4>All Products (Check to Assign)</h4>
                </div>
                <div class="card-body">
                    <form action="{{ url('adranayas753/manage-shop-by-budgets/assign/'.$budget->id) }}" method="POST">
                        @csrf
                        <div class="table-responsive">
                            <table class="table table-striped table-hover datatable" style="width:100%;">
                                <thead>
                                    <tr>
                                        <th>
                                            <input type="checkbox" id="selectAll">
                                        </th>
                                        <th>ID</th>
                                        <th>Image</th>
                                        <th>Product Name</th>
                                        <th>MRP</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($products as $product)
                                    @php
                                        // Skip if already assigned
                                        $isAssigned = $assignedProducts->contains('product_id', $product->id);
                                        if($isAssigned) continue;
                                    @endphp
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="assign[]" value="{{ $product->id }}" class="product-checkbox">
                                        </td>
                                        <td>{{ $product->id }}</td>
                                        <td>
                                            @php
                                                $img = $product->images->first();
                                                $imgPath = $img ? '/storage/images/products/'.$img->image_url : '/assets/image/placeholder.png';
                                            @endphp
                                            <img src="{{ $imgPath }}" alt="product" style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">
                                        </td>
                                        <td>{{ $product->ProductName }}</td>
                                        <td>₹ {{ $product->MRP }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <button type="submit" class="btn btn-primary mt-3"><i class="fa fa-plus"></i> Assign Selected Products</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('extrajs')
<script>
    $(document).ready(function(){
        $('#selectAll').click(function(){
            $('.product-checkbox').prop('checked', this.checked);
        });

        $('.remove-btn').click(function(){
            if(confirm('Are you sure you want to remove this product from the budget?')) {
                $('#removeInput').val($(this).data('id'));
                $('#removeForm').submit();
            }
        });
    });
</script>
@endsection
