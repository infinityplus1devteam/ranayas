<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>OTP VERIFICATION || Ranayas </title>

    <link rel="icon" type="image/png" sizes="32x32" href="{!! asset('assets/image/logo/favicon-32x32.png') !!}">
    <link rel="icon" type="image/png" sizes="16x16" href="{!! asset('assets/image/logo/favicon-16x16.png') !!}">
    <meta name="theme-color" content="#ffffff">

    <!-- General CSS Files -->
    <link rel="stylesheet" href="{!! asset('admin/css/app.min.css') !!}">
    <link rel="stylesheet" href="{!! asset('admin/bundles/bootstrap-social/bootstrap-social.css') !!}">
    <!-- Template CSS -->
    <link rel="stylesheet" href="{!! asset('admin/css/style.css') !!}">
    <link rel="stylesheet" href="{!! asset('admin/css/components.css') !!}">
    <!-- Custom style CSS -->
    <link rel="stylesheet" href="{!! asset('admin/css/custom.css') !!}">
    <link rel='shortcut icon' type='image/x-icon' href="{!! asset('admin/img/favicon.ico') !!}" />
</head>

<body>
    <div class="loader"></div>
    <div id="app">
        <section class="section">
            <div class="container mt-5">
                <div class="row">
                    <div
                        class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
                        <div class="card card-primary">
                            <div class="card-header d-flex flex-column align-items-start">
                                <h4>OTP Verification</h4>
                                @php
                                    $parts = explode('@', $email);
                                    $name = $parts[0];
                                    $domain = $parts[1] ?? '';
                                    $len = strlen($name);
                                    if ($len > 3) {
                                        $obscured = substr($name, 0, 2) . str_repeat('*', $len - 3) . substr($name, -1);
                                    } else {
                                        $obscured = str_repeat('*', $len);
                                    }
                                    $obscuredEmail = $obscured . '@' . $domain;
                                @endphp
                                <p class="text-muted mt-2 small">We have sent a 6-digit OTP code to <strong>{{ $obscuredEmail }}</strong></p>
                            </div>
                            <div class="card-body">
                                @if (session('success'))
                                    <div class="alert alert-success alert-dismissible show fade">
                                        <div class="alert-body">
                                            <button class="close" data-dismiss="alert">
                                                <span>&times;</span>
                                            </button>
                                            {{ session('success') }}
                                        </div>
                                    </div>
                                @endif

                                @if ($errors->has('otp'))
                                    <div class="alert alert-danger alert-dismissible show fade">
                                        <div class="alert-body">
                                            <button class="close" data-dismiss="alert">
                                                <span>&times;</span>
                                            </button>
                                            {{ $errors->first('otp') }}
                                        </div>
                                    </div>
                                @endif

                                <form class="md-float-material form-material needs-validation" id="formOtp"
                                    method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="otp" class="control-label">Enter 6-Digit OTP</label>
                                        <input id="otp" type="text" pattern="[0-9]*" inputmode="numeric"
                                            class="form-control{{ $errors->has('otp') ? ' is-invalid' : '' }}"
                                            name="otp" placeholder="6 Digit OTP" maxlength="6" minlength="6"
                                            required tabindex="1" autofocus>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-lg btn-block btnSubmit"
                                            tabindex="2">
                                            Verify OTP
                                        </button>
                                    </div>
                                </form>

                                <div class="mt-4 text-center">
                                    <span id="timerText" class="text-muted">Resend OTP in <strong id="countdown">30</strong> seconds</span>
                                    <div class="resend-container" style="display: none;">
                                        <button type="button" class="btn btn-link p-0 text-decoration-none btnResend">
                                            Resend OTP
                                        </button>
                                    </div>
                                </div>

                                <div class="mt-4 text-left">
                                    <a href="{{ route('login') }}"><i class="fa fa-angle-double-left"
                                            aria-hidden="true"></i> Back to Login </a>
                                </div>
                            </div>
                        </div>
                        <div class="mt-5 text-muted text-center">
                            Designed & Developed By <a href="https://www.sanjaresolutions.com" target="_blank">Sanjar
                                E
                                Solutions</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Hidden form for Resend OTP -->
    <form action="{{ route('admin.login.otp.resend') }}" method="post" id="resendForm" style="display: none;">
        @csrf
    </form>

    <!-- General JS Scripts -->
    <script src="{!! asset('admin/js/app.min.js') !!}"></script>
    <!-- Template JS File -->
    <script src="{!! asset('admin/js/scripts.js') !!}"></script>
    <!-- Custom JS File -->
    <script src="{!! asset('admin/js/custom.js') !!}"></script>
    <script src="{!! asset('admin/js/jquery.validate.min.js') !!}"></script>

    <script>
        $(document).ready(function() {
            // Countdown timer for Resend button
            let count = 30;
            let counter = setInterval(timer, 1000);

            function timer() {
                count = count - 1;
                if (count <= 0) {
                    clearInterval(counter);
                    $('#timerText').hide();
                    $('.resend-container').show();
                    return;
                }
                $('#countdown').text(count);
            }

            $('.btnResend').click(function() {
                $('#resendForm').submit();
                $(this).attr('disabled', 'disabled');
                $(this).html('<span class="fa fa-spinner fa-spin"></span> Sending...');
            });

            $("#formOtp").validate({
                rules: {
                    otp: {
                        required: true,
                        digits: true,
                        minlength: 6,
                        maxlength: 6
                    },
                },
                messages: {
                    otp: {
                        required: "Please Enter OTP",
                        digits: "OTP must contain only digits",
                        minlength: "OTP must be exactly 6 digits",
                        maxlength: "OTP must be exactly 6 digits"
                    },
                },
                submitHandler: function(form) {
                    $('.btnSubmit').attr('disabled', 'disabled');
                    $(".btnSubmit").html('<span class="fa fa-spinner fa-spin"></span> Verifying...');
                    form.submit();
                }
            });
        });
    </script>
</body>

</html>
