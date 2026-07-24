@extends('layouts.master')
@section('title', 'Home')
@section('extracss')
    <style>
        .service-box i {
            /* color: #e36542; */
            color: #fcca2f;
        }
        .home5-service .service .service-box .s-box .homepage-rupee-icon {
            width: 38px;
            height: 38px;
            margin-right: 15px;
            color: #7423b6;
            transition: all 0.3s ease-in-out;
            vertical-align: middle;
        }
        .home5-service .service .service-box .s-box:hover .homepage-rupee-icon {
            transform: rotateY(180deg);
        }

        .home5-featured .owl-carousel .owl-stage>div>div {
            padding: 0px !important;
        }
        .home5-featured.section-b-padding.featured-products .owl-item .items {
            padding: 0px !important;
        }

        .featured5-pro .caption.caption-9 {
            padding-left: 15px !important;
            padding-right: 15px !important;
            padding-bottom: 15px !important;
        }
        .featured5-pro .caption.caption-9 h3.title {
            margin-left: 0 !important;
            padding-left: 0 !important;
        }

        @media (max-width: 767px) {
            /* Reduce page outer container padding to let carousel stretch wider */
            .featured-products .container {
                padding-left: 10px !important;
                padding-right: 10px !important;
            }

            /* Adjust margins and paddings for mobile display */
            .featured5-pro.owl-carousel .owl-stage-outer {
                padding: 10px 0 !important;
            }
            .featured5-pro.owl-carousel .owl-item {
                padding: 0 4px !important;
            }
            
            /* Add 4px padding-left/right and 10px padding-bottom to caption-9 */
            .featured5-pro .caption.caption-9 {
                padding-left: 4px !important;
                padding-right: 4px !important;
                padding-bottom: 10px !important;
            }
            
            /* Left-align titles and remove padding/margins */
            .featured5-pro .caption-9 h3.title {
                margin: 2px 0 !important;
                padding: 0 !important;
                display: block !important;
                text-align: left !important;
            }
            .featured5-pro .caption-9 h3.title span.pull-left {
                float: none !important;
                display: block !important;
                width: 100% !important;
                text-align: left !important;
            }
            .featured5-pro .caption-9 h3.title span.pull-left a {
                font-size: 11px !important;
                line-height: 1.2 !important;
                display: block !important;
                white-space: nowrap !important;
                overflow: hidden !important;
                text-overflow: ellipsis !important;
                text-align: left !important;
            }

            /* Price and rating alignment left-aligned on mobile */
            .featured5-pro .caption-9 .price-star {
                display: flex !important;
                flex-direction: row !important;
                align-items: center !important;
                justify-content: flex-start !important;
                text-align: left !important;
                margin-top: 2px !important;
            }
            .featured5-pro .caption-9 .price-star .rating {
                display: none !important; /* Hide rating stars on mobile to avoid overcrowding */
            }
            .featured5-pro .caption-9 .price-star .pro-price {
                float: none !important;
                display: flex !important;
                align-items: center !important;
                justify-content: flex-start !important;
                gap: 4px !important;
            }
            .featured5-pro .caption-9 .price-star .pro-price span.new-price {
                font-size: 11px !important;
                font-weight: 600 !important;
            }
            .featured5-pro .caption-9 .price-star .pro-price span.new-price i.fa-inr {
                font-size: 11px !important;
            }
            .featured5-pro .caption-9 .price-star .pro-price span.old-price del {
                font-size: 9px !important;
            }
            .featured5-pro .caption-9 .price-star .pro-price span.old-price i.fa-inr,
            .featured5-pro .caption-9 .price-star .pro-price span.old-price del i.fa-inr {
                font-size: 9px !important;
            }

            /* Labels and discount badges */
            .featured5-pro .tred-pro .Pro-lable {
                top: 5px !important;
                left: 5px !important;
                display: flex !important;
                flex-direction: column !important;
                gap: 2px !important;
            }
            .featured5-pro .tred-pro .Pro-lable span {
                font-size: 8px !important;
                padding: 1px 3px !important;
                line-height: 1 !important;
            }

            /* Hide color dots, wishlist, cart, and eye icons on mobile */
            .featured5-pro .tred-pro .pro-icn {
                display: none !important;
            }
            .featured5-pro .caption-9 h3.title span.product-colors {
                display: none !important;
            }
        }

        @media (max-width: 575px) {
            .featured5-pro .caption-9 .price-star {
                padding: 0 !important;
                margin: 0 !important;
            }
            .featured5-pro .caption-9 .pro-price {
                margin: 4px !important;
            }
            .home5-featured.section-b-padding.featured-products .owl-item .items {
                margin: 0 !important;
            }

            /* Display service strip as 2x2 grid on mobile */
            .home5-service .service {
                display: flex !important;
                flex-wrap: wrap !important;
                border: none !important;
                overflow: visible !important;
            }
            .home5-service .service .service-box {
                width: 50% !important;
            }
            .home5-service .service .service-box .s-box {
                width: 100% !important;
                padding: 12px 6px !important;
                border: 0.5px dashed #dedede !important;
                justify-content: flex-start !important;
                height: 100% !important;
            }
            .home5-service .service .service-box .s-box i,
            .home5-service .service .service-box .s-box svg {
                font-size: 18px !important;
                width: 18px !important;
                height: 18px !important;
                margin-right: 6px !important;
                flex-shrink: 0 !important;
            }
            .home5-service .service .service-box .s-box .service-content {
                white-space: normal !important;
                text-align: left !important;
            }
            .home5-service .service .service-box .s-box .service-content span {
                display: block !important;
                font-size: 10.5px !important;
                font-weight: 600 !important;
                line-height: 1.2 !important;
            }
            .home5-service .service .service-box .s-box .service-content p {
                font-size: 9.5px !important;
                margin-top: 2px !important;
                line-height: 1.2 !important;
            }

            /* Alternate background and text colors on mobile (purple/yellow, then yellow/purple) */
            .home5-service .service .service-box:nth-child(3) {
                background-color: rgb(252 202 47) !important; /* Yellow */
            }
            .home5-service .service .service-box:nth-child(3) .s-box i,
            .home5-service .service .service-box:nth-child(3) .s-box svg {
                color: #7423b6 !important; /* Purple Icon */
            }
            .home5-service .service .service-box:nth-child(3) .s-box .service-content span,
            .home5-service .service .service-box:nth-child(3) .s-box .service-content p {
                color: #333355 !important; /* Dark Text */
            }

            .home5-service .service .service-box:nth-child(4) {
                background-color: #7423b6 !important; /* Purple */
            }
            .home5-service .service .service-box:nth-child(4) .s-box i,
            .home5-service .service .service-box:nth-child(4) .s-box svg {
                color: #ffffff !important; /* White Icon */
            }
            .home5-service .service .service-box:nth-child(4) .s-box .service-content span,
            .home5-service .service .service-box:nth-child(4) .s-box .service-content p {
                color: white !important; /* White Text */
            }
        }

        @media (max-width: 1199px) {
            .home5-cate-image .cate-image {
                width: 100% !important;
                height: auto !important;
                padding: 8px !important;
            }
            .home5-cate-image .items {
                padding: 5px !important;
                margin: 0 !important;
            }
            .home5-cate-image .cate-image a img {
                width: 100% !important;
                height: auto !important;
                aspect-ratio: 1 / 1 !important;
                object-fit: cover !important;
            }
        }

        @media (max-width: 767px) {
            /* Remove circle effect and show full rectangular image on screens <= 767px */
            .home5-cate-image .cate-image a img,
            .home5-cate-image .cate-image:hover img {
                border-radius: 0% !important;
            }
        }
    </style>
@endsection
@section('content')
    <!--home page slider start-->
    <style>
        .banner-slider-section {
            width: 100%;
            overflow: hidden;
            position: relative;
            padding: 0;
            margin: 0;
        }
        .banner-slider-section .home5-slider,
        .banner-slider-section .swiper-wrapper,
        .banner-slider-section .swiper-slide {
            height: auto !important;
        }
        .banner-slide-item {
            position: relative;
            width: 100%;
            display: block;
        }
        .banner-slide-img {
            width: 100% !important;
            height: auto !important;
            display: block !important;
            object-fit: cover;
        }
        .home-slider-5 .home-slider-main-5 .home5-slider .img-back {
            height: auto !important;
        }
        .banner-full-link {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 4;
        }
        .banner-overlay-content {
            position: absolute;
            z-index: 5;
            max-width: 50%;
            padding: 15px;
            pointer-events: auto;
        }
        .banner-overlay-content .banner-title {
            font-size: 52px;
            font-weight: 700;
            line-height: 1.2;
            margin-bottom: 10px;
            color: #222222;
        }
        .banner-overlay-content .banner-subtitle {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 8px;
            color: var(--theme-color, #702c89);
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .banner-overlay-content .banner-description {
            font-size: 20px;
            line-height: 1.5;
            margin-bottom: 15px;
            color: #444444;
        }
        .banner-overlay-content .banner-btn {
            display: inline-block;
            padding: 10px 12px;
            background-color: var(--theme-color, #702c89);
            color: #ffffff !important;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 4px 10px rgba(0,0,0,0.15);
        }
        .banner-overlay-content .banner-btn:hover {
            background-color: #58216c;
            color: #ffffff !important;
        }
        /* Positions */
        .banner-overlay-content.pos-center-left { top: 50%; left: 8%; transform: translateY(-50%); }
        .banner-overlay-content.pos-center { top: 50%; left: 50%; transform: translate(-50%, -50%); }
        .banner-overlay-content.pos-center-right { top: 50%; right: 8%; transform: translateY(-50%); }
        .banner-overlay-content.pos-top-left { top: 10%; left: 8%; }
        .banner-overlay-content.pos-top-center { top: 10%; left: 50%; transform: translateX(-50%); }
        .banner-overlay-content.pos-top-right { top: 10%; right: 8%; }
        .banner-overlay-content.pos-bottom-left { bottom: 10%; left: 8%; }
        .banner-overlay-content.pos-bottom-center { bottom: 10%; left: 50%; transform: translateX(-50%); }
        .banner-overlay-content.pos-bottom-right { bottom: 10%; right: 8%; }

        @media (max-width: 767px) {
            .banner-slide-img {
                width: 100% !important;
                height: auto !important;
                object-fit: contain;
            }
            .banner-overlay-content {
                max-width: 85%;
                padding: 8px;
            }
            .banner-overlay-content .banner-title {
                font-size: 20px;
                margin-bottom: 4px;
            }
            .banner-overlay-content .banner-subtitle {
                font-size: 12px;
                margin-bottom: 4px;
            }
            .banner-overlay-content .banner-description {
                font-size: 11px;
                margin-bottom: 8px;
                display: -webkit-box;
                -webkit-line-clamp: 2;
                -webkit-box-orient: vertical;
                overflow: hidden;
            }
            .banner-overlay-content .banner-btn {
                padding: 5px 12px;
                font-size: 12px;
            }
        }
    </style>
    <section class="home-slider-5 banner-slider-section">
        <div class="home-slider-main-5">
            <div class="home5-slider swiper-container">
                <div class="swiper-wrapper">
                    @foreach ($sliders as $slider)
                        <div class="swiper-slide">
                            <div class="banner-slide-item">
                                @if(empty($slider->button_text) && !empty($slider->url))
                                    <a href="{{ $slider->url }}" class="d-block w-100 banner-img-link">
                                        <picture class="w-100 d-block">
                                            <source media="(max-width: 767px)" srcset="{!! $slider->mobile_image_url !!}">
                                            <img src="{!! $slider->desktop_image_url !!}" alt="{{ $slider->title ?? 'Banner' }}" class="banner-slide-img">
                                        </picture>
                                    </a>
                                @else
                                    <picture class="w-100 d-block">
                                        <source media="(max-width: 767px)" srcset="{!! $slider->mobile_image_url !!}">
                                        <img src="{!! $slider->desktop_image_url !!}" alt="{{ $slider->title ?? 'Banner' }}" class="banner-slide-img">
                                    </picture>
                                @endif

                                @if(!empty($slider->title) || !empty($slider->subtitle) || !empty($slider->description) || !empty($slider->button_text))
                                    @php
                                        $posClass = 'pos-' . ($slider->content_position ?? 'center-left');
                                        $alignClass = 'text-' . ($slider->text_align ?? 'left');
                                    @endphp
                                    <div class="banner-overlay-content {{ $posClass }} {{ $alignClass }}">
                                        @if(!empty($slider->subtitle)) <h3 class="banner-subtitle">{{ $slider->subtitle }}</h3> @endif
                                        @if(!empty($slider->title)) <h1 class="banner-title">{{ $slider->title }}</h1> @endif
                                        @if(!empty($slider->description)) <p class="banner-description">{{ $slider->description }}</p> @endif
                                        @if(!empty($slider->button_text))
                                            <a href="{{ $slider->url ? $slider->url : 'javascript:void(0)' }}" class="btn banner-btn">
                                                {{ $slider->button_text }}
                                            </a>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
                @if(count($sliders) > 1)
                    <div class="swiper-buttons d-none d-md-block">
                        <button class="swiper-prev"><i class="fa fa-angle-left"></i></button>
                        <button class="swiper-next"><i class="fa fa-angle-right"></i></button>
                    </div>
                    <div class="swiper-pagination"><span></span></div>
                @endif
            </div>
        </div>
    </section>
    <!--home page slider end-->

    <!-- service start -->
    <section class="home5-service section-tb-padding">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="service">
                        <div class="service-box">
                            <div class="s-box">
                                <i class="ti-truck"></i>
                                <div class="service-content">
                                    <span class="text--1">100% Original Products</span>
                                    <p class="text--1">Free Delivery On Product</p>
                                </div>
                            </div>
                        </div>
                        <div class="service-box">
                            <div class="s-box">
                                <svg class="homepage-rupee-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M6 3h12"></path>
                                    <path d="M6 8h12"></path>
                                    <path d="m6 13 8.5 8"></path>
                                    <path d="M6 13h3"></path>
                                    <path d="M9 13c6.667 0 6.667-10 0-10"></path>
                                </svg>
                                <div class="service-content">
                                    <span class="text--2">Return and Refund</span>
                                    <p class="text--2">Money Back Guarantee</p>
                                </div>
                            </div>
                        </div>
                        <div class="service-box">
                            <div class="s-box">
                                <i class="ti-headphone"></i>
                                <div class="service-content">
                                    <span class="text--1">Secure Transaction</span>
                                    <p class="text--1">Top Brands</p>
                                </div>
                            </div>
                        </div>
                        <div class="service-box">
                            <div class="s-box">
                                <i class="ti-email"></i>
                                <div class="service-content">
                                    <span class="text--2">Warranty Policy</span>
                                    <p class="text--2">100% Assured Support</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- service end -->


    <!-- category image strat -->
    <section class="home5-category section-t-padding section-b-padding ">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="section-title">
                        <h2>Shop by category</h2>
                    </div>
                    <div class="home5-cate-image owl-carousel owl-theme">
                        @foreach ($categories as $item)
                            <div class="items">
                                <div class="cate-image">
                                    <a href="{{ route('cate', $item->slug_url) }}">
                                        <img src="{!! asset('storage/images/categories/' . $item->image_url) !!}" alt="{{ $item->name }}" class="img-fluid">
                                    </a>
                                    <span>{{ $item->name }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- category image end -->



    
    <style>
        /* ==========================================================================
        Custom Banner Slider (Clickable Banner Only)
        ========================================================================== */
        .banner-slider-sec {
            position: relative;
            width: 100%;
            overflow: hidden;
        }

        .banner-slide-link {
            position: relative;
            display: block;
            width: 100%;
            overflow: hidden;
        }

        /* Image styling */
        .banner-slider-img {
            width: 100%;
            display: block;
            object-fit: cover;
            object-position: center;
            transition: transform 0.6s cubic-bezier(0.25, 0.8, 0.25, 1);
        }

        /* Premium zoom micro-animation on hover */
        .banner-slide-link:hover .banner-slider-img {
            transform: scale(1.025);
        }

        /* ==========================================================================
        Responsive Breakpoints
        ========================================================================== */

        /* Desktop Devices */
        @media (min-width: 992px) {
            .banner-slider-img {
                /* height: auto;  */
                /* Scales naturally with image aspect-ratio */
                /* To restrict height on desktop to a fixed size, uncomment below: */
                /* height: 500px; */
                object-fit: cover;
                object-position: 
            }
        }

        /* Tablets (less than 991px) */
        @media (max-width: 991px) {
            .banner-slider-img {
                height: auto;
            }
        }

        /* Mobile Devices (less than 767px) */
        @media (max-width: 767px) {
            .banner-slider-img {
                height: auto;
            }
        }
    
    </style>

    <!-- Custom Banner Slider Start -->
    @if (!empty($homeOfferSliders))
        <section class="home-slider-5 offer-slider-ui">
            <div class="home-slider-main-5">
                <div class="home5-slider swiper-container">
                    <div class="swiper-wrapper">
                        @foreach ($homeOfferSliders as $homeOfferSlider)
                            <div class="swiper-slide">
                                <!-- Wrap the entire image in a link -->
                                <a href="{{ $homeOfferSlider->url ? $homeOfferSlider->url : 'javascript:void(0)' }}" class="banner-slide-link">
                                    <img src="{!! asset('storage/images/home-offer-sliders/' . $homeOfferSlider->image_url) !!}" 
                                         alt="Ranayas Banner" 
                                         class="banner-slider-img">
                                </a>
                            </div>
                        @endforeach
                    </div>
                    
                    <!-- Swiper Navigation (only if more than 1 slide) -->
                    @if (count($homeOfferSliders) > 1)
                        <div class="swiper-buttons">
                            <button class="swiper-prev"><i class="fa fa-angle-left"></i></button>
                            <button class="swiper-next"><i class="fa fa-angle-right"></i></button>
                        </div>
                        <div class="swiper-pagination"><span></span></div>
                    @endif
                </div>
            </div>
        </section>
    @endif
    <!-- Custom Banner Slider End -->




    <style>
        .offer-slider-ui.home-slider-5,
        .offer-slider-ui .home-slider-main-5,
        .offer-slider-ui .home5-slider {
            width: 100% !important;
            max-width: 100% !important;
            padding: 0 !important;
            margin: 0 !important;
        }

        .offer-slider-ui .img-back {
            width: 100% !important;
            max-width: 100% !important;
        }
    </style>



    <!-- budget tab start -->
    @if(isset($shopByBudgetProducts))
        @foreach ($shopByBudgetProducts as $budgetName => $budgetData)
            @if (count($budgetData['products']))
                <section class="home5-featured section-b-padding featured-products" style="padding-top: 80px !important; padding-bottom: {{ $loop->last ? '80px' : '0px' }} !important; margin-top: 0px;">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <div class="section-title">
                                    <h2><span>{{ $budgetName }}</span></h2>
                                    @if(!empty($budgetData['description']))
                                        <p class="text-secondary mt-3">{{ $budgetData['description'] }}</p>
                                    @endif
                                </div>
                                <div class="featured5-pro owl-carousel owl-theme">
                                    @foreach ($budgetData['products'] as $k => $product)
                                        @php
                                            $colors = explode(',', $product->color_codes);
                                            $getDiff = $product->starting_price - $product->mrp;
                                            $getOffer = $product->starting_price > 0 ? round(($getDiff / $product->starting_price) * 100, 0) : 0;
                                        @endphp
                                        <div class="items">
                                            <div class="tred-pro">
                                                <div class="tr-pro-img">
                                                    <a href="{{ route('product', $product->slug_url) }}">
                                                        <img class="img-fluid lazy" src="{!! asset('storage/images/products/' . $product->image_url) !!}"
                                                            alt="{{ $product->title }}">
                                                        <img class="img-fluid additional-image lazy"
                                                            src="{!! asset('storage/images/products/' . $product->image_url1) !!}" alt="{{ $product->title }}">
                                                    </a>
                                                </div>
                                                <div class="Pro-lable">
                                                    @if (isset($product->created_at) && \Carbon\Carbon::parse($product->created_at)->greaterThanOrEqualTo(\Carbon\Carbon::now()->subDays(15)))
                                                        <span class="p-text">New</span>
                                                    @endif
                                                    <span class="p-discount"> {{ $getOffer }}% off</span>
                                                </div>
                                                <div class="pro-icn">
                                                    @if (auth('user')->check())
                                                        @php
                                                            $wishlistItem = auth('user')
                                                                ->user()
                                                                ->wishlists->where('product_id', $product->id)
                                                                ->first();
                                                        @endphp
                                                        @if ($wishlistItem)
                                                            <a href="javascript:void(0)" class="w-c-q-icn wishlist-remove"
                                                                data-w-id="{{ $wishlistItem->id }}"
                                                                title="Remove from Wishlist"><i class="fa fa-heart" style="color: var(--theme-color) !important;"></i></a>
                                                        @else
                                                            <a href="javascript:void(0)" class="w-c-q-icn wishlist"
                                                                data-p-id="{{ $product->id }}"
                                                                data-c-id="{{ $product->c_id }}"
                                                                data-s-id="{{ $product->s_id }}" title="Add to Wishlist"><i
                                                                    class="fa fa-heart-o"></i></a>
                                                        @endif
                                                    @else
                                                        <a href="javascript:void(0)" class="w-c-q-icn wishlist-login"
                                                            title="Add to Wishlist"><i class="fa fa-heart-o"></i></a>
                                                    @endif
                                                    <a href="javascript:void(0)"
                                                        onclick="addToCart('{{ $product->id }}', '{{ $product->stock }}', '{{ $product->c_id }}', '{{ $product->s_id }}')"
                                                        class="w-c-q-icn" title="Add to Cart"><i
                                                            class="fa fa-shopping-bag"></i></a>
                                                    <a href="{{ route('product', $product->slug_url) }}" class="w-c-q-icn"><i
                                                            class="fa fa-eye"></i></a>
                                                </div>
                                            </div>

                                            <div class="caption caption-9">
                                                <h3 class="title">
                                                    <span class="pull-left">
                                                        <a href="{{ route('product', $product->slug_url) }}">
                                                            {{ Str::length($product->title) > 20 ? Str::substr($product->title, 0, 20) . '...' : $product->title }}
                                                        </a>
                                                    </span>
                                                    <span class="pull-left product-colors">
                                                        @foreach ($colors as $color)
                                                            <span
                                                                style="background: {{ $color }};border-radius:50%;height:10px;width:10px;display:inline-block;box-shadow: 1px 2px 3px 0px #5f5f5f;opacity:1;"></span>
                                                        @endforeach
                                                    </span>
                                                    <div class="clearfix"></div>
                                                </h3>
                                                <div>
                                                    <div class="price-star">
                                                        @if ($product->review_status)
                                                            <div class="rating pull-right">
                                                                @for ($i = 1; $i <= $product->rating; $i++)
                                                                    <i class="fa fa-star"></i>
                                                                @endfor
                                                                @for ($i = 1; $i <= 5 - $product->rating; $i++)
                                                                    <i class="fa fa-star-o"></i>
                                                                @endfor
                                                            </div>
                                                        @endif
                                                        <div class="pro-price pull-left">
                                                            <span class="new-price"><i class="fa fa-inr"></i>
                                                                {{ $product->mrp }}</span>
                                                            <span class="old-price"><del><i class="fa fa-inr"></i>
                                                                    {{ $product->starting_price }}</del></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            @endif
        @endforeach
    @endif
    <!-- budget tab end -->

    <!-- About Us Section start -->
    <section class="about-us-sec overflow-hidden position-relative w-100">
        <figure>
            <img src="{{ asset('assets/image/about-us-section11.png') }}" alt="hearing test background image">
        </figure>

        <div class="about-us-wrapper position-absolute py-4 px-4">
            <h3 class="text-uppercase fs-5 text-light">&nbsp;&nbsp;Shopping made easy&nbsp;&nbsp;</h3>
            <ul class="my-4">
                <li class="mt-3">
                    <h2 class="fs-5 fw-semibold">Wide product range</h2>
                    <p class="text-secondary lh-base">Explore a variety of household essentials including kitchen tools,
                        storage items, and cleaning supplies.</p>
                </li>
                <li class="pt-3">
                    <h2 class="fs-5 fw-semibold">Quality and affordability</h2>
                    <p class="text-secondary lh-base">Carefully selected products that balance durability and
                        cost-effectiveness for everyday use.</p>
                </li>
                <li class="pt-3">
                    <h2 class="fs-5 fw-semibold">Convenient shopping</h2>
                    <p class="text-secondary lh-base">Easy ordering and reliable delivery to ensure a smooth and
                        hassle-free experience.</p>
                </li>
            </ul>
            <a href="#" style="border-radius:8px;" class="text-uppercase fs-6 fw-bold text-light py-1 px-2">contact us</a>
            {{-- <h2 class="text-uppercase fs-4 pt-3 pb-2">Rediscover the Beauty of Sound with Us, Intelligent hearing Solutions for You.</h2> --}}
            {{-- <p class="fs-6 text-secondary">Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam sequi
                officiis fugiat rerum voluptatum
                ipsa optio neque ad cumque tempora.</p> --}}
    </section>
    <!-- About Us Section end -->

    <!-- banner start -->
    <section class="why-choose-us py-5">
        <header class="text-center mb-5">
            <h1 class="fs-1 fw-semibold">Why choose <span class="text-uppercase text-light">&nbsp;Ranayas&nbsp;</span>
            </h1>
        </header>

        <ul class="container my-5 d-flex justify-content-between align-items-start flex-wrap">
            <li class="text-center py-4 px-3">
                <div class="svg d-flex justify-content-center align-items-center py-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewBox="0 0 512 512">
                        <path fill="var(--theme-color)"
                            d="M468.53 236.03H486v39.94h-17.47zm-34.426 51.634h17.47v-63.328h-17.47zm-33.848 32.756h17.47V191.58h-17.47zm-32.177 25.276h17.47V167.483h-17.47v178.17zm-34.448-43.521h17.47v-92.35h-17.47zm-34.994 69.879h17.47v-236.06h-17.525v236.06zM264.2 405.9h17.47V106.1H264.2zm-33.848-46.284h17.47V152.383h-17.47v207.234zm-35.016-58.85h17.47v-87.35h-17.47zm-33.847-20.823h17.47V231.98h-17.47v48.042zm-33.848 25.66h17.47v-99.24h-17.47v99.272zm-33.302 48.04h17.47V152.678H94.34v201zm-33.847-30.702h17.47V187.333h-17.47v135.642zM26 287.664h17.47v-63.328H26z" />
                    </svg>
                </div>
                <h2 class="fs-5 lh-base">High-quality household products</h2>
                <p class="description lh-base text-secondary fs-6 pt-1">Durable and reliable items designed for everyday
                    use in your home.</p>
            </li>
            <li class="text-center py-4 px-3">
                <div class="svg d-flex justify-content-center align-items-center py-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewBox="0 0 1024 1024">
                        <path fill="var(--theme-color)"
                            d="M942.2 486.2Q889.47 375.11 816.7 305l-50.88 50.88C807.31 395.53 843.45 447.4 874.7 512C791.5 684.2 673.4 766 512 766q-72.67 0-133.87-22.38L323 798.75Q408 838 512 838q288.3 0 430.2-300.3a60.29 60.29 0 0 0 0-51.5m-63.57-320.64L836 122.88a8 8 0 0 0-11.32 0L715.31 232.2Q624.86 186 512 186q-288.3 0-430.2 300.3a60.3 60.3 0 0 0 0 51.5q56.69 119.4 136.5 191.41L112.48 835a8 8 0 0 0 0 11.31L155.17 889a8 8 0 0 0 11.31 0l712.15-712.12a8 8 0 0 0 0-11.32M149.3 512C232.6 339.8 350.7 258 512 258c54.54 0 104.13 9.36 149.12 28.39l-70.3 70.3a176 176 0 0 0-238.13 238.13l-83.42 83.42C223.1 637.49 183.3 582.28 149.3 512m246.7 0a112.11 112.11 0 0 1 146.2-106.69L401.31 546.2A112 112 0 0 1 396 512" />
                        <path fill="var(--theme-color)"
                            d="M508 624c-3.46 0-6.87-.16-10.25-.47l-52.82 52.82a176.09 176.09 0 0 0 227.42-227.42l-52.82 52.82c.31 3.38.47 6.79.47 10.25a111.94 111.94 0 0 1-112 112" />
                    </svg>
                </div>
                <h2 class="fs-5 lh-base">Affordable pricing</h2>
                <p class="description lh-base text-secondary fs-6 pt-1">Get the best value for money without compromising
                    on quality.</p>
            </li>
            <li class="text-center py-4 px-3">
                <div class="svg d-flex justify-content-center align-items-center py-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewBox="0 0 24 24">
                        <g fill="none">
                            <path
                                d="M24 0v24H0V0zM12.593 23.258l-.011.002l-.071.035l-.02.004l-.014-.004l-.071-.035c-.01-.004-.019-.001-.024.005l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427c-.002-.01-.009-.017-.017-.018m.265-.113l-.013.002l-.185.093l-.01.01l-.003.011l.018.43l.005.012l.008.007l.201.093c.012.004.023 0 .029-.008l.004-.014l-.034-.614c-.003-.012-.01-.02-.02-.022m-.715.002a.023.023 0 0 0-.027.006l-.006.014l-.034.614c0 .012.007.02.017.024l.015-.002l.201-.093l.01-.008l.004-.011l.017-.43l-.003-.012l-.01-.01z" />
                            <path fill="var(--theme-color)"
                                d="M10.586 2.1a2 2 0 0 1 2.7-.116l.128.117L15.314 4H18a2 2 0 0 1 1.994 1.85L20 6v2.686l1.9 1.9a2 2 0 0 1 .116 2.701l-.117.127l-1.9 1.9V18a2 2 0 0 1-1.85 1.995L18 20h-2.685l-1.9 1.9a2 2 0 0 1-2.701.116l-.127-.116l-1.9-1.9H6a2 2 0 0 1-1.995-1.85L4 18v-2.686l-1.9-1.9a2 2 0 0 1-.116-2.701l.116-.127l1.9-1.9V6a2 2 0 0 1 1.85-1.994L6 4h2.686zM12 3.516l-1.9 1.9a2 2 0 0 1-1.238.577L8.686 6H6v2.686a2 2 0 0 1-.467 1.285l-.119.13l-1.9 1.9l1.9 1.899a2 2 0 0 1 .578 1.238l.008.176V18h2.686a2 2 0 0 1 1.285.467l.13.119l1.899 1.9l1.9-1.9a2 2 0 0 1 1.238-.578l.176-.008H18v-2.686a2 2 0 0 1 .467-1.285l.119-.13l1.9-1.899l-1.9-1.9a2 2 0 0 1-.578-1.238L18 8.686V6h-2.686a2 2 0 0 1-1.285-.467l-.13-.119l-1.9-1.9Zm3.08 5.468a1 1 0 0 1 1.497 1.32l-.084.094l-4.88 4.88a1.1 1.1 0 0 1-1.46.086l-.096-.085l-2.404-2.404a1 1 0 0 1 1.32-1.498l.094.083l1.768 1.768z" />
                        </g>
                    </svg>
                </div>
                <h2 class="fs-5 lh-base">Wide product selection</h2>
                <p class="description lh-base text-secondary fs-6 pt-1">A variety of essentials to meet all your kitchen,
                    storage, and cleaning needs.</p>
            </li>
            <li class="text-center py-4 px-3">
                <div class="svg d-flex justify-content-center align-items-center py-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewBox="0 0 16 16">
                        <path fill="var(--theme-color)" fill-rule="evenodd"
                            d="M11 1H5a1 1 0 0 0-1 1v6a.5.5 0 0 1-1 0V2a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v6a.5.5 0 0 1-1 0V2a1 1 0 0 0-1-1m1 13a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-2a.5.5 0 0 0-1 0v2a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-2a.5.5 0 0 0-1 0zM1.713 7.954a.5.5 0 1 0-.419-.908c-.347.16-.654.348-.882.57C.184 7.842 0 8.139 0 8.5c0 .546.408.94.823 1.201c.44.278 1.043.51 1.745.696C3.978 10.773 5.898 11 8 11q.148 0 .294-.002l-1.148 1.148a.5.5 0 0 0 .708.708l2-2a.5.5 0 0 0 0-.708l-2-2a.5.5 0 1 0-.708.708l1.145 1.144L8 10c-2.04 0-3.87-.221-5.174-.569c-.656-.175-1.151-.374-1.47-.575C1.012 8.639 1 8.506 1 8.5c0-.003 0-.059.112-.17c.115-.112.31-.242.6-.376Zm12.993-.908a.5.5 0 0 0-.419.908c.292.134.486.264.6.377c.113.11.113.166.113.169s0 .065-.13.187c-.132.122-.352.26-.677.4c-.645.28-1.596.523-2.763.687a.5.5 0 0 0 .14.99c1.212-.17 2.26-.43 3.02-.758c.38-.164.713-.357.96-.587c.246-.229.45-.537.45-.919c0-.362-.184-.66-.412-.883s-.535-.411-.882-.571M7.5 2a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1z" />
                    </svg>
                </div>
                <h2 class="fs-5 lh-base">Easy to use products</h2>
                <p class="description lh-base text-secondary fs-6 pt-1">Designed for convenience and comfort in daily
                    routines.</p>
            </li>
            <li class="text-center py-4 px-3">
                <div class="svg d-flex justify-content-center align-items-center py-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewBox="0 0 48 48">
                        <defs>
                            <mask id="ipTHeadphoneSound0">
                                <g fill="none">
                                    <path fill="#555"
                                        d="M4 28a2 2 0 0 1 2-2h4v12H6a2 2 0 0 1-2-2zm34-2h4a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2h-4z" />
                                    <path stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="4"
                                        d="M10 36V24c0-7.732 6.268-14 14-14s14 6.268 14 14v12M10 26H6a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h4zm28 0h4a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2h-4z" />
                                    <path stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="4"
                                        d="M16 32h4l2-6l4 12l2-6h4" />
                                </g>
                            </mask>
                        </defs>
                        <path fill="var(--theme-color)" d="M0 0h48v48H0z" mask="url(#ipTHeadphoneSound0)" />
                    </svg>
                </div>
                <h2 class="fs-5 lh-base">Smart and practical solutions</h2>
                <p class="description lh-base text-secondary fs-6 pt-1">Products that simplify your daily tasks and improve
                    efficiency.</p>
            </li>
            <li class="text-center py-4 px-3">
                <div class="svg d-flex justify-content-center align-items-center py-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewBox="0 0 24 24">
                        <g fill="none">
                            <path
                                d="M24 0v24H0V0zM12.593 23.258l-.011.002l-.071.035l-.02.004l-.014-.004l-.071-.035c-.01-.004-.019-.001-.024.005l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427c-.002-.01-.009-.017-.017-.018m.265-.113l-.013.002l-.185.093l-.01.01l-.003.011l.018.43l.005.012l.008.007l.201.093c.012.004.023 0 .029-.008l.004-.014l-.034-.614c-.003-.012-.01-.02-.02-.022m-.715.002a.023.023 0 0 0-.027.006l-.006.014l-.034.614c0 .012.007.02.017.024l.015-.002l.201-.093l.01-.008l.004-.011l.017-.43l-.003-.012l-.01-.01z" />
                            <path fill="var(--theme-color)"
                                d="M11.298 2.195a2 2 0 0 1 1.232-.055l.172.055l7 2.625a2 2 0 0 1 1.291 1.708l.007.165v5.363a9 9 0 0 1-4.709 7.911l-.266.139l-3.354 1.677a1.5 1.5 0 0 1-1.198.062l-.144-.062l-3.354-1.677a9 9 0 0 1-4.97-7.75l-.005-.3V6.693a2 2 0 0 1 1.145-1.808l.153-.065zM12 4.068L5 6.693v5.363a7 7 0 0 0 3.635 6.138l.235.123L12 19.882l3.13-1.565a7 7 0 0 0 3.865-5.997l.005-.264V6.693zm3.433 4.561a1 1 0 0 1 1.497 1.32l-.083.094l-5.234 5.235a1.1 1.1 0 0 1-1.46.085l-.096-.085l-2.404-2.404a1 1 0 0 1 1.32-1.498l.094.083l1.768 1.768z" />
                        </g>
                    </svg>
                </div>
                <h2 class="fs-5 lh-base">Customer-focused service</h2>
                <p class="description lh-base text-secondary fs-6 pt-1">We prioritize your needs with dependable support
                    and service.</p>
            </li>
        </ul>
    </section>
    <!-- banner end -->

    <!-- testimonial start -->
    @if (count($reviews))
        <section class="testimonial-6 section-tb-padding">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="section-title">
                            <h2>What Customers Say ?</h2>
                        </div>
                        <div class="testi-6 owl-carousel owl-theme">
                            @foreach ($reviews as $review)
                                <div class="items">
                                    <div class="testimonial-content">
                                        <div class="testimonial-area">
                                            <div class="testi-name">
                                                <span class="tsti-title">{{ $review->name }}</span>
                                                @if ($review->rating)
                                                    <span>
                                                        @for ($i = 1; $i <= $review->rating; $i++)
                                                            <i class="fa fa-star e-star"></i>
                                                        @endfor
                                                        @for ($i = 1; $i <= 5 - $review->rating; $i++)
                                                            <i class="fa fa-star-o"></i>
                                                        @endfor
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <p>{{ $review->comment }}</p>
                                        <h6>{{ $review->product ? $review->product->title : 'Unknown' }}</h6>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
    <!-- testimonial end -->


    <!-- Custom Slider/Banner Section Start -->

    <style>
        /* ==========================================================================
   Custom Absolute Position Banner / Slider Style
   ========================================================================== */
.custom-slider-5 {
    position: relative;
    width: 100%;
    overflow: hidden;
}

.custom-slider-slide-wrapper {
    position: relative;
    width: 100%;
    display: block;
    cursor: pointer;
    overflow: hidden;
}

/* Real Image styling */
.custom-slider-image {
    width: 100%;
    display: block;
    object-fit: cover;
    object-position: center;
    transition: transform 0.8s ease;
}

/* Hover Zoom effect on background image */
.custom-slider-slide-wrapper:hover .custom-slider-image {
    transform: scale(1.03);
}

/* Content Container - Absolute Position Overlay */
.custom-slider-content-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center; /* Vertically center content */
    z-index: 5;
    pointer-events: none; /* Make clicks pass through to the slider link */
}

/* Make inner content elements clickable */
.custom-slider-content-overlay * {
    pointer-events: auto;
}

/* Premium Card backdrop (Glassmorphism & Shadows) */
.custom-deal-area {
    max-width: 520px;
    background: rgba(255, 255, 255, 0.42);
    padding: 10px;
    border-radius: 8px;
    /* box-shadow: 0 15px 35px rgba(0, 0, 0, 0.08); */
    /* backdrop-filter: blur(10px); */
    /* -webkit-backdrop-filter: blur(10px); */
    /* transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
    transform: translateY(0); */
    text-align: left;
}

/* Micro interaction card animation */
.custom-slider-slide-wrapper:hover .custom-deal-area {
    /* transform: translateY(-8px); */
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12);
}

.custom-deal-content h2 {
    /* font-size: 36px; */
    /* font-weight: 700; */
    font-size: 20px;
    font-weight: 500;
    color: #111111;
    line-height: 1.25;
    /* margin-bottom: 20px; */
}

.custom-deal-area .btn-style1 {
    display: inline-block;
    padding: 12px 28px;
    font-weight: 600;
    font-size: 15px;
    border-radius: 6px;
    transition: background 0.3s, color 0.3s;
}

/* ==========================================================================
   Responsive Breakpoints
   ========================================================================== */

/* Medium Devices (Tablets, less than 991px) */
@media (max-width: 991px) {
    
    .custom-deal-content h2 {
        font-size: 28px;
    }
    
    .custom-deal-area {
        max-width: 420px;
        padding: 30px;
    }
}

/* Small Devices (Landscape Phones, less than 767px) */
@media (max-width: 767px) {
    
    /* Center text box on mobile and position at the bottom of slide */
    .custom-slider-content-overlay {
        justify-content: center;
        align-items: flex-end;
        padding-bottom: 30px;
    }
    
    .custom-deal-area {
        max-width: 90%;
        width: 100%;
        margin: 0 auto;
        padding: 24px;
        text-align: center;
        background: rgba(255, 255, 255, 0.42);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }
    
    .custom-deal-content h2 {
        font-size: 22px;
        margin-bottom: 15px;
    }
    
    .custom-deal-area .btn-style1 {
        padding: 10px 22px;
        font-size: 14px;
    }
}

/* Extra Small Devices (Portrait Phones, less than 479px) */
@media (max-width: 479px) {
    
    .custom-deal-content h2 {
        font-size: 18px;
    }
    
    .custom-deal-area {
        padding: 20px;
    }
}

    </style>

<!-- Custom Slider/Banner Section End -->



    <!-- hearing test start -->
    <section class="hearing-test-sec">
        {{-- <figure>
            <img src="{{ asset('assets/image/hearing-test.jpg') }}" alt="hearing test background image">
    </figure> --}}
        <div class="hearing-test-wrapper">
            <h2>How do I choose the <br> right home products?</h2>
            <p>Need help finding the best items for your home? We’ve got you covered! Explore our collection and choose
                products that fit your daily needs and lifestyle.</p>

            <div class="btns">
                <a href="{{ route('index') }}">Browse products</a>
                <!-- <a href="javascript:void(0);" onclick="document.getElementById('enquiry-form').style.display = 'block'; document.getElementById('modal_background').classList.remove('d-none');">Get buying advice</a> -->
                {{-- <a href="#">Browse products</a>
    <a href="#">Get buying advice</a> --}}
            </div>
        </div>
    </section>
    <!-- hearing test end -->

    <!-- home banner start -->
    {{-- <section class="home-banner section-b-padding">
    <div class="banner-area">
        <div class="banner-item banner-1">
            <a href="javascript:void(0)" class="banner-url">
                <img src="{!! asset('assets/image/home-10/banner-1.jpg') !!}" class="img-fluid" alt="image">
            </a>
            <div class="banner-text">
                <span class="sub-title">Get up to 30% off</span>
                <h1 class="title">
                    <span class="bold-text">Brussels</span>
                    <span>foods</span>
                </h1>
                <a href="{{ route('cate', 'namkeens-1') }}" class="btn-style2">Buy now</a>
</div>
</div>
<div class="banner-item banner-2">
    <a href="javascript:void(0)" class="banner-url">
        <img src="{!! asset('assets/image/home-10/banner-2.jpg') !!}" class="img-fluid" alt="image">
    </a>
    <div class="banner-text">
        <h1 class="title">
            <span class="bold-text">Fresh</span>
            <span>farm</span>
        </h1>
        <a href="#" data-bs-toggle="modal" data-bs-target="#exampleModalCenter" class="video-btn">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-play">
                <polygon points="5 3 19 12 5 21 5 3" />
            </svg>
        </a>
    </div>
</div>
</div>
<!-- model video start -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                        <line x1="18" y1="6" x2="6" y2="18" />
                        <line x1="6" y1="6" x2="18" y2="18" />
                    </svg>
                </a>
            </div>
            <div class="modal-body">
                <iframe src="https://www.youtube.com/embed/gee7LfsxIa8" title="YouTube video player" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>
        </div>
    </div>
</div>
<!-- model video end -->
</section> --}}
    <!-- home banner end -->
@endsection


@section('extrajs')
    <script>
        // setTimeout(function() {
        //     modal.style.display = 'block';
        //     $("#modal_background").removeClass('d-none');
        // }, 8000);
        const start = document.querySelector(".hearing-test-page-wrapper");
        const startTest = document.querySelector(".hearing-test-page .start-test");
        const allInput = document.querySelectorAll(".htpw-parts input");


        // startTest.addEventListener("click", () => {
        //     allInput.forEach(input => {
        //         if (input.value != "") {
        //             start.classList.add('secActive');
        //         } else {
        //             start.classList.remove('secActive');
        //             console.log("dhii");
        //         }
        //     })
        // })
        // backBtn = form.querySelector(".backBtn"),
        // allInput = form.querySelectorAll(".htpw-parts input");

        // startTest.add
        // nextBtn.addEventListener("click", () => {
        //     allInput.forEach(input => {
        //         if (input.value != "") {
        //             form.classList.add('secActive');
        //         } else {
        //             form.classList.remove('secActive');
        //             alert("check the readio button")
        //         }
        //     })
        // })

        // backBtn.addEventListener("click", () => form.classList.remove('secActive'));
    </script>
@endsection
@section('extrajs')
    <script>
        $(document).ready(function() {
            var swiperOffer = new Swiper(".offer-slider-ui .home5-slider", {
                slidesPerColumn: 1,
                slidesPerView: 1,
                effect: "fade",
                loop: true,
                autoplay: {
                    delay: 5000,
                    disableOnInteraction: false,
                },
                navigation: {
                    nextEl: ".offer-slider-ui .swiper-next",
                    prevEl: ".offer-slider-ui .swiper-prev",
                },
                pagination: {
                    el: ".offer-slider-ui .swiper-pagination",
                    clickable: true,
                },
            });
        });
    </script>
@endsection
