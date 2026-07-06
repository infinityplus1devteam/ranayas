@extends('layouts.master') @section('title', 'Verify Otp') @section('content')

<!--breadcrumbs area start-->
<div class="breadcrumbs_area">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb_content">
                    <ul>
                        <li><a href="/">Home</a></li>
                        <li>Verify Otp</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!--breadcrumbs area end-->

<div class="signUp-page signUp-minimal">
    <div class="signin-form-wrapper">
        <div class="title-area text-center">
            <h5 class="h3-lh-40">Enter 6 digits Otp Sent On
                {{ str_pad(substr(Session::get('user')['mobile'], -2), strlen(Session::get('user')['mobile']), '*', STR_PAD_LEFT) }}
                & Registered Email ID</h5>
        </div> <!-- /.title-area -->
        <form id="login-form" action="{{ route('user.reset-otp.verify') }}" method="POST" autocomplete="off"
            class="form">
            @csrf
            <div class="row">
                <div class="col-12">
                    <div class="input-group">
                        <input type="number" name="otp" value="{{ old('otp') }}" min="0" minlength="6"
                            maxlength="6" required>
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

<form action="{{ route('user.reset-otp.resend') }}" method="post" class="form1" id="resendForm">
    @csrf
</form>
@endsection
@section('extrajs')
<script>
    $(document).ready(function() {
        $('.resend').hide();
        setTimeout(function() {
            $('.resend').show()
        }, 30000);

        $('.resend').click(function() {
            $('#resendForm').submit();
            $('.update_button1').attr('disabled', 'disabled');
            $('.update_button1').html('Please Wait...');
        });

        $('.form').submit(function() {
            $('.update_button').attr('disabled', 'disabled');
            $('.update_button').html('Please Wait...');
        });
    });
</script>
@endsection
