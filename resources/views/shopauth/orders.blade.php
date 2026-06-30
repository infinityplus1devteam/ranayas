@extends('layouts.master')
@section('title','Orders')
@section('content')

<!-- Breadcrumb area Start -->
<div class="breadcrumb-area bg--white-6 pt--60 pb--70 pt-lg--40 pb-lg--50 pt-md--30 pb-md--40">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 text-center">
                <h1 class="page-title">My Account</h1>
                <ul class="breadcrumb justify-content-center">
                    <li class="current"><a href="{{ route('shop.dashboard') }}">Orders</a></li>
                    <li><a href="{{ route('shop.account') }}">Account</a></li>
                    <li><a href="{{ route('shop.logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                    </li>
                   <form id="logout-form" action="{{ route('shop.logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- Breadcrumb area End -->

<section class="main_content_area">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Orders</h4>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Purchase Amount</th>
                                    <th>Commission Received</th>
                                    <th>Ordered Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($orders as $order)
                                <tr>
                                    <td>{{ $order->order_number }}</td>
                                    <td>Rs.{{ $order->tbt }}</td>
                                    <td>Rs.{{ round($order->tbt * 0.1,0) }}</td>
                                    <td>{{ date('d-m-Y h:i A' , strtotime($order->created_at)) }}</td>
                                </tr>
                                @empty
                                <tr class="text-center">
                                    <td class="text-danger" colspan="4">
                                        <h4>No Order Found <strong>Share your Code {{ auth('shop')->user()->shop_code }} </strong> to earn Commission on Each Order</h4>
                                    </td>
                                </tr>
                                @endforelse

                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Purchase Amount</th>
                                    <th>Commission Received</th>
                                    <th>Ordered Date</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
