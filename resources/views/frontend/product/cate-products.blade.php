@extends('layouts.master')
@section('title'){{ isset($category) ? $category->name : 'Search' }} @endsection
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
                                <span>{{ isset($category) ? $category->name : 'Search Results' }} </span>
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
                        <form action="{{ request()->routeIs('search') ? route('search') : route('categories.filter') }}"
                            method="GET" id="searchForm">

                            <!-- Brands -->
                            @if(isset($brands) && count($brands) > 0)
                                <div class="vendor-filter">
                                    <h4 class="filter-title">Brands</h4>
                                    <a href="#brand-filter" data-bs-toggle="collapse" class="filter-link"><span>Brands</span><i
                                            class="fa fa-angle-down"></i></a>
                                    <ul class="all-vendor collapse show" id="brand-filter">
                                        @foreach ($brands as $brand)
                                            <li class="f-vendor">
                                                <input type="checkbox" class="filter cb_brands" name="brands[]"
                                                    id="brand_{{ $brand->id }}" value="{{ $brand->id }}">
                                                <label for="brand_{{ $brand->id }}" style="margin-left: 9px">
                                                    {{ $brand->brand_name }}
                                                </label>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <!-- Conditions -->
                            @if(isset($conditions) && count($conditions) > 0)
                                <div class="vendor-filter">
                                    <h4 class="filter-title">Conditions</h4>
                                    <a href="#condition-filter" data-bs-toggle="collapse"
                                        class="filter-link"><span>Conditions</span><i class="fa fa-angle-down"></i></a>
                                    <ul class="all-vendor collapse show" id="condition-filter">
                                        @foreach ($conditions as $cond)
                                            <li class="f-vendor">
                                                <input type="checkbox" class="filter cb_conditions" name="conditions[]"
                                                    id="condition_{{ $cond->id }}" value="{{ $cond->id }}">
                                                <label for="condition_{{ $cond->id }}" style="margin-left: 9px">
                                                    {{ $cond->condition }}
                                                </label>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <!-- Colors -->
                            @if(isset($colors) && count($colors) > 0)
                                <div class="vendor-filter">
                                    <h4 class="filter-title">Colors</h4>
                                    <a href="#color" data-bs-toggle="collapse" class="filter-link"><span>Colors</span><i
                                            class="fa fa-angle-down"></i></a>
                                    <ul class="all-vendor collapse show" id="color">
                                        @foreach ($colors as $color)
                                            <li class="f-vendor">
                                                <input type="checkbox" class="filter cb_colors" name="colors[]"
                                                    id="color_{{ $color->id }}" value="{{ $color->id }}">
                                                <label for="color_{{ $color->id }}" style="margin-left: 9px">
                                                    <span class="color_div"
                                                        style="background-color: {{ $color->color_code }}; display:inline-block; width:15px; height:15px; border-radius:50%;"></span>
                                                    {{ $color->title }}
                                                </label>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <!-- Volumes -->
                            @if(isset($sizes) && count($sizes) > 0)
                                <div class="vendor-filter">
                                    <h4 class="filter-title">Sizes</h4>
                                    <a href="#size" data-bs-toggle="collapse" class="filter-link"><span>Sizes</span><i
                                            class="fa fa-angle-down"></i></a>
                                    <ul class="all-vendor collapse show" id="size">
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
                                </div>
                            @endif

                            <!-- Price Range -->
                            <div class="price-filter">
                                <a href="#price-filter" data-bs-toggle="collapse" class="filter-link"><span>Price
                                        Range</span><i class="fa fa-angle-down"></i></a>
                                <ul class="all-price collapse show" id="price-filter" style="padding: 10px 15px;">
                                    <span id="price-range-label"
                                        style="font-size: 14px; font-weight: 600; color: #333; display: block; margin-bottom: 15px;">Price:
                                        ₹0 - ₹5000</span>
                                    <input type="hidden" id="amount" name="amount" />
                                    <div id="slider-range"></div>
                                </ul>
                            </div>

                            @if(isset($category))
                                <input type="hidden" name="category_id" value="{{ $category->id }}">
                            @endif
                            @if(request()->has('q'))
                                <input type="hidden" name="q" value="{{ request('q') }}">
                            @endif
                        </form>
                    </div>
                </div>

                <div class="col-lg-9 col-md-8 col-12">
                    <div class="grid-list-area">
                        <div class="grid-pro">
                            <ul class="grid-product">
                                @forelse ($products as $product)
                                                            @php
                                                                $color_arr = explode(",", $product->color_codes);
                                                                $getDiff = $product->starting_price - $product->mrp;
                                                                $getOffer = $product->starting_price > 0 ? round(($getDiff / $product->starting_price) * 100, 0) : 0;
                                                            @endphp
                                                            <li class="grid-items">
                                                                <div class="tred-pro">
                                                                    <div class="tr-pro-img">
                                                                        <a href="{{ route('product', $product->slug_url) }}">
                                                                            <img class="img-fluid"
                                                                                src="{!! asset('storage/images/products/' . $product->image_url) !!}"
                                                                                alt="{{ $product->title }}">
                                                                            <img class="img-fluid additional-image"
                                                                                src="{!! asset('storage/images/products/' . $product->image_url1) !!}"
                                                                                alt="{{ $product->title }}">
                                                                        </a>
                                                                    </div>
                                                                    <div class="Pro-lable">
                                                                        <span class="p-text">New</span>
                                                                        <span class="p-discount"> {{ $getOffer }}% off</span>
                                                                    </div>
                                                                    <div class="pro-icn">
                                                                        @if(auth('user')->check())
                                                                            @php
                                                                                $wishlistItem = auth('user')->user()->wishlists->where('product_id', $product->id)->first();
                                                                            @endphp
                                                                            @if ($wishlistItem)
                                                                                <a href="javascript:void(0)" class="w-c-q-icn wishlist-remove"
                                                                                    data-w-id="{{ $wishlistItem->id }}" title="Remove from Wishlist"><i
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
                                                                <div class="caption">
                                                                    <h3>
                                                                        <span class="pull-left">
                                                                            <a href="{{ route('product', $product->slug_url) }}">
                                                                                {{ Str::length($product->title) > 20 ? Str::substr(
                                        $product->title,
                                        0,
                                        20
                                    ) .
                                        '...' : $product->title }}
                                                                            </a>
                                                                        </span>
                                                                        <span class="pull-right">
                                                                            <span style="display:none"></span>
                                                                            @foreach($color_arr as $color_val)
                                                                                @if(!empty(trim($color_val)))
                                                                                    <span
                                                                                        style="background: {{ $color_val }};border-radius:50%;height:10px;width:10px;display:inline-block;box-shadow: 1px 2px 3px 0px #5f5f5f"></span>
                                                                                @endif
                                                                            @endforeach
                                                                        </span>
                                                                        <div class="clearfix"></div>
                                                                    </h3>
                                                                    <div>
                                                                        <div class="pro-price pull-left">
                                                                            <span class="new-price"><i class="fa fa-inr"></i> {{ $product->mrp }}</span>
                                                                            <span class="old-price"><del><i class="fa fa-inr"></i> {{
                                        $product->starting_price
                                                                                                                                                    }}</del></span>
                                                                        </div>
                                                                        @if($product->review_status)
                                                                            <div class="rating pull-right">
                                                                                @for($i = 1; $i <= $product->rating; $i++)
                                                                                    <i class="fa fa-star b-star"></i>
                                                                                @endfor
                                                                                @for($i = 1; $i <= 5 - $product->rating; $i++)
                                                                                    <i class="fa fa-star-o"></i>
                                                                                @endfor
                                                                            </div>
                                                                        @endif
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
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
    <style>
        #slider-range {
            height: 6px !important;
            background: #e9ecef !important;
            border: none !important;
            border-radius: 10px !important;
            margin: 15px 5px 25px 5px !important;
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
    </style>
@endsection

@section('extrajs')
    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
    <script>
        $(document).ready(function () {

            $('.filter').click(function () {
                submitFilterForm();
            });

            var old_brands = {!! json_encode($input->brands ?? []) !!};
            if (old_brands && typeof old_brands == "object") {
                for (x of old_brands) {
                    $(".cb_brands[value=" + x + "]").prop("checked", true);
                }
            }

            var old_conditions = {!! json_encode($input->conditions ?? []) !!};
            if (old_conditions && typeof old_conditions == "object") {
                for (x of old_conditions) {
                    $(".cb_conditions[value=" + x + "]").prop("checked", true);
                }
            }

            var old_colors = {!! json_encode($input->colors ?? []) !!};
            if (old_colors && typeof old_colors == "object") {
                for (x of old_colors) {
                    $(".cb_colors[value=" + x + "]").prop("checked", true);
                }
            }

            var old_sizes = {!! json_encode($input->sizes ?? []) !!};
            if (old_sizes && typeof old_sizes == "object") {
                for (x of old_sizes) {
                    $(".cb_sizes[value=" + x + "]").prop("checked", true);
                }
            }

            var max_price = {{ isset($max_price) && $max_price > 0 ? $max_price : 50000 }};
            var current_amount = "{!! request('amount') !!}";
            var cur_min = 0;
            var cur_max = max_price;

            if (current_amount) {
                var replaced_amt = current_amount.replace(/₹/g, '').replace(/ /g, '');
                var explode_amt = replaced_amt.split('-');
                if (explode_amt.length == 2) {
                    cur_min = parseInt(explode_amt[0]);
                    cur_max = parseInt(explode_amt[1]);
                }
            }

            var options = {
                range: true,
                min: 0,
                max: max_price,
                values: [cur_min, cur_max],
                slide: function (event, ui) {
                    var min = ui.values[0],
                        max = ui.values[1];

                    $("#amount").val('₹' + min + " - ₹" + max);
                    $("#price-range-label").text('Price: ₹' + min + " - ₹" + max);
                },
                stop: function (event, ui) {
                    submitFilterForm();
                }
            };

            $("#slider-range").slider(options);
            $("#amount").val('₹' + $("#slider-range").slider("values", 0) + " - ₹" + $("#slider-range").slider("values", 1));
            $("#price-range-label").text('Price: ₹' + $("#slider-range").slider("values", 0) + " - ₹" + $("#slider-range").slider("values", 1));
        });

        function submitFilterForm() {
            $('#searchForm').submit();
        }
    </script>
@endsection