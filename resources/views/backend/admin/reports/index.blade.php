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
                                <option value="booked" {{ old('status'=='booked' ? 'selected' : '' ) }}>Booked</option>
                                <option value="shipping" {{ old('status'=='shipping' ? 'selected' : '' ) }}>Shipping
                                </option>
                                <option value="dispatched" {{ old('status'=='dispatched' ? 'selected' : '' ) }}>
                                    Dispatched
                                </option>
                                <option value="delivered" {{ old('status'=='delivered' ? 'selected' : '' ) }}>Delivered
                                </option>
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
                <div class="row">
                    <div class="col-md-12 form-inline">
                        <select name="filter" id="filter" class="form-control" required>
                            <option value="">--Select filter--</option>
                            <option value="day" {{ $dates['filter']=='day' ? 'selected' : '' }}>Day</option>
                            <option value="week" {{ $dates['filter']=='week' ? 'selected' : '' }}>Week</option>
                            <option value="month" {{ $dates['filter']=='month' ? 'selected' : '' }}>Current Month
                            </option>
                            <option value="year" {{ $dates['filter']=='year' ? 'selected' : '' }}>Year</option>
                        </select>

                        <button type="submit" class="btn btn-outline-primary btnSubmit">
                            <i class="fa fa-filter"></i> Filter
                        </button>

                        <a href="javascript:void(0)" class="btn btn-outline-success export-excel">
                            <i class="fa fa-file-excel-o"></i> Excel Export
                        </a>
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