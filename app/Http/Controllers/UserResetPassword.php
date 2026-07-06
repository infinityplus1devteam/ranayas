<?php

namespace App\Http\Controllers;

use App\Model\TxnUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class UserResetPassword extends Controller
{
    /**
     * Show the form to request a password reset link.
     */
    public function showResetRequestForm()
    {
        return view('frontend.user.email');
    }

    /**
     * Send a reset link to the given user.
     */
    public function sendResetLinkEmail(Request $request)
    {
        // dd('HIT sendResetLinkEmail');
        
        $request->validate([
            'email' => 'required|email',
        ]);
        
        try {
            $response = $this->broker()->sendResetLink(
                $request->only('email')
            );
            // dd($response);

            if ($response == Password::RESET_LINK_SENT) {
                // dd("RESET_LINK_SENT");
                return back()->with('status', __($response));
            }
            // dd($response);

            return back()->withErrors(
                ['email' => __($response)]
            )->withInput($request->only('email'));
            
        } catch (\Exception $e) {
            connectify('error', 'Error', $e->getMessage());
            dd($e->getMessage());
            return back()->withInput($request->only('email'));
        }
    }

    /**
     * Show the password reset form (user arrives here from the email link).
     */
    public function showResetForm(Request $request, $token = null)
    {
        return view('frontend.user.reset', [
            'token' => $token,
            'email' => $request->email,
        ]);
    }

    /**
     * Reset the given user's password.
     */
    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        try {
            $response = $this->broker()->reset(
                $request->only('email', 'password', 'password_confirmation', 'token'),
                function ($user, $password) {
                    $user->forceFill([
                        'password' => Hash::make($password),
                        'remember_token' => Str::random(60),
                    ])->save();

                    Auth::guard('user')->login($user);
                }
            );

            if ($response == Password::PASSWORD_RESET) {
                connectify('success', 'Success', 'Password has been reset successfully!');
                return redirect()->route('user.dashboard');
            }

            return back()->withErrors(
                ['email' => [__($response)]]
            )->withInput($request->only('email'));
            
        } catch (\Exception $e) {
            connectify('error', 'Error', $e->getMessage());
            return back()->withInput($request->only('email'));
        }
    }

    /**
     * Get the broker to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\PasswordBroker
     */
    protected function broker()
    {
        return Password::broker('users');
    }
}
