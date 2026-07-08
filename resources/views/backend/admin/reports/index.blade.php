@extends('layouts.admin-master')
@section('title', 'Manage Reports')
@section('content')

<section class="section">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-dark text-white-all">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fas fa-home"></i>
                    Home</a></li>
            <li class="breadcrumb-item active" aria-current="page"><i class="fas fa-list"></i> Order Reports</li>

        </ol>
    </nav>

    <div class="card">
        <div class="card-header bg-dark text-white-all">
            <h4>Manage Order Reports</h4>
        </div>
        <form class="needs-validation" autocomplete="off" method="POST">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="from_date">From Date </label>
                            <input type="date" name="from_date" class="form-control" id="from_date"
                                placeholder="dd-mm-yyyy" value="{{ $dates['from_date'] }}">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="to_date">To Date</label>
                            <input type="date" name="to_date" class="form-control" id="to_date" placeholder="dd-mm-yyyy"
                                value="{{ $dates['to_date'] }}">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="to_date">Order Status</label>
                            <select name="status" id="status" class="form-control">
                                <option value="">--Select Status--</option>
                                <option value="Processing" {{ old('status') == 'Processing' ? 'selected' : '' }}>Processing</option>
                                <option value="Shipped" {{ old('status') == 'Shipped' ? 'selected' : '' }}>Shipped</option>
                                <option value="Out for Delivery" {{ old('status') == 'Out for Delivery' ? 'selected' : '' }}>Out for Delivery</option>
                                <option value="Delivered" {{ old('status') == 'Delivered' ? 'selected' : '' }}>Delivered</option>
                                <option value="Cancelled" {{ old('status') == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="filter">Filter</label>
                            <select name="filter" id="filter" class="form-control">
                                <option value="">--Select filter--</option>
                                <option value="day" {{ old('filter'=='day' ? 'selected' : '' ) }}>Day</option>
                                <option value="week" {{ old('filter'=='week' ? 'selected' : '' ) }}>Week</option>
                                <option value="month" {{ old('filter'=='month' ? 'selected' : '' ) }}>Month</option>
                                <option value="year" {{ old('filter'=='year' ? 'selected' : '' ) }}>Year</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-12 text-center">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-bar-chart"></i> Generate Report
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="card">
        <div class="card-header bg-dark">
            <form action="{{ route('admin.reports.all') }}" method="get" class="needs-validation">
                <div class="row align-items-center">
                    <div class="col-md-2">
                        <div class="form-group mb-0">
                            <input type="date" name="from_date" class="form-control" placeholder="From Date" value="{{ $dates['from_date'] ?? '' }}" style="height: 35px; border-radius: 30px; font-size: 13px;">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group mb-0">
                            <input type="date" name="to_date" class="form-control" placeholder="To Date" value="{{ $dates['to_date'] ?? '' }}" style="height: 35px; border-radius: 30px; font-size: 13px;">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group mb-0">
                            <select name="status" class="form-control" style="height: 35px; border-radius: 30px; font-size: 13px; padding-top: 0; padding-bottom: 0;">
                                <option value="">--Select Status--</option>
                                <option value="Processing" {{ ($dates['status'] ?? '') == 'Processing' ? 'selected' : '' }}>Processing</option>
                                <option value="Shipped" {{ ($dates['status'] ?? '') == 'Shipped' ? 'selected' : '' }}>Shipped</option>
                                <option value="Out for Delivery" {{ ($dates['status'] ?? '') == 'Out for Delivery' ? 'selected' : '' }}>Out for Delivery</option>
                                <option value="Delivered" {{ ($dates['status'] ?? '') == 'Delivered' ? 'selected' : '' }}>Delivered</option>
                                <option value="Cancelled" {{ ($dates['status'] ?? '') == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group mb-0">
                            <select name="filter" class="form-control" style="height: 35px; border-radius: 30px; font-size: 13px; padding-top: 0; padding-bottom: 0;">
                                <option value="">--Select filter--</option>
                                <option value="day" {{ ($dates['filter'] ?? '') == 'day' ? 'selected' : '' }}>Day</option>
                                <option value="week" {{ ($dates['filter'] ?? '') == 'week' ? 'selected' : '' }}>Week</option>
                                <option value="month" {{ ($dates['filter'] ?? '') == 'month' ? 'selected' : '' }}>Month</option>
                                <option value="year" {{ ($dates['filter'] ?? '') == 'year' ? 'selected' : '' }}>Year</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group mb-0 d-flex align-items-center">
                            <button type="submit" class="btn btn-outline-primary btnSubmit" style="height: 35px; border-radius: 30px; font-size: 13px; padding: 0 15px; display: inline-flex; align-items: center; justify-content: center;">
                                <i class="fa fa-filter mr-1"></i> Filter
                            </button>
                            <a href="javascript:void(0)" class="btn btn-outline-success export-excel" style="margin-left: 5px; height: 35px; border-radius: 30px; font-size: 13px; padding: 0 15px; display: inline-flex; align-items: center; justify-content: center;">
                                <i class="fa fa-file-excel-o mr-1"></i> Excel Export
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover datatable" style="width:100%;">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Name</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Ordered Date</th>
                            <th>View</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($orders as $order)
                        <tr>
                            <td>{{ $order->order_number }}</td>
                            <td>{{ $order->user_name }}</td>
                            <td>&#8377;{{ $order->total }}</td>
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
                            <td class="text-danger" colspan="6">
                                <h4>No Record Found..</h4>
                            </td>
                        </tr>
                        @endforelse
                        @if($orders->total() > 50)
                        <tr class="text-center">
                            <td colspan="6">
                                {{ $orders->links() }}
                            </td>
                        </tr>
                        @endif
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Order ID</th>
                            <th>Name</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Ordered Date</th>
                            <th>View</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.orders.reports.export') }}" method="POST" id="exportExcel">
        @csrf
        <input type="hidden" name="from_date" value="{{ $dates['from_date'] ?? '' }}">
        <input type="hidden" name="to_date" value="{{ $dates['to_date'] ?? '' }}">
        <input type="hidden" name="status" value="{{ $dates['status'] ?? '' }}">
        <input type="hidden" name="filter" value="{{ $dates['filter'] ?? '' }}">
    </form>

</section>
@endsection

@section('extrajs')
<script>
    $(document).ready(function () {
        $('.export-excel').click(function () {
            $('#exportExcel').submit();
        });
    });

</script>
@endsection