@extends('layouts.master') @section('title', 'Register') @section('content')


<div class="signUp-page signUp-minimal">
    <div class="signin-form-wrapper">
        <div class="title-area text-center">
            <h3>Sign Up</h3>
        </div>
        <form id="login-form" action="{{ route('user.register') }}" method="POST" autocomplete="off"
            class="register needs-validation">
            @csrf
            <div class="row">
                <div class="col-12">
                    <div class="input-group mb-0">
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required />
                        <label>Name <span style="color:red">*</span></label>
                    </div>
                    <label for="name" class="error"></label>
                    <!-- /.input-group -->
                </div>
                <!-- /.col- -->
                <div class="col-12">
                    <div class="input-group mb-0">
                        <input type="number" name="mobile" id="mobile" value="{{ old('mobile') }}" minlength="10"
                            maxlength="10" min="0000000000" required />
                        <label>Mobile Number <span style="color:red">*</span></label>
                    </div>
                    <label for="mobile" class="error"></label>

                    <!-- /.input-group -->
                </div>
                <!-- /.col- -->
                <div class="col-12">
                    <div class="input-group mb-0">
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required />
                        <label>Email <span style="color:red">*</span></label>
                    </div>
                    <label for="email" class="error"></label>

                    <!-- /.input-group -->
                </div>
                <!-- /.col- -->
                <div class="col-12">
                    <div class="input-group mb-0">
                        <input type="password" name="password" id="password" value="{{ old('password') }}" required />
                        <span class="show-password"><i class="showpassword fa fa-eye"></i></span>
                        <label>Password <span style="color:red">*</span></label>

                    </div>
                    <label for="password" class="error"></label>

                    <!-- /.input-group -->
                </div>
                <!-- /.col- -->
            </div>
            <!-- /.row -->

            <button type="submit" class="line-button-one button-rose btnSubmit">
                Register
            </button>
        </form>
        <p class="signUp-text text-center">
            Already have an account?
            <a href="{{ route('user.login') }}">Login wtih email</a>
            {{-- Or <a href="{{ route('user.login.otp') }}"> Login with Otp</a> --}}
        </p>
        <p class="or-text"><span>or</span></p>
        <ul class="social-icon-wrapper row">
            <li class="col-12"><a href="{{ route('user.login.otp') }}" class="otp"><i class="fa fa-mobile"
                        aria-hidden="true" style="position: relative; top: 2px; font-size: 20px; margin-right: 2px;"></i>
                    Login With OTP</a></li>
            <li class="col-12">
                <a href="{{ route('user.auth.socialite', 'google') }}" class="gmail"><i class="fa fa-google"
                        aria-hidden="true"></i>
                    Google</a>
            </li>
            {{-- <li class="col-12">
                <a href="{{ route('user.auth.socialite', 'facebook') }}" class="facebook"><i class="fa fa-facebook" aria-hidden="true"></i>
            Facebook</a>
            </li> --}}
        </ul>
    </div>
    <!-- /.sign-up-form-wrapper -->
</div>
<!-- /.signUp-page -->

@endsection

@section('extrajs')
<script>
    $(document).ready(function() {

        $("#login-form").validate({
            rules: {

                name: {
                    required: true,
                },

                email: {
                    required: true,
                    email: true,
                },

                mobile: {
                    required: true,
                    number: true,
                    minlength: 10,
                    maxlength: 10
                },

                password: {
                    required: true
                }

            },
            messages: {

                name: {
                    required: "Please Enter Name"
                },

                email: {
                    required: "Please Enter Email"
                },

                password: {
                    required: "Please Enter Password"
                },

                mobile: {
                    required: "Please Enter Mobile Number",
                    number: "Mobile Number should be numeric only",
                    minlength: "Mobile Number should be 10 digits",
                    maxlength: "Mobile Number should be 10 digits",
                }

            },
            submitHandler: function(form) {
                $('.btnSubmit').attr('disabled', 'disabled');
                $(".btnSubmit").html('<span class="fa fa-spinner fa-spin"></span> Loading...');
                form.submit();
            }
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
