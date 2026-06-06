@extends('layouts.admin-master')
@section('title', 'Add Products')
@section('extracss')
    <style>
        #category_id+ul.category_div {
            height: 130px;
            overflow-x: auto;
        }

        #section_id {
            height: 155px;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 42px !important;
        }

        .form-block {
            border: 1px solid #e4e6fc;
            border-radius: 5px;
            padding: 20px;
            margin-bottom: 30px;
            background-color: #fdfdff;
        }

        .block-title {
            color: #34395e;
            font-weight: bold;
            margin-bottom: 20px;
            border-bottom: 1px solid #e4e6fc;
            padding-bottom: 10px;
        }
    </style>
@endsection

@section('content')

    <section class="section">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-dark text-white-all">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.dashboard') }}"><i class="fas fa-home"></i>
                        Dashboard
                    </a>
                </li>
                <li class="breadcrumb-item"><a href="{{ route('admin.products.all') }}"> All Products</a></li>
            </ol>
        </nav>

        <div class="card" ng-app="products">
            <div class="card-header bg-dark text-white-all">
                <h4>Add New Product</h4>
            </div>
            <div class="card-body">
                <form method="POST" role="form" class="needs-validation" id="formAddProduct"
                    enctype="multipart/form-data" autocomplete="off">
                    @csrf
                    <div class="card-body">
                        <!-- Block 1: Product Details -->
                        <div class="form-block">
                            <h6 class="block-title">Product Details</h6>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="category_id">Select Category <span class="text-danger">*</span></label>
                                        <select name="category_id" class="form-control select2" id="category_id" required>
                                            <option value=""> --Select Category--</option>
                                            @foreach ($categories as $cate)
                                                <option value="{{ $cate->id }}"
                                                    {{ old('category_id') == $cate->id ? 'selected' : '' }}>
                                                    {{ $cate->pcategory ? $cate->pcategory->name . ' > ' . $cate->name : $cate->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <label id="" class="error" for="category_id"></label>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="title">Name <span class="text-danger">*</span></label>
                                        <input type="text" name="title" id="title" class="form-control"
                                            value="{{ old('title') }}" placeholder="Enter Product Name" required>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="brand_id">Brand <span class="text-danger">*</span></label>
                                        <select name="brand_id" id="brand_id" class="form-control select2" required>
                                            <option value="">--Select Brand--</option>
                                            @foreach ($brands as $brand)
                                                <option value="{{ $brand->id }}"
                                                    {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
                                                    {{ $brand->brand_name }}</option>
                                            @endforeach
                                        </select>
                                        <label id="" class="error" for="brand_id"></label>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="upc">EAN/UPC </label>
                                        <input type="text" name="upc" id="upc" class="form-control"
                                            value="{{ old('upc') }}" placeholder="Enter EAN/UPC">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="material_id">Material <span class="text-danger">*</span></label>
                                        <select name="material_id" id="material_id" class="form-control select2" required>
                                            <option value="">--Select Material--</option>
                                            @foreach ($materials as $material)
                                                <option value="{{ $material->id }}"
                                                    {{ old('material_id') == $material->id ? 'selected' : '' }}>
                                                    {{ $material->material_name }}</option>
                                            @endforeach
                                        </select>
                                        <label id="" class="error" for="material_id"></label>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="gst_id">Gst </label>
                                        <select name="gst_id" id="gst_id" class="form-control select2">
                                            <option value="">--Select Gst--</option>
                                            @foreach ($gsts as $gst)
                                                <option value="{{ $gst->id }}"
                                                    {{ old('gst_id') == $gst->id ? 'selected' : '' }}
                                                    data-value="{{ $gst->gst_value }}">
                                                    {{ $gst->gst_value }}%
                                                </option>
                                            @endforeach
                                        </select>
                                        <label id="" class="error" for="gst_id"></label>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="condition_id">Condition </label>
                                        <select name="condition_id" id="condition_id" class="form-control select2">
                                            <option value="">--Select Condition--</option>
                                            @foreach ($conditions as $condition)
                                                <option value="{{ $condition->id }}"
                                                    {{ old('condition_id') == $condition->id ? 'selected' : '' }}>
                                                    {{ $condition->condition }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="warranty_id">Warranty</label>
                                        <select name="warranty_id" id="warranty_id" class="form-control select2">
                                            <option value="">--Select Warranty--</option>
                                            @foreach ($warranties as $warranty)
                                                <option value="{{ $warranty->id }}"
                                                    {{ old('warranty_id') == $warranty->id ? 'selected' : '' }}>
                                                    {{ $warranty->title }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="image_url">Front Image <span class="text-danger">*</span></label>
                                        <div class="custom-file">
                                            <input type="file" name="image_url" class="custom-file-input"
                                                id="image_url" required>
                                            <label class="custom-file-label" for="image_url">Choose file</label>
                                        </div>
                                        <label id="" class="error" for="image_url"></label>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="image_url1">Back Image <span class="text-danger">*</span></label>
                                        <div class="custom-file">
                                            <input type="file" name="image_url1" class="custom-file-input"
                                                id="image_url1" required>
                                            <label class="custom-file-label" for="image_url1">Choose file</label>
                                        </div>
                                        <label id="" class="error" for="image_url1"></label>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="image_urls">Color Images <span class="text-danger">*</span></label>
                                        <div class="custom-file">
                                            <input type="file" name="image_urls[]" class="custom-file-input"
                                                id="image_urls" accept="image/jpeg,image/png" multiple required>
                                            <label class="custom-file-label" for="image_urls">Choose file</label>
                                        </div>
                                        <label id="" class="error" for="image_urls"></label>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="color_id">Color <span class="text-danger">*</span></label>
                                        <select name="color_id" id="color_id" class="form-control select2" required>
                                            <option value="">--Select Color--</option>
                                            @foreach ($colors as $color)
                                                <option value="{{ $color->id }}"
                                                    {{ old('color_id') == $color->id ? 'selected' : '' }}>
                                                    {{ $color->title }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <label id="" class="error" for="color_id"></label>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="size_id">Sizes</label>
                                        <select name="size_id" id="size_id" class="form-control select2">
                                            <option value="1">--Select Sizes--</option>
                                            @foreach ($sizes as $size)
                                                <option value="{{ $size->id }}"
                                                    {{ old('size_id') == $size->id ? 'selected' : '' }}>
                                                    {{ $size->title }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <label id="" class="error" for="size_id"></label>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="starting_price">Mrp <span class="text-danger">*</span></label>
                                        <input type="number" name="starting_price" id="starting_price"
                                            class="form-control" value="{{ old('starting_price') }}"
                                            placeholder="Enter Mrp" min="1">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="mrp">Selling Price <span class="text-danger">*</span></label>
                                        <input type="text" name="mrp" id="mrp" class="form-control"
                                            value="{{ old('mrp') }}" placeholder="Enter Selling Price" required>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="stock">Stock <span class="text-danger">*</span></label>
                                        <input type="number" name="stock" id="stock" class="form-control"
                                            value="{{ old('stock', 0) }}" min="0" placeholder="Enter Stock"
                                            required>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="sort_index">Sort Index <span class="text-danger">*</span></label>
                                        <input type="number" name="sort_index" id="sort_index" class="form-control"
                                            value="{{ old('sort_index') }}" min="1"
                                            placeholder="Enter Sort Index" required>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="product_sort_index">Product Sort Index <span class="text-muted">(optional)</span></label>
                                        <input type="number" name="product_sort_index" id="product_sort_index" class="form-control"
                                            value="{{ old('product_sort_index') }}" min="1" placeholder="Enter Product Sort Index (optional)">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="weight">Weight </label>
                                        <input type="text" name="weight" id="weight" class="form-control"
                                            value="{{ old('weight') }}" placeholder="Enter weight">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="weight_id">Unit </label>
                                        <select name="weight_id" id="weight_id" class="form-control select2">
                                            <option value="">--Select Unit--</option>
                                            @foreach ($units as $unit)
                                                <option value="{{ $unit->id }}"
                                                    {{ old('weight_id') == $unit->id ? 'selected' : '' }}>
                                                    {{ $unit->unit }}</option>
                                            @endforeach
                                        </select>
                                        <label id="" class="error" for="weight_id"></label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Block 2: Product Dimensions -->
                        <div class="form-block">
                            <h6 class="block-title">Product Dimensions</h6>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="length">Length </label>
                                        <input type="text" name="length" id="length" class="form-control"
                                            value="{{ old('length') }}" placeholder="Enter length">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="width">Width </label>
                                        <input type="text" name="width" id="width" class="form-control"
                                            value="{{ old('width') }}" placeholder="Enter width">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="height">Height </label>
                                        <input type="text" name="height" id="height" class="form-control"
                                            value="{{ old('height') }}" placeholder="Enter height">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="dimension_unit">Unit </label>
                                        <select name="dimension_unit" id="dimension_unit" class="form-control">
                                            <option value="">--Select Unit--</option>
                                            @foreach ($lengthUnits as $unit)
                                                <option value="{{ $unit->id }}"
                                                    {{ old('dimension_unit') == $unit->id ? 'selected' : '' }}>
                                                    {{ $unit->unit }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>


                            </div>
                        </div>

                        <!-- Block 3: Condition -->
                        <div class="form-block">
                            <h6 class="block-title">Conditions</h6>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="is_cod">Cod Available <span class="text-danger">*</span></label>
                                        <select name="is_cod" id="is_cod" class="form-control" required>
                                            <option value="">--Select Cod Availability--</option>
                                            <option value="1" {{ old('is_cod') == true ? 'selected' : '' }}>
                                                Available
                                            </option>
                                            <option value="0" {{ old('is_cod') == false ? 'selected' : '' }}>Not
                                                Available
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="review_status">Review Status <span
                                                class="text-danger">*</span></label>
                                        <select name="review_status" id="review_status" class="form-control" required>
                                            <option value="">-- Select --</option>
                                            <option value="1" {{ old('review_status') == true ? 'selected' : '' }}>
                                                Available
                                            </option>
                                            <option value="0" {{ old('review_status') == false ? 'selected' : '' }}>
                                                Not
                                                Available
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="status">Status <span class="text-danger">*</span></label>
                                        <select name="status" id="status" class="form-control" required>
                                            <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Active
                                            </option>
                                            <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Inactive
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                {{-- <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="offer_id">Offer <span class="text-warning">( Select Any if want to
                                                give offer )</span></label>
                                        <select name="offer_id" id="offer_id" class="form-control">
                                            <option value="">--Select Offer--</option>
                                            @foreach ($offers as $ofr)
                                                <option value="{{ $ofr->id }}"
                                                    {{ old('offer_id') == $ofr->id ? 'selected' : '' }}>
                                                    {{ $ofr->title }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4 offer_div">
                                    <div class="form-group">
                                        <label for="purchase_quantity">Purchase Quantity <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="purchase_quantity" id="purchase_quantity"
                                            class="form-control" value="{{ old('purchase_quantity') }}"
                                            placeholder="Enter Purchase Quantity">
                                    </div>
                                </div>

                                <div class="col-md-4 offer_div">
                                    <div class="form-group">
                                        <label for="offered_quantity">Offered Quantity <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="offered_quantity" id="offered_quantity"
                                            class="form-control" value="{{ old('offered_quantity') }}"
                                            placeholder="Enter Offered Quantity">
                                    </div>
                                </div> --}}

                                <div class="col-md-8 mb-3">
                                    <label>Return Policy </label> <br>
                                    <div class="form-check form-check-inline">
                                        <div class="custom-control custom-radio my-1 mr-sm-2">
                                            <input type="radio" class="custom-control-input" id="within_days"
                                                name="return_policy" value="within_days" {{ old('return_policy') == 'within_days' ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="within_days">Within 7 Days</label>
                                        </div>

                                        <div class="custom-control custom-radio my-1 mr-sm-2">
                                            <input type="radio" class="custom-control-input" id="non_returnable"
                                                name="return_policy" value="non_returnable" {{ old('return_policy') == 'non_returnable' ? 'checked' : '' }}>
                                            <label class="custom-control-label text-danger fw-bold"
                                                for="non_returnable">Non Returnable</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Common Additional Fields -->
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="description">Description <span class="text-danger">*</span></label>
                                <textarea name="description" id="description" rows="5" class="form-control summernote">{{ old('description') }}</textarea>
                            </div>
                        </div>

                        <div class="col-md-12 d-none">
                            <div class="form-group">
                                <label for="description">Size Cart <span class="text-danger">*</span></label>
                                <textarea name="sizecart" id="sizecart" rows="5" class="form-control summernote">asdasdasdsad</textarea>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="keywords">Keywords </span><span class="text-danger">*</span> <span
                                        class="text-warning">(Use Comma "," to seperate keywords)</span></label>
                                <textarea name="keywords" id="keywords" rows="5" class="form-control">{{ old('keywords') }}</textarea>
                            </div>
                        </div>

                        <div class="col-md-6" ng-controller="productsCtrl">
                            <label>Custom Fields </label>
                            <div class="table-responsive">
                                <table class="table">
                                    <tr>
                                        <td colspan="2">
                                            <a href="javascript:void(0)" title="Remove Field"
                                                class="btn-danger btn btn-sm pull-left" ng-click="removefield()">
                                                <i class="fas fa-minus"></i>
                                            </a>
                                        </td>
                                        <td>
                                            <a href="javascript:void(0)" title="Add More Field"
                                                class="btn-success btn btn-sm pull-right" ng-click="addfield()">
                                                <i class="fa fa-plus fa-fw text-white"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Sr.</th>
                                        <th>Field Name</th>
                                        <th>Field Value</th>
                                    </tr>
                                    <tr class="table-row-sizes" ng-repeat="size in sizes track by $index">
                                        <td ng-bind="$index + 1"></td>
                                        <td>
                                            <input type="text" name="field_name[(=:$index:=)]"
                                                ng-value="field_name[$index]" class="form-control">
                                        </td>
                                        <td>
                                            <input type="text" name="field_value[(=:$index:=)]"
                                                ng-value="field_value[$index]" class="form-control">
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div class="col-md-12 text-danger">
                            Note : All * Mark Fields are Compulsory !
                        </div>

                        <div class="col-md-12 text-center">
                            <button type="submit" class="btn btn-primary btnSubmit">
                                <i class="fa fa-plus"></i> Add Product
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </section>

@endsection

@section('extrajs')

    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.7.2/angular.min.js"></script>

    <script>
        $(document).ready(function() {

            $("#formAddProduct").validate({
                rules: {
                    category_id: {
                        required: true
                    },

                    title: {
                        required: true
                    },

                    brand_id: {
                        required: true
                    },

                    material_id: {
                        required: true
                    },

                    image_url: {
                        required: true
                    },

                    image_url1: {
                        required: true
                    },

                    is_cod: {
                        required: true
                    },

                    review_status: {
                        required: true
                    },

                    description: {
                        required: true
                    },

                    keywords: {
                        required: true
                    },

                    color_id: {
                        required: true
                    },

                    "image_urls[]": {
                        required: true
                    },

                    // size_id: {
                    //     required: true
                    // },

                    mrp: {
                        required: true
                    },

                    starting_price: {
                        required: true
                    },

                    stock: {
                        required: true
                    },

                    sort_index: {
                        required: true
                    },
                },
                messages: {

                    category_id: {
                        required: "Please Select Category"
                    },

                    title: {
                        required: "Please Enter Product Name"
                    },

                    brand_id: {
                        required: "Please Select Brand"
                    },

                    material_id: {
                        required: "Please Select Material"
                    },

                    image_url: {
                        required: "Please Upload Front Image"
                    },

                    image_url1: {
                        required: "Please Upload Back Image"
                    },

                    color_id: {
                        required: "Please Select Color"
                    },
                    // size_id: {
                    //     required: "Please Select Sizes"
                    // },

                    is_cod: {
                        required: "Please Select COD Availability"
                    },

                    review_status: {
                        required: "Please Select Review Status"
                    },

                    description: {
                        required: "Please Enter Description of Product"
                    },

                    keywords: {
                        required: "Please Enter Keywords of Product"
                    },

                    mrp: {
                        required: "Please Enter MRP"
                    },

                    starting_price: {
                        required: "Please Enter MRP"
                    },

                    stock: {
                        required: "Please Enter Stock"
                    },

                    sort_index: {
                        required: "Please Enter Sort Index"
                    },

                    "image_urls[]": {
                        required: "Please Upload Color Images"
                    },
                },
                submitHandler: function(form) {
                    $('.btnSubmit').attr('disabled', 'disabled');
                    $(".btnSubmit").html('<span class="fa fa-spinner fa-spin"></span> Loading...');
                    form.submit();
                }
            });

            /* $(".offer_div").hide();
            $("#offer_id").change(function() {
                if ($(this).val() == "") {
                    $(".offer_div").hide();
                    $("#purchase_quantity").removeAttr('required');
                    $("#offered_quantity").removeAttr('required');
                } else {
                    $(".offer_div").show();
                    $("#purchase_quantity").attr('required', 'required');
                    $("#offered_quantity").attr('required', 'required');
                }
            }); */


        });

        var app = angular.module('products', []);

        app.controller('productsCtrl', function($scope) {
            $scope.field_name = cleanArray({!! json_encode(old('field_name')) !!});
            $scope.field_value = cleanArray({!! json_encode(old('field_value')) !!});

            function cleanArray(actual) {
                if (actual == null) {
                    return [];
                } else {
                    return actual;
                }
            }

            function findLongest() {
                Array.prototype.max = function() {
                    return Math.max.apply(null, this);
                };
                return [
                    $scope.field_name.length,
                    $scope.field_value.length,
                ].max();
            }
            $scope.sizes = new Array(findLongest() == 0 ? 1 : findLongest());
            $scope.addfield = function() {
                if ($scope.sizes.length < 10) {
                    $scope.sizes.push("");
                } else {
                    window.alert("Maximum 10 Fields can be added !");
                }
            }
            $scope.removefield = function() {
                if ($scope.sizes.length > 1) {
                    $scope.sizes.pop();
                } else {
                    window.alert("Minimum 1 Field is required !");
                }
            }
        });

        app.config(function($interpolateProvider) {
            $interpolateProvider.startSymbol('(=:');
            $interpolateProvider.endSymbol(':=)');
        });
    </script>
@endsection
