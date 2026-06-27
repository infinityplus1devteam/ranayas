@extends('layouts.master') @section('title','My Account') @section('content')

    <!-- Breadcrumb area Start -->
    <div
        class="breadcrumb-area bg--white-6 pt--60 pb--70 pt-lg--40 pb-lg--50 pt-md--30 pb-md--40"
    >
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 text-center">
                    <h1 class="page-title">My Account</h1>
                    <ul class="breadcrumb justify-content-center">
                        <li>
                            <a href="{{ route('user.dashboard') }}">Dashboard</a>
                        </li>
                        <li>
                            <a href="{{ route('user.addresses') }}">Addresses</a>
                        </li>
                        <li class="current"><span>Update Address</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb area End -->

    <section class="main_content_area">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <form
                        class="form"
                        method="POST"
                        action="{{ route('user.addresses.update', $add->id) }}"
                        id="formUpdateAddress"
                    >
                        @csrf
                        <div class="row">

                            <div class="col-md-6 form-group">
                                <label>Address <span class="required">*</span></label>
                                <textarea name="address" id="address" rows="10" class="form-control" required>{{ $add->address }}</textarea>
                            </div>

                            <div class="col-md-6 form-group">
                                <label>Name <span class="required">*</span></label>
                                <input type="text" id="name" name="name" placeholder="Enter Name" class="form-control" value="{{ $add->name }}" required />
                            </div>

                            <div class="col-md-6 form-group">
                                <label>Landmark </label>
                                <input type="text" id="landmark" name="landmark" placeholder="Enter Landmark" class="form-control" value="{{ $add->landmark }}" />
                            </div>

                            <div class="col-md-6 form-group">
                                <label>Town/City <span class="required">*</span></label>
                                <input type="text" id="city" name="city" placeholder="Enter Town/City" class="form-control" value="{{ $add->city }}" required />
                            </div>

                            <div class="col-md-6 form-group">
                                <label>State <span class="required">*</span></label>
                                <input type="text" id="territory" name="territory" placeholder="Enter State" class="form-control" value="{{ $add->territory }}" required/>
                            </div>

                            <div class="col-md-6 form-group">
                                <label>Pincode <span class="required">*</span></label>
                                <input type="number" id="pincode" name="pincode" placeholder="Enter Pincode" class="form-control" value="{{ $add->pincode }}" required/>
                            </div>

                            <div class="col-md-6 form-group">
                                <label for="type_of_address" class="form__label form__label--2">
                                    Type of Address <span class="required">*</span>
                                </label>
                                <label for="home">
                                    <input type="radio" name="type_of_address" id="home" value="0" {{ $add->type_of_address == '0' ? 'checked' : '' }}>
                                    Home
                                </label>
                                <label for="corporate">
                                    <input type="radio" name="type_of_address" id="corporate"  value="1" {{ $add->type_of_address == '1' ? 'checked' : '' }}>
                                    Office/Commercial
                                </label>
                            </div>

                            <div class="col-md-12 form-group">
                                <button type="submit" class="btn btn-md btn-dark btnSubmit">
                                    Update
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

@endsection
@section('extracss')
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
    </style>
@endsection
@section('extrajs')

    <script>
        $(document).ready(function () {

            $("#formUpdateAddress").validate({
                rules: {

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

                    type_of_address: {
                        required: true
                    }
                },
                messages: {

                    address: {
                        required: "Please Enter Address"
                    },

                    city: {
                        required: "Please Enter City"
                    },

                    territory: {
                        required: "Please Enter Territory"
                    },

                    type_of_address: {
                        required: "Please Select Address Type"
                    },

                    pincode: {
                        required: "Please Enter Pincode",
                        minlength: "Pincode should be of 6 digits",
                        maxlength: "Pincode should be of 6 digits",
                    },

                },
                submitHandler: function (form) {
                    $('.btnSubmit').attr('disabled', 'disabled');
                    $(".btnSubmit").html('<span class="fa fa-spinner fa-spin"></span> Loading...');
                    form.submit();
                }
            });

        });
    </script>

@endsection
