@extends('layouts.master') @section('title', 'Manage Addresses') @section('content')


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
                                <span>My Addresses</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- order history start -->
    <section class="order-histry-area section-tb-padding pt-2">
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
                                        <a href="{{ route('user.addresses') }}" class="active">
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
                        <div class="profile-address">
                            <div class="row">
                                @foreach($user->addresses as $add)
                                    <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                                        <div class="address-card card">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between align-items-center mb-3">
                                                    <h5 class="address-name">{{ $add->name }}</h5>
                                                    <span class="address-badge">{{ $add->type_of_address ? 'Work' : 'Home' }}</span>
                                                </div>
                                                <p class="address-text">
                                                    {{ $add->address }},<br>
                                                    @if($add->landmark)<span class="text-muted small">Landmark: {{ $add->landmark }}</span><br>@endif
                                                    {{ $add->city }}, {{ $add->territory }}, {{ $add->country }} - {{ $add->pincode }}
                                                </p>
                                                @if($add->mobile)
                                                    <div class="address-phone">
                                                        <i class="fa fa-phone"></i> {{ $add->mobile }}
                                                    </div>
                                                @else
                                                    <div class="address-phone text-danger">
                                                        <i class="fa fa-exclamation-triangle"></i> Update Mobile Number
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="card-footer">
                                                <a href="javascript:void(0)" class="action-btn remove-btn remove-address" data-obj-id="{{ $add->id }}">
                                                    <i class="fa fa-trash"></i> Remove
                                                </a>
                                                <a href="javascript:void(0)" data-obj-id="{{ $add->id }}" class="action-btn edit-btn editAddress">
                                                    <i class="fa fa-pencil"></i> Edit
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                                <div class="col-lg-4 col-md-6 col-sm-12 mb-4 add_address">
                                    <div class="address-card add-card card">
                                        <div class="card-body d-flex flex-column align-items-center justify-content-center">
                                            <div class="add-icon-wrap">
                                                <i class="fa fa-plus"></i>
                                            </div>
                                            <h5 class="add-text">Add new address</h5>
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
                                    <label style="padding: 10px 0px; display: block; font-weight: 500;">Name <span
                                            class="required" style="color:red">*</span></label>
                                    <input type="text" name="name" id="name" required placeholder="Name*" value="{{ old('name') }}"
                                        style="padding: 10px 15px !important; border: 1px solid #e2e2e2; width: 100%; border-radius: 4px;">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6 mb-3 mb-md-0">
                                    <label style="padding: 10px 0px; display: block; font-weight: 500;">Mobile <span
                                            class="required" style="color:red">*</span></label>
                                    <input type="text" name="mobile" id="mobile" placeholder="Mobile Number*" value="{{ old('mobile') }}" required
                                        style="padding: 10px 15px !important; border: 1px solid #e2e2e2; width: 100%; border-radius: 4px;">
                                </div>
                                <div class="col-md-6">
                                    <label style="padding: 10px 0px; display: block; font-weight: 500;">Email Address <span
                                            class="required" style="color:red">*</span></label>
                                    <input type="email" name="email" id="email" placeholder="Email Address*" value="{{ old('email') }}" required
                                        style="padding: 10px 15px !important; border: 1px solid #e2e2e2; width: 100%; border-radius: 4px;">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6 mb-3 mb-md-0">
                                    <label style="padding: 10px 0px; display: block; font-weight: 500;">Country <span
                                            class="required" style="color:red">*</span></label>
                                    <select id="country" name="country" required
                                        style="padding: 10px 15px !important; border: 1px solid #e2e2e2; width: 100%; border-radius: 4px; height: 44px; background: transparent; -webkit-appearance: auto;">
                                        <option value="">Select a country…</option>
                                        <option value="India" selected>India</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label style="padding: 10px 0px; display: block; font-weight: 500;">Pincode <span
                                            class="required" style="color:red">*</span></label>
                                    <input type="text" name="pincode" id="pincode" placeholder="Pincode*" value="{{ old('pincode') }}" required
                                        style="padding: 10px 15px !important; border: 1px solid #e2e2e2; width: 100%; border-radius: 4px;">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-12">
                                    <label style="padding: 10px 0px; display: block; font-weight: 500;">House number and
                                        street name <span class="required" style="color:red">*</span></label>
                                    <input type="text" name="address" id="address" required placeholder="Address*" value="{{ old('address') }}"
                                        style="padding: 10px 15px !important; border: 1px solid #e2e2e2; width: 100%; border-radius: 4px;">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-12">
                                    <label style="padding: 10px 0px; display: block; font-weight: 500;">Landmark</label>
                                    <input type="text" name="landmark" id="landmark" placeholder="Landmark" value="{{ old('landmark') }}"
                                        style="padding: 10px 15px !important; border: 1px solid #e2e2e2; width: 100%; border-radius: 4px;">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6 mb-3 mb-md-0">
                                    <label style="padding: 10px 0px; display: block; font-weight: 500;">Town / City <span
                                            class="required" style="color:red">*</span></label>
                                    <input type="text" name="city" id="city" required placeholder="Town/City*" value="{{ old('city') }}"
                                        style="padding: 10px 15px !important; border: 1px solid #e2e2e2; width: 100%; border-radius: 4px;">
                                </div>
                                <div class="col-md-6">
                                    <label style="padding: 10px 0px; display: block; font-weight: 500;">State <span
                                            class="required" style="color:red">*</span></label>
                                    <select id="territory" name="territory" required
                                        style="padding: 10px 15px !important; border: 1px solid #e2e2e2; width: 100%; border-radius: 4px; height: 44px; background: transparent; -webkit-appearance: auto;">
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
                                        <option value="Dadra and Nagar Haveli and Daman and Diu">Dadra and Nagar Haveli and
                                            Daman and Diu</option>
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
                                    <label
                                        style="padding: 10px 0px; display: block; margin-bottom: 10px; font-weight: 500;">Choose
                                        Type of Address <span class="required" style="color:red">*</span></label>
                                    <div class="type-of-address">
                                        <input id="home-new" class="toggle toggle-left" name="type_of_address" type="radio"
                                            value="0" checked>
                                        <label for="home-new" class="btnn1">Home</label>
                                        <input id="corporate-new" class="toggle toggle-right" name="type_of_address"
                                            type="radio" value="1">
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
            margin-left: 10px;
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

        .mb--5 {
            margin-bottom: 5px !important;
        }

        .order-history label {
            padding: 10px;
            display: block;
        }

        .delivery-address-height {
            cursor: pointer;
        }

        h4.card-title {
            font-size: 16px;
        }

        .pt-65 {
            padding-top: 65px;
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
        $(document).ready(function () {

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
                                    `<a href="javascript:void(0)" data-obj-id=' +
                                        address_id +
                                        'class="card-link float-right editAddress"><i
                                                            class="fa fa-pencil text-primary"></i>Edit</a>`);
                                $('.editAddress').removeAttr('disabled');

                            }
                        }
                    });
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

                    pincode: {
                        required: true,
                        number: true,
                        minlength: 6,
                        maxlength: 6
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

                },
                submitHandler: function (form) {
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

            $('.remove-address').click(function () {

                if (window.confirm('Are you sure want to delete this address ? ')) {

                    var address_id = $(this).attr('data-obj-id');
                    $('#txtAddID').val(address_id);
                    $('.remove-address').html('<span class="fa fa-spinner fa-spin"></span> ');
                    $('.remove-address').attr('disabled', 'disabled');
                    $('#formAddDelete').submit();
                }

            });

            $('.add_address').click(function () {
                $('#new-address').modal('show');
            });

        });

    </script>

@endsection