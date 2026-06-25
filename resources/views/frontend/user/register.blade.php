@extends('layouts.master') @section('title', 'Register with Phone Number') @section('content')

<div class="signUp-page signUp-minimal">
    <div class="signin-form-wrapper">
        <div class="title-area text-center">
            <h3>Register with Phone Number (OTP)</h3>
        </div>

        <form id="phone-register-form" action="{{ route('user.register.phone') }}" method="POST" autocomplete="off"
            class="register needs-validation">
            @csrf
            <div class="row">
                <div class="col-12">
                    <div class="input-group mb-0">
                        <input type="number" name="mobile" id="phone_mobile" value="{{ old('mobile') }}" minlength="10"
                            maxlength="10" min="0000000000" required />
                        <label>Mobile Number <span style="color:red">*</span></label>
                    </div>
                    <label for="phone_mobile" class="error"></label>
                </div>
            </div>

            <button type="submit" class="line-button-one button-rose btnSubmitPhone">
                Register
            </button>
        </form>

        <p class="signUp-text text-center mt-3">
            Already have an account?
            <a href="{{ route('user.login') }}">Login wtih email</a>
        </p>
        <p class="or-text"><span>or</span></p>
        <ul class="social-icon-wrapper row">
            <li class="col-12">
                <a href="{{ route('user.register.mail') }}" class="otp"><i class="fa fa-envelope"
                        aria-hidden="true" style="position: relative; top: 1px; font-size: 18px; margin-right: 6px;"></i>
                    Register With Mail</a>
            </li>
            <li class="col-12"><a href="{{ route('user.login.otp') }}" class="otp"><i class="fa fa-mobile"
                        aria-hidden="true" style="position: relative; top: 2px; font-size: 20px; margin-right: 2px;"></i>
                    Login With OTP</a></li>
            <li class="col-12">
                <a href="{{ route('user.auth.socialite', 'google') }}" class="gmail"><i class="fa fa-google"
                        aria-hidden="true" style="font-size: 14px; margin-right: 6px;"></i>
                    Google</a>
            </li>
        </ul>
    </div>
</div>
@endsection

@section('extrajs')
<script>
    $(document).ready(function() {
        $("#phone-register-form").validate({
            rules: {
                mobile: {
                    required: true,
                    number: true,
                    minlength: 10,
                    maxlength: 10
                }
            },
            messages: {
                mobile: {
                    required: "Please Enter Mobile Number",
                    number: "Mobile Number should be numeric only",
                    minlength: "Mobile Number should be 10 digits",
                    maxlength: "Mobile Number should be 10 digits",
                }
            },
            submitHandler: function(form) {
                $('.btnSubmitPhone').attr('disabled', 'disabled');
                $(".btnSubmitPhone").html('<span class="fa fa-spinner fa-spin"></span> Loading...');
                form.submit();
            }
        });
    });
</script>
@endsection
