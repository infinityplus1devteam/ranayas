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
                                    @foreach (Cart::getContent()->sortBy('id') as $item)
                                                        <div class="cart-area">
                                                            <div class="cart-details">
                                                                <div class="cart-all-pro">
                                                                    <div class="cart-pro">
                                                                        <div class="cart-pro-image">
                                                                            <a href="{{ route('product', $item->attributes->slug_url) }}">
                                                                                @php
                                                                                    $variantCount = \App\Model\MapColorSize::where('product_id', $item->attributes->product_id)->count();
                                                                                    // dd($variantCount);
                                                                                @endphp
                                                                                @if($variantCount > 1 && $item->attributes->color_image)
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
                                                                            @php
                                                                                $cartSizeName = strtolower($item->attributes->size_name ?? '');
                                                                                $cartSizeClass = ($cartSizeName == '' || $cartSizeName == 'null') ? 'size-null' : 'size-' . $cartSizeName;
                                                                            @endphp
                                                                            <span class="cart-pro-price {{ $cartSizeClass }}">
                                                                                <span class="size"> Size:</span>
                                                                                {{ $item->attributes->size_name ?? '' }}{{-- . ' ' .
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
                                                                                    <a href="javascript:void(0)" class="text-black quantity-input"
                                                                                        data-index="{{ $item->id }}"
                                                                                        data-stock="{{ $item->attributes->stock }}"
                                                                                        onclick="updateCartItem(this, -1)">-</a>
                                                                                    <input type="number" id="qty_{{ $item->id }}" name="qty"
                                                                                        class="qty" value="{{ $item->quantity }}" min="1" disabled>
                                                                                    <a href="javascript:void(0)" class="text-black quantity-input"
                                                                                        data-index="{{ $item->id }}"
                                                                                        data-stock="{{ $item->attributes->stock }}"
                                                                                        onclick="updateCartItem(this, 1)">+</a>
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
        function updateCartItem(element, delta) {
            try {
                var btn = $(element);
                var itemid = btn.attr('data-index');
                var input = btn.closest('div').find('.qty');
                var stock = parseInt(btn.attr('data-stock'));

                var currentVal = parseInt(input.val());
                if (isNaN(currentVal)) {
                    currentVal = 1;
                }

                var newQty = currentVal + delta;

                if (newQty < 1) {
                    return;
                }

                if (newQty > stock) {
                    if (typeof swal !== 'undefined') {
                        swal('Out Of Stock', 'Product is Currently Out of Stock, Stay Tuned !', 'error');
                    } else {
                        alert('Product is Currently Out of Stock, Stay Tuned !');
                    }

                    // Revert to original input value so it doesn't look like it changed
                    input.val(currentVal);
                    return;
                }

                // Update input visually immediately
                input.val(newQty);

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    }
                });

                $('.qty').attr('readonly', 'readonly');
                $('.quantity-input').attr('disabled', 'disabled');

                $.ajax({
                    url: "{{ route('cart.update') }}",
                    type: 'POST',
                    data: {
                        quantity: newQty,
                        itemid: itemid,
                    },
                    success: function (result) {
                        window.location.reload(true);
                    },
                    error: function () {
                        window.location.reload(true);
                    }
                });
            } catch (e) {
                console.error("Cart update error: ", e);
                alert("Error updating cart: " + e.message);
            }
        }
    </script>
@endsection