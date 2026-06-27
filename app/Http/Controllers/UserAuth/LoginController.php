<?php

namespace App\Http\Controllers\UserAuth;

use App\Http\Controllers\Controller;
use App\Model\SMS;
use App\Model\Subscriber;
use App\Model\TxnUser;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guard:user')->except('logout');
    }

    protected function guard()
    {
        return Auth::guard('user');
    }

    public function showLoginForm()
    {
        return view('frontend.user.login');
    }

    public function create()
    {
        return view('frontend.user.register');
    }

    public function createMail()
    {
        return view('frontend.user.register-mail');
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('user')->attempt(['email' => $request->email, 'password' => $request->password, 'status' => true], $request->remeber)) {
            connectify('success', 'Logged in', 'You are successfully Logged In');

            return redirect()->intended(url()->previous());
        }

        connectify('error', 'Login Error', 'Invalid Credentials, Please Check Credentials & try again !');

        return back()->withInput($request->only('email', 'remember'));
    }

    public function logout()
    {
        Auth::guard('user')->logout();
        connectify('success', 'Logged Out', 'You have logged out successfully !');

        return redirect()->route('index');
    }

    public function store(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|string|max:191',
                'mobile' => 'required|digits:10|unique:txn_users,mobile',
                'email' => 'required|email|max:191|unique:txn_users,email',
                'password' => 'required',
            ],
            [
                'name.required' => 'Please Enter Name',
                'mobile.required' => 'Please Enter Mobile Number',
                'mobile.digits' => 'Please Enter 10 digits Mobile Number',
                'email.required' => 'Please Enter Email ID',
                'email.email' => 'Please Enter Proper Email ID',
                'password.required' => 'Please Enter Password',
                'email.unique' => 'Email Already Registered with us',
                'mobile.unique' => 'Mobile Already Registered with us',
            ]
        );

        if ($validator->fails()) {
            connectify('error', 'Register Failed', $validator->errors()->first());

            return back()->withInput();
        }

        $rand_otp = rand(100000, 999999);

        $user = [
            'name' => $request->name,
            'mobile' => $request->mobile,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'status' => true,
            'is_verified' => false,
            'otp' => $rand_otp,
            'url' => url()->previous(),
        ];
        session(['user' => $user]);

        // Dear Customer, Thank You for login with RANAYAS. Your OTP for login is {#var#}.
        SMS::send(
            $user['mobile'],
            'Dear Customer, Thank You for login with RANAYAS. Your OTP for login is ' . $user['otp'] . '.',
            config('services.sms.dlt_otp_template_id')
        );
        // dd('i m here');

        try {
            Mail::send(['html' => 'backend.mails.otp'], ['user' => $user], function ($message) use ($user) {
                $message->to($user['email'])->subject(config('app.name') . ', One Time Password(OTP)');
                $message->from(config('mail.from.address'), config('mail.from.name'));
            });
        } catch (\Exception $e) {
            Log::error('Mail Error (Register): ' . $e->getMessage());
        }

        return redirect()->route('user.otp');
    }

    public function registerPhone(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'mobile' => 'required|digits:10|unique:txn_users,mobile',
            ],
            [
                'mobile.required' => 'Please Enter Mobile Number',
                'mobile.digits' => 'Please Enter 10 digits Mobile Number',
                'mobile.unique' => 'Mobile Number Already Registered with us',
            ]
        );

        if ($validator->fails()) {
            connectify('error', 'Register Failed', $validator->errors()->first());
            return back()->withInput();
        }

        $rand_otp = rand(100000, 999999);

        $user = [
            'name' => 'Customer',
            'mobile' => $request->mobile,
            'email' => null,
            'password' => bcrypt($request->mobile),
            'status' => true,
            'is_verified' => false,
            'otp' => $rand_otp,
            'url' => url()->previous(),
        ];
        session(['user' => $user]);

        SMS::send(
            $user['mobile'],
            'Dear Customer, Thank You for login with RANAYAS. Your OTP for login is ' . $user['otp'] . '.',
            config('services.sms.dlt_otp_template_id')
        );

        return redirect()->route('user.otp');
    }

    public function otp(Request $request)
    {
        $user = $request->session()->get('user');

        return view('frontend.user.otp', compact('user'));
    }

    public function resendOtp(Request $request)
    {
        if ($request->session()->has('user')) {

            $user = $request->session()->get('user');

            SMS::send(
                $user['mobile'],
                'Dear Customer, Thank You for login with RANAYAS. Your OTP for login is ' . $user['otp'] . '.',
                config('services.sms.dlt_otp_template_id')
            );

            if (!empty($user['email'])) {
                try {
                    Mail::send(['html' => 'backend.mails.otp'], ['user' => $user], function ($message) use ($user) {
                        $message->to($user['email'])->subject(config('app.name') . ', One Time Password(OTP)');
                        $message->from(config('mail.from.address'), config('mail.from.name'));
                    });
                } catch (\Exception $e) {
                    Log::error('Mail Error (Resend OTP): ' . $e->getMessage());
                }
            }
            connectify('success', 'Resend Otp', 'Otp has been resend on registered mobile');

            return redirect()->route('user.otp');
        }

        connectify('error', 'Error', 'Whoops, User Session Not Found !');

        return back();

    }

    public function verifyOTP(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'otp' => 'required|max:6',
            ],
            [
                'otp.required' => 'Please Enter OTP',
            ]
        );

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
            }
            connectify('error', 'Invalid Otp', $validator->errors()->first());

            return back()->withInput();
        }

        $userData = $request->session()->get('user');

        // Safeguard against expired sessions
        if (!$userData) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Your session has expired. Please try registering again.']);
            }
            connectify('error', 'Session Expired', 'Your session has expired. Please try registering again.');

            return redirect()->route('user.register');
        }

        if ($userData['otp'] == $request->otp) {

            $matchKey = !empty($userData['email']) ? ['email' => $userData['email']] : ['mobile' => $userData['mobile']];

            $user = TxnUser::updateOrCreate(
                $matchKey,
                [

                    'name' => $userData['name'] ?? 'Customer',
                    'email' => $userData['email'] ?? null,
                    'mobile' => $userData['mobile'],
                    'password' => $userData['password'],
                    'status' => true,
                    'is_verified' => true,
                    'otp' => null,
                    'last_login' => Carbon::now(),
                    'is_subcribed' => true,
                ]
            );

            /* if (!empty($userData['email'])) {
                Subscriber::updateOrCreate(
                    [
                        'email' => $userData['email'],
                    ],
                    [
                        'email' => $userData['email'],
                        'status' => true,
                    ]
                );
            } */

            Auth::guard('user')->login($user, true);

            // Cleanup registration session data
            $request->session()->forget('user');

            connectify('success', 'Registered Successfully', 'You are successfully Registered !');

            // Fallback to dashboard if original URL is missing
            $redirectUrl = $userData['url'] ?? route('user.dashboard');

            if ($request->ajax()) {
                return response()->json(['success' => true, 'redirect' => $redirectUrl]);
            }
            return redirect($redirectUrl);

        } else {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'The Entered Otp is Invalid !']);
            }
            connectify('error', 'Error', 'The Entered Otp is Invalid !');

            return back();
        }
    }

    public function showOtpLoginForm()
    {
        return view('frontend.user.otp-login');
    }

    public function otpLogin(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'mobile' => 'required|digits:10|exists:txn_users,mobile',
            ],
            [
                'mobile.required' => 'Please Enter Mobile Number',
                'mobile.digits' => 'Please Enter 10 digits Mobile Number',
                'mobile.exists' => 'Mobile Number does Not exists in our records !',
            ]
        );

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
            }
            connectify('error', 'Otp Login', $validator->errors()->first());

            return back()->withInput();
        }

        try {

            $user = TxnUser::where('mobile', $request->mobile)->firstOrFail();

            $rand_otp = rand(100000, 999999);

            $user = [
                'name' => $user->name,
                'mobile' => $user->mobile,
                'email' => $user->email,
                'password' => $user->password,
                'otp' => $rand_otp,
                'url' => url()->previous(),
            ];

            session(['user' => $user]);

            SMS::send(
                $user['mobile'],
                'Dear Customer, Thank You for login with RANAYAS. Your OTP for login is ' . $user['otp'] . '.',
                config('services.sms.dlt_otp_template_id')
            );

            try {
                Mail::send(['html' => 'backend.mails.otp'], ['user' => $user], function ($message) use ($user) {
                    $message->to($user['email'])->subject(config('app.name') . ', One Time Password(OTP)');
                    $message->from(config('mail.from.address'), config('mail.from.name'));
                });
            } catch (\Exception $e) {
                Log::error('Mail Error (OTP Login): ' . $e->getMessage());
            }

            if ($request->ajax()) {
                return response()->json(['success' => true, 'message' => 'Otp Send']);
            }
            connectify('success', 'Otp Send', 'Otp has been sent on mobile & email !');

            return redirect()->route('user.otp');

        } catch (\Exception $ex) {
            if ($ex instanceof ModelNotFoundException) {

                if ($request->ajax()) {
                    return response()->json(['success' => false, 'message' => 'Mobile number not found, try again later !']);
                }
                connectify('error', 'Error', 'Email id not found, try again later !');

                return redirect(route('user.login.otp'));
            }

            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Something Went Wrong !']);
            }
            connectify('error', 'Error', 'Something Went Wrong !');

            return redirect(route('user.login.otp'));
        }
    }
}
