@extends('layouts.master')
@section('title')Search @endsection
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
                                <span>Search </span>
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
                        <form action="{{ route('search') }}" method="GET" id="searchForm">
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
                                                <span class="color_div"
                                                    style="background-color: {{ $color->color_code }}"></span> {{ $color->title
                                                        }}
                                            </label>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="vendor-filter">
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
                            </div>
                            <div class="price-filter">
                                {{-- <h4 class="filter-title">Price</h4> --}}
                                <a href="#price-filter" data-bs-toggle="collapse" class="filter-link"><span>Price
                                    </span><i class="fa fa-angle-down"></i></a>
                                <ul class="all-price collapse" id="price-filter">
                                    {{-- <li class="f-price">
                                        <input type="checkbox" class="filter cb_price" name="price[]" id="price_0_1000"
                                            value="0-1000">
                                        <label for="price_0_1000">0-1000</label>
                                    </li> --}}
                                    {{-- <li class="f-price">
                                        <input type="checkbox" class="filter cb_price" name="price[]" id="price_1001_5000"
                                            value="1001-5000">
                                        <label for="price_1001_5000">1001-5000</label>
                                    </li>
                                    <li class="f-price">
                                        <input type="checkbox" class="filter cb_price" name="price[]" id="price_5001_10000"
                                            value="5001-10000">
                                        <label for="price_5001_10000">5001-10000</label>
                                    </li>
                                    <li class="f-price">
                                        <input type="checkbox" class="filter cb_price" name="price[]" id="price_10001"
                                            value="10001_plus">
                                        <label for="price_10001">10001 & more</label>
                                    </li> --}}
                                    <div class="input-group mb-3 mt-3 price-filter-group">
                                        <input type="text" id="amount" name="amount" class="form-control" />
                                        <button class="btn price-filter-btn" type="submit">Filter</button>
                                    </div>

                                    <div id="slider-range"></div>
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
                                                                $colors = explode(",", $product->color_codes);
                                                                $getDiff = $product->starting_price - $product->mrp;
                                                                $getOffer = round(($getDiff / $product->starting_price) * 100, 0);
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
                                                                                        class="fa fa-heart"></i></a>
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
                                                                            @foreach($colors as $color)
                                                                                <span
                                                                                    style="background: {{ $color }};border-radius:50%;height:10px;width:10px;display:inline-block;box-shadow: 1px 2px 3px 0px #5f5f5f"></span>
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
@endsection
@section('extrajs')
    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
    <script>
        $(document).ready(function () {

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

            var options = {
                range: true,
                min: 0,
                max: 50000,
                values: [0, 5000],
                slide: function (event, ui) {
                    var min = ui.values[0],
                        max = ui.values[1];

                    $("#amount").val('₹' + min + " - ₹" + max);
                    // filter();
                }
            }, min, max;

            $("#slider-range").slider(options);

            min = $("#slider-range").slider("values", 0);
            max = $("#slider-range").slider("values", 1);

            $("#amount").val('₹' + min + " - ₹" + max);
        });

        function submitFilterForm() {
            $('#searchForm').submit();
        }
    </script>
@endsection