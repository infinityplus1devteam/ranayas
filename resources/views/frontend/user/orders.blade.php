@extends('layouts.master') @section('title','Orders') @section('content')

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
                            <span>Orders</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
{{-- Model --}}

<div class="modal fade" id="orderReturn">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Return Order</h4>
                <button type="button" class="close cclose" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <form method="POST" role="form" class="form" id="returnForm" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="reason">Select Reason <span class="text-danger">*</span></label>
                                    <select name="reason" id="reason" class="form-control" required>
                                        <option value="">--Select Reason--</option>
                                        <option value="Within 7 Days" {{ old('reason')=='Within 7 Days' ? 'selected'
                                            : '' }}>Within 7 Days
                                        </option>
                                        <option value="Wrong Products" {{ old('reason')=='Wrong Products' ? 'selected'
                                            : '' }}>Wrong Products
                                        </option>
                                        <option value="Faulty Products" {{ old('reason')=='Faulty Products' ? 'selected'
                                            : '' }}>Faulty Products
                                        </option>
                                        <option value="Quality Products" {{ old('reason')=='Quality Products'
                                            ? 'selected' : '' }}>Quality Products
                                        </option>
                                        <option value="other" {{ old('reason')=='other' ? 'selected' : '' }}>Other
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
                        <button type="submit" class="btn btn-primary button_update">
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
                <button type="button" class="close cclose" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <form method="POST" role="form" class="form" id="helpForm" action="">
                    @csrf
                    <div class="modal-body">
                        <div class="row">

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="description">Write your query <span class="text-danger">*</span></label>
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
                        <button type="submit" class="btn btn-primary button_update">
                            <i class="fa fa-plus"></i> Submit
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

{{-- Help Model End --}}


<!-- order history start -->
<section class="order-histry-area section-tb-padding">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="order-history">
                    <div class="profile">
                        <div class="order-pro">
                            <div class="pro-img">
                                <a href="javascript:void(0)">
                                    <img src="{!! asset('assets/image/user-dark.png') !!}" alt="img" class="img-fluid"
                                        width="90">
                                </a>
                            </div>
                            <div class="order-name">
                                <h4>{{ auth()->user()->name }}</h4>
                                <span>Joined on {{ auth()->user()->created_at->format('F, d Y') }}</span>
                            </div>
                        </div>
                        <div class="order-his-page">
                            <ul class="profile-ul">
                                <li class="profile-li">
                                    <a href="{{ route('user.dashboard') }}">
                                        Dashboard
                                    </a>
                                </li>
                                <li class="profile-li">
                                    <a href="javascript:void(0)" class="active">
                                        <span>Orders</span>
                                        <span class="pro-count">{{ count(auth()->user()->orders) }}</span>
                                    </a>
                                </li>
                                <li class="profile-li">
                                    <a href="{{ route('user.profile') }}">
                                        Profile
                                    </a>
                                </li>
                                <li class="profile-li">
                                    <a href="{{ route('user.addresses') }}">
                                        Address
                                    </a>
                                </li>
                                <li class="profile-li">
                                    <a href="{{ route('user.wishlists') }}">
                                        <span>Wishlist</span>
                                        <span class="pro-count">{{ count(auth()->user()->wishlists) }}</span>
                                    </a>
                                </li>
                                <li class="profile-li">
                                    <a href="{{ route('user.change-password') }}">
                                        <span>Change Password</span>
                                    </a>
                                </li>
                                <li class="profile-li">
                                    <a href="javascript:void(0)"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                        title="Logout">
                                        <span>Logout</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="order-info">
                        <div id="content" class="main-content-wrapper">
                            <div class="page-content-inner">
                                <div class="col">
                                    @forelse($orders as $key => $order)
                                    <div class="order-bordered {{ $key != 0 ? 'mt-20' : '' }} mb-20">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <a href="{{ route('user.order', $order->id) }}" class="order-btn">Order Detail</a>
                                                <a href="{{ route('user.invoices.download', $order->id) }}"
                                                    class="download-btn float-right">
                                                    <i class="fa fa-download" aria-hidden="true"></i> Download
                                                    Invoice
                                                </a>
                                            </div>
                                            @php $statusBoolean = true @endphp

                                            @foreach($order->details as $detail)
                                            @php
                                            $image = \App\Model\TxnImage::image($detail->product_id,
                                            $detail->size_id);
                                            @endphp
                                            <div class="col-md-12 mt--10">
                                                <div class="order_sec">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="pro_sec">
                                                                <div class="img">
                                                                    @if(!empty($image))
                                                                    <img src="{!! asset('/storage/images/multi-products/' . $image->image_url) !!}"
                                                                        alt="{{ $detail->product->title }}" />
                                                                    @else
                                                                    <img src="{!! asset('/storage/images/products/' . $detail->product->image_url) !!}"
                                                                        alt="{{ $detail->product->title }}" />
                                                                    @endif

                                                                </div>
                                                                <div class="content">
                                                                    <p class="title">
                                                                        {{ $detail->product->title }}

                                                                    </p>
                                                                    <p>
                                                                        {{ $detail->size ? 'Volume: ' .
                                                                        $detail->size->title : '' }}{{--
                                                                        {{ $detail->product->unit ?
                                                                        $detail->product->unit->unit :
                                                                        'GM' }} --}} <br>
                                                                        {{ $detail->color ? 'Color: ' .
                                                                        $detail->color->title :'' }}
                                                                    </p>
                                                                    <p>
                                                                        Price :
                                                                        {{ $detail->mrp }}
                                                                    </p>
                                                                    <p>
                                                                        Qty :
                                                                        {{ $detail->quantity }}
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <p class="price">
                                                                &#8377; {{ $detail->mrp * $detail->quantity }}
                                                            </p>
                                                        </div>
                                                        <div class="col-md-4">
                                                            @if($order->delivery_date)
                                                            <p class="delivery">
                                                                Delivered by
                                                                {{ date('M, d', strtotime($order->delivery_date
                                                                )) }}
                                                            </p>
                                                            @endif
                                                            @if($statusBoolean)
                                                            @php $statusBoolean = false @endphp
                                                            <p class="padding10">
                                                                Order Status: <strong>
                                                                    {{ $order->status }}
                                                                </strong>
                                                            </p>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                            <div class="col-md-12">
                                                <div class="review-sec mt-20">
                                                    <div class="row">
                                                        <div class="col">
                                                            <p class="date" style="line-height: 20px;">
                                                                Order On <br />
                                                                <strong>{{ date('d M \'y h:i A',
                                                                    strtotime($order->created_at))
                                                                    }}</strong>
                                                            </p>
                                                        </div>
                                                        @if($order->return_status === null &&
                                                        $order->status === 'Delivered' &&
                                                        $order->status !== 'Cancelled')
                                                        <div class="col">
                                                            <a href="javascript:void(0)" class="return-btn"
                                                                data-obj-id="{{ $order->id }}">
                                                                <i class="fa fa-refresh" aria-hidden="true"></i>
                                                                Return
                                                            </a>
                                                        </div>
                                                        @endif @if($order->return_status ===
                                                        null && $order->status != 'Delivered' &&
                                                        $order->status != 'Cancelled') @if($order->status !=
                                                        'Shipped')
                                                        <div class="col">
                                                            <a href="javascript:void(0);" class="cancelBtn"
                                                                data-obj-id="{{ $order->id }}">
                                                                <i class="fa fa-times" aria-hidden="true"></i>
                                                                Cancel
                                                            </a>
                                                        </div>
                                                        @else
                                                        <div class="col">
                                                            <a href="javascript:void(0);" class="cancelBtn"
                                                                data-obj-id="{{ $order->id }}">
                                                                <i class="fa fa-times" aria-hidden="true"></i>
                                                                Cancel
                                                            </a>
                                                            <p>
                                                                <strong class="text-danger">
                                                                    Note : Extra Shipping Charges
                                                                    will be charged.
                                                                </strong>
                                                            </p>
                                                        </div>
                                                        @endif @endif
                                                        <div class="col">
                                                            <a href="javascript:void(0)" class="need-help-btn"
                                                                data-obj-id="{{ $order->id }}">
                                                                <i class="fa fa-question-circle" aria-hidden="true"></i>
                                                                Need Help
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @empty There are no orders yet. @endforelse
                                </div>

                                <div class="col">
                                    {{ $orders->links('vendor.pagination.default') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- order history end -->

<form id="formCancel" method="POST" action="{{ route('user.orders.cancel') }}">
    @csrf
    <input type="hidden" name="order_id" id="txtCancelOrder">
</form>

@endsection
@section('extracss')
<style>
    .cancelBtn {
        float: right;
    }
</style>
@endsection
@section('extrajs')

<script>
    $(document).ready(function () {
        $('.return-btn').click(function () {
            var id = $(this).attr('data-obj-id');
            var action = '/myaccount/order/return/' + id;
            $('#returnForm').attr('action', action);
            $('#orderReturn').modal('show');
        });

        $('.need-help-btn').click(function () {
            var id = $(this).attr('data-obj-id');
            var action = '/myaccount/order/help/' + id;
            $('#helpForm').attr('action', action);
            $('#orderHelp').modal('show');
        });

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
    });

</script>

@endsection