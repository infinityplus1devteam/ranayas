@extends('layouts.master') @section('title','Orders Tracking') @section('content')

<!-- Breadcrumb area Start -->
<section class="breadcrumb-area">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="breadcrumb-start">
                    <ul class="breadcrumb-url">
                        <li class="breadcrumb-url-li">
                            <a href="{{ route('index') }}">Home</a>
                        </li>
                        <li class="breadcrumb-url-li">
                            <a href="{{ route('user.showOrder') }}">Orders</a>
                        </li>
                        <li class="breadcrumb-url-li">
                            <span>Order Tracking Of #{{ $order->order_number }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb area End -->

<section class="section-b-padding">
    <div id="content" class="main-content-wrapper order-details">
        <div class="page-content-inner">
            <div class="container">
                <div class="personal-detail">
                    <div class="row">
                        <div class="col-md-12">
                            <a href="{{ route('user.order',$order->id) }}" class="pull-left mt-0 mb-3"> <i
                                    class="fa fa-angle-double-left" aria-hidden="true"></i> Go Back</a>
                        </div>
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header bg-info text-white-all">
                                    <h4 class="text-white">Order Tracking</h4>
                                </div>
                                <div class="card-body table-responsive">
                                    @if($track_response)
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th colspan="4">
                                                    <span class="pull-left text-dark">Order Pickedup Origin :
                                                        {{ $track_response['shipment_track']['origin'] }}</span>
                                                </th>
                                            </tr>

                                            <tr class="thead-dark">
                                                <th>Instructions</th>
                                                <th>Location</th>
                                                <th>Date & Time</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        @if($track_response['shipment_track_activities'])
                                        <tbody>
                                            @foreach($track_response['shipment_track_activities'] as $scan)
                                            <tr>
                                                <td>
                                                    {{ $scan['activity'] }}
                                                </td>
                                                <td>
                                                    {{ $scan['location'] }}
                                                </td>
                                                <td>
                                                    {{ date('d-M-Y h:i A', strtotime($scan['date'])) }}
                                                </td>
                                                <td>
                                                    {{ $scan['status'] }}
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                        @endif
                                    </table>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
@endsection

@section('extracss')
<style>
    .order-details h4 {
        margin-bottom: 0;
    }
</style>
@endsection