@extends('layouts.master')
@section('title')
    {{ $product->title }}
@endsection
@section('content')
    <!-- Breadcrumb area Start -->
    <div class="breadcrumb-area pt--70 pt-md--25">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <ul class="breadcrumb">
                        <li><a href="{{ route('index') }}">Home</a></li>
                        <li><a href="{{ route('cate', $product->category->slug_url) }}">{{ $product->category->name }}</a>
                        </li>
                        <li class="current"><span> {{ $product->title }}</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb area End -->

    <!-- Main Content Wrapper Start -->
    <div id="content" class="main-content-wrapper">
        <div class="page-content-inner enable-full-width">
            <div class="container">
                <div class="row pt--20">
                    <div class="col-md-6 product-main-image">
                        <div class="product-image">
                            <div class="product-gallery vertical-slide-nav">
                                <div class="product-gallery__thumb">
                                    <div class="product-gallery__thumb--image">

                                    </div>
                                </div>
                                <div class="product-gallery__large-image">
                                    <div class="gallery-with-thumbs">
                                        <div class="product-gallery__wrapper">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="col-md-6 product-main-details mt--40 mt-md--10 mt-sm--30"> -->
                    <div class="col-md-5 product-main-details mt-md--10 mt-sm--30">
                        <div class="product-summary">
                            @if ($product->review_status)
                                <div class="product-rating float-left" id="product-rating">
                                    @if ($prod)
                                        <span>
                                            @for ($i = 1; $i <= $prod->rating; $i++)
                                                <i class="fa fa-star rated" aria-hidden="true"></i>
                                            @endfor
                                            @for ($i = 1; $i <= 5 - $prod->rating; $i++)
                                                <i class="fa fa-star-o" aria-hidden="true"></i>
                                            @endfor
                                        </span>
                                        @if ($prod->total_rating)
                                            <a href="javascript:void(0)" class="review-link">({{ $prod->total_rating }}
                                                customer
                                                review)</a>
                                        @endif
                                    @else
                                        <span>
                                            <i class="fa fa-star-o" aria-hidden="true"></i>
                                            <i class="fa fa-star-o" aria-hidden="true"></i>
                                            <i class="fa fa-star-o" aria-hidden="true"></i>
                                            <i class="fa fa-star-o" aria-hidden="true"></i>
                                            <i class="fa fa-star-o" aria-hidden="true"></i>
                                        </span>
                                    @endif

                                </div>
                            @endif

                            <div class="clearfix"></div>

                            {{-- <h3 class="product-titles">{{ $product->title }} <span data-toggle="modal"
                                data-target="#bulk-order" class="btn btn-sm float-right bulk-order-btn">Bulk
                                Order</span></h3> --}}
                            <div class="product-price-wrapper mb--10 mb-md--10">
                                <span class="money mrp"> <i class="fa fa-inr"></i> {{ $product->colors[0]->mrp }}</span>
                                <span class="old-price">
                                    <span class="money starting_price"><i class="fa fa-inr"></i>
                                        {{ $product->colors[0]->starting_price }}</span>
                                </span>
                                @php
                                    $getDiff = $product->colors[0]->starting_price - $product->colors[0]->mrp;
                                    $getOffer = round(($getDiff / $product->colors[0]->starting_price) * 100, 0);
                                @endphp
                                <span style="color:#388e3c;font-size: 18px" class="priceOffer">
                                    ({{ $getOffer }}% OFF)
                                </span>
                            </div>

                            <div class="bg-gray">
                                @if ($product->category)
                                    <a href="{{ route('cate', [$product->category->slug_url]) }}" class="mb--10 text-black">
                                        <span>{{ $product->category->name }}</span>
                                    </a>
                                @endif

                                @if ($product->isCodAvailable)
                                    <span class="product-stock in-stock float-right text-success">
                                        <i class="fa fa-check-circle-o" aria-hidden="true"></i>
                                        Cash on Delivery Available
                                    </span>
                                @else
                                    <span class="product-stock in-stock float-right text-danger">
                                        <i class="fa fa-ban" aria-hidden="true"></i>
                                        Cash on Delivery Not Available
                                    </span>
                                @endif
                            </div>
                            <div class="product-name">
                                <h3>{{ $product->title }}</h3>
                            </div>

                            <div class="clearfix"></div>

                            <form action="#" class="variation-form mb--20">

                                {{-- @if (count($colorsSizes) > 0)
                            <div class="product-color-variations mb--20">
                                <p class="swatch-label"><strong class="swatch-label color-label"></strong></p>
                                <div class="product-color-swatch variation-wrapper">
                                    @foreach ($colorsSizes as $item)
                                    <div class="swatch-wrapper swatch-wrapper-color">
                                        <a class="product-color-swatch-btn variation-btn" data-toggle="tooltip"
                                            data-placement="top" title="{{ $item->color_name }}"
                                            data-color-id="{{ $item->color_id }}" data-mrp="{{ $item->mrp }}"
                                            data-stock="{{ $item->stock }}" data-map-id="{{ $item->map_id }}"
                                            data-product-id="{{ $product->id }}" data-title="{{ $item->color_name }}"
                                            data-starting-price="{{ $item->starting_price }}"
                                            {{-- data-unit="{{ $product->unit->unit }}" --}}
                                style="border: 2px solid {{ $item->color_code }};background: {{ $item->color_code }}">
                                <div style="background: {{ $item->color_code }};height: calc(100%);border-radius:5px">
                                </div>
                                </a>
                        </div>
                        @endforeach

                    </div>
                </div>
                @endif --}}
                @if (count($product->sizes) > 0)
                    @php
                        $firstSize = strtolower($product->sizes[0]->title ?? '');
                    @endphp
                    <style>
                        .size-null { display: none !important; }
                    </style>
                    <div class="product-size-variations size-{{ $firstSize }}">
                        <p class="swatch-label">Selected Size <strong class="swatch-label size size_lable"></strong>

                        </p>
                        <div class="product-size-swatch variation-wrapper size-block">
                            @foreach ($product->sizes as $item)
                                <div class="swatch-wrapper size-{{ strtolower($item->title) }}">
                                    <a class="product-size-swatch-btn variation-btn size_btn" data-toggle="tooltip"
                                        data-placement="top" title="{{ $item->title }}"
                                        data-size-id="{{ $item->size_id }}">
                                        <span class="product-size-swatch-label">{{ $item->title }} </span>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
                </form>

                <div class="offerSection">
                    @if (count($offers))
                        <p> Choose {{ $offers[0]->offered_quantity }} Free Product On Purchase Of
                            {{ $offers[0]->purchase_quantity }} <a href="javascript:void(0)"
                                class="d-inline pull-right selectedOfferBtn text-black">View Selected Offer</a></p>
                        <div class="airi-element-carousel-offer product-carousel nav-vertical-center offer"
                            data-slick-options='{
                                        "spaceBetween": 30,
                                        "slidesToShow": 6,
                                        "slidesToScroll": 1,
                                        "arrows": true,
                                        "prevArrow": {"buttonClass": "slick-btn slick-prev", "iconClass": "fa fa-angle-double-left" },
                                        "nextArrow": {"buttonClass": "slick-btn slick-next", "iconClass": "fa fa-angle-double-right" }
                                        }'
                            data-slick-responsive='[
                                            {"breakpoint":1200, "settings": {"slidesToShow": 6} },
                                            {"breakpoint":991, "settings": {"slidesToShow": 5} },
                                            {"breakpoint":450, "settings": {"slidesToShow": 4} }
                                        ]'>
                        </div>

                    @endif
                </div>

                <form action="#" class="form--action mt--20 mb--30 mb-sm--20">
                    <div class="d-flex flex-row align-items-center">
                        <div class="quantity">
                            <input type="number" class="quantity-input" name="qty" id="qty"
                                value="{{ old('qty') ? old('qty') : '1' }}" min="1" max="4">
                        </div>

                        <div id="button-box" class="flex-grow-1" style="margin-right: 10px;">
                            <a href="javascript:void(0)" class="add-cart sm-hidden">ADD TO BAG</a>
                        </div>
                    </div>
                </form>
                @if ($product->within_days || $product->wrong_products || $product->faulty_products || $product->quality_issue)
                    <div class="row pt--20 text-center return--policy">
                        @if ($product->within_days == true)
                            <div class="col-sm-3 col-6">
                                <span class="badge badge-success"><i class="fa fa-calendar-o"></i> </span>
                                <p>Within 7 <br /> Days</p>
                            </div>
                        @endif
                        @if ($product->wrong_products == true)
                            <div class="col-sm-3 col-6">
                                <span class="badge badge-danger"><i class="fa fa-times-circle-o"></i>
                                </span>
                                <p>Wrong <br /> Product</p>
                            </div>
                        @endif
                        @if ($product->faulty_products == true)
                            <div class="col-sm-3 col-6">
                                <span class="badge badge-primary"><i class="fa fa-ban"></i>
                                </span>
                                <p> Faulty <br /> Product</p>
                            </div>
                        @endif
                        @if ($product->quality_issue == true)
                            <div class="col-sm-3 col-6">
                                <span class="badge badge-dark"><i class="fa fa-thumbs-o-down"></i>
                                </span>
                                <p>
                                    Quality <br> Issue
                                </p>
                            </div>
                        @endif
                    </div>
                @endif

                {{-- description and review start --}}
                <div class="product-data-tab border-bottom pb--20 pb-md--30 pb-sm--20 tab-style-4">
                    @if (count($product->reviews) && $product->review_status)
                        <div class="nav nav-tabs product-data-tab__head mb--40 mb-sm--30" id="product-tab"
                            role="tablist">
                            <a class="product-data-tab__link nav-link active" id="nav-description-tab" data-toggle="tab"
                                href="#nav-description" role="tab" aria-selected="true">
                                <span>Description</span>
                            </a>
                            <a class="product-data-tab__link nav-link" id="nav-reviews-tab" data-toggle="tab"
                                href="#nav-reviews" role="tab" aria-selected="true">
                                <span>Reviews ({{ $prod->total_rating }})</span>
                            </a>
                        </div>
                    @endif
                    <div class="tab-content product-data-tab__content" id="product-tabContent">
                        <div class="tab-pane fade show active" id="nav-description" role="tabpanel"
                            aria-labelledby="nav-description-tab">
                            <div class="product-description">
                                <div class="pdp-productDescriptorsContainer" id="accordionSpecifications">
                                    <h4 class="pdp-product-description-title">
                                        Product Details
                                        <span
                                            class="fa fa-list-alt myntraweb-sprite pdp-productDetailsIcon sprites-productDetailsIcon"></span>
                                        <span class="btn bulk-order-btn pull-right" data-toggle="collapse"
                                            data-target="#collapseOne">
                                            Other Information
                                            <i class="fa fa-plus"></i>
                                    </h4>
                                    <p class="pdp-product-description-content">
                                        {!! $product->description !!}
                                    </p>
                                    <div id="collapseOne" class="index-sizeFitDesc collapse" aria-labelledby="specOne"
                                        data-parent="#accordionSpecifications">

                                        <h4 class="index-sizeFitDescTitle index-product-description-title" id="specOne"
                                            style="padding-bottom: 12px;">
                                            </i> Specifications
                                        </h4>
                                        <div class="index-tableContainer">
                                            @if ($product->brand)
                                                <div class="index-row">
                                                    <div class="index-rowKey">Brand</div>
                                                    <div class="index-rowValue">{{ $product->brand->brand_name }}
                                                    </div>
                                                </div>
                                            @endif
                                            @if ($product->warranty)
                                                <div class="index-row">
                                                    <div class="index-rowKey">Warranty</div>
                                                    <div class="index-rowValue">{{ $product->warranty->title }}
                                                    </div>
                                                </div>
                                            @endif
                                            @foreach ($product->custom_fields as $field)
                                                <div class="index-row">
                                                    <div class="index-rowKey">{{ $field->field_name }}</div>
                                                    <div class="index-rowValue">{{ $field->field_value }}</div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if ($product->review_status)
                            <div class="tab-pane fade" id="nav-reviews" role="tabpanel"
                                aria-labelledby="nav-reviews-tab">
                                <div class="product-reviews">
                                    <ul class="review__list">
                                        @foreach ($product->reviews as $review)
                                            <li class="review__item">
                                                <div class="review__container">

                                                    <img alt="Review Avatar" class="review__avatar lazy"
                                                        data-src="{!! asset('admin/img/admin2.png') !!}">

                                                    <div class="review__text">
                                                        <div class="product-rating float-right">
                                                            <span>
                                                                @for ($i = 1; $i <= $review->rating; $i++)
                                                                    <i class="fa fa-star rated" aria-hidden="true"></i>
                                                                @endfor
                                                                @for ($i = 1; $i <= 5 - $review->rating; $i++)
                                                                    <i class="fa fa-star-o" aria-hidden="true"></i>
                                                                @endfor
                                                            </span>
                                                        </div>
                                                        <div class="review__meta">
                                                            <strong class="review__author">{{ $review->name }} </strong>
                                                            <span class="review__dash">-</span>
                                                            <span
                                                                class="review__published-date">{{ date('F d, Y', strtotime($review->created_at)) }}</span>
                                                        </div>
                                                        <div class="clearfix"></div>
                                                        <p class="review__description">
                                                            {{ $review->comment }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                {{-- description and review end --}}
            </div>
        </div>
    </div>

    {{-- Releted Products --}}
    <div class="row pt--35 pt-md--25 pt-sm--15 pb--75 pb-md--55 pb-sm--35">
        <div class="col-12">
            <div class="row mb--40 mb-md--30">
                <div class="col-12">
                    <h2 class="heading-secondary section-product-title">Related Products</h2>
                    <div class="title-border"></div>
                </div>
            </div>
            <div class="row">
                @foreach ($related_products as $rproduct)
                    <div class="col-md-3 col-sm-6 col-xs-6 col-6 mb-5">
                        <div class="airi-product">
                            <div class="product-inner">
                                <figure class="product-image">
                                    <div class="product-image--holder">
                                        <a href="{{ route('product', [$rproduct->slug_url]) }}">
                                            <img data-src="{!! asset('storage/images/products/' . $rproduct->image_url) !!} " alt="Product Image"
                                                class="primary-image lazy">

                                            <img data-src="{!! asset('storage/images/products/' . $rproduct->image_url1) !!} " alt="Product Image"
                                                class="secondary-image lazy">
                                        </a>
                                    </div>
                                    <span class="product-trending">Trending</span>
                                    @if (auth('user')->check())
                                        @php
                                            $wishlistItem = auth('user')
                                                ->user()
                                                ->wishlists->where('product_id', $rproduct->id)
                                                ->first();
                                        @endphp
                                        @if ($wishlistItem)
                                            <span class="product-badge fav wishlist-remove"
                                                data-w-id="{{ $wishlistItem->id }}"><i
                                                    class="fa fa-heart colorfull-heart" aria-hidden="true"
                                                    title="Remove from Wishlist"></i></span>
                                        @else
                                            <span class="product-badge fav wishlist" data-p-id="{{ $rproduct->id }}"
                                                data-c-id="{{ $rproduct->c_id }}" data-s-id="{{ $rproduct->s_id }}"
                                                title="Add to Wishlist"><i class="fa fa-heart-o"
                                                    aria-hidden="true"></i></span>
                                        @endif
                                    @else
                                        <span class="product-badge fav wishlist-login"><i class="fa fa-heart-o"
                                                aria-hidden="true" title="Add to Wishlist"></i></span>
                                    @endif
                                </figure>
                                <!-- Color  -->
                                @php
                                    $getDiff = $rproduct->starting_price - $rproduct->mrp;
                                    $getOffer = round(($getDiff / $rproduct->starting_price) * 100, 0);
                                @endphp
                                <div class="product-info">
                                    <h3 class="product-title">
                                        <a href="{{ route('product', $rproduct->slug_url) }}">{{ $rproduct->title }}</a>

                                    </h3>
                                    <span class="product-price-wrapper">
                                        <span class="money"><i class="fa fa-inr"></i> {{ $rproduct->mrp }}</span>
                                        <span class="product-price-old">
                                            <span class="money"><i class="fa fa-inr"></i>
                                                {{ $rproduct->starting_price }}</span>
                                        </span>
                                        <span style="color:#388e3c">
                                            {{ $getOffer }}% off
                                        </span>
                                        @if ($rproduct->review_status)
                                            <span class="pull-right">
                                                @for ($i = 1; $i <= $rproduct->rating; $i++)
                                                    <i class="fa fa-star rated" aria-hidden="true"></i>
                                                @endfor
                                                @for ($i = 1; $i <= 5 - $rproduct->rating; $i++)
                                                    <i class="fa fa-star-o" aria-hidden="true"></i>
                                                @endfor
                                            </span>
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    </div>
    </div>
    <!-- Main Content Wrapper Start -->
    <!-- The Modal -->

    <!-- Selected Offer modal start -->
    <div class="modal fade" id="seleted-offer">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title">Selected Offer</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <div class="ptb--10 plr--10">
                        <div class="row offer_section">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Selected Offer modal end -->

    {{-- fixed add to cart in mobile start --}}
    <div class="sm-container add-cart">
        <div class="item">
            <a href="javascript:void(0);">
                ADD TO CART
            </a>
        </div>
    </div>
    {{-- fixed add to cart in mobile end --}}

    <form action="{{ route('cart.store') }}" method="post" id="cartForm">
        @csrf
        <input type="hidden" name="prod_id" id="cart_prod_id" value="{{ $product->id }}">
        <input type="hidden" name="qty" id="cart_qty">
        <input type="hidden" name="color_id" id="cart_color_id">
        <input type="hidden" name="size_id" id="cart_size_id">
        <input type="hidden" name="offers" id="cart_offer">
        <input type="hidden" name="map_ids" id="cart_map_id">
    </form>
@endsection

@section('extracss')
    <style>
        img.lazy.thumb_img {
            width: 125px;
            min-height: 125px;
            max-height: 125px;
        }

        img.lazy.big_img {
            width: 100%;
            min-height: 300px;
            max-height: 100%;
            border: 1px solid #e0e0e0;
        }

        img.lazy.related_img {
            width: 100%;
            min-height: 180px;
            max-height: 270px;
        }

        .product-title a {
            /* color: #fff; */
            color: #282828;
        }

        .offer .slick-track {
            margin-bottom: 8px;
        }

        .offer .product-info {
            padding: 0 0 5px 0
        }

        .offer .product-info .product-title {
            height: 24px;
            overflow: hidden;
        }

        @media (max-width: 47.94em) {
            img.lazy.big_img {
                border: none;
            }

            .btn {
                min-height: unset;
                line-height: unset;
            }
        }

        @media screen and (max-width: 767px) {
            .sm-padding-footer {
                padding-bottom: 15% !important;
            }
        }

        .table-bordered td,
        .table-bordered th {
            border: 1px solid #dee2e6;
        }

        .table td,
        .table th {
            padding: .75rem;
            vertical-align: top;
            border-top: 1px solid #dee2e6;
        }

        .bulk-order-btn {
            padding: 5px 15px 6px;
            border-radius: 3px;
            font-size: 11px;
            background-color: #172337;
            border: 1px solid #172337;
            color: #fff;
            cursor: pointer;
        }

        .bulk-order-btn:hover {
            background-color: #fff;
            border: 1px solid #d7ae00;
            color: #d7ae00;
        }

        .table th {
            font-weight: 600;
        }

        .table td,
        .table th {
            font-size: 14px !important;
            padding: 10px 0 10px 5px !important;
            text-transform: capitalize !important;
        }

        .disabledClass {
            cursor: not-allowed;
            text-decoration-line: line-through;
            text-decoration-style: solid;
            color: rgba(0, 0, 0, .6);
            background-color: #f5f5f5;
            box-shadow: none;
            pointer-events: none;
            border-color: transparent;
        }

        .disabledOffer img {
            -webkit-filter: blur(3px);
            /* Ch 23+, Saf 6.0+, BB 10.0+ */
            filter: blur(3px);
            /* FF 35+ */
            cursor: no-drop;
        }

        .offer .product-info {
            padding-top: 0rem;
        }

        .offer .product-info .product-title {
            font-size: 1rem;
            margin: 10px 0 0px;
        }

        /* .offer.slick-gutter-30 .slick-slide {
            padding-left: 0;
            padding-right: 1.5rem;
        } */
        .modal-header .close {
            padding: 1.5rem 2rem;
        }

        .slick-prev,
        .slick-next {
            z-index: 1000;
        }

        .slick-prev:before,
        .slick-next:before {
            color: #806326 !important;
        }

        .offerSection .slick-gutter-30 .slick-slide {
            padding-left: 0rem;
            padding-right: 1rem;
        }
    </style>

    <script type='text/javascript'
        src='https://platform-api.sharethis.com/js/sharethis.js#property=5ccc480d0ff462001290decd&product=inline-share-buttons&cms=website'
        async='async'></script>
@endsection

@section('extrajs')
    <script>
        $(document).ready(function() {
            // Add minus icon for collapse element which is open by default
            $(".collapse.show").each(function() {
                $(this).prev(".index-product-description-title").find(".fa").addClass("fa-minus")
                    .removeClass("fa-plus");
            });

            // Toggle plus minus icon on show hide of collapse element
            $(".collapse").on('show.bs.collapse', function() {
                $(this).prev(".index-product-description-title").find(".fa").removeClass("fa-plus")
                    .addClass("fa-minus");
            }).on('hide.bs.collapse', function() {
                $(this).prev(".index-product-description-title").find(".fa").removeClass("fa-minus")
                    .addClass("fa-plus");
            });
        });

        $(document).ready(function() {

            // var color_id = $('.product-color-swatch-btn').attr('data-color-id');
            var color_id = 1;

            var title = $('.product-color-swatch-btn').attr('data-title');

            $('.swatch-wrapper-color:first-child a').addClass('active')

            volume(color_id, title);

            sessionStorage.clear();

            var offers = JSON.parse(sessionStorage.getItem('offers')) || {};

            var load_offers = {!! json_encode($offers) !!};

            var count = {!! json_encode($product->offer ? $product->offer->offered_quantity : '') !!};

            var html = '';

            for (let index = 0; index < load_offers.length; index++) {

                if (count > 0) {
                    offers[index] = {};
                    offers[index] = {
                        'name': load_offers[index].product_name,
                        'color': load_offers[index].color_name,
                        'size': load_offers[index].size_name,
                        'offer_id': load_offers[index].offer_id,
                        'map_id': load_offers[index].map_id,
                        'image_url': load_offers[index].image_url,
                    };

                }

                count--;

                html += `<div  title="First Uncheck then Select Another"  class="airi-product offer_product ${count+1>0 ? 'active': 'disabledOffer'}" data-product-name="${load_offers[index].product_name }"
                        data-color="${load_offers[index].color_name }" data-size="${load_offers[index].size_name }"
                        data-index="${index }" data-purchase-quantity="${load_offers[index].purchase_quantity }"
                        data-offered-quantity="${load_offers[index].offered_quantity }"
                        data-offered-id="${load_offers[index].offer_id }" data-map-id="${load_offers[index].map_id }" data-image="${load_offers[index].image_url}">
                        <div class="product-inner">
                            <figure class="product-image">
                                <div class="product-image--holder">
                                    <a href="javascript:void(0)">
                                        <img src="${window.location.origin + '/storage/images/multi-products/' + load_offers[index].image_url}"
                                            alt="Product Image">
                                    </a>
                                </div>
                            </figure>
                            <div class="product-info">
                                <h3 class="product-title text-center">
                                    ${load_offers[index].product_name }
                                </h3>
                                <p class="text-center" style="margin:0;font-size: 1rem">
                                    ${load_offers[index].color_name} [ ${load_offers[index].size_name} ]
                                </p>
                            </div>
                        </div>
                    </div>`

            }

            $('.offer').html(html);

            elementCarousel('.airi-element-carousel-offer');

            sessionStorage.setItem("offers", JSON.stringify(offers));

            $('.offer_product').click(function() {

                var total_offers = JSON.parse(sessionStorage.getItem("offers"));

                var pquantity = $(this).attr('data-purchase-quantity');
                var oquantity = $(this).attr('data-offered-quantity');
                var quantity = $('.quantity-input').val();
                var index = $(this).attr('data-index');

                if (total_offers[index]) {

                    delete total_offers[index];

                    $(this).removeClass('active');

                    sessionStorage.setItem("offers", JSON.stringify(total_offers));

                }

                var offer_count = Object.keys(total_offers).length;

                var result = checkOfferQuantity(offer_count, quantity);

                if (result) {

                    var pname = $(this).attr('data-product-name');
                    var pcolor = $(this).attr('data-color');
                    var psize = $(this).attr('data-size');
                    var offer_id = $(this).attr('data-offered-id');
                    var map_id = $(this).attr('data-map-id');
                    var image_path = $(this).attr('data-image');

                    if (quantity >= pquantity) {
                        if (!offers[index]) {
                            offers[index] = {};
                            offers[index] = {
                                'name': pname,
                                'color': pcolor,
                                'size': psize,
                                'offer_id': offer_id,
                                'map_id': map_id,
                                'image_url': image_path,
                            };

                            $(this).addClass('active');

                        } else {
                            delete offers[index];
                            $(this).removeClass('active');
                        }

                        sessionStorage.setItem("offers", JSON.stringify(offers));

                    } else {
                        swal('Invalid', 'On Purchase of ' + pquantity + ' Choose Any ' + oquantity,
                        'error');
                    }
                } else {

                    var ofrs = $('.offer_product').not('.active');

                    for (const key in ofrs) {
                        if (ofrs.hasOwnProperty(key)) {
                            $('.offer_product').not('.active').addClass('disabledOffer');
                        }
                    }

                    // swal('Invalid', 'On Purchase of ' + pquantity*quantity + ' Product(s) Choose Any ' + oquantity*quantity + ' Product(s)', 'error');
                }
            });

            $('#formBulkOrder').validate({

                rules: {

                    name: {
                        required: true,
                    },

                    email: {
                        required: true,
                    },

                    mobile: {
                        required: true,
                        number: true,
                        minlength: 10,
                        maxlength: 10
                    },

                    message: {
                        required: true
                    }
                },

                messages: {

                    name: {
                        required: "Please Enter Name"
                    },

                    email: {
                        required: "Please Enter Email"
                    },

                    mobile: {
                        required: "Please Enter Mobile Number",
                        number: "Mobile Number should be of digits only",
                        maxlength: "Mobile Number should be of 10 digits",
                        minlength: "Mobile Number should be of 10 digits",
                    },

                    message: {
                        required: "Please Enter Message"
                    }
                },

                submitHandler: function(form) {
                    $('.btnSubmit').attr('disabled', 'disabled');
                    $(".btnSubmit").html('<span class="fa fa-spinner fa-spin"></span> Loading...');
                    form.submit();
                }
            });

            $('.selectedOfferBtn').click(function() {
                $('#seleted-offer').modal('show');
                var offers = JSON.parse(sessionStorage.getItem("offers"));
                var html = '';
                if (offers) {
                    for (let key in offers) {
                        html += ` <div class="col-md-6 col-6 mb-3">
                        <div class="card">
                            <img class="card-img-top" src="${window.location.origin + '/storage/images/multi-products/' + offers[key].image_url}" alt="${offers[key].name}">
                            <div class="card-body">
                            <h5 class="card-title">${offers[key].name}</h5>
                            <p class="card-text">Color : ${offers[key].color} <br />Size : ${offers[key].size}</p>
                            </div>
                        </div>
                    </div>`;
                    }
                    $('.offer_section').html(html);
                }
            });

            $('.add-cart').click(function() {
                var quantity = $('.quantity-input').val();
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
                    offer_ids = [];
                    map_ids = [];
                    if (offers) {
                        var offer = JSON.parse(sessionStorage.getItem("offers"));
                        for (let key in offers) {
                            offer_ids.push(offers[key].offer_id);
                            map_ids.push(offers[key].map_id);
                        }
                        $('#cart_offer').val(offer_ids);
                        $('#cart_map_id').val(map_ids);
                    }
                    $('#cartForm').submit();
                    $(this).html(
                        '<i class="fa fa-spinner fa-pulse fa-fw text-light"></i><span class="sr-only">Loading...</span>'
                    );
                    var btn = $(this);
                    setTimeout(function() {
                        btn.html('<i class="fa fa-shopping-bag"></i> Add to cart');
                    }, 2000);
                }
            });

            window.addEventListener('pageshow', function (event) {
                if (event.persisted || window.performance && window.performance.navigation.type === 2) {
                    $('.add-cart').html('<i class="fa fa-shopping-bag"></i> Add to cart');
                }
            });

            $('#product-rating').click(function(event) {
                event.preventDefault();
                $('html, body').animate({
                    scrollTop: $("#nav-reviews-tab").offset().top - 130
                }, 2000);
                $('#nav-description').removeClass('active show');
                $('#nav-description-tab').removeClass('active');
                $('#nav-reviews-tab').addClass('active');
                $('#nav-reviews').addClass('active show');
            });

            $('.popup-close').on('click', function(e) {
                e.preventDefault();
                $('#bulk-order').fadeOut('slow');
            });

            $('.product-color-swatch-btn').click(function(e) {

                $('.product-color-swatch-btn').removeClass('active')

                $(this).addClass('active')

                var mrp = $(this).attr('data-mrp');
                var product_id = $(this).attr('data-product-id');
                var color_id = $(this).attr('data-color-id');
                var map_id = $(this).attr('data-map-id');
                var stock = $(this).attr('data-stock');
                var starting_price = $(this).attr('data-starting-price');
                var title = $(this).attr('data-title');
                $('.size_lable').html('');
                $('#cart_size_id').val('');

                if (stock <= 0) {

                    $('#out_of_stock').show();
                    $('#out_of_stock').html('Out Of Stock');
                    $('.add-cart').attr('disabled', 'disabled');

                } else {

                    $("#cart_prod_id").val(product_id);
                    $("#cart_map_id").val(map_id);
                    $("#cart_color_id").val(color_id);
                    $('.mrp').html('<i class="fa fa-inr"></i> ' + mrp);

                    $('.starting_price').html('<i class="fa fa-inr"></i> ' + starting_price);

                    var size_id = $('.product-size-swatch-btn:first-child').attr('data-size-id');

                    getSizePrice(size_id, color_id, product_id);
                }

                volume(color_id, title);

                attachClickListener('.size_btn');

                $(".disabledClass").parents('.swatch-wrapper').css({
                    "cursor": "no-drop",
                    "border": "1px solid red"
                });


            });

            function elementCarousel(elementClass) {
                $html = $('html');
                $body = $('body');

                $elementCarousel = $(`${elementClass}`);

                // console.log('epeke', $elementCarousel);

                if ($elementCarousel.elExists()) {
                    var slickInstances = [];

                    /*For RTL*/
                    if ($html.attr("dir") == "rtl" || $body.attr("dir") == "rtl") {
                        $elementCarousel.attr("dir", "rtl");
                    }


                    $elementCarousel.each(function(index, element) {
                        var $this = $(this);

                        // Carousel Options

                        var $options = typeof $this.data('slick-options') !== 'undefined' ? $this.data(
                            'slick-options') : '';

                        var $spaceBetween = $options.spaceBetween ? parseInt($options.spaceBetween, 10) : 0,
                            $spaceBetween_xl = $options.spaceBetween_xl ? parseInt($options.spaceBetween_xl,
                                10) : 0,
                            $spaceBetween_lg = $options.spaceBetween_lg ? parseInt($options.spaceBetween_lg,
                                10) : 0,
                            $rowSpace = $options.rowSpace ? parseInt($options.rowSpace, 10) : 0,
                            $vertical = $options.vertical ? $options.vertical : false,
                            $focusOnSelect = $options.focusOnSelect ? $options.focusOnSelect : false,
                            $asNavFor = $options.asNavFor ? $options.asNavFor : '',
                            $fade = $options.fade ? $options.fade : false,
                            $autoplay = $options.autoplay ? $options.autoplay : false,
                            $autoplaySpeed = $options.autoplaySpeed ? parseInt($options.autoplaySpeed, 10) :
                            5000,
                            $swipe = $options.swipe ? $options.swipe : true,
                            $swipeToSlide = $options.swipeToSlide ? $options.swipeToSlide : true,
                            $touchMove = $options.touchMove ? $options.touchMove : true,
                            $verticalSwiping = $vertical ? ($options.verticalSwiping ? $options
                                .verticalSwiping : true) : false,
                            $draggable = $options.draggable ? $options.draggable : true,
                            $arrows = $options.arrows ? $options.arrows : false,
                            $dots = $options.dots ? $options.dots : false,
                            $adaptiveHeight = $options.adaptiveHeight ? $options.adaptiveHeight : true,
                            $infinite = $options.infinite ? $options.infinite : false,
                            $variableWidth = $options.variableWidth ? $options.variableWidth : false,
                            $centerMode = $options.centerMode ? $options.centerMode : false,
                            $centerPadding = $options.centerPadding ? $options.centerPadding : '',
                            $speed = $options.speed ? parseInt($options.speed, 10) : 500,
                            $appendArrows = $options.appendArrows ? $options.appendArrows : $this,
                            $prevArrow = $arrows === true ? ($options.prevArrow ? '<span class="' + $options
                                .prevArrow.buttonClass + '"><i class="' + $options.prevArrow.iconClass +
                                '"></i></span>' :
                                '<button class="tty-slick-text-btn tty-slick-text-prev">previous</span>') :
                            '',
                            $nextArrow = $arrows === true ? ($options.nextArrow ? '<span class="' + $options
                                .nextArrow.buttonClass + '"><i class="' + $options.nextArrow.iconClass +
                                '"></i></span>' :
                                '<button class="tty-slick-text-btn tty-slick-text-next">next</span>') : '',
                            $rows = $options.rows ? parseInt($options.rows, 10) : 1,
                            $rtl = $options.rtl || $html.attr('dir="rtl"') || $body.attr('dir="rtl"') ?
                            true : false,
                            $slidesToShow = $options.slidesToShow ? parseInt($options.slidesToShow, 10) : 1,
                            $slidesToScroll = $options.slidesToScroll ? parseInt($options.slidesToScroll,
                                10) : 1;

                        /*Responsive Variable, Array & Loops*/
                        var $responsiveSetting = typeof $this.data('slick-responsive') !== 'undefined' ?
                            $this.data('slick-responsive') : '',
                            $responsiveSettingLength = $responsiveSetting.length,
                            $responsiveArray = [];
                        for (var i = 0; i < $responsiveSettingLength; i++) {
                            $responsiveArray[i] = $responsiveSetting[i];

                        }

                        // Adding Class to instances
                        $this.addClass('slick-carousel-' + index);
                        $this.parent().find('.slick-dots').addClass('dots-' + index);
                        $this.parent().find('.slick-btn').addClass('btn-' + index);

                        if ($spaceBetween != 0) {
                            $this.addClass('slick-gutter-' + $spaceBetween);
                        }
                        if ($spaceBetween_xl != 0) {
                            $this.addClass('slick-gutter-xl-' + $spaceBetween_xl);
                        }
                        if ($spaceBetween_lg != 0) {
                            $this.addClass('slick-gutter-lg-' + $spaceBetween_lg);
                        }
                        var $slideCount = null;
                        $this.on('init', function(event, slick) {
                            $this.find('.slick-active').first().addClass('first-active');
                            $this.find('.slick-active').last().addClass('last-active');
                            $slideCount = slick.slideCount;
                            if ($slideCount <= $slidesToShow) {
                                $this.children('.slick-dots').hide();
                            }
                            var $firstAnimatingElements = $('.slick-slide').find(
                            '[data-animation]');
                            doAnimations($firstAnimatingElements);
                        });

                        $this.slick({
                            slidesToShow: $slidesToShow,
                            slidesToScroll: $slidesToScroll,
                            asNavFor: $asNavFor,
                            autoplay: $autoplay,
                            autoplaySpeed: $autoplaySpeed,
                            speed: $speed,
                            infinite: $infinite,
                            arrows: $arrows,
                            dots: $dots,
                            adaptiveHeight: $adaptiveHeight,
                            vertical: $vertical,
                            focusOnSelect: $focusOnSelect,
                            centerMode: $centerMode,
                            centerPadding: $centerPadding,
                            swipe: $swipe,
                            swipeToSlide: $swipeToSlide,
                            touchMove: $touchMove,
                            draggable: $draggable,
                            verticalSwiping: $verticalSwiping,
                            variableWidth: $variableWidth,
                            fade: $fade,
                            appendArrows: $appendArrows,
                            prevArrow: $prevArrow,
                            nextArrow: $nextArrow,
                            rtl: $rtl,
                            responsive: $responsiveArray,
                        });



                        $this.on('beforeChange', function(e, slick, currentSlide, nextSlide) {
                            $this.find('.slick-active').first().removeClass('first-active');
                            $this.find('.slick-active').last().removeClass('last-active');
                            var $animatingElements = $('.slick-slide[data-slick-index="' +
                                nextSlide + '"]').find('[data-animation]');
                            doAnimations($animatingElements);
                        });

                        function doAnimations(elements) {
                            var animationEndEvents =
                                'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';
                            elements.each(function() {
                                var $el = $(this);
                                var $animationDelay = $el.data('delay');
                                var $animationDuration = $el.data('duration');
                                var $animationType = 'animated ' + $el.data('animation');
                                $el.css({
                                    'animation-delay': $animationDelay,
                                    'animation-duration': $animationDuration,
                                });
                                $el.addClass($animationType).one(animationEndEvents, function() {
                                    $el.removeClass($animationType);
                                });
                            });
                        }

                        $this.on('afterChange', function(e, slick) {
                            $this.find('.slick-active').first().addClass('first-active');
                            $this.find('.slick-active').last().addClass('last-active');
                        });

                        // Updating the sliders in tab
                        $('body').on('shown.bs.tab', 'a[data-toggle="tab"], a[data-toggle="pill"]',
                            function(e) {
                                $this.slick('setPosition');
                            });
                    });
                }
            }


            function volume(color_id, title) {

                $('#cart_color_id').val(color_id);

                // $('.swatch-wrapper-color:first-child a').addClass('active');

                $('.color-label').html(title);

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    }
                });

                $.ajax({
                    url: "{{ route('get.sizes') }}",
                    type: 'POST',
                    data: {
                        product_id: "{{ $product->id }}",
                        color_id: color_id,
                    },
                    success: function(result) {

                        var success = result.success;
                        var images = result.color_images;

                        if (success) {

                            var html = '';

                            var prodSize = {!! json_encode($product->sizes) !!}
                            var unit = "{{ $product->unit ? $product->unit->unit : '' }}";
                            $('.size_lable').html(prodSize[0].title + ' ' + unit);

                            $('#cart_size_id').val(prodSize[0].size_id);

                            var productSizeObj = {

                            };

                            success.forEach(size => {
                                if (!productSizeObj[size.size_id]) {
                                    productSizeObj[size.size_id] = {};
                                }
                                productSizeObj[size.size_id] = size;
                            });

                            prodSize.forEach(data => {

                                html += `<div class="swatch-wrapper"><a class="product-size-swatch-btn variation-btn size_btn ${productSizeObj[data.size_id]? (productSizeObj[data.size_id].size_id ? '' : 'disabledClass'): 'disabledClass'}" data-toggle="tooltip"
                                data-placement="top" title="${data.title} {{ $product->unit ? $product->unit->unit : '' }}" data-size-id="${data.size_id}" >
                                <span class="product-size-swatch-label">${data.title}</span>
                            </a>
                        </div>`

                            });

                            navSlider = `<div class="mynavclass nav-slider slick-vertical" data-slick-options='{
                                        "slidesToShow": 4,
                                        "slidesToScroll": 4,
                                        "vertical": true,
                                        "swipe": true,
                                        "verticalSwiping": true,
                                        "infinite": true,
                                        "focusOnSelect": true,
                                        "asNavFor": ".main-slider",
                                        "arrows": true,
                                        "prevArrow": {"buttonClass": "slick-btn slick-prev", "iconClass": "fa fa-angle-up" },
                                        "nextArrow": {"buttonClass": "slick-btn slick-next", "iconClass": "fa fa-angle-down" }
                                    }'
                                    data-slick-responsive='[
                                        {
                                            "breakpoint":992,
                                            "settings": {
                                                "slidesToShow": 5,
                                                "vertical": false,
                                                "verticalSwiping": false
                                            }
                                        },
                                        {
                                            "breakpoint":575,
                                            "settings": {
                                                "centerMode" : true,
                                                "slidesToShow": 4,
                                                "vertical": false,
                                                "verticalSwiping": false
                                            }
                                        },
                                        {
                                            "breakpoint":480,
                                            "settings": {
                                                "centerMode" : true,
                                                "slidesToShow": 3,
                                                "vertical": false,
                                                "verticalSwiping": false
                                            }
                                        }
                                    ]'>`;
                            mainSlider = `<div class="main-slider">`;

                            images.forEach(image => {
                                navSlider += `
                            <figure class="product-gallery__thumb--single">
                                <img alt="Products" class="lazy thumb_img" data-lazy="${window.location.origin}/storage/images/multi-products/${image.image_url}">
                            </figure>`

                                mainSlider += `
                            <figure class="product-gallery__image zoom">
                                <img alt="Products" class="lazy big_img" data-lazy="${window.location.origin}/storage/images/multi-products/${image.image_url}" data_img = ${window.location.origin}/storage/images/multi-products/${image.image_url}">
                            </figure>`
                            });

                            navSlider += `</div>`
                            mainSlider += `</div>
                                        <div class="product-gallery__actions">
                                            <button class="action-btn btn-zoom-popup"><i class="fa fa-search-plus" aria-hidden="true"></i></button>
                                        </div>`

                            $('.product-gallery__thumb--image').html(navSlider);
                            $('.product-gallery__wrapper').html(mainSlider);

                            elementCarousel('.mynavclass');

                            $(".main-slider").not('.slick-initialized').slick({
                                lazyLoad: 'ondemand',
                                slidesToShow: 1,
                                slidesToScroll: 1,
                                swipe: true,
                                infinite: true,
                                arrows: true,
                                asNavFor: ".nav-slider",
                            });

                            $('.product-size-swatch').html(html);

                            $('.product-size-swatch-btn:first').addClass('active');
                            $('.product-size-swatch-btn:first').parent().addClass('active');

                            attachClickListener('.size_btn');

                            $(".disabledClass").parents('.swatch-wrapper').css({
                                "cursor": "no-drop",
                                "border": "1px solid red"
                            });


                        }
                    }
                });
            }

            function attachClickListener(elementName) {
                const elements = $(elementName);

                elements.each((index, element) => {

                    element.addEventListener('click', function() {

                        var size_id = $(element).attr('data-size-id');
                        var prod_id = $('#cart_prod_id').val();
                        var color_id = $('#cart_color_id').val();

                        getSizePrice(size_id, color_id, prod_id);

                        var title = $(element).attr('title');

                        $('.size_lable').html(title);

                        if ($(this).hasClass('disabledClass')) {

                            $('#cart_size_id').val('')

                            $('.size_lable').html(title + ' ' +
                                '<strong class="text-danger">Out of Stock</strong>');

                        } else {

                            $('#cart_size_id').val(size_id);

                            var item2 = $('.product-size-swatch-btn').hasClass('active');
                            var item1 = $('.product-size-swatch-btn').parent().hasClass('active');

                            if (item2) {
                                $('.product-size-swatch-btn').removeClass('active')
                            }
                            if (item1) {
                                $('.product-size-swatch-btn').parent().removeClass('active')
                            }

                            $(element).addClass('active');
                            $(element).parent().addClass('active');
                        }

                    });

                });

            }

        });

        function getSizePrice(size_id, color_id, prod_id) {


            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                }
            });

            $.ajax({
                url: "{{ route('get.size.price') }}",
                type: 'POST',
                data: {
                    product_id: prod_id,
                    color_id: color_id,
                    size_id: size_id,
                },
                success: function(result) {

                    var success = result.success;

                    if (success) {

                        $('#cart_size_id').val(size_id);

                        $('.mrp').html('<i class="fa fa-inr"></i> ' + success.mrp);

                        var getDiff = success.starting_price - success.mrp;
                        var getOffer = Math.round((getDiff / success.starting_price) * 100, 0);

                        $('.priceOffer').html('(' + getOffer + '% OFF)');

                        $('.starting_price').html('<i class="fa fa-inr"></i> ' + success.starting_price);

                    } else {

                        // swal('Error', result.error , 'error');
                    }
                }
            });

        }

        function isOfferExists(key) {
            if (sessionStorage.getItem('offers') && sessionStorage.getItem('offers')[key]) {
                return true;
            }
            return false;
        }

        function checkOfferQuantity(offer_counts, quantity) {

            var count = {!! json_encode($product->offer ? $product->offer->offered_quantity : '') !!};

            if (offer_counts >= count * quantity) {
                return false;
            }

            $('.offer_product ').removeClass('disabledOffer');

            return true;
        }
    </script>
@endsection
