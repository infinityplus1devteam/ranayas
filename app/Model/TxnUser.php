<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\UserResetPasswordNotification;

class TxnUser extends Authenticatable
{
    use Notifiable;

    protected $guarded = ['id'];

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new UserResetPasswordNotification($token));
    }

    protected $dates = ['last_login', 'last_purchase'];

    public function orders()
    {
        return $this->hasMany(TxnOrder::class, 'user_id', 'id')->where('status', '<>', 'nc');
    }

    public function reviews()
    {
        return $this->hasMany(TxnReview::class, 'user_id', 'id');
    }

    public function addresses()
    {
        return $this->hasMany(Address::class, 'user_id', 'id');
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class, 'user_id', 'id');
    }
}
