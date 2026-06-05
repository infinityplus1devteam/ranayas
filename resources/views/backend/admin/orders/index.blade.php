@extends('layouts.admin-master')
@section('title', 'Manage Orders')
@section('content')
<section class="section">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-dark text-white-all">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fas fa-home"></i>
                    Home</a></li>
            <li class="breadcrumb-item active" aria-current="page"><i class="fas fa-list"></i> Orders</li>

        </ol>
    </nav>
    <div class="card">
        <div class="card-header bg-dark text-white-all">
            <h4>Search Orders</h4>
        </div>
        <form class="needs-validation" autocomplete="off" method="GET">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="order_id">Order Number</label>
                            <input type="number" name="order_id" class="form-control" id="order_id"
                                placeholder="Enter Order ID" value="{{Request::get('order_id')}}" autofocus min="1">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="city">City</label>
                            <input type="text" name="city" class="form-control" id="city" placeholder="Enter City"
                                value="{{Request::get('city')}}">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="pincode">Pincode</label>
                            <input type="number" name="pincode" class="form-control" id="pincode"
                                value="{{Request::get('pincode')}}" placeholder="Enter Pincode" minlength="5" min="1">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="order_date">Order Date</label>
                            <input type="text" name="order_date" class="form-control date" id="order_date"
                                value="{{Request::get('order_date')}}" placeholder="dd-mm-yyyy">
                        </div>
                    </div>

                    <div class="col-md-12 text-center">
                        <button type="submit" class="btn btn-primary btnSubmit">
                            <i class="fa fa-search"></i> Search
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="card">
        <div class="card-header bg-dark text-white-all">
            <h4>Manage Orders</h4>
            @if(count($orders))
            <form action="{{ route('admin.orders.export') }}" method="post">
                @csrf
                <button type="submit" class="btn btn-primary btnSubmit">
                    <i class="fa fa-file-excel-o"></i> Export Excel
                </button>
            </form>
            @endif
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover datatable" style="width:100%;">
                    <thead>
                        <tr>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>City</th>
                            <th>Pincode</th>
                            <th>Status</th>
                            <th>Ordered Date</th>
                            <th>Action</th>
                        </tr>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($orders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->user_name }}</td>
                            <td>{{ $order->user?->email ?? 'N/A' }}</td>
                            <td>{{ $order->city }}</td>
                            <td>{{ $order->pincode }}</td>
                            <td class="text-capitalize">{{ $order->status }}</td>
                            <td>{{ date('d-m-Y h:i A' , strtotime($order->created_at)) }}</td>
                            <td>
                                <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-outline-primary"
                                    title="View Detail">
                                    <i class="fa fa-eye has-icon"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr class="text-center">
                            <td class="text-danger" colspan="8">
                                <h4>No Record Found..</h4>
                            </td>
                        </tr>
                        @endforelse
                        @if($orders->total() > 50)
                        <tr class="text-center">
                            <td colspan="8">
                                {{ $orders->links() }}
                            </td>
                        </tr>
                        @endif
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>City</th>
                            <th>Pincode</th>
                            <th>Status</th>
                            <th>Ordered Date</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</section>
@endsection