@extends('layouts.master') @section('title', 'Order Placed') @section('content')

<!-- breadcrumb start -->
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
                            <a href="{{ route('user.showOrder') }}">My Orders</a>
                        </li>
                        <li class="breadcrumb-url-li">
                            <span>Order Placed</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- breadcrumb end -->
<div id="content" class="main-content-wrapper order-details">
    <div class="page-content-inner">
        <div class="container div-visible">
            @if(isset($order))
            <div class="personal-detail">
                <div class="row">
                    <div class="col-md-12 mt-10">
                        <div class="pull-right btn-box">
                            <button type="submit" class="btn-print" onclick="javascript:window.print();">
                                <i class="fa fa-print"></i>
                                Print
                            </button>
                        </div>
                    </div>

                    <div class="col-md-9">
                        <div class="address">
                            <h4>Delivery Address</h4>
                            <h5><strong>{{ $order->user->name }}</strong></h5>
                            <p>{{ $order->address }}</p>
                            @if($order->landmark)
                                <p>Landmark - {{ $order->landmark }}</p>
                            @endif
                            <p>City - {{ $order->city }}</p>
                            <p>State - {{ $order->territory }}</p>
                            <p>Pincode - {{ $order->pincode }}</p>
                            <p><strong>Phone Number - {{ $order->user->mobile }}</strong></p>
                            <p><strong>Email Id - {{ $order->user->email }}</strong></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="order-bordered mt--30 mb--30">
                <div class="row">
                    <div class="col-md-12">
                        <div class="order_sec">
                            @php $total = 0; @endphp
                            @foreach($order->details as $detail)
                                                @php
                                                    $total += $detail->quantity * $detail->mrp;
                                                    $offers = json_decode($detail->offers);
                                                    $exp_offers = explode(",", $offers);
                                                    $image = \App\Model\TxnImage::image($detail->product_id, $detail->color_id);
                                                @endphp
                                                <div class="row mb-3">
                                                    <div class="col-sm-5">
                                                        <div class="pro_sec">
                                                            <div class="img">
                                                                <img src="{!! asset('/storage/images/multi-products/' . $image->image_url) !!}"
                                                                    alt="{{ $detail->product->title }}" class="img-fluid">
                                                            </div>
                                                            <div class="content">
                                                                <p class="title">
                                                                    {{ $detail->product->title }}
                                                                </p>
                                                                <p>
                                                                    {{ $detail->size ? 'Volume: ' . $detail->size->title : '' }} {{
                                $detail->product->unit ? $detail->product->unit->unit :
                                'GM' }} <br>
                                                                    {{ $detail->color ? 'Color: ' . $detail->color->title : '' }}
                                                                </p>
                                                                <p>Price : {{ $detail->mrp }}</p>
                                                                <p>Quantity : {{ $detail->quantity }}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <p class="price">&#8377; {{ $detail->mrp * $detail->quantity }}</p>
                                                    </div>
                                                    <div class="col-sm-5">
                                                        @if($order->delivery_date)
                                                            <p class="delivery">Delivered by
                                                                {{ date('M, d', strtotime($order->delivery_date)) }}
                                                            </p>
                                                        @endif
                                                    </div>
                                                </div>
                            @endforeach
                            <hr>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="row">
                                        <div class="col-sm-12 mb-15">
                                            <p class="mb-0"><strong>Order On </strong></p>
                                            <p>{{ date('D, M d, Y', strtotime($order->created_at)) }}</strong></p>
                                        </div>
                                        <div class="col-sm-12 mb-15">
                                            <p class="mb-0"><strong>Order Status </strong></p>
                                            <p class="text-capitalize">{{ $order->status }}</p>
                                        </div>

                                        @if($order->transaction)
                                            <div class="col-sm-12 mb-15">
                                                <p class="mb-0"><strong>Transaction ID </strong></p>
                                                <p>{{ $order->transaction->TXNID }}</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="row">
                                        <div class="col-sm-12 mb-15">
                                            <p class="mb-0"><strong>Payment Status </strong></p>
                                            <p> {{ $order->payment_status }}</p>
                                        </div>
                                        <div class="col-sm-12 mb-15">
                                            <p class="mb-0"><strong>Payment Mode </strong></p>
                                            <p class="text-capitalize"> {{ $order->payment_mode }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <table class="table table-striped table-bordered table-hover table-dark">
                                        <tbody>
                                            <tr>
                                                <th>Total</th>
                                                <td><strong>&#8377; {{ $order->tbt }}</strong></td>
                                            </tr>
                                            @if($order->tax > 0)
                                                <tr>
                                                    <th> + CGST </th>
                                                    <td> &#8377; {{ round($order->tax / 2, 2) }} </td>
                                                </tr>
                                                <tr>
                                                    <th> + SGST </th>
                                                    <td> &#8377; {{ round($order->tax / 2, 2) }} </td>
                                                </tr>
                                            @endif
                                            @if($order->discount)
                                                <tr>
                                                    <th> - Discount </th>
                                                    <td> &#8377; {{ $order->discount }} </td>
                                                </tr>
                                            @endif
                                            <tr>
                                                @php $shipping = $order->total >= 1000 ? 0 : 60; @endphp
                                                <th> + Shipping Charges </th>
                                                <td> &#8377; {{ $shipping }} </td>
                                            </tr>
                                            <tr>
                                                <th> <strong>Grand Total</strong> </th>
                                                <td> <strong>&#8377; {{ round($order->tbt + $order->tax - $order->discount + $shipping, 2) }}</strong> </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

@endsection
@section('extracss')
    <style>
        @media print {
            body * {
                visibility: hidden;
            }

            .btn-print {
                display: none;
                visibility: hidden;
            }

            /* nav.navbar.bootsnav .navbar-header {
                display: none;
            }
            footer.dark-bg {
                display: none;
            }*/
            .div-visible * {
                visibility: visible;
            }

            .div-visible {
                position: absolute;
                top: 0;
            }

            table.table tr td,
            table.table.table-lg tr th {
                padding: 5px 0 5px 5px;
            }

            .table>tbody>tr>th,
            .table>tfoot>tr>th {
                padding: 5px 0 5px 30px;
                font-weight: 100;
            }
        }

        .btn-print {
            background: #ed2024;
            width: 100px;
            color: #fff;
            border: 1px solid #ed2024;
            border-radius: 25px;
            padding: 5px 15px;
            margin: 0 0 10px 0;
        }

        img.lazy {
            width: 100%;
            min-height: 120px;
            max-height: 120px;
            background: #fff url("{{ asset('assets/img/loader.gif') }}") no-repeat 50% 50% !important;
            display: block;
        }

        .table thead th,
        .table th,
        .table thead td,
        .table td {
            padding: 10px;
        }

        .order-details p {
            color: #000;
        }

        .order-details .personal-detail {
            box-shadow: 0px 2px 6px 2px #ccc;
            padding: 20px;
            margin-bottom: 15px;
        }

        .order-bordered {
            margin-bottom: 20px;
        }

        .order-details .address p {
            margin-bottom: 0px;
        }

        .order-details .address h4 {
            font-size: 18px;
            font-weight: 600;
        }

        .icon-circle {
            background: #ffd54c;
            text-align: center;
            height: 20px;
            width: 20px;
            line-height: 20px;
            border-radius: 50%;
            margin-right: 5px;
        }

        .order_sec {
            border: none;
            border-radius: 5px;
        }

        .order_sec .pro_sec .img,
        .order_sec p.delivery,
        .order_sec p.date,
        .padding10,
        .order_sec p.price {
            padding-left: 0;
        }

        .review-sec {
            padding-right: 0;
            padding-left: 0;
        }

        .review-sec a {
            display: block;
            border: 1px solid #333 !important;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            color: #333 !important;
        }

        .review-sec h4 {
            font-size: 18px;
            font-weight: 600;
        }

        @media screen and (max-width: 767px) {
            .order_sec .pro_sec {
                height: auto;
            }

            .order_sec .pro_sec .content {
                padding-top: 0;
                padding-top: 0;
            }

            .order_sec .pro_sec .content p.title {
                margin-bottom: 5px;
            }

            .order_sec .pro_sec .img,
            .order_sec p.delivery,
            .order_sec p.date,
            .padding10,
            .order_sec p.price {
                padding: 0;
            }

            .review-sec {
                float: unset !important;
            }
        }

        .order-details p {
            padding: 0;
            box-shadow: none;
        }
    </style>
@endsection @section('extrajs')

@endsection