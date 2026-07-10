@extends('layouts.master')
@section('title', 'My Account')
@section('content')

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
                                <span>My Account</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb area End -->

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
                                        <a href="javascript:void(0)" class="active">
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
                        <div class="profile-form">
                            <form class="form" method="POST" action="{{ route('user.profile.updateRequest') }}"
                                id="formUpdateProfile">
                                @csrf
                                <ul class="pro-input-label">
                                    <li>
                                        <label>First name</label>
                                        <input id="name" type="text" name="name" placeholder="Name*"
                                            value="{{ $user->name }}" required="required">
                                    </li>
                                    <li>
                                        <label>Email</label>
                                        <input disabled value="{{ $user->email }}">
                                    </li>
                                </ul>
                                <ul class="pro-input-label">
                                    <li>
                                        <label>Mobile</label>
                                        <input type="text" name="mobile" placeholder="Mobile Number*"
                                            value="{{ $user->mobile }}" required>
                                    </li>
                                    <li>
                                        <label>City</label>
                                        <input type="text" name="city" placeholder="City*" value="{{ $user->city }}">
                                    </li>
                                </ul>
                                <ul class="pro-input-label">
                                    <li>
                                        <label>State</label>
                                        <input type="text" name="territory" placeholder="Territory*"
                                            value="{{ $user->territory }}" required>
                                    </li>
                                    <li>
                                        <label>Pincode</label>
                                        <input type="number" name="pincode" placeholder="Pincode*" minlength="6"
                                            maxlength="6" value="{{ $user->pincode }}">
                                    </li>
                                </ul>
                                <ul class="pro-input-label">
                                    <li>
                                        <label>Address</label>
                                        <input type="text" name="address" placeholder="Address*"
                                            value="{{ $user->address }}">
                                    </li>
                                </ul>
                                <ul class="pro-submit">
                                    <li></li>
                                    <li>
                                        <button type="submit" class="btn btn-style1">Update profile</button>
                                    </li>
                                </ul>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- order history end -->
@endsection @section('extracss')
    <style>
        label {
            padding: 10px 0px;
        }

        .form-control {
            font-size: 14px;
            padding: 10px 15px !important;
            height: auto;
        }

        textarea {
            padding: 10px 15px !important;
            height: 80px !important;
        }

        .error {
            color: #fc544b !important;
        }

        .profile-form input {
            padding: 10px 15px !important;
            border: 1px solid #e2e2e2;
            width: 100%;
            border-radius: 4px;
        }

        .profile-form .btn-style1 {
            color: #fff !important;
            background-color: var(--theme-color) !important;
            border: 2px solid transparent !important;
        }

        .profile-form .btn-style1:hover {
            color: var(--theme-color) !important;
            border-color: var(--theme-color) !important;
            background-color: transparent !important;
        }
    </style>
@endsection

@section('extrajs')
    <script>
        $("#formUpdateProfile").validate({
            rules: {

                name: {
                    required: true
                },

                mobile: {
                    required: true,
                    minlength: 10,
                    maxlength: 10,
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

                pincode: {
                    required: true,
                    minlength: 6,
                    maxlength: 6
                },
            },
            messages: {

                name: {
                    required: "Please Enter Name"
                },

                mobile: {
                    required: "Please Enter Mobile Number",
                    maxlength: "Mobile Number should be of 10 digits",
                    minlength: "Mobile Number should be of 10 digits"
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

                pincode: {
                    required: "Please Enter Pincode",
                    minlength: "Pincode should be of 6 digits",
                    maxlength: "Pincode should be of 6 digits",
                },

            },
            submitHandler: function (form) {
                $('.submit_button').attr('disabled', 'disabled');
                $(".submit_button").html('<span class="fa fa-spinner fa-spin"></span> Loading...');
                form.submit();
            }
        });
    </script>
@endsection