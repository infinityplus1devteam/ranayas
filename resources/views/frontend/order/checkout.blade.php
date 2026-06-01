@extends('layouts.master')
@section('title', 'Checkout')
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
                                <a href="{{ route('cart') }}">Cart</a>
                            </li>
                            <li class="breadcrumb-url-li">
                                <span>Checkout</span>
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
                <!-- <div class="row pt--80 pt-md--60 pt-sm--40"> -->
                <div class="row justify-content-md-center">
                    <!-- Checkout Area Start -->

                    @if (auth('user')->check())

                        <div class="col-md-12">
                            <form action="{{ route('order.checkout') }}" method="post" id="formCheckout">
                                @csrf
                                <div class="row">
                                    <div class="col">
                                        <div class="checkout-area">
                                            <div class="billing-area">
                                                @if (count($addresses))
                                                    <div class="check-pro">
                                                        <h2>Select Delivery Address</h2>
                                                    </div>
                                                @endif
                                                <div class="row address_div">
                                                    @if (count($addresses))
                                                        <div class="col-md-12">
                                                            <div class="checkout-form form-row mb--5 mb-xs--10">
                                                                <div class="form__group col-md-12 mb-sm--30 mb-xs--10">
                                                                    <label for="name"
                                                                        style="padding-left: 0;font-size: 18px"
                                                                        class="form__label form__label--2">Please enter
                                                                        PIN code to check delivery
                                                                        <span class="required">*</span></label>
                                                                    <div class="input-group">
                                                                        <input type="text" placeholder="Enter pincode"
                                                                            class="pincode-code form-control form__input form__input--2"
                                                                            value="{{ Session::get('pincode') }}"
                                                                            name="pincode" id="pincode" required>
                                                                        <div class="input-group-append">
                                                                            <button
                                                                                class="btn check-availibility pincode_button"
                                                                                type="submit"><i class="fa fa-search"
                                                                                    aria-hidden="true"></i></button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form__group col-md-12 pincd">
                                                                    <label for="pincode"
                                                                        class="error pincode_error"></label>
                                                                    <p class="text-success pincode_success"></p>
                                                                    <p class="text-success estimated_date"></p>
                                                                    <!-- <p class="text-danger pincode_error"></p> -->
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    @foreach ($addresses as $add)
                                                        <div class="col-md-6">
                                                            <label class="radio-cont">
                                                                <div class="card">
                                                                    <div class="card-body">
                                                                        <h4 class="card-title pl--35">

                                                                            {{ $add->name }}

                                                                            <input type="radio" checked="checked"
                                                                                name="choose_address"
                                                                                value="{{ $add->id }}"
                                                                                data-pincode="{{ $add->pincode }}">
                                                                            <span class="checkmark"></span>

                                                                            <b><span class="badge rounded-pill bg-primary"
                                                                                    style="font-size: 12px;float:right;margin-top:2px">{{ $add->type_of_address ? 'Work' : 'Home' }}</span></b>
                                                                        </h4>
                                                                        <p class="card-text">
                                                                            {{ $add->address }},
                                                                            {{ $add->landmark ? $add->landmark . ',' : '' }}
                                                                            {{ $add->city }},
                                                                            {{ $add->territory }},
                                                                            {{ $add->country }},
                                                                            {{ $add->pincode }},
                                                                        </p>
                                                                        @if ($add->mobile)
                                                                            <p class="text-info">
                                                                                {{ $add->mobile }}
                                                                            </p>
                                                                        @else
                                                                            <p class="text-danger">
                                                                                Update Mobile Number
                                                                            </p>
                                                                        @endif

                                                                    </div>
                                                                    <div class="card-footer">
                                                                        <a href="javascript:void(0)"
                                                                            class="card-link float-left remove-address"
                                                                            data-obj-id="{{ $add->id }}"><i
                                                                                class="fa fa-trash text-danger "></i>
                                                                            Remove</a>
                                                                        <a href="javascript:void(0)"
                                                                            data-obj-id="{{ $add->id }}"
                                                                            class="card-link pull-right editAddress"><i
                                                                                class="fa fa-pencil text-primary"></i>
                                                                            Edit</a>
                                                                    </div>
                                                                </div>
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                    @if (count($addresses))
                                                        <div class="col-md-6 add_address">
                                                            <label class="radio-cont">
                                                                <div class="card">
                                                                    <div
                                                                        class="card-body text-center delivery-address-height">
                                                                        <i class="fa fa-plus-circle fa-3x text-black"></i>
                                                                        <p class="text-black"> Add new delivery address</p>
                                                                    </div>
                                                                </div>
                                                            </label>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            @if (count($addresses))

                                                <div class="order-area">
                                                    <div class="check-pro">
                                                        <h2>Your order</h2>
                                                        <ul class="check-ul">
                                                            @php
                                                                $isCodAvailable = true;
                                                            @endphp
                                                            @foreach (Cart::getContent() as $item)
                                                                @php
                                                                    $isCodAvailable =
                                                                        $item->attributes->isCodAvailable &&
                                                                        $isCodAvailable;
                                                                @endphp
                                                                <li>
                                                                    <div class="check-pro-img">
                                                                        <a
                                                                            href="{{ route('product', $item->attributes->slug_url) }}">
                                                                            @if (!empty($item->attributes->color_image))
                                                                                <img src="{!! asset('storage/images/multi-products/' . $item->attributes->color_image) !!}"
                                                                                    class="img-fluid"
                                                                                    alt="{{ $item->name }}">
                                                                            @else
                                                                                <img src="{!! asset('storage/images/products/' . $item->attributes->image_url) !!}"
                                                                                    class="img-fluid"
                                                                                    alt="{{ $item->name }}">
                                                                            @endif
                                                                        </a>
                                                                    </div>
                                                                    <div class="check-content">
                                                                        <a
                                                                            href="{{ route('product', $item->attributes->slug_url) }}">
                                                                            {{ $item->name }}
                                                                        </a>
                                                                        <span class="check-code-blod">
                                                                            Volume:
                                                                            <span>{{ $item->attributes->size_name }}{{-- . ' ' . $item->attributes->unit --}}</span>
                                                                        </span>
                                                                        <span class="check-code-blod">
                                                                            Color:
                                                                            <span>{{ $item->attributes->color_name }}</span>
                                                                        </span>
                                                                        <span class="check-price">
                                                                            ₹{{ $item->price }}
                                                                            <i class="fa fa-times"></i>
                                                                            {{ $item->quantity }}
                                                                        </span>
                                                                        <span class="pull-right mt-10">
                                                                            ₹{{ $item->price * $item->quantity }}
                                                                        </span>
                                                                    </div>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                    <ul class="order-history">
                                                        <li class="order-details">
                                                            <span>Total:</span>
                                                            <span>₹{{ Cart::getTotal() }}</span>
                                                        </li>
                                                    </ul>
                                                    <div class="checkout-payment">

                                                        <div class="promocode-checkout">
                                                            <div class="faq-tab-wrapper-three">
                                                                <div class="faq-panel">
                                                                    <div class="panel-group theme-accordion"
                                                                        id="accordion">

                                                                        <div class="panel">
                                                                            <div class="panel-heading" id="heading2">
                                                                                <h6 class="panel-title">
                                                                                    <a data-bs-toggle="collapse"
                                                                                        href="#collapse2" role="button"
                                                                                        aria-expanded="false"
                                                                                        aria-controls="collapse2">
                                                                                        Apply Coupon</a>
                                                                                </h6>
                                                                            </div>
                                                                            <div id="collapse2"
                                                                                class="panel-collapse collapse"
                                                                                aria-labelledby="heading2"
                                                                                data-parent="#accordion" style="">
                                                                                <div class="panel-body">
                                                                                    <div class="check">
                                                                                        <div class="input-group">
                                                                                            <input type="text"
                                                                                                name="discountcode"
                                                                                                id="discountcode"
                                                                                                class="single-input-wrapper check-availibility discountcode"
                                                                                                placeholder="Enter Coupon"
                                                                                                style="border-right: none;margin-bottom: 0;">
                                                                                            <div
                                                                                                class="input-group-append">
                                                                                                <button type="button"
                                                                                                    class="verify_promo check-availibility theme-button-three  mr-0">
                                                                                                    Apply
                                                                                                </button>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group text-center">
                                                                    <div class="promo_success text-success mt-3"></div>
                                                                    <div class="promo_error text-danger mt-3"></div>
                                                                </div>
                                                                
                                                                @if(isset($coupons) && $coupons->count() > 0)
                                                                <div class="mt-3">
                                                                    <p class="font-weight-bold mb-2">Available Coupons:</p>
                                                                    <div class="list-group">
                                                                        @foreach($coupons as $coupon)
                                                                            <a href="javascript:void(0)" class="list-group-item list-group-item-action coupon-item" data-code="{{ $coupon->code }}" style="padding: 10px;">
                                                                                <div class="d-flex w-100 justify-content-between align-items-center">
                                                                                    <h6 class="mb-0 text-primary"><i class="fa fa-tag"></i> {{ $coupon->code }}</h6>
                                                                                    <small class="text-success font-weight-bold">{{ $coupon->type == 'percentage' ? $coupon->value . '%' : '₹' . $coupon->value }} OFF</small>
                                                                                </div>
                                                                            </a>
                                                                        @endforeach
                                                                    </div>
                                                                </div>
                                                                @endif

                                                            </div>
                                                        </div>

                                                        @if ($isCodAvailable)
                                                            <div class="payment-group pymt-btn mb--10">
                                                                <div class="payment-radio">
                                                                    <label for="cod" class="cb-container">
                                                                        CASH ON DELIVERY
                                                                        <input type="radio" value="cod"
                                                                            name="payment_mode" id="cod"
                                                                            {{ $isCodAvailable ? 'checked' : '' }}>
                                                                        <span class="rb-checkmark"></span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        @endif

                                                        <div class="payment-group pymt-btn mb--10">
                                                            <div class="payment-radio">
                                                                <label for="paytm" class="cb-container">
                                                                    DEBIT/CREDIT/NETBANKING/PAYTM
                                                                    <input type="radio" value="paytm"
                                                                        name="payment_mode" id="paytm"
                                                                        {{ !$isCodAvailable ? 'checked' : '' }}>
                                                                    <span class="rb-checkmark"></span>
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <div class="checkout-btn">
                                                            <button type="submit" class="btn-style1 order_place">Place
                                                                order</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        @if (!count($addresses))
                            <div class="col-md-6">
                                <div class="new-delivery-address">
                                    <div class="form-row">
                                        <div class="form__group col-md-12 title">
                                            <h4>Add New Delivery Address</h4>
                                        </div>
                                    </div>
                                    <div class="checkout-form form-row ">
                                        <div class="form__group col-md-12 mb-sm--30 mb-xs--10">
                                            <label for="name" style="padding-left: 0;font-size: 18px"
                                                class="form__label form__label--2">Please enter
                                                PIN code to check delivery
                                                <span class="required">*</span></label>
                                            <div class="input-group">
                                                <input type="text" placeholder="Enter pincode"
                                                    class="pincode-code form-control form__input form__input--2"
                                                    value="{{ Session::get('pincode') }}" name="pincode_add"
                                                    id="pincode_add" required>
                                                <div class="input-group-append">
                                                    <button class="btn check-availibility pincode_button"
                                                        type="submit"><i class="fa fa-search"
                                                            aria-hidden="true"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form__group col-md-12 pincd">
                                            <label for="pincode" class="error pincode_error"></label>
                                            <p class="text-success pincode_success"></p>
                                            <p class="text-success estimated_date"></p>
                                            <!-- <p class="text-danger pincode_error"></p> -->
                                        </div>
                                    </div>
                                    <form action="{{ route('user.addresses.add') }}" method="post" id="formAddAddress">
                                        @csrf
                                        <div class="form">
                                            <input type="hidden" id="txtPincode" name="pincode">

                                            <div class="form-row mb--5">
                                                <div class="form__group col-md-12">
                                                    <label for="name" class="form__label form__label--2">Name
                                                        <span class="required">*</span></label>
                                                    <input type="text" name="name" id="name"
                                                        class="form__input form__input--2" required placeholder="Name"
                                                        value="{{ old('name') }}">
                                                </div>
                                            </div>

                                            <div class="form-row mb--5">
                                                <div class="form__group col-12">
                                                    <label for="mobile" class="form__label form__label--2">Mobile <span
                                                            class="required">*</span></label>
                                                    <input type="text" name="mobile" id="mobile"
                                                        class="form__input form__input--2" placeholder="Mobile Number"
                                                        value="{{ old('mobile') }}" required>
                                                </div>
                                            </div>

                                            <div class="form-row mb--5">
                                                <div class="form__group col-12">
                                                    <label for="email" class="form__label form__label--2">Email Address
                                                        <span class="required">*</span></label>
                                                    <input type="email" name="email" id="email"
                                                        class="form__input form__input--2" value=""
                                                        placeholder="Email Address" value="{{ old('email') }}" required>
                                                </div>
                                            </div>

                                            <div class="form-row mb--5">
                                                <div class="form__group col-12">
                                                    <label for="country" class="form__label form__label--2">Country
                                                        <span class="required">*</span></label>
                                                    <select id="country" name="country"
                                                        class="form__input form__input--2 nice-select" required>
                                                        <option value="">Select a country…</option>
                                                        <option value="India" selected>India</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-row mb--5">
                                                <div class="form__group col-12">
                                                    <label for="address" class="form__label form__label--2">Street
                                                        Address <span class="required">*</span></label>

                                                    <input type="text" name="address" id="address"
                                                        class="form__input form__input--2 mb--5"
                                                        placeholder="House number and street name" required
                                                        value="{{ old('address') }}">
                                                </div>
                                            </div>

                                            <div class="form-row mb--5">
                                                <div class="form__group col-12">
                                                    <label for="landmark"
                                                        class="form__label form__label--2">Landmark</label>
                                                    <input type="text" name="landmark" id="landmark"
                                                        class="form__input form__input--2" placeholder="Landmark"
                                                        value="{{ old('landmark') }}">
                                                </div>
                                            </div>

                                            <div class="form-row mb--5">
                                                <div class="form__group col-12">
                                                    <label for="city" class="form__label form__label--2">Town / City
                                                        <span class="required">*</span></label>
                                                    <input type="text" name="city" id="city"
                                                        class="form__input form__input--2" required
                                                        placeholder="Town/City" value="{{ old('city') }}">
                                                </div>
                                            </div>

                                            <div class="form-row mb--5">
                                                <div class="form__group col-12">
                                                    <label for="territory" class="form__label form__label--2">State
                                                        <span class="required">*</span></label>
                                                    <input type="text" name="territory" id="territory"
                                                        class="form__input form__input--2" required placeholder="State"
                                                        value="{{ old('territory') }}">
                                                </div>
                                            </div>


                                            <div class="form-row mb--5">
                                                <div class="form__group type-of-address col-12">
                                                    <label for="type_of_address" class="form__label form__label--2">Choose
                                                        Type of
                                                        Address
                                                        <span class="required">*</span></label>
                                                    <input id="home" class="toggle toggle-left"
                                                        name="type_of_address" type="radio" value="0"
                                                        {{ old('type_of_address') == 0 ? 'checked' : 'checked' }}>
                                                    <label for="home" class="btnn1">Home</label>
                                                    <input id="corporate" class="toggle toggle-right"
                                                        name="type_of_address" type="radio" value="1"
                                                        {{ old('type_of_address') == 1 ? 'checked' : '' }}>
                                                    <label for="corporate" class="btnn1">Office/Commercial</label>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="form-row">
                                            <div class="col-md-12 text-center">
                                                <button type="submit"
                                                    class="btn btn-block btn-secondary btnSubmit text-black">SAVE
                                                    DELIVERY
                                                    ADDRESS</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endif
                    @else
                        <!-- Checkout Area End -->
                        <div class="Checkout_section mt-32">
                            <div class="container">
                                <div class="checkout_form">

                                    <div class="row">
                                        <div class="col-md-6 sm-mb-50">
                                            <div class="signUp-page signUp-minimal">
                                                <div class="signin-form-wrapper">
                                                    <div class="title-area text-center">
                                                        <h3>Login</h3>
                                                    </div> <!-- /.title-area -->
                                                    <ul class="social-icon-wrapper row">
                                                        <li class="col-12">
                                                            <a href="{{ route('user.login.otp') }}" class="otp"><i class="fa fa-mobile" aria-hidden="true"></i> Login With OTP</a>
                                                        </li>
                                                        <li class="col-12">
                                                            <a href="{{ route('user.auth.socialite', 'google') }}" class="gmail"><i class="fa fa-google" aria-hidden="true"></i> Google</a>
                                                        </li>
                                                    </ul>
                                                    <p class="or-text mt-4 mb-4"><span>or</span></p>

                                                    <form id="login-form" action="{{ route('user.login') }}"
                                                        method="POST" autocomplete="off" class="login needs-validation">
                                                        @csrf
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="input-group">
                                                                    <input type="text" name="email" value=""
                                                                        required>
                                                                    <label>Email *</label>
                                                                </div> <!-- /.input-group -->
                                                            </div> <!-- /.col- -->
                                                            <div class="col-12">
                                                                <div class="input-group">
                                                                    <input type="password" name="password" required>
                                                                    <label>Password *</label>
                                                                </div> <!-- /.input-group -->
                                                            </div> <!-- /.col- -->
                                                        </div> <!-- /.row -->
                                                        <div
                                                            class="agreement-checkbox d-flex justify-content-between align-items-center">
                                                            <div>
                                                                <input type="checkbox" name="remember" checked
                                                                    id="remember">
                                                                <label for="remember">Remember Me</label>
                                                            </div>
                                                            <a href="{{ route('user.password.request') }}">Forget
                                                                Password?</a>
                                                        </div>
                                                        <button type="submit"
                                                            class="line-button-one button-rose button_update_login">
                                                            Login
                                                        </button>
                                                    </form>
                                                </div> <!-- /.sign-up-form-wrapper -->
                                            </div> <!-- /.signUp-page -->
                                        </div>

                                        <div class="col-md-6">
                                            <div class="login-or">
                                                <h3>OR</h3>
                                            </div>
                                            <div class="signUp-page signUp-minimal">
                                                <div class="signin-form-wrapper">
                                                    <div class="title-area text-center">
                                                        <h3>Register</h3>
                                                    </div> <!-- /.title-area -->
                                                    <form action="{{ route('user.register') }}" method="POST"
                                                        autocomplete="off" class="register needs-validation"
                                                        id="formRegister">
                                                        @csrf
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="input-group">
                                                                    <input type="text" name="name"
                                                                        value="{{ old('name') }}" required>
                                                                    <label>Name *</label>
                                                                </div> <!-- /.input-group -->
                                                            </div> <!-- /.col- -->
                                                            <div class="col-12">
                                                                <div class="input-group">
                                                                    <input type="text" name="mobile"
                                                                        value="{{ old('mobile') }}" required>
                                                                    <label>Mobile Number *</label>
                                                                </div> <!-- /.input-group -->
                                                            </div> <!-- /.col- -->
                                                            <div class="col-12">
                                                                <div class="input-group">
                                                                    <input type="text" name="email"
                                                                        value="{{ old('email') }}" required>
                                                                    <label>Email *</label>
                                                                </div> <!-- /.input-group -->
                                                            </div> <!-- /.col- -->
                                                            <div class="col-12">
                                                                <div class="input-group">
                                                                    <input type="password" name="password" required>
                                                                    <label>Password *</label>
                                                                </div> <!-- /.input-group -->
                                                            </div> <!-- /.col- -->
                                                        </div> <!-- /.row -->
                                                        <button type="submit"
                                                            class="line-button-one button-rose button_update_register">
                                                            Register
                                                        </button>
                                                    </form>

                                                </div> <!-- /.sign-up-form-wrapper -->
                                            </div> <!-- /.signUp-page -->
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- Main Content Wrapper Start -->

    {{-- add new addresss start --}}
    <div class="modal fade" id="new-address">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title">ADD NEW ADDRESS</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Modal body -->
                <form action="{{ route('user.addresses.add') }}" method="post" id="formAddAddress">
                    @csrf
                    <div class="modal-body" style="height: 400px; overflow: auto">
                        <div class="form">

                            <div class="form-row mb--5">
                                <div class="form__group col-md-12">
                                    <label for="name" class="form__label form__label--2">Name
                                        <span class="required">*</span></label>
                                    <input type="text" name="name" id="name"
                                        class="form__input form__input--2" required placeholder="Name" value="">
                                </div>
                            </div>

                            <div class="form-row mb--5">
                                <div class="form__group col-12">
                                    <label for="mobile" class="form__label form__label--2">Mobile <span
                                            class="required">*</span></label>
                                    <input type="text" name="mobile" id="mobile"
                                        class="form__input form__input--2" placeholder="Mobile Number" required>
                                </div>
                            </div>

                            <div class="form-row mb--5">
                                <div class="form__group col-12">
                                    <label for="email" class="form__label form__label--2">Email Address
                                        <span class="required">*</span></label>
                                    <input type="email" name="email" id="email"
                                        class="form__input form__input--2" value="" placeholder="Email Address"
                                        required>
                                </div>
                            </div>

                            <div class="form-row mb--5">
                                <div class="form__group col-12">
                                    <label for="country" class="form__label form__label--2">Country
                                        <span class="required">*</span></label>
                                    <select id="country" name="country" class="form__input form__input--2 nice-select"
                                        required>
                                        <option value="">Select a country…</option>
                                        <option value="India" selected>India</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row mb--5">
                                <div class="form__group col-12">
                                    <label for="pincode_modal" class="form__label form__label--2">Pincode
                                        <span class="required">*</span></label>
                                    <input type="text" name="pincode" id="pincode_modal"
                                        class="form__input form__input--2" placeholder="Pincode"
                                        required>
                                </div>
                            </div>
                            <div class="form-row mb--5">
                                <div class="form__group col-12">
                                    <label for="address" class="form__label form__label--2">Street Address <span
                                            class="required">*</span></label>

                                    <input type="text" name="address" id="address"
                                        class="form__input form__input--2 mb--5"
                                        placeholder="House number and street name" required value="">
                                </div>
                            </div>

                            <div class="form-row mb--5">
                                <div class="form__group col-12">
                                    <label for="landmark" class="form__label form__label--2">Landmark</label>
                                    <input type="text" name="landmark" id="landmark"
                                        class="form__input form__input--2" placeholder="Landmark" value="">
                                </div>
                            </div>

                            <div class="form-row mb--5">
                                <div class="form__group col-12">
                                    <label for="city" class="form__label form__label--2">Town / City
                                        <span class="required">*</span></label>
                                    <input type="text" name="city" id="city"
                                        class="form__input form__input--2" required placeholder="Town/City"
                                        value="">
                                </div>
                            </div>

                            <div class="form-row mb--5">
                                <div class="form__group col-12">
                                    <label for="territory" class="form__label form__label--2">State
                                        <span class="required">*</span></label>
                                    <input type="text" name="territory" id="territory"
                                        class="form__input form__input--2" required placeholder="State" value="">
                                </div>
                            </div>


                            <div class="form-row mb--5">
                                <div class="form__group type-of-address col-12">
                                    <label for="type_of_address" class="form__label form__label--2">Choose Type of Address
                                        <span class="required">*</span></label>
                                    <input id="home-new" class="toggle toggle-left" name="type_of_address"
                                        type="radio" value="0" checked>
                                    <label for="home-new" class="btnn1">Home</label>
                                    <input id="corporate-new" class="toggle toggle-right" name="type_of_address"
                                        type="radio" value="1">
                                    <label for="corporate-new" class="btnn1">Office/Commercial</label>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="modal-footer">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn btn-secondary btnSubmit">SAVE</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- add new addresss end --}}

    {{-- edit addresss start --}}
    <div class="modal fade" id="edit-address">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title">EDIT ADDRESS</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <!-- Modal body -->
                <form action="{{ route('user.addresses.fupdate') }}" method="post" id="formUpdateAddress">
                    @csrf
                    <div class="modal-body" style="height: 400px; overflow: auto">
                        <div class="form" id="formEdit">

                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn btn-secondary btnSubmit">UPDATE</button>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
    {{-- edit addresss end --}}

    <form action="{{ route('user.addresses.delete') }}" method="post" id="formAddDelete">
        @csrf

        <input type="hidden" name="address_id" id="txtAddID">
    </form>

@endsection

@section('extracss')
    <style>
        .error {
            color: rgb(238, 53, 53);
        }

        .fs-14 {
            font-size: 14 !important;
        }

        .signUp-page {
            background-color: #fff;
        }

        .signUp-minimal .signin-form-wrapper {
            max-width: 540px;
        }

        .Checkout_section .login-or h3 {
            margin-left: 12px;
            z-index: 6;
        }

        .input-group {
            flex-wrap: inherit !important;
        }

        .form__label,
        .pincode_error,
        .pincode_success,
        lable {
            padding-left: 0px;
            font-size: 15px;
        }

        @media screen and (max-width: 767px) {
            .btn {
                padding: 8px;
            }

            .checkout-payment .payment-group.pymt-btn label {
                font-size: 14px;
            }
        }

        label {
            padding: 10px;
            display: block;
        }

        .mb--5 {
            margin-bottom: 5px !important;
        }

        .delivery-address-height {
            cursor: pointer;
        }

        h4.card-title {
            font-size: 16px;
        }

        .order_place {
            width: 100%;
            background-color: transparent !important;
            color: var(--theme-color) !important;
            border: 2px solid var(--theme-color) !important;
            font-weight: 600 !important;
            text-transform: uppercase;
            padding: 12px !important;
            transition: all 0.3s ease !important;
        }

        .order_place:hover {
            background-color: var(--theme-color) !important;
            color: #fff !important;
        }

        .btnSubmit {
            background-color: transparent !important;
            color: var(--theme-color) !important;
            border: 2px solid var(--theme-color) !important;
            font-weight: 600 !important;
            text-transform: uppercase;
            padding: 10px 30px !important;
            transition: all 0.3s ease !important;
            border-radius: 4px !important;
        }

        .btnSubmit:hover {
            background-color: var(--theme-color) !important;
            color: #fff !important;
        }
    </style>
@endsection

@section('extrajs')

    <script>
        $(document).ready(function() {
            var seconds = 5;

            $('.order_place').attr('disabled', 'disabled');
            $('.add_address').hide();

            var pincode = $("input[name='choose_address']:checked").attr('data-pincode');

            if (pincode) {
                $('#pincode').val(pincode);
                chkPindode(pincode);
            }

            $('.radio-cont').change(function() {
                var pincode = $("input[name='choose_address']:checked").attr('data-pincode');

                $('#pincode').val(pincode);

                chkPindode(pincode);
            });

            // Sync pincode input with hidden field for Add Address form
            $(document).on('keyup change', '.pincode-code', function() {
                var val = $(this).val();
                if ($(this).attr('id') == 'pincode_add' || $(this).closest('.new-delivery-address')
                    .length || $(this).closest('.modal').length) {
                    $('#txtPincode').val(val);
                }
            });

            $('.pincode_button').click(function(e) {
                e.preventDefault();
                var container = $(this).closest('.checkout-form');
                var input = container.find('.pincode-code');
                var val = input.val();

                if (val == '') {
                    input.focus();
                    container.find('.pincode_success').css('display', 'none');
                    container.find('.pincode_error').css('display', 'block');
                    container.find('.pincode_error').html('Please Enter Pincode');
                    $(this).html('<i class="fa fa-search" aria-hidden="true"></i>');
                    $(this).removeAttr('disabled');
                } else if (val.length == 6) {
                    chkPindode(val, container);
                } else {
                    container.find('.pincode_success').css('display', 'none');
                    container.find('.pincode_error').css('display', 'block');
                    container.find('.pincode_error').html('Pincode should be of 6 digits');
                }
            });

            $('.delivery-address-height').click(function() {
                $('#new-address').modal('show');
            });

            $('.remove-address').click(function() {

                if (window.confirm('Are you sure want to delete ? ')) {

                    var address_id = $(this).attr('data-obj-id');
                    $('#txtAddID').val(address_id);
                    $('.remove-address').html('<span class="fa fa-spinner fa-spin"></span> ');
                    $('.remove-address').attr('disabled', 'disabled');
                    $('#formAddDelete').submit();
                }

            });

            $('.editAddress').click(function() {

                var address_id = $(this).attr('data-obj-id');

                $(this).html('<span class="fa fa-spinner fa-spin"></span> ');
                $(this).attr('disabled', 'disabled');

                if (address_id.length > 0) {

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('input[name="_token"]').val()
                        }
                    });

                    $.ajax({
                        url: "{{ route('user.addresses.fedit') }}",
                        type: 'POST',
                        data: {
                            address_id: address_id,
                        },
                        success: function(result) {
                            if (result.data) {

                                var data = result.data;

                                var html =
                                    `<div class="form-row mb--5">
                                    <div class="form__group col-md-12">
                                        <label for="name" class="form__label form__label--2">Name
                                            <span class="required">*</span></label>
                                        <input type="text" name="name" id="name" class="form__input form__input--2" required
                                            placeholder="Name" value="${data.name}">
                                    </div>
                                </div>

                                <div class="form-row mb--5">
                                    <div class="form__group col-md-12">
                                        <label for="mobile" class="form__label form__label--2">Mobile
                                            <span class="required">*</span></label>
                                        <input type="number" name="mobile" id="mobile" class="form__input form__input--2" required
                                            placeholder="Mobile" value="${data.mobile}">
                                    </div>
                                </div>

                                <div class="form-row mb--5">
                                    <div class="form__group col-12">
                                        <label for="address" class="form__label form__label--2">Street
                                            Address <span class="required">*</span></label>

                                        <input type="text" name="address" id="address" class="form__input form__input--2 mb--5"
                                            placeholder="House number and street name" required value="${data.address}" required>
                                    </div>
                                </div>

                                <div class="form-row mb--5">
                                    <div class="form__group col-12">
                                        <label for="landmark" class="form__label form__label--2">Landmark</label>
                                        <input type="text" name="landmark" id="landmark" class="form__input form__input--2"
                                            placeholder="Landmark" value="${data.landmark ? data.landmark : '' }">
                                    </div>
                                </div>

                                <div class="form-row mb--5">
                                    <div class="form__group col-12">
                                        <label for="city" class="form__label form__label--2">Town / City
                                            <span class="required">*</span></label>
                                        <input type="text" name="city" id="city" class="form__input form__input--2" required
                                            placeholder="Town/City" value="${data.city}" required>
                                    </div>
                                </div>

                                <div class="form-row mb--5">
                                    <div class="form__group col-12">
                                        <label for="territory" class="form__label form__label--2">State
                                            <span class="required">*</span></label>
                                        <input type="text" name="territory" id="territory" class="form__input form__input--2"
                                            required placeholder="State" value="${data.territory}" required>
                                    </div>
                                </div>

                                <div class="form-row mb--5">
                                    <div class="form__group col-12">
                                        <label for="pincode" class="form__label form__label--2">Pincode
                                            <span class="required">*</span></label>
                                        <input type="text" name="pincode" id="pincode" class="form__input form__input--2"
                                            required placeholder="Pincode" value="${data.pincode}" required>
                                    </div>
                                </div>

                                <div class="form-row mb--5">
                                    <div class="form__group type-of-address col-12">
                                        <label for="type_of_address" class="form__label form__label--2">Choose Type of Address
                                            <span class="required">*</span></label>
                                        <input id="home-update" class="toggle toggle-left" name="type_of_address" type="radio" value="0" ${ data.type_of_address == '0' ? 'checked' : '' }>
                                        <label for="home-update" class="btnn1">Home</label>
                                        <input id="corporate-update" class="toggle toggle-right" name="type_of_address" type="radio" value="1" ${ data.type_of_address == '1' ? 'checked' : '' }>
                                        <label for="corporate-update" class="btnn1">Office/Commercial</label>
                                    </div>
                                </div>
                                <input type="hidden" name="address_id" value="${data.id}">`

                                $('#formEdit').html(html);
                                $('#edit-address').modal('show');
                                $('.editAddress').html(
                                    '<a href="javascript:void(0)" data-obj-id=' +
                                    address_id +
                                    'class="card-link float-right editAddress"> <i class="fa fa-pencil text-primary"></i> Edit</a>'
                                );
                                $('.editAddress').removeAttr('disabled');

                            }
                        }
                    });
                }


            });

            $("#formCheckout").validate({
                rules: {

                    pincode: {
                        required: true,
                        minlength: 6,
                        maxlength: 6
                    },

                    choose_address: {
                        required: true
                    }

                },
                messages: {

                    pincode: {
                        required: "Please Enter Pincode",
                        minlength: "Pincode should be of 6 digits",
                        maxlength: "Pincode should be of 6 digits",
                    },

                    choose_address: {
                        required: "Please Select Address",
                    },

                },
                submitHandler: function(form) {
                    $('.order_place').attr('disabled', 'disabled');
                    $(".order_place").html('<span class="fa fa-spinner fa-spin"></span> Loading...');
                    form.submit();
                }
            });

            $("#formAddAddress").validate({
                rules: {
                    name: {
                        required: true
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    mobile: {
                        required: true,
                        number: true,
                        minlength: 10,
                        maxlength: 10
                    },
                    country: {
                        required: true,
                    },
                    address: {
                        required: true,
                    },
                    city: {
                        required: true,
                    },
                    territory: {
                        required: true,
                    },
                    type_of_address: {
                        required: true
                    },
                    pincode: {
                        required: true,
                        digits: true,
                        minlength: 6,
                        maxlength: 6
                    }
                },
                messages: {
                    name: {
                        required: "Please Enter Name"
                    },
                    email: {
                        required: "Please Enter Email",
                        email: "Please Enter Proper Email ID"
                    },
                    mobile: {
                        required: "Please Enter Mobile Number",
                        number: "Please Enter Proper Mobile Number",
                        minlength: "Mobile Number should be of 10 digits",
                        maxlength: "Mobile Number should be of 10 digits",
                    },
                    country: {
                        required: "Please Select Country"
                    },
                    address: {
                        required: "Please Enter Address"
                    },
                    city: {
                        required: "Please Enter City"
                    },
                    territory: {
                        required: "Please Enter Territory"
                    },
                    type_of_address: {
                        required: "Please Select Address Type"
                    },
                    pincode: {
                        required: "Please Enter Pincode",
                        digits: "Please Enter Proper Pincode",
                        minlength: "Pincode should be of 6 digits",
                        maxlength: "Pincode should be of 6 digits",
                    },
                },
                submitHandler: function(form) {
                    var pincodeInput = $(form).find('input[name="pincode"]');
                    var pincodeVal = pincodeInput.val();
                    
                    if (!pincodeVal || pincodeVal.length < 6) {
                        alert("Please enter a valid 6-digit Pincode.");
                        if ($(form).attr('id') === 'formAddAddress' && !pincodeInput.is(':visible')) {
                             $('#pincode_add').focus();
                        } else {
                             pincodeInput.focus();
                        }
                        return false;
                    }
                    
                    $('.btnSubmit').attr('disabled', 'disabled');
                    $(".btnSubmit").html('<span class="fa fa-spinner fa-spin"></span> Loading...');
                    form.submit();
                }
            });

            $("#formUpdateAddress").validate({
                rules: {

                    name: {
                        required: true
                    },

                    email: {
                        required: true,
                        email: true
                    },

                    mobile: {
                        required: true,
                        number: true,
                        minlength: 10,
                        maxlength: 10
                    },

                    pincode: {
                        required: true,
                        number: true,
                        minlength: 6,
                        maxlength: 6
                    },

                    address: {
                        required: true,
                    },

                    city: {
                        required: true,
                    },

                    territory: {
                        required: true,
                    },

                    type_of_address: {
                        required: true
                    }
                },
                messages: {

                    name: {
                        required: "Please Enter Name"
                    },

                    email: {
                        required: "Please Enter Email",
                        email: "Please Enter Proper Email ID"
                    },

                    mobile: {
                        required: "Please Enter Mobile Number",
                        number: "Please Enter Proper Mobile Number",
                        minlength: "Mobile Number should be of 10 digits",
                        maxlength: "Mobile Number should be of 10 digits",
                    },

                    pincode: {
                        required: "Please Enter Pincode",
                        number: "Please Enter Proper Pincode",
                        minlength: "Pincode should be of 6 digits",
                        maxlength: "Pincode should be of 6 digits",
                    },

                    address: {
                        required: "Please Enter Address"
                    },

                    city: {
                        required: "Please Enter City"
                    },

                    territory: {
                        required: "Please Enter Territory"
                    },

                    type_of_address: {
                        required: "Please Select Address Type"
                    },

                },
                submitHandler: function(form) {
                    $('.btnSubmit').attr('disabled', 'disabled');
                    $(".btnSubmit").html('<span class="fa fa-spinner fa-spin"></span> Loading...');
                    form.submit();
                }
            });

            $("#login-form").validate({
                rules: {

                    email: {
                        required: true,
                        email: true
                    },

                    password: {
                        required: true,
                    },

                },
                messages: {

                    email: {
                        required: "Please Enter Email",
                        email: "Please Enter Proper Email ID"
                    },

                    password: {
                        required: "Please Enter Password"
                    },

                },
                submitHandler: function(form) {
                    $('.button_update_login').attr('disabled', 'disabled');
                    $(".button_update_login").html(
                        '<span class="fa fa-spinner fa-spin"></span> Loading...');
                    form.submit();
                }
            });

            $("#formRegister").validate({
                rules: {

                    name: {
                        required: true,
                    },

                    mobile: {
                        required: true,
                    },

                    email: {
                        required: true,
                        email: true
                    },

                    password: {
                        required: true,
                    },

                },
                messages: {

                    email: {
                        required: "Please Enter Email",
                        email: "Please Enter Proper Email ID"
                    },

                    password: {
                        required: "Please Enter Password"
                    },

                    name: {
                        required: "Please Enter Name"
                    },

                    mobile: {
                        required: "Please Enter Mobile Number",
                        minlength: "Mobile Number should be of 10 digits only",
                        maxlength: "Mobile Number should be of 10 digits only",
                    },

                },
                submitHandler: function(form) {
                    $('.button_update_register').attr('disabled', 'disabled');
                    $(".button_update_register").html(
                        '<span class="fa fa-spinner fa-spin"></span> Loading...');
                    form.submit();
                }
            });

            $('.coupon-item').click(function() {
                var code = $(this).data('code');
                $('#discountcode').val(code);
                // Auto click apply button
                $('.verify_promo').click();
            });

            $('.verify_promo').click(function(e) {

                e.preventDefault();

                var promo = $('#discountcode').val();

                if (promo == '') {

                    $('.promo_error').html('Please Enter Coupon !');

                } else {

                    $(this).html('<span class="fa fa-spinner fa-spin"></span>');
                    $(this).attr('disabled', 'disabled');

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('input[name="_token"]').val()
                        }
                    });

                    $.ajax({
                        url: "{{ route('verify.promocode') }}",
                        method: 'POST',
                        data: {
                            discountcode: $('#discountcode').val(),
                        },
                        success: function(result) {
                            if (result.success) {
                                $('.promo_success').html(result.success);
                                $('.verify_promo').html('Apply');
                                $('.verify_promo').removeAttr('disabled', 'disabled');
                                $('.promo_error').hide();
                                $('.promo_success').show();
                                setTimeout(function() {
                                    $('.promo_success').fadeOut();
                                }, 4000);
                                $('#discount_span').html(result.discount_amount);
                                $('.order-total-ammount').html(result.new_total);
                            } else {
                                $('.promo_success').hide();
                                $('.promo_error').show();
                                $('.promo_error').html(result.error);
                                $('.verify_promo').html('Apply');
                                $('.verify_promo').removeAttr('disabled', 'disabled');
                                setTimeout(function() {
                                    $('.promo_error').fadeOut();
                                }, 4000);
                            }
                        }
                    });
                }

            });

        });

        function chkPindode(val, container) {
            container = container || $('.checkout-form').first();
            if (val == '' || val === undefined || val === null) {
                container.find('.pincode-code').focus();
                container.find('.pincode_error').html('Please Enter Pincode');
                container.find('.pincode_button').html('<i class="fa fa-search" aria-hidden="true"></i>');
                container.find('.pincode_button').removeAttr('disabled');
            } else if (val.length == 6) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('input[name="_token"]').val()
                    }
                });
                container.find('.pincode_button').html('<span class="fa fa-spinner fa-spin"></span>');
                container.find('.pincode_button').attr('disabled', 'disabled');
                $('.add_address').hide();
                $.ajax({
                    url: "{{ route('verify.pincode') }}",
                    type: 'POST',
                    data: {
                        pincode: val,
                    },
                    success: function(result) {
                        if (result.error) {
                            container.find('.pincode_error').html(result.error);
                            container.find('.pincode_success').css('display', 'none');
                            container.find('.pincode_error').css('display', 'block');
                            container.find('.pincode_button').html(
                                '<i class="fa fa-search" aria-hidden="true"></i>');
                            container.find('.pincode_button').removeAttr('disabled');
                            $('.order_place').attr('disabled', 'disabled');
                            $('.order_place').addClass('disabled');
                            container.find('.estimated_date').hide();
                        } else {
                            container.find('.pincode_success').html(result.success);
                            container.find('.pincode_error').css('display', 'none');
                            container.find('.pincode_success').css('display', 'block');
                            container.find('.pincode_button').html(
                                '<i class="fa fa-search" aria-hidden="true"></i>');
                            container.find('.pincode_button').removeAttr('disabled');
                            $('.order_place').removeAttr('disabled');
                            $('.order_place').removeClass('disabled');
                            $('.add_address').show();
                            $('#txtPincode').val(val);
                            container.find('.estimated_date').html('Estimated Delivery: ' + result
                                .estimated_date);
                            container.find('.estimated_date').show();
                        }
                    }
                });
            } else {
                container.find('.pincode_error').html('Pincode should be of 6 digits');
            }
        }
    </script>
@endsection
