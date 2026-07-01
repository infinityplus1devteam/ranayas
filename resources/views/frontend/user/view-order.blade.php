@extends('layouts.master') @section('title', 'Orders') @section('content')

    {{-- Model --}}

    <div class="modal fade" id="orderReturn">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Return Order</h4>
                    <button type="button" class="btn-close cclose" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <form method="POST" role="form" class="form" action="{{ route('user.orders.return', $order->id) }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="reason">Select Reason <span class="text-danger">*</span></label>
                                        <select name="reason" id="reason" class="form-control" required>
                                            <option value="">--Select Reason--</option>
                                            <option value="Within 7 Days" {{ old('reason') == 'Within 7 Days' ? 'selected'
        : '' }}>Within 7 Days
                                            </option>
                                            <option value="Wrong Products" {{ old('reason') == 'Wrong Products' ? 'selected'
        : '' }}>Wrong Products
                                            </option>
                                            <option value="Faulty Products" {{ old('reason') == 'Faulty Products' ? 'selected'
        : '' }}>Faulty Products
                                            </option>
                                            <option value="Quality Products" {{ old('reason') == 'Quality Products'
        ? 'selected' : '' }}>Quality Products
                                            </option>
                                            <option value="other" {{ old('reason') == 'other' ? 'selected' : '' }}>Other
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12 other_reason">
                                    <div class="form-group">
                                        <label for="other_reason">Write Reason <span class="text-danger">*</span></label>
                                        <textarea name="other_reason" id="other_reason" class="form-control"
                                            rows="5">{{ old('other_reason') }}</textarea>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="image_url">Upload Product Image</label>
                                        <input type="file" name="image_url" id="image_url" class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-12 text-danger">
                                    Note : All * Mark Fields are Compulsory !
                                </div>

                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn review-submit-btn">
                                <i class="fa fa-plus"></i> Submit
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    {{-- Model End --}}

    {{-- Help Model --}}

    <div class="modal fade" id="orderHelp">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Need Help ? </h4>
                    <button type="button" class="btn-close cclose" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <form method="POST" role="form" class="form" action="{{ route('user.orders.help', $order->id) }}">
                        @csrf
                        <div class="modal-body">
                            <div class="row">

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="description" style="padding-left: 0">Write your query <span
                                                class="text-danger">*</span></label>
                                        <textarea name="description" id="description" class="form-control" rows="5"
                                            required>{{ old('description') }}</textarea>
                                    </div>
                                </div>

                                <div class="col-md-12 text-danger">
                                    Note : All * Mark Fields are Compulsory !
                                </div>

                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn review-submit-btn">
                                <i class="fa fa-plus"></i> Submit
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    {{-- Help Model End --}}
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
                                <span>Order id: {{ $order->order_number }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb area End -->
    <section>
        <div id="content" class="main-content-wrapper order-details">
            <div class="page-content-inner">
                <div class="container">
                    <div class="personal-detail">
                        <div class="row">
                            <div class="col-md-12">
                                <a href="{{ route('user.showOrder') }}" class="pull-left mt-0 mb-3"> <i
                                        class="fa fa-angle-double-left" aria-hidden="true"></i> Go Back</a>
                            </div>
                            <div class="col-md-9">
                                <div class="address">
                                    <h4>Delivery Address</h4>
                                    <h5>{{ $order->user->name }}</h5>
                                    <p>{{ $order->address }}</p>
                                    @if($order->landmark)
                                        <p>Landmark - {{ $order->landmark }}</p>
                                    @endif
                                    <p>City - {{ $order->city }}</p>
                                    <p>State - {{ $order->territory }}</p>
                                    <p>Pincode - {{ $order->pincode }}</p>
                                    <p>Phone Number - {{ $order->user->mobile }}</p>
                                    <p>Email Id - {{ $order->user->email }}</p>
                                    @if($order->promocode)
                                        <p> Promocode Used - {{ $order->promocode }}</p>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="review-sec float-right">
                                    <h4>More actions</h4>
                                    <a href="{{ route('user.invoices.download', $order->id) }}" class="download-invoice"
                                        onclick="downloadInvoice()"><i class="fa fa-download" aria-hidden="true"></i>
                                        Download</a>
                                    @if($order->shipment_id)
                                        <a href="{{ route('user.order.tracking', $order->shipment_id) }}"
                                            class="tracking-btn"><i class="fa fa-map-marker" aria-hidden="true"></i>
                                            Tracking</a>
                                    @endif
                                    <a href="javascript:void(0);" class="orderHelp">
                                        <i class="fa fa-question-circle" aria-hidden="true"></i> Need Help
                                    </a>
                                    <a href="javascript:void(0);" class="review">
                                        <i class="fa fa-star" aria-hidden="true"></i> Rate & Review
                                    </a>
                                    @if($order->return_status === null && $order->status == 'Processing')
                                        <a href="javascript:void(0);" class="cancelBtn" data-obj-id="{{ $order->id }}">
                                            <i class="fa fa-times" aria-hidden="true"></i>
                                            Cancel
                                        </a>
                                    @endif

                                     @if($order->return_status === null && $order->status === 'Delivered')
                                        @php
                                            $deliveredAt = \Carbon\Carbon::parse($order->delivery_date ?? $order->updated_at);
                                            $daysSinceDelivery = now()->diffInDays($deliveredAt);
                                            $withinReturnWindow = $daysSinceDelivery <= 7;
                                        @endphp
                                        @if($withinReturnWindow)
                                            <a href="javascript:void(0);" class="returnBtn"><i class="fa fa-refresh"
                                                    aria-hidden="true"></i>
                                                Return</a>
                                        @else
                                            <span class="return-expired-btn" title="Return window of 7 days has expired">
                                                <i class="fa fa-times-circle" aria-hidden="true"></i>
                                                Return Expired
                                                <small class="return-expired-note">(Valid only within 7 days of delivery)</small>
                                            </span>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="order-bordered mt-20 mb-20">
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
                                                                                    alt="{{ $detail->product->title }}">
                                                                            </div>
                                                                            <div class="content">
                                                                                <p class="title"><a href="/product/{{ $detail->product->slug_url }}">{{
                                        $detail->product->title }}</a></p>
                                                                                <p>
                                                                                    @php
                                                                                        $viewOrderSizeName = strtolower($detail->size->title ?? '');
                                                                                        $viewOrderSizeClass = ($viewOrderSizeName == '' || $viewOrderSizeName == 'null') ? 'size-null' : 'size-' . $viewOrderSizeName;
                                                                                    @endphp
                                                                                    <span class="{{ $viewOrderSizeClass }}">{{ $detail->size ? 'Size: ' . $detail->size->title : '' }}</span>{{-- {{
                                                                                    $detail->product->unit ? $detail->product->unit->unit :
                                                                                    'GM' }} --}}
                                                                                    <br>
                                                                                    {{ $detail->color ? 'Color: ' . $detail->color->title : '' }}
                                                                                </p>
                                                                                <p>Price : {{ $detail->mrp }}</p>
                                                                                <p>Qty : {{ $detail->quantity }}</p>
                                                                                @if($offers)
                                                                                    <p>

                                                                                        @if(!empty($exp_offers))
                                                                                            @foreach($exp_offers as $ofr)
                                                                                                @php
                                                                                                    $offer = \App\Model\MapMstOfferProduct::offer($ofr);
                                                                                                @endphp

                                                                                                + {{ $offer->product->title }} [{{ $offer->size->title }}{{-- ML
                                                                                                --}}] <br />
                                                                                            @endforeach
                                                                                        @endif
                                                                                    </p>
                                                                                @endif
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

                                                @if($order->status === 'delivered' && $order->delivery_date)
                                                    <div class="col-sm-12 mb-15">
                                                        <p class="mb-0"><strong>Delivered At </strong></p>
                                                        <p> {{ date('d-M-Y h:i A', strtotime($order->delivery_date)) }} </p>
                                                    </div>
                                                @endif
                                                @if($order->return_status !== null)
                                                    <div class="col-sm-12 mb-15">
                                                        <p class="mb-0"><strong>Return Status </strong></p>
                                                        <p> {{ $order->return_status }} </p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <table class="table table-striped table-bordered table-hover table-dark">
                                                <tbody>
                                                    <tr>
                                                        @php 
                                                            $itemSubtotal = 0;
                                                            foreach($order->details as $detail) {
                                                                $itemSubtotal += $detail->mrp * $detail->quantity;
                                                            }
                                                            // Shipping feature removed
                                                            // $shipping = $itemSubtotal < 1000 ? 60 : 0;
                                                        @endphp
                                                        <th>Subtotal</th>
                                                        <td><strong>&#8377; {{ $itemSubtotal }}</strong></td>
                                                    </tr>
                                                    @if($order->tax > 0)
                                                        <tr>
                                                            <td style="font-size: 13px; font-weight: normal; color: #555;">(Includes CGST)</td>
                                                            <td style="font-size: 13px; color: #555;">&#8377; {{ round($order->tax / 2, 2) }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td style="font-size: 13px; font-weight: normal; color: #555;">(Includes SGST)</td>
                                                            <td style="font-size: 13px; color: #555;">&#8377; {{ round($order->tax / 2, 2) }}</td>
                                                        </tr>
                                                    @endif

                                                    @if($order->discount)
                                                        <tr>
                                                            <td> - Discount </td>
                                                            <td> &#8377; {{ $order->discount }} </td>
                                                        </tr>
                                                    @endif
                                                    {{-- <tr>
                                                        <td> + Shipping Charges </td>
                                                        <td> &#8377; {{ $shipping }} </td>
                                                    </tr> --}}
                                                    <tr>
                                                        <th> <strong>Grand Total</strong> </th>
                                                        <td> <strong>&#8377; {{ round($order->total, 2) }}</strong> </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Review Model Start --}}

    <div class="modal fade" id="review">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Rating & Review</h4>
                    <button type="button" class="btn-close cclose" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <div class="login">
                        <div class="login_form_container">
                            <div class="account_login_form">
                                <form class="form" method="POST" action="/myaccount/review">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label style="padding-left: 0">Select Product <span
                                                    class="text-danger">*</span></label style="padding-left: 0">
                                            <select name="product_id" id="product_id" class="form__input form__input--2">
                                                <option value="">--Select Product--</option>
                                                @foreach($order->details as $order)
                                                    <option value="{{ $order->product->id }}">
                                                        {{ $order->product->title }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label style="padding-left: 0">Rating <span class="text-danger">*</span></label
                                                style="padding-left: 0">
                                            <div class="starability-grow">
                                                <input type="radio" id="growing-rate1" class="star" name="rating" checked
                                                    value="1" {{old('rating') == 1 ? 'checked' : '' }}>
                                                <label for="growing-rate1" title="Terrible">1
                                                    star</label>

                                                <input type="radio" id="growing-rate2" class="star" name="rating" value="2"
                                                    {{old('rating') == 2 ? 'checked' : '' }}>
                                                <label for="growing-rate2" title="Not good">2
                                                    stars</label>

                                                <input type="radio" id="growing-rate3" class="star" name="rating" value="3"
                                                    {{old('rating') == 3 ? 'checked' : '' }}>
                                                <label for="growing-rate3" title="Average">3
                                                    stars</label>

                                                <input type="radio" id="growing-rate4" class="star" name="rating" value="4"
                                                    {{old('rating') == 4 ? 'checked' : '' }}>
                                                <label for="growing-rate4" title="Very good">4
                                                    stars</label>

                                                <input type="radio" id="growing-rate5" class="star" name="rating" value="5"
                                                    {{old('rating') == 5 ? 'checked' : '' }}>
                                                <label for="growing-rate5" title="Amazing">5
                                                    stars</label>
                                            </div>
                                        </div>
                                        <div class="col-md-12 mt-3">
                                            <label style="padding-left: 0">Comment <span
                                                    class="text-danger">*</span></label>
                                            <textarea class="form__input form__input--textarea" name="comment" id="comment"
                                                cols="30" rows="4" placeholder="Write your comments here"
                                                required>{{ old('comment') }}</textarea>
                                        </div>
                                        <div class="col-md-12 mb-4 text-center">
                                            <div class="pull-right">
                                                <button type="submit" class="btn review-submit-btn">Submit</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Review Model End --}}
    <form id="formCancel" method="POST" action="{{ route('user.orders.cancel') }}">
        @csrf
        <input type="hidden" name="order_id" id="txtCancelOrder">

    </form>

@endsection
@section('extracss')
    <style>
        .table thead th,
        .table th,
        .table thead td,
        .table td {
            padding: 10px;
        }

        .order-details p {
            color: #000;
            padding: 0;
            box-shadow: none;
        }

        .order-details .personal-detail {
            box-shadow: 0px 2px 6px 2px #ccc;
            padding: 20px;
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
            width: 150px;
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

        .review-submit-btn {
            background-color: transparent !important;
            border: 2px solid #8a2be2 !important;
            color: #8a2be2 !important;
            padding: 8px 24px !important;
            font-size: 15px !important;
            font-weight: 600 !important;
            border-radius: 5px !important;
            transition: all 0.3s ease !important;
            cursor: pointer !important;
        }

        .review-submit-btn:hover {
            background-color: #8a2be2 !important;
            color: #ffffff !important;
        }
    </style>
@endsection
@section('extrajs')

    <style>
        .return-expired-btn {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            color: #999;
            font-size: 13px;
            cursor: not-allowed;
            opacity: 0.75;
        }

        .return-expired-btn i {
            color: #cc0000;
            font-size: 14px;
        }

        .return-expired-note {
            display: block;
            font-size: 11px;
            color: #aaa;
            margin-top: 2px;
        }
    </style>
    <script>
        $(document).ready(function () {

            $('.cancelBtn').click(function () {

                if (window.confirm('Are you sure want to cancel order ?')) {
                    $("#txtCancelOrder").val($(this).attr("data-obj-id"));
                    $("#formCancel").submit();
                    $(this).attr('disabled', 'disabled');
                    $(this).html(
                        '<i class="fa fa-spinner fa-pulse fa-fw"></i><span class="sr-only">Loading...</span>'
                    );
                }
            });

            $('.orderHelp').click(function () {
                $('#orderHelp').modal('show')
            });

            $('.review').click(function () {
                $('#review').modal('show')
            });

            $('.returnBtn').click(function () {
                $('#orderReturn').modal('show')
            });
        });

        function downloadInvoice() {
            $('.download-invoice').html(
                '<i class="fa fa-spinner fa-pulse fa-fw"></i><span class="sr-only">Loading...</span>');
            setTimeout(function () {
                $('.download-invoice').html('<i class="fa fa-download" aria-hidden="true"></i> Download');

            }, 2000);
        }



    </script>
@endsection