@extends('layouts.master')
@section('title')
    {{ $product->title }}
@endsection
@section('content')

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
                                <span>{{ $product->title }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- product info start -->
    <section class="section-tb-padding pro-page">
        <div class="container">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-xs-12 pro-image">
                    <div class="row">
                        <div class="col-lg-5 col-xl-5 col-md-6 col-12 col-xs-12 larg-image">
                            @php
                                $firstColorImages = collect();
                                if ($product->colors->count() > 0) {
                                    $firstColorId = $product->colors[0]->color_id;
                                    $firstSizeId = $product->colors[0]->size_id;
                                    
                                    // First try to get images for the specific color AND size
                                    $firstColorImages = $product->images->where('color_id', $firstColorId)->where('size_id', $firstSizeId)->sortByDesc('id')->values();
                                    
                                    // Fallback to just color if no specific size images exist
                                    if ($firstColorImages->count() == 0) {
                                        $firstColorImages = $product->images->where('color_id', $firstColorId)->sortByDesc('id')->values();
                                    }
                                }
                            @endphp
                            <div class="tab-content large_image">
                                <style>
                                    .tab-content.large_image .tab-pane:not(.active) {
                                        display: none !important;
                                    }
                                </style>
                                @if ($firstColorImages->count() > 0)
                                    @foreach ($firstColorImages as $key => $image)
                                        <div class="tab-pane fade {{ $key == 0 ? 'show active' : '' }}"
                                            id="image-{{ $image->id }}">
                                            <a href="javascript:void(0)" class="long-img">
                                                <figure class="zoom" onmousemove="zoom(event)"
                                                    style="background-image: url({{ asset('storage/images/multi-products/' . $image->image_url) }})">
                                                    <img src="{{ asset('storage/images/multi-products/' . $image->image_url) }}"
                                                        class="img-fluid" alt="{{ $product->title }}">
                                                </figure>
                                            </a>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <ul class="nav nav-tabs pro-page-slider owl-carousel owl-theme thumb_image">
                                @if ($firstColorImages->count() > 0)
                                    @foreach ($firstColorImages as $key => $image)
                                        <li class="nav-item items">
                                            <a class="thumb_image_active nav-link {{ $key == 0 ? 'active' : '' }}"
                                                data-bs-toggle="tab" href="#image-{{ $image->id }}">
                                                <img src="{{ asset('storage/images/multi-products/' . $image->image_url) }}"
                                                    class="img-fluid" alt="{{ $product->title }}">
                                            </a>
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                        <div class="col-lg-6 col-xl-6 col-md-6 col-12 col-xs-12 pro-info">
                            <h4>{{ $product->title }}</h4>
                            @if ($product->brand)
                                <div class="pro-details">
                                    <strong>Brand:</strong> {{ $product->brand->brand_name }}
                                </div>
                            @endif
                            @if ($product->category)
                                <div class="pro-details">
                                    <a href="{{ route('cate', [$product->category->slug_url]) }}"
                                        class="mb--10 text-black">
                                        <span>{{ $product->category->name }}</span>
                                    </a>
                                </div>
                            @endif
                            @if ($product->review_status)
                                <div class="rating">
                                    @for ($i = 1; $i <= $product->reviews->avg('rating'); $i++)
                                        <i class="fa fa-star d-star"></i>
                                    @endfor
                                    @for ($i = 1; $i <= 5 - $product->reviews->avg('rating'); $i++)
                                        <i class="fa fa-star-o"></i>
                                    @endfor

                                    @if ($product->reviews->count('id'))
                                        <a href="javascript:void(0)" id="writeReview">({{ $product->reviews->count('id') }}
                                            customer
                                            review)</a>
                                    @endif
                                </div>
                            @endif
                            <div class="pro-availabale">
                                @if (count($product->colors) > 0)
                                    @if ($product->colors[0]->stock <= 0)
                                        <span class="available">Availability:</span>
                                        <span class="pro-instock text-danger">
                                            <i class="ti-close"></i> Out of Stock
                                        </span>
                                    @else
                                        <span class="available">Availability:</span>
                                        <span class="pro-instock text-success">
                                            <i class="ti-check-box"></i> In stock
                                            {{-- @if ($product->isCodAvailable)
                                        <span class="text-success">
                                            <i class="fa fa-check-circle-o" aria-hidden="true"></i>
                                            | Cash on Delivery Available
                                        </span>
                                        @else
                                        <span class="text-danger">
                                            <i class="fa fa-ban" aria-hidden="true"></i>
                                            | Cash on Delivery Not Available
                                        </span>
                                        @endif --}}
                                        </span>
                                    @endif
                                @else
                                    <span class="available">Availability:</span>
                                    <span class="pro-instock text-danger">
                                        <i class="ti-close"></i> Unavailable
                                    </span>
                                @endif
                            </div>
                            <div class="pro-price">
                                @if (count($product->colors) > 0)
                                    <span class="new-price main-new-price"><i class="fa fa-inr"></i>
                                        {{ $product->colors[0]->mrp }}</span>
                                    @if ($product->colors[0]->mrp < $product->colors[0]->starting_price)
                                        <span class="old-price main-old-price">
                                            <del>
                                                <i class="fa fa-inr"></i> {{ $product->colors[0]->starting_price }}
                                            </del>
                                        </span>
                                    @endif
                                    @php
                                        $getDiff = $product->colors[0]->starting_price - $product->colors[0]->mrp;
                                        if ($getDiff > 0) {
                                            $getOffer = round(
                                                ($getDiff / $product->colors[0]->starting_price) * 100,
                                                0,
                                            );
                                        } else {
                                            $getOffer = 0;
                                        }
                                    @endphp
                                    @if ($getOffer > 0)
                                        <div class="Pro-lable">
                                            <span class="p-discount"> {{ $getOffer }}% off</span>
                                        </div>
                                    @endif
                                @else
                                    <span class="new-price">Price Unavailable</span>
                                @endif
                            </div>

                            @if (count($product->sizes) > 0)
                                <div class="pro-items">
                                    <span class="pro-size">Size:</span>
                                    <ul class="pro-wight">
                                        @foreach ($product->sizes as $key => $item)
                                            {{-- @if (!empty($product->unit)) --}}
                                            <li>
                                                <a href="javascript:void(0)"
                                                    class="size_btn {{ $key == 0 ? 'active' : '' }}" data-toggle="tooltip"
                                                    data-placement="top" title="{{ $item->size->title ?? $item->title }}{{-- . ' ' . $product->unit->unit --}}"
                                                    data-size-id="{{ $item->size_id }}"
                                                    data-prod-id="{{ $product->id }}">
                                                    {{ $item->size->title ?? $item->title }}
                                                </a>
                                            </li>
                                            {{-- @else
                                            <li>
                                                <a href="javascript:void(0)"
                                                    class="size_btn {{ $key == 0 ? 'active' : '' }}" data-toggle="tooltip"
                                                    data-placement="top" title="{{ $item->title . ' GM' }}"
                                                    data-size-id="{{ $item->size_id }}"
                                                    data-prod-id="{{ $product->id }}">
                                                    {{ $item->title . ' GM' }}
                                                </a>
                                            </li>
                                        @endif --}}
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="featured_bullet d-none">
                                <span style="min-width: 105px;
                            font-weight: 600;"
                                    class="qty">Sizecart:</span>
                                {!! $product->sizecart !!}
                            </div>

                            {{-- @if ($product->offer && $product->offer->purchase_quantity > 0 && $product->offer->offered_quantity > 0)
                                <div class="product-offer-notice mb-3">
                                    <div class="offer-box p-2"
                                        style="background-color: #fff9e6; border: 1px dashed #fcca2f; border-radius: 5px;">
                                        <p class="mb-0" style="font-size: 14px; color: #856404;">
                                            <i class="fa fa-gift me-1"></i>
                                            <strong>Offer:</strong> Get {{ $product->offer->offered_quantity }} Free
                                            Product On Purchase Of {{ $product->offer->purchase_quantity }}
                                        </p>
                                    </div>
                                </div>
                            @endif --}}

                            <div class="product-color">
                                <span class="color-label">Colors:</span>
                                <span class="color" id="colorDiv">
                                    @foreach ($product->colors as $key => $item)
                                        <a href="javascript:void(0)" class="color_btn {{ $key == 0 ? 'active' : '' }}"
                                            data-toggle="tooltip" data-placement="top" title="{{ $item->color->title }}"
                                            data-color-id="{{ $item->color_id }}" data-prod-id="{{ $product->id }}">
                                            <span style="background-color: {{ $item->color->color_code }}"></span>
                                        </a>
                                    @endforeach
                                </span>
                            </div>
                            <div class="pro-qty">
                                <span class="qty">Quantity:</span>
                                <div class="plus-minus">
                                    <span>
                                        <a href="javascript:void(0)" class="minus-btn text-black">-</a>
                                        <input type="text" class="quantity-input" name="qty" id="qty"
                                            value="1">
                                        <a href="javascript:void(0)" class="plus-btn text-black">+</a>
                                    </span>
                                </div>
                            </div>
                            <div class="pro-btn">

                                @if (auth('user')->check())
                                    @if ($product->wishlist && $product->wishlist->product_id == $product->id)
                                        <a href="javascript:void(0)" class="w-c-q-icn btn-style1 wishlist-remove"
                                            data-w-id="{{ $product->wishlist->id }}" title="Remove from Wishlist"><i
                                                class="fa fa-heart"></i></a>
                                    @else
                                        <a href="javascript:void(0)" class="w-c-q-icn btn-style1 wishlist"
                                            title="Add to Wishlist"><i class="fa fa-heart-o"></i></a>
                                    @endif
                                @else
                                    <a href="javascript:void(0)" class="w-c-q-icn btn-style1 wishlist-login"
                                        title="Add to Wishlist"><i class="fa fa-heart-o"></i></a>
                                @endif

                                <a href="javascript:void(0)" class="btn btn-style1 add-cart">
                                    <i class="fa fa-shopping-bag"></i> Add to cart
                                </a>
                                {{-- <a href="javascript:void(0)" class="btn btn-style1">Buy now</a> --}}

                                @if ($product->length || $product->width || $product->height)
                                    <div class="product-dimensions-info mt-3">
                                        <span class="text-muted" style="font-size: 14px;">
                                            <strong>Dimensions:</strong> {{ $product->length ?: '-' }} x
                                            {{ $product->width ?: '-' }} x {{ $product->height ?: '-' }}
                                            {{ $product->dim_unit ? $product->dim_unit->unit : '' }}
                                        </span>
                                    </div>
                                @endif

                                @if ($product->non_returnable)
                                    <div class="return-policy-notice mt-3">
                                        <span class="text-danger fw-bold" style="font-size: 16px;">Non Returnable</span>
                                    </div>
                                @elseif($product->within_days)
                                    <div class="return-policy-notice mt-3">
                                        <div class="d-flex align-items-center">

                                            <span class="text-muted fw-bold" style="font-size: 14px;">Return within 7
                                                days</span>
                                        </div>
                                    </div>
                                @endif

                            </div>
                            {{-- <div class="share">
                            <span class="share-lable">Share:</span>
                            <ul class="share-icn">
                                <li><a href="javascript:void(0)"><i class="fa fa-facebook"></i></a></li>
                                <li><a href="javascript:void(0)"><i class="fa fa-twitter"></i></a></li>
                                <li><a href="javascript:void(0)"><i class="fa fa-instagram"></i></a></li>
                                <li><a href="javascript:void(0)"><i class="fa fa-pinterest"></i></a></li>
                            </ul>
                        </div> --}}
                            {{-- <div class="pay-img">
                                <a href="javascript:void(0)">
                                    <img src="{!! asset('assets/image/pay-image.jpg') !!}" class="img-fluid" alt="pay-image">
                                </a>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- product info end -->



    <!-- product page tab start -->
    <section class="section-b-padding pro-page-content">
        <div class="container">
            <div class="row">
                <div class="col">

                    <style>
                        .pro-features h4,
                        .tech-spec h4,
                        .pack-detl h4,
                        .certification h4 {
                            text-transform: capitalize;
                        }

                        /* .specification{
                                                                                                                                                                        display: flex;
                                                                                                                                                                    } */
                    </style>

                    <style>
                        th {
                            font-size: 20px;
                            text-transform: capitalize;
                            border: 1px solid black;
                            padding: 10px;
                        }

                        td {
                            padding: 10px;
                            border: 1px solid black;
                        }

                        @media screen and (max-width: 1199px) {
                            table {
                                margin-bottom: 60px;
                            }
                        }

                        @media screen and (max-width: 768px) {
                            .specification-table {
                                display: none;
                            }
                        }
                    </style>



                    <style>
                        .specification {
                            display: none;
                            border: 1px solid #d6d6d6;
                        }

                        .specification h3 {
                            padding: 20px 25px;
                            border-bottom: 1px solid #d6d6d6;
                        }

                        .pro-features,
                        .read-more-btn,
                        .tech-spec,
                        .pack-detl,
                        .certification {
                            border-bottom: 1px solid #d6d6d6;
                        }

                        .pro-features h4,
                        .tech-spec h4,
                        .pack-detl h4,
                        .certification h4 {
                            padding: 20px 25px;
                            border-bottom: 1px solid #d6d6d6;
                        }

                        .pro-features ul,
                        .tech-spec ul,
                        .pack-detl ul,
                        .certification ul {
                            padding: 20px 25px;
                        }

                        .pro-features li,
                        .tech-spec li,
                        .pack-detl li,
                        .certification li {
                            line-height: 25px;
                        }

                        /* .read-more-btn{
                                                                                                                                                                        position: relative;
                                                                                                                                                                        font-size:18px;
                                                                                                                                                                        cursor: pointer;
                                                                                                                                                                    } */
                        /* .read-more-btn:before{
                                                                                                                                                                        position: absolute;
                                                                                                                                                                        content:"";
                                                                                                                                                                        width: 100%;
                                                                                                                                                                        height: 30px;
                                                                                                                                                                        background: linear-gradient(0deg, rgba(255,0,0,0.5) 0%, rgba(0,0,0,0) 80%);
                                                                                                                                                                        left: 0;
                                                                                                                                                                        top: -30px;
                                                                                                                                                                    } */
                        /* .tech-spec, .pack-detl, .certification{
                                                                                                                                                                        display: none;
                                                                                                                                                                    } */
                        @media screen and (max-width: 768px) {
                            .specification {
                                display: block;
                                border: 1px solid #d6d6d6;
                            }
                        }

                        /* Specification Standalone Card Styling */
                        .product-specification-list {
                            margin: 0 -10px;
                            /* Offset the padding of columns */
                        }

                        .spec-box {
                            border: 1px solid #eee;
                            padding: 15px 20px;
                            margin-bottom: 15px;
                            border-radius: 8px;
                            transition: all 0.3s ease;
                            background: #fff;
                            height: calc(100% - 15px);
                            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
                        }

                        .spec-box:hover {
                            border-color: #d6d6d6;
                            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
                            transform: translateY(-2px);
                        }

                        .spec-label {
                            font-size: 11px;
                            text-transform: uppercase;
                            letter-spacing: 1px;
                            color: #999 !important;
                            display: block;
                            margin-bottom: 4px;
                            font-weight: 700;
                        }

                        .spec-value {
                            font-size: 15px;
                            font-weight: 500;
                            color: #333 !important;
                            display: block;
                        }
                    </style>

                    <!-- Specifications Section -->
                    <div class="product-specification-section mb-5">
                        <div class="pill-header-wrapper">
                            <div class="pill-header">Product Specification</div>
                        </div>
                        <div class="specification-content">
                            <ul class="row product-specification-list list-unstyled">
                                @php
                                    $specs = [
                                        'Brand' => $product->brand ? $product->brand->brand_name : null,
                                        'Material' => $product->material ? $product->material->material_name : null,
                                        'Condition' => $product->condition ? $product->condition->condition : null,
                                        'Warranty' => $product->warranty ? $product->warranty->title : null,
                                        'Length' => $product->length
                                            ? $product->length .
                                                ' ' .
                                                ($product->dim_unit ? $product->dim_unit->unit : '')
                                            : null,
                                        'Width' => $product->width
                                            ? $product->width .
                                                ' ' .
                                                ($product->dim_unit ? $product->dim_unit->unit : '')
                                            : null,
                                        'Height' => $product->height
                                            ? $product->height .
                                                ' ' .
                                                ($product->dim_unit ? $product->dim_unit->unit : '')
                                            : null,
                                        'Weight' => $product->weight
                                            ? $product->weight . ' ' . ($product->unit ? $product->unit->unit : '')
                                            : null,
                                        'EAN/UPC' => $product->upc,
                                    ];
                                @endphp

                                @foreach ($specs as $label => $value)
                                    @if ($value && $value != '0' && $value != '-')
                                        <li class="col-lg-3 col-md-4 col-sm-6 p-2">
                                            <div class="spec-box">
                                                <strong class="spec-label">{{ $label }}</strong>
                                                <span class="spec-value">{{ $value }}</span>
                                            </div>
                                        </li>
                                    @endif
                                @endforeach

                                {{-- Custom Fields --}}
                                @if (isset($product->custom_fields) && count($product->custom_fields) > 0)
                                    @foreach ($product->custom_fields as $field)
                                        <li class="col-lg-3 col-md-4 col-sm-6 p-2">
                                            <div class="spec-box">
                                                <strong class="spec-label">{{ $field->field_name }}</strong>
                                                <span class="spec-value">{{ $field->field_value }}</span>
                                            </div>
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                    </div>

                    <!-- Description Section -->
                    <div class="product-description-section mb-5">
                        <div class="pill-header-wrapper">
                            <div class="pill-header">Description</div>
                        </div>
                        <div class="description-content">
                            <div class="spec-box" style="height: auto;">
                                {!! $product->description !!}
                            </div>
                        </div>
                    </div>


                    <!-- Reviews Section -->
                    @if (count($product->reviews) && $product->review_status)
                        <div class="product-reviews-section mt-5">
                            <div class="pill-header-wrapper">
                                <div class="pill-header">Customer Reviews</div>
                            </div>
                            <div class="customer-reviews">
                                <section class="testimonial-6 p-0">
                                    <div class="container p-0">
                                        <div class="row">
                                            <div class="col">
                                                <div class="testi-6 owl-carousel owl-theme">
                                                    @foreach ($product->reviews as $review)
                                                        <div class="items">
                                                            <div class="testimonial-content">
                                                                <div class="testimonial-area">
                                                                    <div class="testi-name">
                                                                        <span
                                                                            class="tsti-title">{{ $review->name }}</span>
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
                                                                <h6>{{ date('F d, Y', strtotime($review->created_at)) }}
                                                                </h6>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        </div>
    </section>
    <!-- product page tab end -->
    <!-- releted product start -->
    <section class="section-b-padding pro-releted">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="section-title">
                        <h2>Related Products</h2>
                    </div>
                    <div class="releted-products owl-carousel owl-theme">
                        @foreach ($related_products as $product)
                            @php
                                $colors = explode(',', $product->color_codes);
                                $getDiff = $product->starting_price - $product->mrp;
                                if ($getDiff > 0) {
                                    $getOffer = round(($getDiff / $product->starting_price) * 100, 0);
                                } else {
                                    $getOffer = 0;
                                }
                            @endphp
                            <div class="items">
                                <div class="tred-pro">
                                    <div class="tr-pro-img">
                                        <a href="{{ route('product', $product->slug_url) }}">
                                            <img class="img-fluid lazy" src="{!! asset('storage/images/products/' . $product->image_url) !!}"
                                                alt="{{ $product->title }}">
                                            <img class="img-fluid additional-image lazy" src="{!! asset('storage/images/products/' . $product->image_url1) !!}"
                                                alt="{{ $product->title }}">
                                        </a>
                                    </div>
                                    <div class="Pro-lable">
                                        <span class="p-text">New</span>
                                        @if ($getOffer > 0)
                                            <span class="p-discount"> {{ $getOffer }}% off</span>
                                        @endif
                                    </div>
                                    <div class="pro-icn">
                                        @if (auth()->check())
                                            @if (auth()->user()->id == $product->w_u_id && $product->w_product_id == $product->id)
                                                <a href="javascript:void(0)" class="w-c-q-icn wishlist-remove"
                                                    data-w-id="{{ $product->w_id }}" title="Remove from Wishlist"><i
                                                        class="fa fa-heart"></i></a>
                                            @else
                                                <a href="javascript:void(0)" class="w-c-q-icn wishlist"
                                                    data-p-id="{{ $product->product_id }}"
                                                    data-c-id="{{ $product->c_id }}" data-s-id="{{ $product->s_id }}"
                                                    title="Add to Wishlist"><i class="fa fa-heart-o"></i></a>
                                            @endif
                                        @else
                                            <a href="javascript:void(0)" class="w-c-q-icn wishlist-login"
                                                title="Add to Wishlist"><i class="fa fa-heart-o"></i></a>
                                        @endif
                                        <a href="javascript:void(0)"
                                            onclick="addToCart('{{ $product->product_id }}', '{{ $product->stock }}', '{{ $product->c_id }}', '{{ $product->s_id }}')"
                                            class="w-c-q-icn" title="Add to Cart"><i class="fa fa-shopping-bag"></i></a>
                                        <a href="{{ route('product', $product->slug_url) }}" class="w-c-q-icn"><i
                                                class="fa fa-eye"></i></a>
                                    </div>
                                </div>

                                <div class="caption">
                                    <h3>
                                        <span class="pull-left">
                                            <a href="{{ route('product', $product->slug_url) }}">
                                                {{ Str::length($product->title) > 20 ? Str::substr($product->title, 0, 20) . '...' : $product->title }}
                                            </a>
                                        </span>
                                        <span class="pull-right">
                                            <span style="display:none"></span>
                                            @foreach ($colors as $color)
                                                <span
                                                    style="background: {{ $color }};border-radius:50%;height:10px;width:10px;display:inline-block;box-shadow: 1px 2px 3px 0px #5f5f5f"></span>
                                            @endforeach
                                        </span>
                                        <div class="clearfix"></div>
                                    </h3>
                                    <div>
                                        <div class="pro-price pull-left">
                                            <span class="new-price"><i class="fa fa-inr"></i> {{ $product->mrp }}</span>
                                            @if ($product->mrp < $product->starting_price)
                                                <span class="old-price"><del><i class="fa fa-inr"></i>
                                                        {{ $product->starting_price }}</del></span>
                                            @endif
                                        </div>
                                        @if ($product->review_status)
                                            <div class="rating pull-right">
                                                @for ($i = 1; $i <= $product->rating; $i++)
                                                    <i class="fa fa-star b-star"></i>
                                                @endfor
                                                @for ($i = 1; $i <= 5 - $product->rating; $i++)
                                                    <i class="fa fa-star-o"></i>
                                                @endfor
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- releted product end -->



@endsection

@section('extrajs')
    <script>
        $(document).ready(function() {


            var param = {};
            param = {
                size_id: $('.size_btn:first-child').data('size-id'),
                product_id: $('.size_btn:first-child').data('prod-id'),
                color_id: $('.color_btn:first-child').data('color-id'),
                source: 'size'
            };
            console.log('param', param);

            getProduct(param);

            $('#writeReview').click(function(event) {
                event.preventDefault();
                $('html, body').animate({
                    scrollTop: $("#reviewTab").offset().top - 250
                }, 1000);
                $('#description').removeClass('active show');
                $('#descriptionTab').removeClass('active');
                $('#reviewTab').addClass('active');
                $('#review').addClass('active show');
            });

            $('.add-cart').click(function() {
                var quantity = $('#qty').val();
                var color_id = $('#cart_color_id').val();
                var size_id = $('#cart_size_id').val();
                if (color_id.length < 1) {
                    swal('Add to Cart', 'Please Choose Color', 'error');
                } else if (quantity < 1) {
                    swal('Add to Cart', 'Please Choose Atleast One Quantity to add in Cart', 'error');
                } else if (size_id.length < 1) {
                    swal('Add to Cart', 'Please Choose Size', 'error');
                } else {
                    $('#cart_qty').val(quantity);
                    $('#cartForm').submit();
                    $(this).html(
                        '<i class="fa fa-spinner fa-pulse fa-fw text-light"></i><span class="sr-only">Loading...</span>'
                    );
                }
            });

            $('.size_btn').click(function() {
                var param = {};
                param = {
                    size_id: $(this).data('size-id'),
                    product_id: $(this).data('prod-id'),
                    color_id: $('#cart_color_id').val(),
                    source: 'size'
                };

                getProduct(param);

                var ac = $('.size_btn').hasClass('active');
                if (ac == true) {
                    $('.size_btn').removeClass('active');
                }
                $(this).addClass('active');
            });

            $('.color_btn').click(function() {

                attachClickListener('.color_btn');

            });


            $('.add-cart').click(function() {
                $(this).html(
                    `<i class="fa fa-spinner fa-pulse fa-fw"></i><span class="sr-only">Loading...</span>`
                );
                $('#cartForm').submit();
            });

        });

        function attachClickListener(elementName) {
            const elements = $(elementName);

            elements.each((index, element) => {

                element.addEventListener('click', function() {

                    var param = {};
                    param = {
                        color_id: $(element).data('color-id'),
                        product_id: $(element).data('prod-id'),
                        size_id: $('#cart_size_id').val(),
                        source: 'color'
                    };

                    getProduct(param);

                    var ac = $(elementName).hasClass('active');
                    if (ac == true) {
                        $(elementName).removeClass('active');
                    }
                    $(element).addClass('active');

                });
            });
        }

        function getProduct(param) {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                }
            });

            $.ajax({
                url: "{{ route('get.sizes') }}",
                type: 'POST',
                data: param,
                success: function(result) {
                    if (result.success) {
                        var data = result.success[0];
                        var mrp = data.mrp;
                        var starting_price = data.starting_price;
                        var getDiff = starting_price - mrp;
                        var getOffer = Math.round((getDiff / starting_price) * 100, 0);
                        if (getOffer > 0) {
                            $('.pro-price .Pro-lable').show();
                            $('.pro-price .p-discount').html(getOffer + "% off");
                        } else {
                            $('.pro-price .Pro-lable').hide();
                        }
                        $('.main-new-price').html('<i class="fa fa-inr"></i> ' + mrp);
                        $('.main-old-price').html('<del><i class="fa fa-inr"></i> ' + starting_price +
                            '</del>');
                        $('#cart_prod_id').val(param.product_id);
                        $('#cart_qty').val($('#qty').val());
                        $('#cart_color_id').val(data.color_id);
                        $('#cart_size_id').val(data.size_id);
                        $('.wishlist').attr('data-p-id', param.product_id);
                        $('.wishlist').attr('data-c-id', data.color_id);
                        $('.wishlist').attr('data-s-id', data.size_id);
                        setImages(result.images);

                        if (result.source == "size") {
                            setColor(result.available_colors);
                        }
                        checkStock(data.stock);
                    }
                }
            });
        }

        function setImages(images) {
            var large_image = '';
            var thumb_image = '';
            var path = "{!! asset('storage/images/multi-products') !!}";

            images.forEach((element, index) => {
                var active = index === 0 ? 'show active' : '';
                var thumb_active = index === 0 ? 'active' : '';

                large_image += `<div class="tab-pane fade ${active}" id="image-${element.id}">
                <a href="javascript:void(0)" class="long-img">
                    <figure class="zoom" onmousemove="zoom(event)"
                        style="background-image: url(${path+'/'+element.image_url})">
                        <img src="${path+'/'+element.image_url}"
                            class="img-fluid" alt="{{ $product->title }}">
                    </figure>
                </a>
            </div>`;

                thumb_image += `
            <li class="nav-item items">
                <a class="thumb_image_active nav-link ${thumb_active}" data-bs-toggle="tab" href="#image-${element.id}">
                    <img src="${path}/${element.image_url}" class="img-fluid" alt="{{ $product->title }}">
                </a>
            </li>`;
            });

            $('.large_image').html(large_image);
            $('.thumb_image').html(thumb_image);

            // Initialize Owl Carousel
            $('.thumb_image').trigger('destroy.owl.carousel');
            $('.thumb_image').owlCarousel({
                // items: images.length,
                // loop: true,
                // margin: 5,

                nav: false,
                margin: 5,
                autoplay: false,
                autoplayTimeout: 5000,
                responsive: {
                    0: {
                        items: 2,
                        loop: images.length > 2
                    },
                    578: {
                        items: 4,
                        loop: images.length > 4
                    },
                    768: {
                        items: 5,
                        loop: images.length > 5
                    }
                }
            });

            // Thumbnail click event
            $('.thumb_image_active').click(function() {
                $('.thumb_image_active').removeClass('active');
                $(this).addClass('active');
            });

            // Zoom functionality
            $('.zoom').on('mousemove', function(event) {
                // Implement your zoom logic here using event.pageX, event.pageY, etc.
            });
        }


        function setColor(available_colors) {

            if (available_colors.length > 0) {
                var color_html = '';
                var currentColorId = $('#cart_color_id').val();
                var colorExists = available_colors.some(item => item.color_id == currentColorId);
                
                available_colors.forEach((item, index) => {
                    var activeClass = '';
                    if (colorExists) {
                        activeClass = (item.color_id == currentColorId) ? 'active' : '';
                    } else {
                        activeClass = (index == 0) ? 'active' : '';
                    }
                    
                    color_html += `<a href="javascript:void(0)" class="color_btn ${activeClass}"
                    data-toggle="tooltip" data-placement="top" title="${item.color.title}"
                    data-color-id="${item.color_id}" data-prod-id="${item.product_id}">
                    <span style="background-color: ${item.color.color_code}"></span>
                </a>`;
                })

                $('#colorDiv').html(color_html);

                attachClickListener('.color_btn');
            }
        }

        function zoom(e) {
            var zoomer = e.currentTarget;
            e.offsetX ? offsetX = e.offsetX : offsetX = e.touches[0].pageX
            e.offsetY ? offsetY = e.offsetY : offsetX = e.touches[0].pageX
            x = offsetX / zoomer.offsetWidth * 100
            y = offsetY / zoomer.offsetHeight * 100
            zoomer.style.backgroundPosition = x + '% ' + y + '%';
        }

        function checkStock(params) {
            if (params <= 0) {
                $('.add-cart').addClass('disabled', 'disabled');
                $('.pro-availabale').html(
                    `<span class="available">Availability:</span><span class="pro-instock text-danger"><i class="ti-close"></i> Out of Stock </span>`
                );
            } else {
                $('.add-cart').removeClass('disabled');
                $('.pro-availabale').html(
                    `<span class="available">Availability:</span><span class="pro-instock text-success"><i class="ti-check-box"></i> In Stock </span>`
                );
            }
        }
    </script>
@endsection
