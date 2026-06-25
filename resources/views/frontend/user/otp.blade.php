@extends('layouts.master')
@section('title','Login with OTP')
@section('content')


<div class="breadcrumb-area bg--white-6 pt--60 pb--70 pt-lg--40 pb-lg--50 pt-md--30 pb-md--40">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 text-center">
                <h1 class="page-title">OTP</h1>
                <ul class="breadcrumb justify-content-center">
                    <li><a href="{{ route('index') }}">Home</a></li>
                    <li class="current"><span>OTP</span></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- Breadcrumb area End -->

<div class="signUp-page signUp-minimal">
    <div class="signin-form-wrapper">
        <div class="title-area text-center">
            <h5 class="h3-lh-40">Enter 6 digit Otp Sent On
                {{ str_pad(substr($user['mobile'], -2), strlen($user['mobile']), '*', STR_PAD_LEFT) }}
                @if(!empty($user['email'])) & Registered Email @endif</h5>
        </div> <!-- /.title-area -->
        <form id="login-form" action="{{ route('user.otp.verify') }}" method="POST" autocomplete="off" class="form">
            @csrf
            <div class="row">
                <div class="col-12">
                    <div class="input-group">
                        <input type="number" name="otp" value="{{ old('otp') }}" min="0" minlength="6" maxlength="6"
                            required>
                        <label>OTP *</label>
                    </div> <!-- /.input-group -->
                </div> <!-- /.col- -->

            </div> <!-- /.row -->

            <button type="submit" class="line-button-one button-rose update_button">Verify</button>
            <div class="resend mt-30">
                <button type="button" class="line-button-one button-rose update_button1">Resend</button>
            </div>
        </form>
    </div> <!-- /.sign-up-form-wrapper -->
</div> <!-- /.signUp-page -->

<form action="{{ route('user.otp.resend') }}" method="post" class="form1" id="resendForm">
    @csrf
</form>

@endsection

@section('extrajs')
<script>
    $(document).ready(function () {
        $('.resend').hide();
        setTimeout(function () {
            $('.resend').show()
        }, 30000);

        $('.resend').click(function () {
            $('#resendForm').submit();
            $('.update_button1').attr('disabled', 'disabled');
            $('.update_button1').html('Please Wait...');
        });

        $('.form').submit(function () {
            $('.update_button').attr('disabled', 'disabled');
            $('.update_button').html('Please Wait...');
        });
    });

</script>
@endsection