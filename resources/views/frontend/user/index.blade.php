@extends('layouts.master') @section('title', 'Dashboard') @section('content')

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

    <!-- Main Section -->
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
                                        <a href="javascript:void(0)" class="active">
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
                            <div class="col-lg-12 mb-sm--25">
                                <div class="about-text">
                                    <h3 class="heading-tertiary heading-color mb--20">
                                        Hi {{ auth()->user()->name }},
                                    </h3>
                                    <h3>Welcome to the <strong>Ranayas</strong></h3>
                                    @if (auth()->user()->last_login)
                                        <p>
                                            Last Login on
                                            <strong>{{ \Carbon\Carbon::parse(auth()->user()->last_login)->diffForHumans() }}</strong>
                                        </p>
                                    @endif

                                    @if (auth()->user()->last_purchase)
                                        <p>
                                            Your last purchase on
                                            <strong>{{ \Carbon\Carbon::parse(auth()->user()->last_purchase)->diffForHumans() }}</strong>
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <form id="logout-form" action="{{ route('user.logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </section>
    <!-- Main Section -->
@endsection