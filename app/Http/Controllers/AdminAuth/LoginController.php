<?php

namespace App\Http\Controllers\AdminAuth;

use App\Http\Controllers\Controller;
use App\Model\Admin;
use Auth;
use Illuminate\Http\Request;
use Lang;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{

    public function __construct()
    {
        $this->middleware('guard:admin')->except('logout');
    }

    protected function guard()
    {
        return Auth::guard('admin');
    }

    public function showLoginForm()
    {
        return view('adminauth.login');
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $admin = Admin::where('email', $request->email)->first();

        if ($admin && Hash::check($request->password, $admin->password)) {
            $otp = rand(100000, 999999);

            session([
                'admin_login_email' => $request->email,
                'admin_login_otp' => $otp,
                'admin_login_otp_expires_at' => now()->addMinutes(10),
                'admin_login_remember' => $request->remember ? true : false,
            ]);

            $user = [
                'name' => $admin->name ?? 'Admin',
                'otp' => $otp,
                'email' => $admin->email,
            ];

            try {
                Mail::send(['html' => 'backend.mails.otp'], ['user' => $user], function ($message) use ($user) {
                    $message->to($user['email'])->subject(config('app.name').', Admin One Time Password(OTP)');
                    $message->from(config('mail.from.address'), config('mail.from.name'));
                });
            } catch (\Exception $e) {
                Log::error('Mail Error (Admin OTP): '.$e->getMessage());
            }

            return redirect()->route('admin.login.otp');
        }

        return redirect(route('login'))
            ->withInput($request->only('email', 'remember'))
            ->withErrors(['email' => Lang::get('auth.failed')]);
    }

    public function showOtpForm(Request $request)
    {
        if (!$request->session()->has('admin_login_email')) {
            return redirect()->route('login');
        }

        $email = session('admin_login_email');
        return view('adminauth.otp', compact('email'));
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6',
        ]);

        if (!$request->session()->has('admin_login_email')) {
            return redirect()->route('login');
        }

        $email = session('admin_login_email');
        $otp = session('admin_login_otp');
        $expiresAt = session('admin_login_otp_expires_at');
        $remember = session('admin_login_remember', false);

        if (now()->greaterThan($expiresAt)) {
            return back()->withErrors(['otp' => 'The OTP has expired. Please request a new one.']);
        }

        if ($request->otp == $otp) {
            $admin = Admin::where('email', $email)->first();
            if ($admin) {
                Auth::guard('admin')->login($admin, $remember);

                // Clear OTP session keys
                session()->forget([
                    'admin_login_email',
                    'admin_login_otp',
                    'admin_login_otp_expires_at',
                    'admin_login_remember'
                ]);

                return redirect()->intended(route('admin.dashboard'));
            }
        }

        return back()->withErrors(['otp' => 'The entered OTP is incorrect.']);
    }

    public function resendOtp(Request $request)
    {
        if (!$request->session()->has('admin_login_email')) {
            return redirect()->route('login');
        }

        $email = session('admin_login_email');
        $admin = Admin::where('email', $email)->first();
        if (!$admin) {
            return redirect()->route('login');
        }

        $otp = rand(100000, 999999);
        session([
            'admin_login_otp' => $otp,
            'admin_login_otp_expires_at' => now()->addMinutes(10),
        ]);

        $user = [
            'name' => $admin->name ?? 'Admin',
            'otp' => $otp,
            'email' => $admin->email
        ];

        try {
            Mail::send(['html' => 'backend.mails.otp'], ['user' => $user], function ($message) use ($user) {
                $message->to($user['email'])->subject(config('app.name').', Admin One Time Password(OTP)');
                $message->from(config('mail.from.address'), config('mail.from.name'));
            });
        } catch (\Exception $e) {
            Log::error('Mail Error (Admin OTP Resend): '.$e->getMessage());
        }

        return back()->with('success', 'OTP has been resent to your email address.');
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->intended(route('login'));
    }

    public function checkEmail(Request $request)
    {
        $admin = Admin::where('email', $request->email)->first();
        if ($admin) {
            return "true";
        }
        return "false";
    }
}
