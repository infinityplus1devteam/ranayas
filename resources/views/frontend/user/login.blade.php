@extends('layouts.master') @section('title', 'Login') @section('content')


<div class="signUp-page signUp-minimal">
    <div class="signin-form-wrapper">
        <div class="title-area text-center">
            <h3>Login</h3>
        </div>
        <ul class="social-icon-wrapper row">
            <li class="col-12">
                <a href="{{ route('user.login.otp') }}" class="otp"><i class="fa fa-mobile" aria-hidden="true" style="position: relative; top: 2px; font-size: 20px; margin-right: 2px;"></i> Login With OTP</a>
            </li>
            <li class="col-12">
                <a href="{{ route('user.auth.socialite', 'google') }}" class="gmail"><i class="fa fa-google"
                        aria-hidden="true"></i>
                    Google</a>
            </li>
        </ul>

        <p class="or-text mt-4 mb-4"><span>or</span></p>

        <form id="login-form" action="{{ route('user.login') }}" method="POST" autocomplete="off" class="login">
            @csrf
            <div class="row">
                <div class="col-12">
                    <div class="input-group">
                        <input type="text" name="email" value="{{ old('email') }}" required />
                        <label>Email <span style="color:red">*</span></label>
                    </div>
                </div>
                <div class="col-12">
                    <div class="input-group">
                        <input type="password" name="password" required />
                        <span class="show-password"><i class="showpassword fa fa-eye"></i></span>
                        <label>Password <span style="color:red">*</span></label>
                    </div>
                </div>
            </div>
            <div class="agreement-checkbox d-flex justify-content-between align-items-center">
                <div>
                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }} checked
                        id="remember">
                    <label for="remember">Remember Me</label>
                </div>
                <a href="{{ route('user.password.request') }}">Forget Password?</a>
            </div>
            <button type="submit" class="line-button-one button-rose button_update_login">
                Login
            </button>
        </form>
        <p class="signUp-text text-center mt-3">
            Don’t have any account?
            <a href="{{ route('user.register') }}">Register</a> now
        </p>
    </div>
    <!-- /.sign-up-form-wrapper -->
</div>
<!-- /.signUp-page -->

@endsection @section('extrajs')
<script>
    $(document).ready(function() {
        $(".login").submit(function() {
            $(".button_update_login").attr("disabled", "disabled");
            $(".button_update_login").html("Please Wait");
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('.show-password').on('click', function() {
            var passwordInput = $(this).prev('input');
            var icon = $(this).find('i');

            // Toggle the password input type
            if (passwordInput.attr('type') === 'password') {
                passwordInput.attr('type', 'text');
                icon.removeClass('fa-eye').addClass('fa-eye-slash');
            } else {
                passwordInput.attr('type', 'password');
                icon.removeClass('fa-eye-slash').addClass('fa-eye');
            }
        });
    });
</script>
@endsection
