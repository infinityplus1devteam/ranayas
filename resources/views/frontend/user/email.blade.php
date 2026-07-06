@extends('layouts.master') @section('title', 'Recover your password')
@section('content')
    <!-- Breadcrumb area Start -->
    <div class="breadcrumb-area bg--white-6 pt--60 pb--70 pt-lg--40 pb-lg--50 pt-md--30 pb-md--40">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 text-center">
                    <h1 class="page-title">Recover your password</h1>
                    <ul class="breadcrumb justify-content-center">
                        <li><a href="{{ route('index') }}">Home</a></li>
                        <li class="current"><span>Recover your password</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb area End -->

    <div class="signUp-page signUp-minimal">
        <div class="signin-form-wrapper">
            <div class="title-area text-center">
                <h3>Recover your password</h3>
            </div> <!-- /.title-area -->
            <form id="login-form" method="POST" action="{{ route('user.password.email') }}" autocomplete="off" class="form">
                @csrf
                <div class="row">
                    @if (session('status'))
                        <div class="col-12">
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        </div>
                    @endif
                    <div class="col-12">
                        <div class="input-group{{ $errors->has('email') ? ' is-invalid' : '' }}">
                            <input type="text" name="email" id="email" value="{{ $email ?? old('email') }}" required
                                autofocus>
                            <label>Email *</label>
                        </div> <!-- /.input-group -->
                    </div> <!-- /.col- -->
                    @if ($errors->any())
                        <div class="col-12">
                            <span class="invalid-feedback" role="alert">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <strong>
                                            <li>{{ $error }}</li>
                                        </strong>
                                    @endforeach
                                </ul>
                            </span>
                        </div>
                    @endif
                </div> <!-- /.row -->

                {{-- <button type="submit" class="line-button-one button-rose button_update">Submit</button> --}}
                <button type="submit" class="line-button-one button-rose">Submit</button>

            </form>
        </div> <!-- /.sign-up-form-wrapper -->
    </div>
@endsection
@section('extracss')
    <style>
        .signUp-page {
            position: relative;
            min-height: 50vh;
            z-index: 5;
            padding-top: 50px;
            padding-bottom: 50px;
        }
    </style>
@endsection
@section('extrajs')
    <script>
        $(document).ready(function () {
            $(".form").submit(function () {
                $(".button_update_login").attr("disabled", "disabled");
                $(".button_update_login").html("Please Wait");
            });
        });
    </script>
@endsection