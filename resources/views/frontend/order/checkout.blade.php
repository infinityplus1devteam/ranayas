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
                                                                    <label for="name" style="padding-left: 0;font-size: 18px"
                                                                        class="form__label form__label--2">Please enter
                                                                        PIN code to check delivery
                                                                        <span class="required">*</span></label>
                                                                    <input type="text" placeholder="Enter pincode"
                                                                        class="pincode-code form-control form__input form__input--2"
                                                                        value="{{ Session::get('pincode') }}" name="pincode"
                                                                        id="pincode" required>
                                                                </div>
                                                                <div class="form__group col-md-12 pincd">
                                                                    <label for="pincode" class="error pincode_error"></label>
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
                                                                                name="choose_address" value="{{ $add->id }}"
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
                                                                        <a href="javascript:void(0)" data-obj-id="{{ $add->id }}"
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
                                                                    <div class="card-body text-center delivery-address-height">
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
                                                            @foreach (Cart::getContent()->sortBy('id') as $item)
                                                                @php
                                                                    $isCodAvailable =
                                                                        $item->attributes->isCodAvailable &&
                                                                        $isCodAvailable;
                                                                @endphp
                                                                <li>
                                                                    <div class="check-pro-img">
                                                                        <a href="{{ route('product', $item->attributes->slug_url) }}">
                                                                            @php
                                                                                $variantCount = \App\Model\MapColorSize::where('product_id', $item->attributes->product_id)->count();
                                                                                // dd($variantCount);
                                                                            @endphp
                                                                            @if ($variantCount > 1 && $item->attributes->color_image)
                                                                                <img src="{!! asset('storage/images/multi-products/' . $item->attributes->color_image) !!}"
                                                                                    class="img-fluid" alt="{{ $item->name }}">
                                                                            @else
                                                                                <img src="{!! asset('storage/images/products/' . $item->attributes->image_url) !!}"
                                                                                    class="img-fluid" alt="{{ $item->name }}">
                                                                            @endif
                                                                        </a>
                                                                    </div>
                                                                    <div class="check-content">
                                                                        <a href="{{ route('product', $item->attributes->slug_url) }}">
                                                                            {{ $item->name }}
                                                                        </a>
                                                                        @php
                                                                            $checkoutSizeName = strtolower($item->attributes->size_name ?? '');
                                                                            $checkoutSizeClass = ($checkoutSizeName == '' || $checkoutSizeName == 'null') ? 'size-null' : 'size-' . $checkoutSizeName;
                                                                        @endphp
                                                                        <span class="check-code-blod {{ $checkoutSizeClass }}">
                                                                            Size:
                                                                            <span>{{ $item->attributes->size_name ?? '' }}{{-- . ' ' .
                                                                                $item->attributes->unit --}}</span>
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
                                                            <span>₹<span id="cart-total-span">{{ Cart::getTotal() }}</span></span>
                                                        </li>
                                                        {{-- @if (Cart::getTotal() < 1000) <li class="order-details shipping-row">
                                                            <span class="text-danger">Shipping Charge:</span>
                                                            <span class="text-danger">+ ₹60</span>
                                                            </li>
                                                            @endif --}}
                                                            <li class="order-details discount-row" style="display: none;">
                                                                <span class="text-success">Discount:</span>
                                                                <span class="text-success">- ₹<span
                                                                        id="discount_span">0</span></span>
                                                            </li>
                                                            {{-- Grand total row now only shows if there's a discount, so we start
                                                            hidden like discount-row --}}
                                                            <li class="order-details grand-total-row"
                                                                style="font-weight: bold; border-top: 1px solid #ddd; padding-top: 10px; margin-top: 10px; display: none;">
                                                                <span>Grand Total:</span>
                                                                <span>₹<span
                                                                        class="order-total-ammount">{{ Cart::getTotal() }}</span></span>
                                                            </li>
                                                    </ul>
                                                    <div class="checkout-payment">

                                                        <div class="promocode-checkout mb-4 mt-4"
                                                            style="padding: 20px 15px; border-top: 1px dashed #ccc; border-bottom: 1px dashed #ccc;">
                                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                                <h6 class="font-weight-bold mb-0"
                                                                    style="font-size: 15px; color: #333;">Have a Coupon?
                                                                </h6>
                                                                <div class="text-right">
                                                                    <span class="promo_success text-success font-weight-bold"
                                                                        style="font-size: 14px; display: none;"></span>
                                                                    <span class="promo_error text-danger font-weight-bold"
                                                                        style="font-size: 14px; display: none;"></span>
                                                                </div>
                                                            </div>
                                                            <div class="position-relative">
                                                                <div class="check">
                                                                    <div class="input-group" style="position: relative;">
                                                                        <input type="text" name="discountcode" id="discountcode"
                                                                            class="form-control discountcode"
                                                                            placeholder="Enter Coupon Code"
                                                                            style="border: 1px solid #ccc; margin-bottom: 0; height: 45px; box-shadow: none; border-right: none; padding-left: 15px; padding-right: 35px; border-radius: 4px 0 0 4px; background: #fff;"
                                                                            autocomplete="off">
                                                                        <span id="remove_promo"
                                                                            style="display: none; position: absolute; right: 114px; top: 50%; transform: translateY(-50%); z-index: 10; cursor: pointer; color: #ff4d4d; padding: 5px;"><i
                                                                                class="fa fa-times"
                                                                                style="font-size: 16px;"></i></span>
                                                                        <div class="input-group-append">
                                                                            <button type="button"
                                                                                class="verify_promo btn btn-dark mr-0"
                                                                                style="height: 45px; border-radius: 0 4px 4px 0; padding: 0 25px; font-weight: 600; background: #333; color: #fff; border: 1px solid #333;">
                                                                                Apply
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                @if (isset($coupons) && $coupons->count() > 0)
                                                                    <div class="available-coupons-dropdown list-group"
                                                                        style="display: none; position: absolute; z-index: 99999; width: 100%; background-color: #ffffff; box-shadow: 0 8px 24px rgba(0,0,0,0.15); max-height: 250px; overflow-y: auto; top: 100%; left: 0; border: 1px solid #ddd; border-radius: 4px; margin-top: 5px;">
                                                                        @foreach ($coupons as $coupon)
                                                                            <a href="javascript:void(0)"
                                                                                class="list-group-item list-group-item-action coupon-item"
                                                                                data-code="{{ $coupon->code }}"
                                                                                style="padding: 12px 15px; border-radius: 0; border: none; border-bottom: 1px solid #eee; background-color: #ffffff;">
                                                                                <div
                                                                                    class="d-flex w-100 justify-content-between align-items-center">
                                                                                    <h6 class="mb-0 text-primary" style="font-size: 14px;">
                                                                                        <i class="fa fa-tag"></i>
                                                                                        {{ $coupon->code }}
                                                                                    </h6>
                                                                                    <small class="text-success font-weight-bold"
                                                                                        style="font-size: 13px;">{{ $coupon->type == 'percentage' ? $coupon->value . '%' : '₹' . $coupon->value }}
                                                                                        OFF</small>
                                                                                </div>
                                                                            </a>
                                                                        @endforeach
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>


                                                        @if ($isCodAvailable)
                                                            <div class="payment-group pymt-btn mb--10">
                                                                <div class="payment-radio">
                                                                    <label for="cod" class="cb-container">
                                                                        CASH ON DELIVERY
                                                                        <input type="radio" value="cod" name="payment_mode" id="cod" {{ $isCodAvailable ? 'checked' : '' }}>
                                                                        <span class="rb-checkmark"></span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        @endif

                                                        @if ($isCodAvailable)
                                                            <div class="payment-group pymt-btn mb--10">
                                                                <div class="payment-radio">
                                                                    <label for="paytm" class="cb-container">
                                                                        NETBANKING/PAYTM
                                                                        <input type="radio" value="paytm" name="payment_mode" id="paytm">
                                                                        <span class="rb-checkmark"></span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <input type="hidden" value="paytm" name="payment_mode" id="paytm">
                                                        @endif

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
                                <div class="new-delivery-address profile-form" style="background: #fff; padding: 25px; border-radius: 5px; border: 1px solid #e2e2e2; margin-bottom: 30px;">
                                    <div class="title-area mb-4">
                                        <h4 style="font-weight: 600; font-size: 18px; margin-bottom: 20px;">Add New Delivery Address</h4>
                                    </div>
                                    
                                    <div class="checkout-form row mb-3">
                                        <div class="col-12">
                                            <label style="padding: 10px 0px; display: block; font-weight: 500;">Please enter PIN code to check delivery <span class="required" style="color:red">*</span></label>
                                            <input type="text" placeholder="Enter pincode"
                                                class="pincode-code form-control form__input form__input--2"
                                                style="padding: 10px 15px !important; border: 1px solid #e2e2e2; width: 100%; border-radius: 4px;"
                                                value="{{ Session::get('pincode') }}" name="pincode_add" id="pincode_add" required>
                                        </div>
                                        <div class="col-12 pincd mt-2">
                                            <label for="pincode" class="error pincode_error"></label>
                                            <p class="text-success pincode_success m-0"></p>
                                            <p class="text-success estimated_date m-0"></p>
                                        </div>
                                    </div>

                                    <form action="{{ route('user.addresses.add') }}" method="post" id="formAddAddress" class="form">
                                        @csrf
                                        <input type="hidden" id="txtPincode" name="pincode">
                                        
                                        <div class="row mb-3">
                                            <div class="col-12">
                                                <label style="padding: 10px 0px; display: block; font-weight: 500;">Name <span class="required" style="color:red">*</span></label>
                                                <input type="text" name="name" id="name" required placeholder="Name*" value="{{ old('name') }}" style="padding: 10px 15px !important; border: 1px solid #e2e2e2; width: 100%; border-radius: 4px;">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-6 mb-3 mb-md-0">
                                                <label style="padding: 10px 0px; display: block; font-weight: 500;">Mobile <span class="required" style="color:red">*</span></label>
                                                <input type="text" name="mobile" id="mobile" placeholder="Mobile Number*" value="{{ old('mobile') }}" required style="padding: 10px 15px !important; border: 1px solid #e2e2e2; width: 100%; border-radius: 4px;">
                                            </div>
                                            <div class="col-md-6">
                                                <label style="padding: 10px 0px; display: block; font-weight: 500;">Email Address <span class="required" style="color:red">*</span></label>
                                                <input type="email" name="email" id="email" placeholder="Email Address*" value="{{ old('email') }}" required style="padding: 10px 15px !important; border: 1px solid #e2e2e2; width: 100%; border-radius: 4px;">
                                            </div>
                                        </div>
                                        
                                        <div class="row mb-3">
                                            <div class="col-md-6 mb-3 mb-md-0">
                                                <label style="padding: 10px 0px; display: block; font-weight: 500;">Country <span class="required" style="color:red">*</span></label>
                                                <select id="country" name="country" required style="padding: 10px 15px !important; border: 1px solid #e2e2e2; width: 100%; border-radius: 4px; height: 44px; background: transparent; -webkit-appearance: auto;">
                                                    <option value="">Select a country…</option>
                                                    <option value="India" selected>India</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label style="padding: 10px 0px; display: block; font-weight: 500;">State <span class="required" style="color:red">*</span></label>
                                                <select id="territory" name="territory" required style="padding: 10px 15px !important; border: 1px solid #e2e2e2; width: 100%; border-radius: 4px; height: 44px; background: transparent; -webkit-appearance: auto;">
                                                    <option value="">Select a state…</option>
                                                    <option value="Andhra Pradesh">Andhra Pradesh</option>
                                                    <option value="Arunachal Pradesh">Arunachal Pradesh</option>
                                                    <option value="Assam">Assam</option>
                                                    <option value="Bihar">Bihar</option>
                                                    <option value="Chhattisgarh">Chhattisgarh</option>
                                                    <option value="Goa">Goa</option>
                                                    <option value="Gujarat">Gujarat</option>
                                                    <option value="Haryana">Haryana</option>
                                                    <option value="Himachal Pradesh">Himachal Pradesh</option>
                                                    <option value="Jharkhand">Jharkhand</option>
                                                    <option value="Karnataka">Karnataka</option>
                                                    <option value="Kerala">Kerala</option>
                                                    <option value="Madhya Pradesh">Madhya Pradesh</option>
                                                    <option value="Maharashtra">Maharashtra</option>
                                                    <option value="Manipur">Manipur</option>
                                                    <option value="Meghalaya">Meghalaya</option>
                                                    <option value="Mizoram">Mizoram</option>
                                                    <option value="Nagaland">Nagaland</option>
                                                    <option value="Odisha">Odisha</option>
                                                    <option value="Punjab">Punjab</option>
                                                    <option value="Rajasthan">Rajasthan</option>
                                                    <option value="Sikkim">Sikkim</option>
                                                    <option value="Tamil Nadu">Tamil Nadu</option>
                                                    <option value="Telangana">Telangana</option>
                                                    <option value="Tripura">Tripura</option>
                                                    <option value="Uttar Pradesh">Uttar Pradesh</option>
                                                    <option value="Uttarakhand">Uttarakhand</option>
                                                    <option value="West Bengal">West Bengal</option>
                                                    <option value="Andaman and Nicobar Islands">Andaman and Nicobar Islands</option>
                                                    <option value="Chandigarh">Chandigarh</option>
                                                    <option value="Dadra and Nagar Haveli and Daman and Diu">Dadra and Nagar Haveli and Daman and Diu</option>
                                                    <option value="Delhi">Delhi</option>
                                                    <option value="Jammu and Kashmir">Jammu and Kashmir</option>
                                                    <option value="Ladakh">Ladakh</option>
                                                    <option value="Lakshadweep">Lakshadweep</option>
                                                    <option value="Puducherry">Puducherry</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-12">
                                                <label style="padding: 10px 0px; display: block; font-weight: 500;">Town / City <span class="required" style="color:red">*</span></label>
                                                <input type="text" name="city" id="city" required placeholder="Town/City*" value="{{ old('city') }}" style="padding: 10px 15px !important; border: 1px solid #e2e2e2; width: 100%; border-radius: 4px;">
                                            </div>
                                        </div>
                                        
                                        <div class="row mb-3">
                                            <div class="col-12">
                                                <label style="padding: 10px 0px; display: block; font-weight: 500;">House number and street name <span class="required" style="color:red">*</span></label>
                                                <input type="text" name="address" id="address" required placeholder="Address*" value="{{ old('address') }}" style="padding: 10px 15px !important; border: 1px solid #e2e2e2; width: 100%; border-radius: 4px;">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-12">
                                                <label style="padding: 10px 0px; display: block; font-weight: 500;">Landmark</label>
                                                <input type="text" name="landmark" id="landmark" placeholder="Landmark" value="{{ old('landmark') }}" style="padding: 10px 15px !important; border: 1px solid #e2e2e2; width: 100%; border-radius: 4px;">
                                            </div>
                                        </div>

                                        <div class="row mb-3 mt-4">
                                            <div class="col-12">
                                                <label style="padding: 10px 0px; display: block; margin-bottom: 10px; font-weight: 500;">Choose Type of Address <span class="required" style="color:red">*</span></label>
                                                <div class="type-of-address">
                                                    <input id="home" class="toggle toggle-left" name="type_of_address" type="radio" value="0" {{ old('type_of_address') == 0 ? 'checked' : 'checked' }}>
                                                    <label for="home" class="btnn1">Home</label>
                                                    <input id="corporate" class="toggle toggle-right" name="type_of_address" type="radio" value="1" {{ old('type_of_address') == 1 ? 'checked' : '' }}>
                                                    <label for="corporate" class="btnn1">Office/Commercial</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mt-4">
                                            <div class="col-12">
                                                <button type="submit" class="btn btn-style1 btnSubmit" style="color: #fff !important; background-color: var(--theme-color) !important; border: 2px solid transparent !important; padding: 12px 30px; font-weight: 600; text-transform: uppercase; width: 100%; border-radius: 4px; transition: all 0.3s ease;">SAVE DELIVERY ADDRESS</button>
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
                                                    <!-- OTP Flow -->
                                                    <div class="text-center mb-3">
                                                        <h6>Login With OTP</h6>
                                                    </div>
                                                    <div id="checkout-otp-flow-container">
                                                        <form id="checkout-otp-request-form" class="login"
                                                            action="{{ route('user.login.otp') }}" method="POST"
                                                            autocomplete="off">
                                                            @csrf
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <div class="input-group mb-0">
                                                                        <input type="number" name="mobile"
                                                                            id="checkout-otp-mobile-input" required />
                                                                        <label>Enter 10 digit Mobile Number <span
                                                                                style="color:red">*</span></label>
                                                                    </div>
                                                                    <span class="text-danger"
                                                                        style="font-size: 13px; margin-bottom: 15px; display: block;"
                                                                        id="checkout-otp-request-error"></span>
                                                                </div>
                                                            </div>
                                                            <button type="submit" class="line-button-one button-rose mt-1 w-100"
                                                                id="checkout-btn-request-otp">
                                                                Next
                                                            </button>
                                                        </form>

                                                        <form id="checkout-otp-verify-form" class="login d-none"
                                                            action="{{ route('user.otp.verify') }}" method="POST"
                                                            autocomplete="off">
                                                            @csrf
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <div class="input-group mb-0">
                                                                        <input type="number" name="otp" id="checkout-otp-input"
                                                                            required />
                                                                        <label>Enter OTP <span
                                                                                style="color:red">*</span></label>
                                                                    </div>
                                                                    <span class="text-danger"
                                                                        style="font-size: 13px; margin-bottom: 15px; display: block;"
                                                                        id="checkout-otp-verify-error"></span>
                                                                </div>
                                                            </div>
                                                            <button type="submit" class="line-button-one button-rose mt-1 w-100"
                                                                id="checkout-btn-verify-otp">
                                                                Verify & Login
                                                            </button>
                                                        </form>
                                                    </div>

                                                    <p class="or-text mt-4 mb-4"><span>or</span></p>

                                                    <div class="row m-0 p-0">
                                                        <div class="col-12 p-0">
                                                            <a href="{{ route('user.login') }}"
                                                                class="line-button-one button-rose mt-1 w-100 login-with-email-btn"
                                                                style="display: block; text-align: center;"><i
                                                                    class="fa fa-envelope" aria-hidden="true"></i> Login
                                                                with
                                                                Email</a>
                                                        </div>
                                                    </div>

                                                    <ul class="social-icon-wrapper row m-0 mt-4 mb-4 p-0">
                                                        <li class="col-12 p-0">
                                                            <a href="{{ route('user.auth.socialite', 'google') }}"
                                                                class="gmail w-100" style="width: 100%; display: block;"><i
                                                                    class="fa fa-google" aria-hidden="true"
                                                                    style="font-size: 14px; margin-right: 6px;"></i> Login
                                                                with
                                                                Google</a>
                                                        </li>
                                                    </ul>
                                                </div> <!-- /.sign-up-form-wrapper -->
                                            </div> <!-- /.signUp-page -->
                                        </div>

                                        <div class="col-md-6">
                                            <div class="login-or">
                                                <h3>OR</h3>
                                            </div>
                                            <div class="signUp-page signUp-minimal">
                                                <div class="signin-form-wrapper" id="checkout-register-phone-section">
                                                    <div class="title-area text-center">
                                                        <h3>Register</h3>
                                                    </div> <!-- /.title-area -->
                                                    <form action="{{ route('user.register.phone') }}" method="POST"
                                                        autocomplete="off" class="register needs-validation"
                                                        id="formRegisterPhoneCheckout">
                                                        @csrf
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="input-group">
                                                                    <input type="number" name="mobile"
                                                                        value="{{ old('mobile') }}" minlength="10"
                                                                        maxlength="10" required>
                                                                    <label>Enter 10 digit Mobile Number *</label>
                                                                </div> <!-- /.input-group -->
                                                            </div> <!-- /.col- -->
                                                        </div> <!-- /.row -->
                                                        <button type="submit"
                                                            class="line-button-one button-rose button_update_register w-100"
                                                            style="width: 100%;">
                                                            Register
                                                        </button>
                                                    </form>

                                                    <p class="or-text mt-4 mb-4"><span>or</span></p>

                                                    <div class="row m-0 p-0">
                                                        <div class="col-12 p-0">
                                                            <a href="{{ route('user.register.mail') }}"
                                                                class="line-button-one button-rose mt-1 w-100 login-with-email-btn"
                                                                style="display: block; text-align: center;"><i
                                                                    class="fa fa-envelope" aria-hidden="true"></i>
                                                                Register with Email</a>
                                                        </div>
                                                    </div>
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
                    <div class="modal-body" style="height: 450px; overflow: auto; padding: 25px;">
                        <div class="form profile-form">

                            <div class="row mb-3">
                                <div class="col-12">
                                    <label style="padding: 10px 0px; display: block; font-weight: 500;">Name <span class="required" style="color:red">*</span></label>
                                    <input type="text" name="name" id="name" required placeholder="Name*" value="" style="padding: 10px 15px !important; border: 1px solid #e2e2e2; width: 100%; border-radius: 4px;">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6 mb-3 mb-md-0">
                                    <label style="padding: 10px 0px; display: block; font-weight: 500;">Mobile <span class="required" style="color:red">*</span></label>
                                    <input type="text" name="mobile" id="mobile" placeholder="Mobile Number*" required style="padding: 10px 15px !important; border: 1px solid #e2e2e2; width: 100%; border-radius: 4px;">
                                </div>
                                <div class="col-md-6">
                                    <label style="padding: 10px 0px; display: block; font-weight: 500;">Email Address <span class="required" style="color:red">*</span></label>
                                    <input type="email" name="email" id="email" placeholder="Email Address*" required style="padding: 10px 15px !important; border: 1px solid #e2e2e2; width: 100%; border-radius: 4px;">
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-md-6 mb-3 mb-md-0">
                                    <label style="padding: 10px 0px; display: block; font-weight: 500;">Country <span class="required" style="color:red">*</span></label>
                                    <select id="country" name="country" required style="padding: 10px 15px !important; border: 1px solid #e2e2e2; width: 100%; border-radius: 4px; height: 44px; background: transparent; -webkit-appearance: auto;">
                                        <option value="">Select a country…</option>
                                        <option value="India" selected>India</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label style="padding: 10px 0px; display: block; font-weight: 500;">Pincode <span class="required" style="color:red">*</span></label>
                                    <input type="text" name="pincode" id="pincode_modal" placeholder="Pincode*" required style="padding: 10px 15px !important; border: 1px solid #e2e2e2; width: 100%; border-radius: 4px;">
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-12">
                                    <label style="padding: 10px 0px; display: block; font-weight: 500;">House number and street name <span class="required" style="color:red">*</span></label>
                                    <input type="text" name="address" id="address" required placeholder="Address*" value="" style="padding: 10px 15px !important; border: 1px solid #e2e2e2; width: 100%; border-radius: 4px;">
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-12">
                                    <label style="padding: 10px 0px; display: block; font-weight: 500;">Landmark</label>
                                    <input type="text" name="landmark" id="landmark" placeholder="Landmark" value="" style="padding: 10px 15px !important; border: 1px solid #e2e2e2; width: 100%; border-radius: 4px;">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6 mb-3 mb-md-0">
                                    <label style="padding: 10px 0px; display: block; font-weight: 500;">Town / City <span class="required" style="color:red">*</span></label>
                                    <input type="text" name="city" id="city" required placeholder="Town/City*" value="" style="padding: 10px 15px !important; border: 1px solid #e2e2e2; width: 100%; border-radius: 4px;">
                                </div>
                                <div class="col-md-6">
                                    <label style="padding: 10px 0px; display: block; font-weight: 500;">State <span class="required" style="color:red">*</span></label>
                                    <select id="territory" name="territory" required style="padding: 10px 15px !important; border: 1px solid #e2e2e2; width: 100%; border-radius: 4px; height: 44px; background: transparent; -webkit-appearance: auto;">
                                        <option value="">Select a state…</option>
                                        <option value="Andhra Pradesh">Andhra Pradesh</option>
                                        <option value="Arunachal Pradesh">Arunachal Pradesh</option>
                                        <option value="Assam">Assam</option>
                                        <option value="Bihar">Bihar</option>
                                        <option value="Chhattisgarh">Chhattisgarh</option>
                                        <option value="Goa">Goa</option>
                                        <option value="Gujarat">Gujarat</option>
                                        <option value="Haryana">Haryana</option>
                                        <option value="Himachal Pradesh">Himachal Pradesh</option>
                                        <option value="Jharkhand">Jharkhand</option>
                                        <option value="Karnataka">Karnataka</option>
                                        <option value="Kerala">Kerala</option>
                                        <option value="Madhya Pradesh">Madhya Pradesh</option>
                                        <option value="Maharashtra">Maharashtra</option>
                                        <option value="Manipur">Manipur</option>
                                        <option value="Meghalaya">Meghalaya</option>
                                        <option value="Mizoram">Mizoram</option>
                                        <option value="Nagaland">Nagaland</option>
                                        <option value="Odisha">Odisha</option>
                                        <option value="Punjab">Punjab</option>
                                        <option value="Rajasthan">Rajasthan</option>
                                        <option value="Sikkim">Sikkim</option>
                                        <option value="Tamil Nadu">Tamil Nadu</option>
                                        <option value="Telangana">Telangana</option>
                                        <option value="Tripura">Tripura</option>
                                        <option value="Uttar Pradesh">Uttar Pradesh</option>
                                        <option value="Uttarakhand">Uttarakhand</option>
                                        <option value="West Bengal">West Bengal</option>
                                        <option value="Andaman and Nicobar Islands">Andaman and Nicobar Islands</option>
                                        <option value="Chandigarh">Chandigarh</option>
                                        <option value="Dadra and Nagar Haveli and Daman and Diu">Dadra and Nagar Haveli and Daman and Diu</option>
                                        <option value="Delhi">Delhi</option>
                                        <option value="Jammu and Kashmir">Jammu and Kashmir</option>
                                        <option value="Ladakh">Ladakh</option>
                                        <option value="Lakshadweep">Lakshadweep</option>
                                        <option value="Puducherry">Puducherry</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3 mt-4">
                                <div class="col-12">
                                    <label style="padding: 10px 0px; display: block; margin-bottom: 10px; font-weight: 500;">Choose Type of Address <span class="required" style="color:red">*</span></label>
                                    <div class="type-of-address">
                                        <input id="home-new" class="toggle toggle-left" name="type_of_address" type="radio" value="0" checked>
                                        <label for="home-new" class="btnn1">Home</label>
                                        <input id="corporate-new" class="toggle toggle-right" name="type_of_address" type="radio" value="1">
                                        <label for="corporate-new" class="btnn1">Office/Commercial</label>
                                    </div>
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
        $(window).on('pageshow', function () {
            $('.order_place').text('Place order');
            var pincode = $("input[name='choose_address']:checked").attr('data-pincode');
            if (pincode) {
                chkPindode(pincode);
            }
        });

        $(document).ready(function () {
            var seconds = 5;

            $('.order_place').attr('disabled', 'disabled');
            $('.add_address').hide();

            var pincode = $("input[name='choose_address']:checked").attr('data-pincode');

            if (pincode) {
                $('#pincode').val(pincode);
                chkPindode(pincode);
            }

            $('.radio-cont').change(function () {
                var pincode = $("input[name='choose_address']:checked").attr('data-pincode');

                $('#pincode').val(pincode);

                chkPindode(pincode);
            });

            // Sync pincode input with hidden field for Add Address form
            $(document).on('keyup change', '.pincode-code', function () {
                var val = $(this).val();
                if ($(this).attr('id') == 'pincode_add' || $(this).closest('.new-delivery-address')
                    .length || $(this).closest('.modal').length) {
                    $('#txtPincode').val(val);
                }
            });

            $('.pincode-code').on('keyup', function (e) {
                var input = $(this);
                var val = input.val();

                if (val.length !== 6) return; // Only check when 6 digits are entered

                var container = $(this).closest('.checkout-form');

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

            $('.delivery-address-height').click(function () {
                $('#new-address').modal('show');
            });

            $('.remove-address').click(function () {

                if (window.confirm('Are you sure want to delete ? ')) {

                    var address_id = $(this).attr('data-obj-id');
                    $('#txtAddID').val(address_id);
                    $('.remove-address').html('<span class="fa fa-spinner fa-spin"></span> ');
                    $('.remove-address').attr('disabled', 'disabled');
                    $('#formAddDelete').submit();
                }

            });

            $('.editAddress').click(function () {

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
                        success: function (result) {
                            if (result.data) {

                                var data = result.data;

                                var html =
                                    `<div class="form profile-form">

                                        <div class="row mb-3">
                                            <div class="col-12">
                                                <label style="padding: 10px 0px; display: block; font-weight: 500;">Name <span class="required" style="color:red">*</span></label>
                                                <input type="text" name="name" id="name" required placeholder="Name*" value="${data.name}" style="padding: 10px 15px !important; border: 1px solid #e2e2e2; width: 100%; border-radius: 4px;">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-6 mb-3 mb-md-0">
                                                <label style="padding: 10px 0px; display: block; font-weight: 500;">Mobile <span class="required" style="color:red">*</span></label>
                                                <input type="number" name="mobile" id="mobile" placeholder="Mobile Number*" value="${data.mobile}" required style="padding: 10px 15px !important; border: 1px solid #e2e2e2; width: 100%; border-radius: 4px;">
                                            </div>
                                            <div class="col-md-6">
                                                <label style="padding: 10px 0px; display: block; font-weight: 500;">Pincode <span class="required" style="color:red">*</span></label>
                                                <input type="text" name="pincode" id="pincode" placeholder="Pincode*" value="${data.pincode}" required style="padding: 10px 15px !important; border: 1px solid #e2e2e2; width: 100%; border-radius: 4px;">
                                            </div>
                                        </div>
                                        
                                        <div class="row mb-3">
                                            <div class="col-12">
                                                <label style="padding: 10px 0px; display: block; font-weight: 500;">House number and street name <span class="required" style="color:red">*</span></label>
                                                <input type="text" name="address" id="address" required placeholder="Address*" value="${data.address}" style="padding: 10px 15px !important; border: 1px solid #e2e2e2; width: 100%; border-radius: 4px;">
                                            </div>
                                        </div>
                                        
                                        <div class="row mb-3">
                                            <div class="col-12">
                                                <label style="padding: 10px 0px; display: block; font-weight: 500;">Landmark</label>
                                                <input type="text" name="landmark" id="landmark" placeholder="Landmark" value="${data.landmark ? data.landmark : ''}" style="padding: 10px 15px !important; border: 1px solid #e2e2e2; width: 100%; border-radius: 4px;">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-6 mb-3 mb-md-0">
                                                <label style="padding: 10px 0px; display: block; font-weight: 500;">Town / City <span class="required" style="color:red">*</span></label>
                                                <input type="text" name="city" id="city" required placeholder="Town/City*" value="${data.city}" style="padding: 10px 15px !important; border: 1px solid #e2e2e2; width: 100%; border-radius: 4px;">
                                            </div>
                                            <div class="col-md-6">
                                                <label style="padding: 10px 0px; display: block; font-weight: 500;">State <span class="required" style="color:red">*</span></label>
                                                <select id="territory" name="territory" required style="padding: 10px 15px !important; border: 1px solid #e2e2e2; width: 100%; border-radius: 4px; height: 44px; background: transparent; -webkit-appearance: auto;">
                                                    <option value="">Select a state…</option>
                                                    <option value="Andhra Pradesh" ${data.territory == 'Andhra Pradesh' ? 'selected' : ''}>Andhra Pradesh</option>
                                                    <option value="Arunachal Pradesh" ${data.territory == 'Arunachal Pradesh' ? 'selected' : ''}>Arunachal Pradesh</option>
                                                    <option value="Assam" ${data.territory == 'Assam' ? 'selected' : ''}>Assam</option>
                                                    <option value="Bihar" ${data.territory == 'Bihar' ? 'selected' : ''}>Bihar</option>
                                                    <option value="Chhattisgarh" ${data.territory == 'Chhattisgarh' ? 'selected' : ''}>Chhattisgarh</option>
                                                    <option value="Goa" ${data.territory == 'Goa' ? 'selected' : ''}>Goa</option>
                                                    <option value="Gujarat" ${data.territory == 'Gujarat' ? 'selected' : ''}>Gujarat</option>
                                                    <option value="Haryana" ${data.territory == 'Haryana' ? 'selected' : ''}>Haryana</option>
                                                    <option value="Himachal Pradesh" ${data.territory == 'Himachal Pradesh' ? 'selected' : ''}>Himachal Pradesh</option>
                                                    <option value="Jharkhand" ${data.territory == 'Jharkhand' ? 'selected' : ''}>Jharkhand</option>
                                                    <option value="Karnataka" ${data.territory == 'Karnataka' ? 'selected' : ''}>Karnataka</option>
                                                    <option value="Kerala" ${data.territory == 'Kerala' ? 'selected' : ''}>Kerala</option>
                                                    <option value="Madhya Pradesh" ${data.territory == 'Madhya Pradesh' ? 'selected' : ''}>Madhya Pradesh</option>
                                                    <option value="Maharashtra" ${data.territory == 'Maharashtra' ? 'selected' : ''}>Maharashtra</option>
                                                    <option value="Manipur" ${data.territory == 'Manipur' ? 'selected' : ''}>Manipur</option>
                                                    <option value="Meghalaya" ${data.territory == 'Meghalaya' ? 'selected' : ''}>Meghalaya</option>
                                                    <option value="Mizoram" ${data.territory == 'Mizoram' ? 'selected' : ''}>Mizoram</option>
                                                    <option value="Nagaland" ${data.territory == 'Nagaland' ? 'selected' : ''}>Nagaland</option>
                                                    <option value="Odisha" ${data.territory == 'Odisha' ? 'selected' : ''}>Odisha</option>
                                                    <option value="Punjab" ${data.territory == 'Punjab' ? 'selected' : ''}>Punjab</option>
                                                    <option value="Rajasthan" ${data.territory == 'Rajasthan' ? 'selected' : ''}>Rajasthan</option>
                                                    <option value="Sikkim" ${data.territory == 'Sikkim' ? 'selected' : ''}>Sikkim</option>
                                                    <option value="Tamil Nadu" ${data.territory == 'Tamil Nadu' ? 'selected' : ''}>Tamil Nadu</option>
                                                    <option value="Telangana" ${data.territory == 'Telangana' ? 'selected' : ''}>Telangana</option>
                                                    <option value="Tripura" ${data.territory == 'Tripura' ? 'selected' : ''}>Tripura</option>
                                                    <option value="Uttar Pradesh" ${data.territory == 'Uttar Pradesh' ? 'selected' : ''}>Uttar Pradesh</option>
                                                    <option value="Uttarakhand" ${data.territory == 'Uttarakhand' ? 'selected' : ''}>Uttarakhand</option>
                                                    <option value="West Bengal" ${data.territory == 'West Bengal' ? 'selected' : ''}>West Bengal</option>
                                                    <option value="Andaman and Nicobar Islands" ${data.territory == 'Andaman and Nicobar Islands' ? 'selected' : ''}>Andaman and Nicobar Islands</option>
                                                    <option value="Chandigarh" ${data.territory == 'Chandigarh' ? 'selected' : ''}>Chandigarh</option>
                                                    <option value="Dadra and Nagar Haveli and Daman and Diu" ${data.territory == 'Dadra and Nagar Haveli and Daman and Diu' ? 'selected' : ''}>Dadra and Nagar Haveli and Daman and Diu</option>
                                                    <option value="Delhi" ${data.territory == 'Delhi' ? 'selected' : ''}>Delhi</option>
                                                    <option value="Jammu and Kashmir" ${data.territory == 'Jammu and Kashmir' ? 'selected' : ''}>Jammu and Kashmir</option>
                                                    <option value="Ladakh" ${data.territory == 'Ladakh' ? 'selected' : ''}>Ladakh</option>
                                                    <option value="Lakshadweep" ${data.territory == 'Lakshadweep' ? 'selected' : ''}>Lakshadweep</option>
                                                    <option value="Puducherry" ${data.territory == 'Puducherry' ? 'selected' : ''}>Puducherry</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row mb-3 mt-4">
                                            <div class="col-12">
                                                <label style="padding: 10px 0px; display: block; margin-bottom: 10px; font-weight: 500;">Choose Type of Address <span class="required" style="color:red">*</span></label>
                                                <div class="type-of-address">
                                                    <input id="home-update" class="toggle toggle-left" name="type_of_address" type="radio" value="0" ${data.type_of_address == '0' ? 'checked' : ''}>
                                                    <label for="home-update" class="btnn1">Home</label>
                                                    <input id="corporate-update" class="toggle toggle-right" name="type_of_address" type="radio" value="1" ${data.type_of_address == '1' ? 'checked' : ''}>
                                                    <label for="corporate-update" class="btnn1">Office/Commercial</label>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" name="address_id" value="${data.id}">
                                    </div>`

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
                submitHandler: function (form) {
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
                submitHandler: function (form) {
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
                submitHandler: function (form) {
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
                submitHandler: function (form) {
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
                submitHandler: function (form) {
                    $('.button_update_register').attr('disabled', 'disabled');
                    $(".button_update_register").html(
                        '<span class="fa fa-spinner fa-spin"></span> Loading...');
                    form.submit();
                }
            });

            // Coupon Dropdown logic
            $('#discountcode').on('focus', function () {
                $('.available-coupons-dropdown').slideDown('fast');
            });

            $(document).on('click', function (e) {
                if (!$(e.target).closest('.promocode-checkout').length) {
                    $('.available-coupons-dropdown').slideUp('fast');
                }
            });

            $('.coupon-item').click(function (e) {
                e.preventDefault();
                var code = $(this).data('code');
                $('#discountcode').val(code);
                $('.available-coupons-dropdown').slideUp('fast');
                // Auto click apply button
                $('.verify_promo').click();
            });

            $('.verify_promo').click(function (e) {

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
                        success: function (result) {
                            if (result.success) {
                                $('.promo_success').html(result.success);
                                $('.verify_promo').html('Applied');
                                $('.verify_promo').attr('disabled', 'disabled');
                                $('#discountcode').attr('readonly', 'readonly');
                                $('#remove_promo').show();
                                $('.promo_error').hide();
                                $('.promo_success').show();
                                setTimeout(function () {
                                    $('.promo_success').fadeOut();
                                }, 4000);
                                $('#discount_span').html(result.discount_amount);
                                $('.order-total-ammount').html(result.new_total);
                                $('.discount-row').show();
                                $('.grand-total-row').show();
                            } else {
                                $('.promo_success').hide();
                                $('.promo_error').show();
                                $('.promo_error').html(result.error);
                                $('.verify_promo').html('Apply');
                                $('.verify_promo').removeAttr('disabled');
                            }
                        }
                    });
                }

            });

            $('#remove_promo').click(function (e) {
                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('input[name="_token"]').val()
                    }
                });

                $.ajax({
                    url: "{{ route('remove.promocode') }}",
                    method: 'POST',
                    success: function (result) {
                        if (result.success) {
                            $('#discountcode').val('');
                            $('#discountcode').removeAttr('readonly');
                            $('.verify_promo').html('Apply');
                            $('.verify_promo').removeAttr('disabled');
                            $('#remove_promo').hide();
                            $('.promo_error').hide();

                            // Optionally reset the totals on the frontend
                            $('#discount_span').html('0');
                            $('.order-total-ammount').html(result.new_total);
                            $('.discount-row').hide();
                            if (result.new_total != {{ Cart::getTotal() }}) {
                                $('.grand-total-row').show();
                            } else {
                                $('.grand-total-row').hide();
                            }
                        }
                    }
                });
            });

        });

        function chkPindode(val, container) {
            container = container || $('.checkout-form').first();
            if (val == '' || val === undefined || val === null) {
                container.find('.pincode-code').focus();
                container.find('.pincode_error').html('Please Enter Pincode');
                // container.find('.pincode_button').html('<i class="fa fa-search" aria-hidden="true"></i>');
                // container.find('.pincode_button').removeAttr('disabled');
            } else if (val.length == 6) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('input[name="_token"]').val()
                    }
                });
                // container.find('.pincode_button').html('<span class="fa fa-spinner fa-spin"></span>');
                // container.find('.pincode_button').attr('disabled', 'disabled');
                $('.add_address').hide();
                $.ajax({
                    url: "{{ route('verify.pincode') }}",
                    type: 'POST',
                    data: {
                        pincode: val,
                    },
                    success: function (result) {
                        if (result.error) {
                            container.find('.pincode_error').html(result.error);
                            container.find('.pincode_success').css('display', 'none');
                            container.find('.pincode_error').css('display', 'block');
                            // container.find('.pincode_button').html(
                            //     '<i class="fa fa-search" aria-hidden="true"></i>');
                            // container.find('.pincode_button').removeAttr('disabled');
                            $('.order_place').attr('disabled', 'disabled');
                            $('.order_place').addClass('disabled');
                            container.find('.estimated_date').hide();
                        } else {
                            container.find('.pincode_success').html(result.success);
                            container.find('.pincode_error').css('display', 'none');
                            container.find('.pincode_success').css('display', 'block');
                            // container.find('.pincode_button').html(
                            //     '<i class="fa fa-search" aria-hidden="true"></i>');
                            // container.find('.pincode_button').removeAttr('disabled');
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

        $(document).ready(function () {
            $('#checkout-otp-request-form').on('submit', function (e) {
                e.preventDefault();
                var $form = $(this);
                var $btn = $('#checkout-btn-request-otp');
                var mobile = $('#checkout-otp-mobile-input').val();
                $('#checkout-otp-request-error').text('');

                if (!mobile || mobile.length !== 10) {
                    $('#checkout-otp-request-error').text('Please enter a valid 10-digit mobile number.');
                    return;
                }

                $btn.prop('disabled', true).html('<span class="fa fa-spinner fa-spin"></span> Loading...');

                $.ajax({
                    url: $form.attr('action'),
                    type: 'POST',
                    data: $form.serialize(),
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    success: function (response) {
                        if (response.success) {
                            $form.addClass('d-none');
                            $('#checkout-otp-verify-form').removeClass('d-none');
                        } else {
                            $('#checkout-otp-request-error').text(response.message ||
                                'Something went wrong.');
                        }
                    },
                    error: function (xhr) {
                        $('#checkout-otp-request-error').text(
                            'An error occurred. Please try again.');
                    },
                    complete: function () {
                        $btn.prop('disabled', false).text('Next');
                    }
                });
            });

            $('#checkout-otp-verify-form').on('submit', function (e) {
                e.preventDefault();
                var $form = $(this);
                var $btn = $('#checkout-btn-verify-otp');
                var otp = $('#checkout-otp-input').val();
                $('#checkout-otp-verify-error').text('');

                if (!otp) {
                    $('#checkout-otp-verify-error').text('Please enter OTP.');
                    return;
                }

                $btn.prop('disabled', true).html(
                    '<span class="fa fa-spinner fa-spin"></span> Verifying...');

                $.ajax({
                    url: $form.attr('action'),
                    type: 'POST',
                    data: $form.serialize(),
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    success: function (response) {
                        if (response.success) {
                            window.location.href = response.redirect;
                        } else {
                            $('#checkout-otp-verify-error').text(response.message ||
                                'Invalid OTP.');
                        }
                    },
                    error: function (xhr) {
                        $('#checkout-otp-verify-error').text(
                            'An error occurred. Please try again.');
                    },
                    complete: function () {
                        $btn.prop('disabled', false).text('Verify & Login');
                    }
                });
            });
        });
    </script>
@endsection