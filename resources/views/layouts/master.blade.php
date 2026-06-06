<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="Ranayas" />
    <link rel="shortcut icon" href="{!! asset('assets/image/logo/favicon-32x32.png') !!}">
    <!-- Title -->
    <title>@yield('title') || Ranayas</title>
    <link rel="stylesheet" type="text/css" href="{!! asset('assets/css/bootstrap.min.css') !!}">
    <!-- simple-line icon -->
    <link rel=" stylesheet" type="text/css" href="{!! asset('assets/css/simple-line-icons.css') !!}">
    <!-- font-awesome icon -->
    <link rel=" stylesheet" type="text/css" href="{!! asset('assets/css/font-awesome.min.css') !!}">
    <!-- themify icon -->
    <link rel=" stylesheet" type="text/css" href="{!! asset('assets/css/themify-icons.css') !!}">
    <!-- ion icon -->
    <link rel=" stylesheet" type="text/css" href="{!! asset('assets/css/ionicons.min.css') !!}">
    <!-- owl slider -->
    <link rel=" stylesheet" type="text/css" href="{!! asset('assets/css/owl.carousel.min.css') !!}">
    <link rel=" stylesheet" type="text/css" href="{!! asset('assets/css/owl.theme.default.min.css') !!}">
    <!-- swiper -->
    <link rel=" stylesheet" type="text/css" href="{!! asset('assets/css/swiper.min.css') !!}">
    <!-- animation -->
    <link rel=" stylesheet" type="text/css" href="{!! asset('assets/css/animate.css') !!}">
    <!-- style -->
    <link rel=" stylesheet" type="text/css" href="{!! asset('assets/css/style5.css') !!}">
    <link rel=" stylesheet" type="text/css" href="{!! asset('assets/css/responsive5.css') !!}">
    <link rel=" stylesheet" type="text/css" href="{!! asset('assets/css/custom.css') !!}">
    <link rel=" stylesheet" type="text/css" href="{!! asset('assets/css/hearing-test.css') !!}">
    <link rel=" stylesheet" type="text/css" href="{!! asset('assets/css/responsive.css') !!}">
    <link rel=" stylesheet" type="text/css" href="{!! asset('assets/css/popup.css') !!}">
    @notifyCss
    <style>
        #laravel-notify,
        #laravel-notify .notify,
        #laravel-notify .notify.fixed,
        .notify-alert,
        .drake-alert,
        .smiley-alert,
        .connectify-alert {
            position: fixed !important;
            z-index: 99999 !important;
            top: 20px !important;
            right: 20px !important;
            left: auto !important;
        }

        #laravel-notify .notify {
            inset: 0 auto auto 0 !important;
            width: auto !important;
            min-width: 420px !important;
        }
    </style>
    <style>
        .f-logo ul.footer-ul li.footer-li {
            width: 100% !important;
        }

        .f-logo,
        .footer-bottom {
            border-top: none !important;
        }
    </style>
    @yield('extracss')

</head>

<body class="home-5">



    <div class="toast d-none ">

        <div class="toast-content">
            <i class="fa fa-check check"></i>

            <div class="message">
                <span class="text text-1">Thank You </span>
                <span class="text text-2">Your data has been saved succesfully!!</span>
            </div>
        </div>
        <i class="fa-solid fa-xmark close"></i>

        <!-- Remove 'active' class, this is just to show in Codepen thumbnail -->
        <div class="progress active"></div>
    </div>

    <!-- modal popup start -->
    <div class="d-none" id="modal_background"
        style="position: fixed; background: rgba(0,0,0,0.5); top: 0; left: 0;width: 100%; height: 100%; z-index: 99;">
    </div>

    <div class="modal-1010">
        <div class="fixed-btn">
            <button id="connectBtn" class="custom-btn">LET'S CONNECT</button>
        </div>
        <div id="enquiry-form" class="popup-modal">
            <div class="popup-content">
                <button type="button" class="close1" onclick="closeModal()" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

                <div class="popup-body">

                    {{-- <div class="img-popup mb-5">
                        <img width="300px" src="{!! asset('assets/image/logo/ranayas-logo.png') !!}" alt="img">
                    </div> --}}
                    <form id="modal-form-ctc" name="modal_contact_form" class="contact-form"
                        action="{{ url('sendmail') }}" method="post">
                        @csrf
                        <input type="text" name="website" style="display:none !important;" tabindex="-1"
                            autocomplete="off">
                        <div class="popup mb-5">
                            <h5 class="modal-title text-center mb-3">
                                Connect Us
                            </h5>
                            <h3>Listen with Ranayas</h3>
                        </div>
                        <div class="custom-form-group">
                            <input type="text" id="form_name" name="form_name" class="custom-input" required />
                            <label for="form_name" class="custom-label">Name:</label>
                        </div>
                        <div class="custom-form-group">
                            <input type="email" id="form_email" name="form_email" class="custom-input" required />
                            <label for="form_email" class="custom-label">Email Address:</label>
                        </div>
                        <div class="custom-form-group">
                            <input type="tel" id="form_number" name="form_phone" class="custom-input"
                                required />
                            <label for="form_number" class="custom-label">Contact Number:</label>
                        </div>
                        <div class="custom-form-group">
                            <input type="text" id="form_message" name="form_message" class="custom-input"
                                required />
                            <label for="form_message" class="custom-label">Message:</label>
                        </div>
                        <div class="contact-section-btn">
                            <button class="custom-submit-btn" id="submit-btn" type="submit">
                                Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- modal popup end -->


    <!-- For social Start here  -->
    <!-- <div class="floating-button" onclick="toggleSocialMenu()">

    </div> -->

    <div class="social-icons">
        <div class="social-icon">
            <!-- <p class="social-title">Phone</p> -->
            <div class="social-phone">
                <a href="tel:+91 9820760951">
                    <svg data-bbox="17.052 7.009 15.938 16.944" width="20" height="30"
                        viewBox="17.052 7.009 15.938 16.944" xmlns="http://www.w3.org/2000/svg">
                        <g fill="#fff">
                            <path
                                d="M21.886 7.46c-.265-.483-.827-.599-1.271-.247l-1.74 1.38c-2.164 1.718-2.44 4.79-.618 6.86l5.96 6.772c1.822 2.07 5.011 2.316 7.13.542l1.313-1.1c.428-.357.444-.946.028-1.322l-2.904-2.63c-.412-.373-1.105-.404-1.54-.076l-1.714 1.296-4.843-5.353 1.743-1.259c.446-.321.595-.97.327-1.457l-1.87-3.406z"
                                fill-rule="evenodd"></path>
                        </g>
                    </svg>
                </a>
            </div>

        </div>
        <!-- <div class="social-icon">
        <div class="social-Whatsaap whatsapp-icon-1">
                <a
                    href="https://wa.me/9820760951?text=Hi%2C%20There%21%0A%0AI%20am%20interested%20in%20exploring%20your%20digital%20offerings%2E">
                    <i class="fa fa-whatsapp whatsapp-icon text-white" aria-hidden="true">

                    </i>
                </a>

            </div>
        </div> -->

    </div>
    <!-- For social Start here  -->


    <!-- header area start -->
    <section class="top-5">
        <!-- header start -->
        <header class="header-area">
            <div class="header-main-area">
                <div class="container container_WidthMas">
                    <div class="row">
                        <div class="col">
                            <div class="header-main">
                                <!-- logo start -->
                                <div class="header-element logo">
                                    <a href="{{ route('index') }}">
                                        <img src="{!! asset('assets/image/logo/ranayas-logo2.jpg') !!}" alt="logo" class="img-fluid">
                                    </a>
                                </div>
                                <!-- logo end -->
                                <!-- menu start -->
                                <div class="menu-area">
                                    <div class="header-element header-menu">
                                        <div class="top-menu">
                                            <div class="header-element megamenu-content">
                                                <div class="mainwrap">
                                                    <ul class="main-menu">
                                                        {{-- <li class="menu-link">
                                                            <a href="{{ route('index') }}" class="link-title">
                                                        <span class="sp-link-title">Home</span>
                                                        </a>
                                                        </li> --}}
                                                        {{-- <li class="menu-link parent">
                                                            <a href="javascript:void(0)" class="link-title">
                                                                <span class="sp-link-title">Collection</span>
                                                                <i class="fa fa-angle-down"></i>
                                                            </a>
                                                            <a href="#collapse-top-banner-menu"
                                                                data-bs-toggle="collapse"
                                                                class="link-title link-title-lg">
                                                                <span class="sp-link-title">Collection</span>
                                                                <i class="fa fa-angle-down"></i>
                                                            </a>
                                                            <ul class="dropdown-submenu banner-menu collapse"
                                                                id="collapse-top-banner-menu">
                                                                <li class="menu-banner">
                                                                    <a href="{{ route('cate', 'namkeens-1') }}"
                                                        class="menu-banner-img"><img src="{!! asset('assets/image/layout-7/banner33.jpg') !!}" alt="menu-image" class="img-fluid"></a>
                                                        <a href="{{ route('cate', 'namkeens-1') }}" class="menu-banner-title"><span>Mens
                                                                Shoes</span></a>
                                                        </li>
                                                        <li class="menu-banner">
                                                            <a href="{{ route('cate', 'namkeens-1') }}" class="menu-banner-img"><img src="{!! asset('assets/image/layout-7/banner34.jpg') !!}" alt="menu-image" class="img-fluid"></a>
                                                            <a href="{{ route('cate', 'namkeens-1') }}" class="menu-banner-title"><span>Women
                                                                    Shoes</span></a>
                                                        </li>
                                                        <li class="menu-banner">
                                                            <a href="{{ route('cate', 'namkeens-1') }}" class="menu-banner-img"><img src="{!! asset('assets/image/layout-7/banner35.jpg') !!}" alt="mneu image" class="img-fluid"></a>
                                                            <a href="{{ route('cate', 'namkeens-1') }}" class="menu-banner-title"><span>Accessories</span></a>
                                                        </li>
                                                    </ul>
                                                    </li> --}}
                                                        {{-- <li class="menu-link parent">
                                                            <a href="javascript:void(0)" class="link-title">
                                                                <span class="sp-link-title">New Arrival</span>
                                                                <i class="fa fa-angle-down"></i>
                                                            </a>
                                                            <a href="#collapse-top-page-menu" data-bs-toggle="collapse"
                                                                class="link-title link-title-lg">
                                                                <span class="sp-link-title">New Arrival</span>
                                                                <i class="fa fa-angle-down"></i>
                                                            </a>
                                                            <ul class="dropdown-submenu sub-menu collapse"
                                                                id="collapse-top-page-menu">
                                                                <li class="submenu-li">
                                                                    <a href="{{ route('cate', 'namkeens-1') }}"
                                                    class="submenu-link">Men</a>
                                                    </li>
                                                    <li class="submenu-li">
                                                        <a href="{{ route('cate', 'namkeens-1') }}" class="submenu-link">Women</a>
                                                    </li>
                                                    </ul>
                                                    </li> --}}
                                                        {!! $dynamiccategoryDesktop !!}
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- menu end -->
                                <!-- header icon start -->
                                <div class="header-element right-block-box">
                                    <ul class="shop-element">
                                        <li class="side-wrap nav-toggler">
                                            <button class="navbar-toggler" type="button" data-toggle="collapse"
                                                data-target="#navbarContent">
                                                <span class="line"></span>
                                            </button>
                                        </li>

                                        {{-- <li class="side-wrap hearing-test-nav">
                                            <a href="{{ route('test.index') }}">Hearing Test</a>
                                        </li> --}}

                                        <li class="side-wrap search-wrap">
                                            <div class="search-rap">
                                                <a href="#search-modal" class="search-popuup"
                                                    data-bs-toggle="modal"><i class="ion-ios-search-strong"></i></a>
                                            </div>
                                        </li>
                                        <li class="side-wrap user-wrap">
                                            <div class="acc-desk">
                                                <div class="user-icon">
                                                    <a href="javascript:void(0)" class="user-icon-desk">
                                                        <span><i class="icon-user"></i></span>
                                                    </a>
                                                </div>
                                                @if (auth('user')->check())
                                                    <div class="user-info">
                                                        <span class="acc-title">
                                                            {{ Str::limit(auth('user')->user()->name, 16, '') }}
                                                        </span>
                                                        <div class="account-login">
                                                            <a href="{{ route('user.dashboard') }}">My Account</a>
                                                            <a href="javascript:void(0)"
                                                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                                                title="Logout">Logout</a>
                                                            <form id="logout-form" action="{{ route('user.logout') }}"
                                                                method="POST" style="display: none;">
                                                                @csrf
                                                            </form>
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="user-info">
                                                        <span class="acc-title">Account</span>
                                                        <div class="account-login">
                                                            <a href="{{ route('user.register') }}">Register</a>
                                                            <a href="javascript:void(0)" data-bs-toggle="modal"
                                                                data-bs-target="#modalLogin">Log in</a>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="acc-mob">
                                                <a href="{{ route('user.dashboard') }}" class="user-icon">
                                                    <span><i class="icon-user"></i></span>
                                                </a>
                                            </div>
                                        </li>
                                        <li class="side-wrap wishlist-wrap">
                                            <a href="{{ route('user.wishlists') }}" class="header-wishlist">
                                                <span class="wishlist-icon"><i class="icon-heart"></i></span>
                                                <span class="wishlist-counter">
                                                    @if (auth('user')->check())
                                                        {{ count(auth('user')->user()->wishlists) }}
                                                    @else
                                                        0
                                                    @endif
                                                </span>
                                            </a>
                                        </li>

                                        <li class="side-wrap cart-wrap">
                                            <div class="shopping-widget">
                                                <div class="shopping-cart">
                                                    <a href="javascript:void(0)" class="cart-count">
                                                        <span class="cart-icon-wrap">
                                                            <span class="cart-icon"><i
                                                                    class="icon-handbag"></i></span>
                                                            <span id="cart-total"
                                                                class="bigcounter">{{ Cart::getContent()->count() }}</span>
                                                        </span>
                                                    </a>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <!-- header icon end -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- header end -->
    </section>
    <!-- header area end -->
    <!-- mobile menu start -->
    <div class="header-bottom-area">
        <div class="main-menu-area">
            <div class="main-navigation navbar-expand-xl">
                <div class="box-header menu-close">
                    <button class="close-box" type="button"><i class="ion-close-round"></i></button>
                </div>
                <div class="navbar-collapse" id="navbarContent">
                    <!-- main-menu start -->
                    <div class="megamenu-content">
                        <div class="mainwrap">
                            <ul class="main-menu">
                                <li class="menu-link">
                                    <a href="{{ route('index') }}" class="link-title">
                                        <span class="sp-link-title">Home</span>
                                    </a>
                                </li>
                                {{-- <li class="menu-link parent">
                                    <a href="javascript:void(0)" class="link-title">
                                        <span class="sp-link-title">Collection</span>
                                        <i class="fa fa-angle-down"></i>
                                    </a>
                                    <a href="#collapse-banner-menu" data-bs-toggle="collapse"
                                        class="link-title link-title-lg">
                                        <span class="sp-link-title">Collection</span>
                                        <i class="fa fa-angle-down"></i>
                                    </a>
                                    <ul class="dropdown-submenu banner-menu collapse" id="collapse-banner-menu">
                                        <li class="menu-banner">
                                            <a href="{{ route('cate', 'namkeens-1') }}" class="menu-banner-img"><img src="{!! asset('assets/image/menu-banner01.jpg') !!}" alt="menu-image" class="img-fluid"></a>
                                <a href="{{ route('cate', 'namkeens-1') }}" class="menu-banner-title"><span>Men
                                        Shoes</span></a>
                                </li>
                                <li class="menu-banner">
                                    <a href="{{ route('cate', 'namkeens-1') }}" class="menu-banner-img"><img src="{!! asset('assets/image/menu-banner02.jpg') !!}" alt="menu-image" class="img-fluid"></a>
                                    <a href="{{ route('cate', 'namkeens-1') }}" class="menu-banner-title"><span>Women
                                            Shoes</span></a>
                                </li>
                                <li class="menu-banner">
                                    <a href="{{ route('cate', 'namkeens-1') }}" class="menu-banner-img"><img src="{!! asset('assets/image/menu-banner03.jpg') !!}" alt="mneu image" class="img-fluid"></a>
                                    <a href="{{ route('cate', 'namkeens-1') }}" class="menu-banner-title"><span>Accessories</span></a>
                                </li>
                            </ul>
                            </li>
                            --}}
                                {!! $dynamiccategoryMobile !!}
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- mobile menu end -->
    <!-- mini cart start -->
    <div class="mini-cart">
        <a href="javascript:void(0)" class="shopping-cart-close"><i class="ion-close-round"></i></a>
        @if (Cart::isEmpty())
            <div class="cart-item-title">
                <p>
                    <span class="cart-count-item bigcounter">Your cart is empty... You can add some product from <a
                            href="/search">here</a></span>
                </p>
            </div>
        @else
            <div class="cart-item-title">
                <p>
                    <span class="cart-count-desc">There are</span>
                    <span class="cart-count-item bigcounter">{{ Cart::getContent()->count() }}</span>
                    <span class="cart-count-desc">Products</span>
                </p>
            </div>
        @endif
        <ul class="cart-item-loop">
            @foreach (Cart::getcontent() as $item)
                <li class="cart-item">
                    <div class="cart-img">
                        <a href="{{ route('product', $item->attributes->slug_url) }}">
                            <img src="{!! asset('storage/images/products/' . $item->attributes->image_url) !!}" alt="cart-image" class="img-fluid">
                        </a>
                    </div>
                    <div class="cart-title">
                        <h6><a href="{{ route('product', $item->attributes->slug_url) }}">{{ $item->name }}</a>
                        </h6>
                        <div class="cart-pro-info">
                            <div class="cart-qty-price">
                                <span class="quantity">{{ $item->quantity }} x </span>
                                <span class="price-box"><i class="fa fa-inr"></i> {{ $item->price }}</span>
                            </div>
                            <div class="delete-item-cart">
                                <a href="javascript:void(0)" class="btn-remove-item"
                                    data-remove-id="{{ $item->id }}"><i class="icon-trash icons"></i></a>
                            </div>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
        @if (!Cart::isEmpty())
            <ul class="subtotal-title-area">
                <li class="subtotal-info">
                    <div class="subtotal-titles">
                        <h6>Sub total:</h6>
                        <span class="subtotal-price"><i class="fa fa-inr"></i> {{ Cart::getTotal() }}</span>
                    </div>
                </li>
                <li class="mini-cart-btns">
                    <div class="cart-btns">
                        <a href="{{ route('cart') }}" class="btn btn-style1">View cart</a>
                        <a href="{{ route('checkout') }}" class="btn btn-style1">checkout</a>
                    </div>
                </li>
            </ul>
        @endif
    </div>
    <!-- mini cart end -->
    <!-- search start -->
    <div class="search-model">
        <div class="modal fade" id="search-modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="container">
                            <div class="row">
                                <div class="col">
                                    <form action="{{ route('search') }}" method="GET"
                                        class="searchform searchform-3">
                                        <div class="search-content">
                                            <div class="search-engine">
                                                <input name="q" type="text" value="{{ Request::get('q') }}"
                                                    id="search-box" class="searchform__input"
                                                    autocomplete="off" placeholder="Search by product, category..." />
                                                <button class="search-btn" type="submit"><i
                                                        class="ion-ios-search-strong"></i></button>
                                                <div id="custom-suggestion-box"></div>
                                            </div>
                                            <button type="button" class="close" data-bs-dismiss="modal"
                                                aria-label="Close"><i class="ion-close-round"></i></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- search start -->

    @yield('content')

    <!-- footer start -->
    <section class="footer5">
        <div class="section-tb-padding footer-bg">
            <div class="container container_WidthMas1">
                <div class="row">
                    <div class="col">
                        {{-- <div class="news-5">
                            <style>
                                .news-content h2 {
                                    padding-top: 25px;
                                }
                            </style>
                            <div class="news-content">
                                <h2>Get the latest deals</h2>
                            </div>
                            <form>
                                <input type="text" name="email" placeholder="Enter Your Email Address">
                                <a href="javascript:void(0)" class="btn btn-style1"><i
                                        class="ion-paper-airplane"></i></a>
                            </form>
                        </div> --}}
                        <div class="home5-footer">
                            <div class="f-logo">
                                <ul class="footer-ul">
                                    <li class="footer-li footer-logo">
                                        <a href="{{ route('index') }}">
                                            <img class="img-fluid" src="{!! asset('assets/image/logo/ranayas-logo.png') !!}" alt="">
                                        </a>
                                    </li>
                                    <li class="footer-li footer-contact">
                                        <ul class="f-ul-li-ul">
                                            <li class="footer-icon">
                                                <i class="ion-ios-telephone"></i>
                                            </li>
                                            <li class="footer-info">
                                                <a href="tel:+91 9820760951"> +91 9820760951</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="footer-li footer-contact">
                                        <ul class="f-ul-li-ul">
                                            <li class="footer-icon">
                                                <i class="ion-ios-email"></i>
                                            </li>
                                            <li class="footer-info">
                                                <a href="mailto: info@ranayas.com">
                                                    info@ranayas.com</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="footer-li footer-contact footer-map">
                                        <ul class="f-ul-li-ul">
                                            <li class="footer-icon">
                                                <i class="ion-ios-location"></i>
                                            </li>
                                            <li class="footer-info">
                                                <span> Ranayas
                                                </span>
                                                <span>
                                                    kandivali west, Mumbai, India, Maharashtra
                                                </span>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                            <div class="footer-bottom">
                                <div class="footer-link" id="footer-accordian">
                                    <div class="f-link">
                                        <h2 class="h-footer">Top categories</h2>
                                        <a href="#t-cate" data-bs-toggle="collapse" class="h-footer">
                                            <span>Top categories</span>
                                            <i class="fa fa-angle-down"></i>
                                        </a>
                                        <ul class="f-link-ul collapse" id="t-cate"
                                            data-bs-parent="#footer-accordian">
                                            @foreach ($footerDynamicCategory as $cat)
                                                <li class="f-link-ul-li">
                                                    <a
                                                        href="{{ route('cate', $cat->slug_url) }}">{{ $cat->name }}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    <div class="f-link">
                                        <h2 class="h-footer">Services</h2>
                                        <a href="#services" data-bs-toggle="collapse" class="h-footer">
                                            <span>Services</span>
                                            <i class="fa fa-angle-down"></i>
                                        </a>
                                        <ul class="f-link-ul collapse" id="services"
                                            data-bs-parent="#footer-accordian">
                                            <li class="f-link-ul-li"><a href="{{ route('about') }}">About</a></li>
                                            <li class="f-link-ul-li"><a href="{{ route('faq') }}">Faq's</a></li>
                                            <li class="f-link-ul-li"><a href="{{ route('contact') }}">Contact us</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="f-link">
                                        <h2 class="h-footer">Privacy & terms</h2>
                                        <a href="#privacy" data-bs-toggle="collapse" class="h-footer">
                                            <span>Privacy & terms</span>
                                            <i class="fa fa-angle-down"></i>
                                        </a>
                                        <ul class="f-link-ul collapse" id="privacy"
                                            data-bs-parent="#footer-accordian">
                                            <li class="f-link-ul-li"><a href="{{ route('terms-condition') }}">Terms &
                                                    conditions</a>
                                            </li>
                                            <li class="f-link-ul-li"><a href="{{ route('privacy') }}">Privacy
                                                    policy</a>
                                            </li>
                                            <li class="f-link-ul-li"><a href="{{ route('refund-return') }}">Return
                                                    policy</a>
                                            </li>
                                            <li class="f-link-ul-li"><a href="{{ route('shipping') }}">Shipping
                                                    policy</a>
                                            </li>
                                            <li class="f-link-ul-li"><a
                                                    href="{{ route('cancellation') }}">Cancellation
                                                    policy</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="f-link">
                                        <h2 class="h-footer">My account</h2>
                                        <a href="#services1" data-bs-toggle="collapse" class="h-footer">
                                            <span>My account</span>
                                            <i class="fa fa-angle-down"></i>
                                        </a>
                                        <ul class="f-link-ul collapse" id="services1"
                                            data-bs-parent="#footer-accordian">
                                            <li class="f-link-ul-li">
                                                @if (auth('user')->check())
                                                    <a href="{{ route('user.dashboard') }}">My Account</a>
                                                @else
                                                    <a href="javascript:void(0)" data-bs-toggle="modal"
                                                        data-bs-target="#modalLogin">My Account</a>
                                                @endif
                                            </li>
                                            <li class="f-link-ul-li">
                                                @if (auth('user')->check())
                                                    <a href="{{ route('user.showOrder') }}">My Orders</a>
                                                @else
                                                    <a href="javascript:void(0)" data-bs-toggle="modal"
                                                        data-bs-target="#modalLogin">My Orders</a>
                                                @endif
                                            </li>
                                            <li class="f-link-ul-li">
                                                @if (auth('user')->check())
                                                    <a href="{{ route('user.wishlists') }}">My Wishlists</a>
                                                @else
                                                    <a href="javascript:void(0)" data-bs-toggle="modal"
                                                        data-bs-target="#modalLogin">My Wishlists</a>
                                                @endif
                                            </li>
                                            <li class="f-link-ul-li">
                                                @if (auth('user')->check())
                                                    <a href="{{ route('user.addresses') }}">My Address</a>
                                                @else
                                                    <a href="javascript:void(0)" data-bs-toggle="modal"
                                                        data-bs-target="#modalLogin">My Address</a>
                                                @endif
                                            </li>
                                        </ul>
                                    </div>

                                    <!-- <div class="f-link elf-F_Link">
                                   <a href="https://wa.me/9820760951">    <img src="{!! asset('assets/image/elf.png') !!}" alt="">
                                   </a>
                                    </div> -->

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- footer end -->
    <!-- copyright start -->
    <section class="footer-copyright">
        <div class="container container_WidthMas1">
            <div class="row">
                <div class="col">
                    <ul class="f-bottom">
                        <li class="f-c f-copyright">
                            <p>Copyright <i class="fa fa-copyright"></i> 2026 <a style="color:white;" href="https://ranayas.com/"> Ranayas</a> - All Rights Reserved.</p>
                        </li>
                        <li class="f-c">
                            <ul class="f-bottom">
                                <li class="f-social">
                                    <a href="https://wa.me/9820760951" class="f-icn-link"><i
                                            class="fa fa-whatsapp"></i></a>
                                    <a href="https://www.facebook.com/ranayas2016" class="f-icn-link"><i
                                            class="fa fa-facebook-f"></i></a>
                                    <a href="https://twitter.com/" class="f-icn-link"><i
                                            class="fa fa-twitter"></i></a>
                                    <a href="https://www.instagram.com/ranayas2016/" class="f-icn-link"><i
                                            class="fa fa-instagram"></i></a>
                                    <a href="https://www.pinterest.com/" class="f-icn-link"><i
                                            class="fa fa-pinterest-p"></i></a>
                                    <a href="https://www.youtube.com/" class="f-icn-link"><i
                                            class="fa fa-youtube"></i></a>
                                </li>
                            </ul>
                        </li>
                        {{-- <li class="f-c f-payment">
                            <a href="javascript:void(0)"><img src="{!! asset('assets/image/payment.png') !!}" class="img-fluid"
                                    alt="payment image"></a>
                        </li> --}}
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="modalLogin" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h6>Login</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <!-- Modal body -->
                <div class="modal-body p-0">
                    <div class="signUp-page signUp-minimal p-0">
                        <div class="signin-form-wrapper border-0">
                            <!-- <div class="title-area text-center">
                                    <h3>Login.</h3>
                                </div>  -->
                            <!-- OTP Flow -->
                            <div class="text-center mb-3">
                                <h6>Login With OTP</h6>
                            </div>
                            <div id="otp-flow-container">
                                <form id="otp-request-form" class="login" action="{{ route('user.login.otp') }}" method="POST" autocomplete="off">
                                    @csrf
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="input-group mb-0">
                                                <input type="number" name="mobile" id="otp-mobile-input" required />
                                                <label>Enter 10 digit Mobile Number <span style="color:red">*</span></label>
                                            </div>
                                            <span class="text-danger" style="font-size: 13px; margin-bottom: 15px; display: block;" id="otp-request-error"></span>
                                        </div>
                                    </div>
                                    <button type="submit" class="line-button-one button-rose mt-1 w-100" id="btn-request-otp">
                                        Next
                                    </button>
                                </form>

                                <form id="otp-verify-form" class="login d-none" action="{{ route('user.otp.verify') }}" method="POST" autocomplete="off">
                                    @csrf
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="input-group mb-0">
                                                <input type="number" name="otp" id="otp-input" required />
                                                <label>Enter OTP <span style="color:red">*</span></label>
                                            </div>
                                            <span class="text-danger" style="font-size: 13px; margin-bottom: 15px; display: block;" id="otp-verify-error"></span>
                                        </div>
                                    </div>
                                    <button type="submit" class="line-button-one button-rose mt-1 w-100" id="btn-verify-otp">
                                        Verify & Login
                                    </button>
                                </form>
                            </div>

                            <p class="or-text mt-4 mb-4"><span>or</span></p>

                            <style>
                                .login-with-email-btn {
                                    border-radius: 5px !important;
                                    color: var(--theme-color) !important;
                                }
                                .login-with-email-btn:hover {
                                    color: #fff !important;
                                }
                            </style>
                            <div class="row m-0 p-0">
                                <div class="col-12 p-0">
                                    <a href="{{ route('user.login') }}" class="line-button-one button-rose mt-1 w-100 login-with-email-btn" style="display: block; text-align: center;"><i class="fa fa-envelope" aria-hidden="true"></i> Login with Email</a>
                                </div>
                            </div>

                            <ul class="social-icon-wrapper row m-0 mb-4 p-0">
                                <li class="col-12 p-0">
                                    <a href="{{ route('user.auth.socialite', 'google') }}" class="gmail w-100" style="width: 100%; display: block;"><i class="fa fa-google" aria-hidden="true" style="font-size: 14px; margin-right: 6px;"></i> Login with Google</a>
                                </li>
                            </ul>

                            <p class="signUp-text text-center mt-3">
                                Don’t have any account?
                                <a href="{{ route('user.register') }}">Register</a> now.
                            </p>
                        </div>
                        <!-- /.sign-up-form-wrapper -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('frontend.forms')
    <!-- copyright end -->
    <a href="javascript:void(0)" class="scroll" id="top">
        <span><i class="fa fa-angle-double-up"></i></span>
    </a>
    <!-- back to top end -->
    <div class="mm-fullscreen-bg"></div>

    <!-- jquery -->
    <script src="{!! asset('assets/js/modernizr-2.8.3.min.js') !!}"></script>
    <script src="{!! asset('assets/js/jquery-3.6.0.min.js') !!}"></script>
    <!-- bootstrap -->
    <script src="{!! asset('assets/js/bootstrap.min.js') !!}"></script>
    <!-- popper -->
    <script src="{!! asset('assets/js/popper.min.js') !!}"></script>
    <!-- fontawesome -->
    <script src="{!! asset('assets/js/fontawesome.min.js') !!}"></script>
    <!-- owl carousal -->
    <script src="{!! asset('assets/js/owl.carousel.min.js') !!}"></script>
    <!-- swiper -->
    <script src="{!! asset('assets/js/swiper.min.js') !!}"></script>
    <!-- custom -->
    <script src="{!! asset('assets/js/imagesloaded.pkgd.min.js') !!}"></script>
    <script src="{!! asset('assets/js/jquery.isotope.min.js') !!}"></script>
    <script src="{!! asset('assets/js/jquery.validate.min.js') !!}"></script>
    <script src="{!! asset('assets/js/custom.js') !!}"></script>
    <script src="{!! asset('assets/js/main.js') !!}"></script>
    @yield('extrajs')

    <script>
        $(document).ready(function() {
            $('#otp-request-form').on('submit', function(e) {
                e.preventDefault();
                var $form = $(this);
                var $btn = $('#btn-request-otp');
                var mobile = $('#otp-mobile-input').val();
                $('#otp-request-error').text('');

                if(!mobile || mobile.length !== 10) {
                    $('#otp-request-error').text('Please enter a valid 10-digit mobile number.');
                    return;
                }

                $btn.prop('disabled', true).html('<span class="fa fa-spinner fa-spin"></span> Loading...');

                $.ajax({
                    url: $form.attr('action'),
                    type: 'POST',
                    data: $form.serialize(),
                    headers: { 'X-Requested-With': 'XMLHttpRequest' },
                    success: function(response) {
                        if (response.success) {
                            $form.addClass('d-none');
                            $('#otp-verify-form').removeClass('d-none');
                        } else {
                            $('#otp-request-error').text(response.message || 'Something went wrong.');
                        }
                    },
                    error: function(xhr) {
                        $('#otp-request-error').text('An error occurred. Please try again.');
                    },
                    complete: function() {
                        $btn.prop('disabled', false).text('Next');
                    }
                });
            });

            $('#otp-verify-form').on('submit', function(e) {
                e.preventDefault();
                var $form = $(this);
                var $btn = $('#btn-verify-otp');
                var otp = $('#otp-input').val();
                $('#otp-verify-error').text('');

                if(!otp) {
                    $('#otp-verify-error').text('Please enter OTP.');
                    return;
                }

                $btn.prop('disabled', true).html('<span class="fa fa-spinner fa-spin"></span> Verifying...');

                $.ajax({
                    url: $form.attr('action'),
                    type: 'POST',
                    data: $form.serialize(),
                    headers: { 'X-Requested-With': 'XMLHttpRequest' },
                    success: function(response) {
                        if (response.success) {
                            window.location.href = response.redirect;
                        } else {
                            $('#otp-verify-error').text(response.message || 'Invalid OTP.');
                        }
                    },
                    error: function(xhr) {
                        $('#otp-verify-error').text('An error occurred. Please try again.');
                    },
                    complete: function() {
                        $btn.prop('disabled', false).text('Verify & Login');
                    }
                });
            });
            
            $('#modalLogin').on('hidden.bs.modal', function () {
                $('#otp-request-form').removeClass('d-none');
                $('#otp-verify-form').addClass('d-none');
                $('#otp-request-form')[0].reset();
                $('#otp-verify-form')[0].reset();
                $('#otp-request-error').text('');
                $('#otp-verify-error').text('');
            });
        });
    </script>

    <!-- AlpineJS for laravel-notify -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @include('notify::components.notify')
    @notifyJs
    <script>
        toast = document.querySelector(".toast");
        (closeIcon = document.querySelector(".close")),
        (progress = document.querySelector(".progress"));

        if (toast && closeIcon && progress) {
            let timer1, timer2;

            timer1 = setTimeout(() => {
                toast.classList.remove("active");
            }, 5000); //1s = 1000 milliseconds

            timer2 = setTimeout(() => {
                progress.classList.remove("active");
            }, 5300);

            closeIcon.addEventListener("click", () => {
                toast.classList.remove("active");
                setTimeout(() => {
                    progress.classList.remove("active");
                }, 300);
                clearTimeout(timer1);
                clearTimeout(timer2);
            });

            if (sessionStorage.getItem("test_question") != null) {
                console.warn('i m here', sessionStorage.getItem("test_question"));
                toast.classList.add("active");
                toast.classList.remove("d-none");
                progress.classList.add("active");
            }
        }

        sessionStorage.removeItem("test_question");
    </script>


    <!-- Modal and Social Media  -->
    <script>
        var connectBtn = document.getElementById('connectBtn');
        var modal = document.getElementById('enquiry-form');
        var modalBackground = document.getElementById('modal_background');

        connectBtn.addEventListener('click', function() {
            modal.style.display = 'block';
            modalBackground.classList.remove('d-none');
        });

        modalBackground.addEventListener('click', function(event) {
            if (event.target === modalBackground) {
                closeModal();
            }
        });

        function closeModal() {
            modal.style.display = 'none';
            modalBackground.classList.add('d-none');
        }

        function toggleSocialMenu() {
            var socialIcons = document.querySelector('.social-icons');
            socialIcons.style.display = (socialIcons.style.display === 'block') ? 'none' : 'block';
        }
    </script>

    <!-- Custom Search JS - Luxury Implementation -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchBox = document.getElementById('search-box');
            const suggestionBox = document.getElementById('custom-suggestion-box');
            const keywords = {!! json_encode($keywords->pluck('keyword')) !!};

            function showSuggestions(list, title = "Search Results") {
                if (list.length > 0) {
                    suggestionBox.innerHTML = `
                        <div class="suggestion-group-title">${title}</div>
                        ${list.map(k => `
                            <div class="suggestion-item">
                                <i class="fa fa-search"></i>
                                ${k}
                            </div>
                        `).join('')}
                    `;
                    suggestionBox.classList.add('active');
                } else {
                    suggestionBox.classList.remove('active');
                }
            }

            searchBox.addEventListener('input', function() {
                const query = this.value.toLowerCase().trim();
                if (query.length > 0) {
                    const filtered = keywords.filter(k => k && k.toLowerCase().includes(query)).slice(0, 8);
                    showSuggestions(filtered, "Suggested Keywords");
                } else {
                    // Show top trending when empty
                    showSuggestions(keywords.slice(0, 5), "Trending Searches");
                }
            });

            // Focus handling
            searchBox.addEventListener('focus', function() {
                if (this.value.length === 0) {
                    showSuggestions(keywords.slice(0, 5), "Trending Searches");
                } else {
                    searchBox.dispatchEvent(new Event('input'));
                }
            });

            // Click on suggestion
            suggestionBox.addEventListener('click', function(e) {
                const item = e.target.closest('.suggestion-item');
                if (item) {
                    searchBox.value = item.innerText.trim();
                    suggestionBox.classList.remove('active');
                    setTimeout(() => {
                        searchBox.form.submit();
                    }, 100);
                }
            });

            // Close on outside click
            document.addEventListener('click', function(e) {
                if (!searchBox.contains(e.target) && !suggestionBox.contains(e.target)) {
                    suggestionBox.classList.remove('active');
                }
            });

            // Modal handling
            const searchModal = document.getElementById('search-modal');
            if (searchModal) {
                searchModal.addEventListener('shown.bs.modal', function() {
                    searchBox.focus();
                });
                searchModal.addEventListener('hidden.bs.modal', function() {
                    suggestionBox.classList.remove('active');
                });
            }
        });
    </script>

</body>


</html>
