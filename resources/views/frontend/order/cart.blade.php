@extends('layouts.master')
@section('title', 'Cart')
@section('content')
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
                                <span>Cart</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- breadcrumb end -->
    <!-- Main Content Wrapper Start -->
    <div id="content" class="main-content-wrapper">
        <div class="page-content-inner">
            <div class="container">
                @if(Cart::isEmpty())
                    <div class="row">
                        <div class="col-md-12 mb--50 mt--50">
                            <div class="alert alert-warning text-center">
                                <h4>Your cart is empty... You can add some product from <a href="{{ route('search') }}">here</a>
                                </h4>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- cart start -->
                    <section class="cart-page section-tb-padding">
                        <div class="container">
                            <div class="row">
                                <div class="col-xl-9 col-xs-12 col-sm-12 col-md-12 col-lg-8">
                                    <div class="cart-area" style="border: none">
                                        <div class="cart-details">
                                            <div class="cart-item">
                                                <span class="cart-head">My cart:</span>
                                                <span class="c-items">{{ Cart::getContent()->count() }} items</span>
                                            </div>
                                        </div>
                                    </div>
                                    @foreach (Cart::getContent() as $item)
                                                        <div class="cart-area">
                                                            <div class="cart-details">
                                                                <div class="cart-all-pro">
                                                                    <div class="cart-pro">
                                                                        <div class="cart-pro-image">
                                                                            <a href="{{ route('product', $item->attributes->slug_url) }}">
                                                                                @if(!empty($item->attributes->color_image))
                                                                                    <img src="{!! asset('storage/images/multi-products/' . $item->attributes->color_image) !!}"
                                                                                        class="img-fluid" alt="{{ $item->name }}" width="100">
                                                                                @else
                                                                                    <img src="{!! asset('storage/images/products/' . $item->attributes->image_url) !!}"
                                                                                        class="img-fluid" alt="{{ $item->name }}" width="100">
                                                                                @endif
                                                                            </a>
                                                                        </div>
                                                                        <div class="pro-details">
                                                                            <h4>
                                                                                <a href="{{ route('product', $item->attributes->slug_url) }}">
                                                                                    {{ $item->name }}
                                                                                </a>
                                                                            </h4>
                                                                            <span class="cart-pro-price">
                                                                                <span class="size"> Volume:</span>
                                                                                {{ $item->attributes->size_name }}{{-- . ' ' .
                                                                                $item->attributes->unit --}}
                                                                            </span>
                                                                            <span class="cart-pro-price">
                                                                                <span class="size"> Color:</span>
                                                                                {{ $item->attributes->color_name }}
                                                                            </span>
                                                                            <span class="cart-pro-price">
                                                                                <span class="size"> Price:</span>
                                                                                ₹{{ $item->price }}
                                                                            </span>
                                                                            <span class="cart-pro-price">
                                                                                <span class="size"> Quantity:</span>
                                                                                {{ $item->quantity }}
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="qty-item">
                                                                        <div class="center">
                                                                            <div class="plus-minus">
                                                                                <span>
                                                                                    <a href="javascript:void(0)"
                                                                                        class="minus-btn text-black quantity-input"
                                                                                        data-index="{{ $item->id }}"
                                                                                        data-stock="{{ $item->attributes->stock }}">-</a>
                                                                                    <input type="number" id="qty_{{ $item->id }}" name="qty"
                                                                                        class="qty" value="{{ $item->quantity }}" min="1" disabled>
                                                                                    <a href="javascript:void(0)"
                                                                                        class="plus-btn text-black quantity-input"
                                                                                        data-index="{{ $item->id }}"
                                                                                        data-stock="{{ $item->attributes->stock }}">+</a>
                                                                                </span>
                                                                            </div>
                                                                            <a href="javascript:void(0)" data-remove-id="{{ $item->id }}"
                                                                                class="pro-remove btn-remove-item">
                                                                                <i class="icon-trash icons"></i> Remove
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                    <div class="all-pro-price">
                                                                        <span>
                                                                            ₹{{ $item->price }}
                                                                            <i class="fa fa-times"></i>
                                                                            {{ $item->quantity }} = ₹{{ $item->price
                                        * $item->quantity }}
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                    @endforeach
                                </div>
                                <div class="col-xl-3 col-xs-12 col-sm-12 col-md-12 col-lg-4">
                                    <div class="cart-total">
                                        <h5 class="mb--15">Cart totals</h5>
                                        <div class="shop-total">
                                            <span>Total</span>
                                            <span class="total-amount">₹{{ Cart::getTotal() }}</span>
                                        </div>

                                        <ul class="subtotal-title-area">
                                            <li class="mini-cart-btns">
                                                <div class="cart-btns">
                                                    <a href="{{ route('checkout') }}" class="btn btn-style2 theme-color">Proceed
                                                        To Checkout</a>
                                                    <a href="{{ route('search') }}" class="btn btn-style2">Continue Shopping</a>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <!-- cart end -->
                @endif
            </div>
        </div>
    </div>
    <!-- Main Content Wrapper Start -->
@endsection
@section('extracss')
    <style>
        .btn-style2 {
            width: 93%;
            margin: 10px;
        }

        .theme-color {
            background-color: #f5ab1d;
        }

        .theme-color:hover {
            background-color: #212529;
        }

        .cart-pro-image {
            width: 100px;
            height: 100px;
            min-width: 100px;
            min-height: 100px;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #fff;
            border-radius: 4px;
            border: 1px solid #eee;
            overflow: hidden;
        }

        .cart-pro-image img {
            max-width: 100%;
            max-height: 100%;
            width: auto;
            height: auto;
            object-fit: contain;
        }
    </style>
@endsection
@section('extrajs')
    <script>
        $(document).ready(function () {

            $('.quantity-input').click(function (e) {
                e.preventDefault();
                var itemid = $(this).attr('data-index');
                var quantity = parseInt($('#qty_' + itemid).val());
                var stock = parseInt($(this).attr('data-stock'));
                if (quantity > stock) {
                    swal('Out Of Stock', 'Product is Currently Out of Stock, Stay Tuned !', 'error');
                } else {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        }
                    });
                    $('.qty').attr('readonly', 'readonly');
                    $('.quantity-input').attr('disabled', 'disabled');
                    $('.quantity-input').html(
                        '<i class="fa fa-spinner fa-pulse fa-fw"></i><span class="sr-only">Loading...</span>'
                    );
                    $.ajax({
                        url: "{{ route('cart.update') }}",
                        type: 'POST',
                        data: {
                            quantity: quantity,
                            itemid: itemid,
                        },
                        success: function (result) {
                            var success = result.success;
                            if (success) {
                                $('.quantity-input').removeAttr('disabled', 'disabled');
                            } else {
                                $('.quantity-input').removeAttr('disabled', 'disabled');
                            }
                            location.reload(true);
                        }
                    });
                }
            });
        });

    </script>
@endsection