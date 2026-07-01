@extends('layouts.master') @section('title','Wishlists') @section('content')

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
                            <span>Wishlists</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

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
                                    <a href="{{ route('user.showOrder') }}">
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
                                    <a href="javascript:void(0)" class="active">
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
                    <div class="profile-wishlist">

                        @forelse ($wishlists as $key => $wishlist)
                        @php
                        $mapproduct = \App\Model\Wishlist::mapproduct($wishlist->product_id, $wishlist->color_id,
                        $wishlist->size_id);
                        @endphp
                        <div class="wishlist-area">
                            <div class="wishlist-details">
                                @if($key==0)
                                <div class="wishlist-item">
                                    <span class="wishlist-head">My wishlist:</span>
                                    <span class="wishlist-items">{{ count(auth()->user()->wishlists) }} item</span>
                                </div>
                                @endif
                                <div class="wishlist-all-pro">
                                    <div class="wishlist-pro">
                                        <div class="wishlist-pro-image">
                                            <a href="{{ route('product', $wishlist->product->slug_url) }}">
                                                <img src="{!! asset('storage/images/products/' . $wishlist->product->image_url) !!}"
                                                    class="img-fluid" alt=" {{ $wishlist->product->title }}"
                                                    width="120">
                                            </a>
                                        </div>
                                        <div class="pro-details">
                                            <h4>
                                                <a href="{{ route('product', $wishlist->product->slug_url) }}">
                                                    {{ $wishlist->product->title }}
                                                </a>
                                            </h4>

                                            <span class="wishlist-text">{{ $wishlist->product->category->name }}</span>

                                            @php
                                                $wishlistSizeName = strtolower($wishlist->size->title ?? '');
                                                $wishlistSizeClass = ($wishlistSizeName == '' || $wishlistSizeName == 'null') ? 'size-null' : 'size-' . $wishlistSizeName;
                                            @endphp
                                            @if(strtolower($wishlist->size->title ?? '') !== 'null')
                                            <span class="all-size {{ $wishlistSizeClass }}">Size: <span class="pro-size">
                                                    {{ $wishlist->size->title ?? '' }} {{ $wishlist->product->unit ?
                                                    $wishlist->product->unit->unit : '' }}</span></span>
                                            @endif
                                            <span class="all-size">Color: <span class="pro-size">
                                                    {{ $wishlist->color->title }} </span>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="qty-item">
                                        <a href="javascript:void(0)" class="add-wishlist wishlist-remove"
                                            data-w-id="{{ $wishlist->id }}" title="Remove from Wishlist">Remove From
                                            Wishlist</a>
                                        <a href="javascript:void(0)"
                                            onclick="addToCart('{{ $wishlist->product->id }}', {{ !empty($mapproduct) ? $mapproduct->stock : 0 }}, '{{ $wishlist->color->id }}', '{{ $wishlist->size->id }}')"
                                            class="add-wishlist" title="Add to Cart">Add to Cart</a>
                                    </div>
                                    <div class="all-pro-price">
                                        <span class="new-price"><i class="fa fa-inr"></i> {{ $mapproduct->mrp }}</span>
                                        <span class="old-price"><del><i class="fa fa-inr"></i> {{
                                                $mapproduct->starting_price }}</del></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <h3>No Wishlist Found</h3>
                        @endforelse
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