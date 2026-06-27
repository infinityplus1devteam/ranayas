@extends('layouts.admin-master')
@section('title', 'Administrative Dashboard')
@section('content')
<section class="section">
    <div class="row ">

        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="card bg">
                <div class="card-body">
                    <span class="info-box-icon bg-transparent pull-right">
                        <i class="fa fa-shopping-cart fa-fw fa-3x theme-color"></i>
                    </span>
                    <div class="info-box-content">
                        <h6 class="info-box-text text-dark"> New Orders</h6>
                        <h3 class="text-dark">{{ $orders }}</h3>
                    </div>
                </div>
                <div class="card-footer bg-dark text-white-all">
                    <a href="{{ route('admin.orders.all') }}" title="View Details">
                        View Details <i class="fa fa-angle-double-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="card bg">
                <div class="card-body">
                    <span class="info-box-icon bg-transparent pull-right">
                        <i class="fa fa-users fa-fw fa-3x theme-color"></i>
                    </span>
                    <div class="info-box-content">
                        <h6 class="info-box-text text-dark">New Customers</h6>
                        <h3 class="text-dark">{{ $today_users }}</h3>
                    </div>
                </div>
                <div class="card-footer bg-dark text-white-all">
                    <a href="{{ route('admin.users.all') }}" title="View Details">
                        View Details <i class="fa fa-angle-double-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="card bg">
                <div class="card-body">
                    <span class="info-box-icon bg-transparent pull-right">
                        <i class="fa fa-credit-card fa-fw fa-3x theme-color"></i>
                    </span>
                    <div class="info-box-content">
                        <h6 class="info-box-text text-dark">Today Sale</h6>
                        <h3 class="text-dark">₹ {{ $todays_sales }}</h3>
                    </div>
                </div>
                <div class="card-footer bg-dark text-white-all">
                    <a href="{{ route('admin.orders.all') }}" title="View Details">
                        View Details <i class="fa fa-angle-double-right"></i>
                    </a>
                </div>
            </div>
        </div>

        {{-- <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="card bg">
                <div class="card-body">
                    <span class="info-box-icon bg-transparent pull-right">
                        <i class="fa fa-newspaper fa-fw fa-3x theme-color"></i>
                    </span>
                    <div class="info-box-content">
                        <h6 class="info-box-text text-dark">Total Subscribers</h6>
                        <h3 class="text-dark">{{ $subscribers }}</h3>
                    </div>
                </div>
                <div class="card-footer bg-dark text-white-all">
                    <a href="{{ route('admin.subscribers.all') }}" title="View Details">
                        View Details <i class="fa fa-angle-double-right"></i>
                    </a>
                </div>
            </div>
        </div> --}}
    </div>
</section>
@endsection