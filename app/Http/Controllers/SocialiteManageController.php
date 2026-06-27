<?php

namespace App\Http\Controllers;

use App\Model\Subscriber;
use App\Model\TxnUser;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Laravel\Socialite\Facades\Socialite;

class SocialiteManageController extends Controller
{
    use AuthenticatesUsers;

    public function redirectToProvider($provider)
    {
        session(['previous_url' => url()->previous()]);

        return Socialite::driver($provider)->redirect();
    }

    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider)
    {
        try {

            $user = Socialite::driver($provider)->stateless()->user();
            $authUser = $this->findOrCreateUser($user, $provider);
            Auth::guard('user')->login($authUser, true);
            connectify('success', 'Logged in', 'You are successfully Logged in !');

            return Redirect::to(session()->get('previous_url'));
        } catch (\Exception $ex) {
            \Log::info($ex->getMessage());
            connectify('error', 'Login Error', 'We are not able to Logged you in !');

            return redirect('/');
        }

    }

    public function findOrCreateUser($user, $provider)
    {
        $authUser = TxnUser::where('email', $user->email)->first();

        /* Subscriber::updateOrCreate(
            ['email' => $user->email],
            [
                'email' => $user->email,
                'status' => true,
            ]
        ); */

        if ($authUser) {

            return $authUser;
        }

        $authUser = TxnUser::create([
            'name' => $user->name,
            'email' => $user->email,
            'provider' => $provider,
            'provider_id' => $user->id,
            'image_url' => $user->avatar,
            'status' => true,
            'created_at' => date('Y-m-d H:i'),
        ]);

        return $authUser;
    }
}
