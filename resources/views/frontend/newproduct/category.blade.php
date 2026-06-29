@extends('layouts.master')
@section('title')
    {{ $category->name }}
@endsection
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
                                <span>{{ $category->name }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- breadcrumb end -->
    <!-- grid-list start -->
    <section class="section-tb-padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-4 col-12">
                    <div class="all-filter">
                        <form action="{{ route('cate', $category->slug_url) }}" method="GET" id="searchForm">
                            {{-- <div class="categories-page-filter">
                                <h4 class="filter-title">Categories</h4>
                                <a href="#category-filter" data-bs-toggle="collapse" class="filter-link">
                                    <span>Categories</span><i class="fa fa-angle-down"></i>
                                </a>
                                <ul class="all-option collapse" id="category-filter">
                                    @foreach ($categories as $cate)
                                    <li class="grid-list-option f-price">
                                        <input type="checkbox" class="filter cb_category" name="category[]"
                                            id="category_{{ $cate->id }}" value="{{ $cate->id }}">
                                        <label for="category_{{ $cate->id }}" style="margin-left: 9px">
                                            {{ $cate->category_name }}
                                        </label>
                                    </li>
                                    @endforeach
                                </ul>
                            </div> --}}
                            <div class="vendor-filter">
                                <h4 class="filter-title">Colors</h4>
                                <a href="#color" data-bs-toggle="collapse" class="filter-link"><span>Colors
                                    </span><i class="fa fa-angle-down"></i></a>
                                <ul class="all-vendor collapse" id="color">
                                    @foreach ($colors as $color)
                                        <li class="f-vendor">
                                            <input type="checkbox" class="filter cb_colors" name="colors[]"
                                                id="color_{{ $color->id }}" value="{{ $color->id }}">
                                            <label for="color_{{ $color->id }}" style="margin-left: 9px">
                                                {{ $color->title }} <span
                                                    style="background-color: {{ $color->color_code }}"></span>
                                            </label>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            {{-- <div class="vendor-filter">
                                <h4 class="filter-title">Sizes</h4>
                                <a href="#size" data-bs-toggle="collapse" class="filter-link"><span>Sizes
                                    </span><i class="fa fa-angle-down"></i></a>
                                <ul class="all-vendor collapse" id="size">
                                    @foreach ($sizes as $size)
                                    <li class="f-vendor">
                                        <input type="checkbox" class="filter cb_sizes" name="sizes[]"
                                            id="size_{{ $size->id }}" value="{{ $size->id }}">
                                        <label for="size_{{ $size->id }}" style="margin-left: 9px">
                                            {{ $size->title }}
                                        </label>
                                    </li>
                                    @endforeach
                                </ul>
                            </div> --}}
                            <div class="price-filter">
                                <h4 class="filter-title">Price</h4>
                                <a href="#price-filter" data-bs-toggle="collapse" class="filter-link"><span>Price
                                    </span><i class="fa fa-angle-down"></i></a>
                                <ul class="all-price collapse" id="price-filter">

                                    <div class="price-range-display mb-3 mt-3">
                                        <span id="price-range-label" style="font-weight: 600; color: #333;">Price: ₹0 -
                                            ₹{{ $max_price }}</span>
                                        <input type="hidden" id="amount" name="amount" />
                                    </div>

                                    <div id="slider-range" class="mb-4"></div>
                                </ul>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-9 col-md-8 col-12">
                    <div class="grid-list-area">
                        <div class="grid-pro">
                            <ul class="grid-product">
                                @forelse ($products as $product)
                                    @php
                                        $colors = explode(',', $product->color_codes);
                                        $getDiff = $product->starting_price - $product->mrp;
                                        if ($getDiff > 0) {
                                            $getOffer = round(($getDiff / $product->starting_price) * 100, 0);
                                        } else {
                                            $getOffer = 0;
                                        }
                                    @endphp
                                    <li class="grid-items">
                                        <div class="tred-pro">
                                            <div class="tr-pro-img">

                                                <a href="{{ route('product', $product->slug_url) }}">
                                                    <img class="img-fluid"
                                                        src="{{ asset('/storage/images/products') . '/' . $product->image_url }}"
                                                        alt="{{ $product->title }}">
                                                    <img class="img-fluid additional-image"
                                                        src="{{ asset('/storage/images/products/') . '/' . $product->image_url1 }}"
                                                        alt="{{ $product->title }}">
                                                    {{-- {{dd($product->slug_url)}}; --}}
                                                    {{-- {{dd($product->image_url)}}; --}}

                                                </a>
                                            </div>
                                            <div class="Pro-lable">
                                                <span class="p-text">New</span>
                                                @if ($getOffer > 0)
                                                    <span class="p-discount"> {{ $getOffer }}% off</span>
                                                @endif
                                            </div>
                                            <div class="pro-icn">
                                                @if (auth('user')->check())
                                                    @if (auth('user')->user()->id == $product->w_u_id && $product->w_product_id == $product->id)
                                                        <a href="javascript:void(0)" class="w-c-q-icn wishlist-remove"
                                                            data-w-id="{{ $product->w_id }}" title="Remove from Wishlist"><i
                                                                class="fa fa-heart" style="color: var(--theme-color) !important;"></i></a>
                                                    @else
                                                        <a href="javascript:void(0)" class="w-c-q-icn wishlist"
                                                            data-p-id="{{ $product->id }}" data-c-id="{{ $product->c_id }}"
                                                            data-s-id="{{ $product->s_id }}" title="Add to Wishlist"><i
                                                                class="fa fa-heart-o"></i></a>
                                                    @endif
                                                @else
                                                    <a href="javascript:void(0)" class="w-c-q-icn wishlist-login"
                                                        title="Add to Wishlist"><i class="fa fa-heart-o"></i></a>
                                                @endif
                                                <a href="javascript:void(0)"
                                                    onclick="addToCart('{{ $product->id }}', '{{ $product->stock }}', '{{ $product->c_id }}', '{{ $product->s_id }}')"
                                                    class="w-c-q-icn" title="Add to Cart"><i class="fa fa-shopping-bag"></i></a>
                                                <a href="{{ route('product', $product->slug_url) }}" class="w-c-q-icn"><i
                                                        class="fa fa-eye"></i></a>
                                            </div>
                                        </div>
                                        <div class="caption caption-9">
                                            <h3>
                                                <span class="pull-left">
                                                    <a href="{{ route('product', $product->slug_url) }}">
                                                        {{ Str::length($product->title) > 20 ? Str::substr($product->title, 0, 20) . '...' : $product->title }}
                                                    </a>
                                                </span>
                                                <span class="pull-left">
                                                    @foreach ($colors as $color)
                                                        <span
                                                            style="background: {{ $color }};border-radius:50%;height:10px;width:10px;display:inline-block;box-shadow: 1px 2px 3px 0px #5f5f5f;opacity:1"></span>
                                                    @endforeach
                                                </span>
                                                <div class="clearfix"></div>
                                            </h3>
                                            <div>
                                                <div class="price-star">
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
                                                    <div class="pro-price pull-left">
                                                        <span class="new-price"><i class="fa fa-inr"></i>
                                                            {{ $product->mrp }}</span>
                                                        @if ($product->mrp < $product->starting_price)
                                                            <span class="old-price"><del><i class="fa fa-inr"></i>
                                                                    {{ $product->starting_price }}</del></span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>

                                @empty
                                    <li>
                                        <h3 class="text-danger">No Product Found...</h3>
                                    </li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                    {{ $products->links('vendor.pagination.default') }}
                </div>
            </div>
        </div>
    </section>
    <!-- grid-list start -->

@endsection
@section('extracss')
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
    <style>
        #slider-range {
            height: 6px !important;
            background: #e9ecef !important;
            border: none !important;
            border-radius: 10px !important;
            margin: 25px 10px 15px 10px !important;
            position: relative;
        }

        #slider-range .ui-slider-range {
            background: #670cb1 !important;
            border: none !important;
        }

        #slider-range .ui-slider-handle {
            width: 22px !important;
            height: 22px !important;
            background: #fff !important;
            border: 3px solid #670cb1 !important;
            border-radius: 50% !important;
            cursor: pointer !important;
            top: -9px !important;
            outline: none !important;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2) !important;
            z-index: 2;
        }

        #slider-range .ui-slider-handle:hover {
            background: #670cb1 !important;
        }

        #price-range-label {
            font-size: 16px;
            font-weight: 600;
            color: #333;
            display: block;
            margin-bottom: 5px;
        }
    </style>
@endsection
@section('extrajs')
    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
    <script>
        $(document).ready(function () {
            console.log("Slider script initializing...");

            $('.filter').click(function () {
                submitFilterForm();
            });

            var old_category = {!! json_encode($input->category) !!};
            if (old_category && typeof old_category == "object") {
                for (x of old_category) {
                    $(".cb_category[value=" + x + "]").attr("checked", "checked");
                }
            }

            var old_colors = {!! json_encode($input->colors) !!};
            if (old_colors && typeof old_colors == "object") {
                for (x of old_colors) {
                    $(".cb_colors[value=" + x + "]").attr("checked", "checked");
                }
            }

            var old_sizes = {!! json_encode($input->sizes) !!};
            if (old_sizes && typeof old_sizes == "object") {
                for (x of old_sizes) {
                    $(".cb_sizes[value=" + x + "]").attr("checked", "checked");
                }
            }

            // Wait a bit to ensure jQuery UI is fully ready
            setTimeout(function () {
                if (typeof $.fn.slider === 'undefined') {
                    console.error("jQuery UI Slider is not loaded!");
                    return;
                }

                var max_price = {{ $max_price ?? 5000 }};
                var current_min = 0;
                var current_max = max_price;

                // Parse existing amount if present
                var amount_val = "{{ $input->amount ?? '' }}";
                if (amount_val) {
                    var cleaned_amt = amount_val.replace(/₹/g, '');
                    var parts = cleaned_amt.split('-');
                    if (parts.length === 2) {
                        current_min = parseInt(parts[0].trim());
                        current_max = parseInt(parts[1].trim());
                    }
                }

                console.log("Initializing slider with max:", max_price, "values:", [current_min, current_max]);

                $("#slider-range").slider({
                    range: true,
                    min: 0,
                    max: max_price,
                    values: [current_min, current_max],
                    slide: function (event, ui) {
                        $("#amount").val('₹' + ui.values[0] + " - ₹" + ui.values[1]);
                        $("#price-range-label").text('Price: ₹' + ui.values[0] + " - ₹" + ui.values[1]);
                    },
                    stop: function (event, ui) {
                        submitFilterForm();
                    }
                });

                $("#amount").val('₹' + $("#slider-range").slider("values", 0) + " - ₹" + $("#slider-range").slider("values", 1));
                $("#price-range-label").text('Price: ₹' + $("#slider-range").slider("values", 0) + " - ₹" + $("#slider-range").slider("values", 1));

                console.log("Slider initialized successfully.");
            }, 500);
        });

        function submitFilterForm() {
            $('#searchForm').submit();
        }
    </script>
@endsection