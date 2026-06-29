<?php

namespace App\Services;

// Darryldecode's cart storage doesn't actually have an interface in newer versions, 
// but duck typing requires has, get, put. We will define it normally without the interface if it doesn't exist.
// Let's omit the implements statement because we found out it doesn't exist in the package.

use Illuminate\Support\Facades\DB;

class UserCartStorage
{
    public function has($key)
    {
        if (auth('user')->check()) {
            return DB::table('txn_user_carts')
                ->where('user_id', auth('user')->id())
                ->where('storage_key', $key)
                ->exists();
        }
        return session()->has($key);
    }

    public function get($key)
    {
        if (auth('user')->check()) {
            $row = DB::table('txn_user_carts')
                ->where('user_id', auth('user')->id())
                ->where('storage_key', $key)
                ->first();
            return $row ? unserialize($row->storage_value) : [];
        }
        return session()->get($key, []);
    }

    public function put($key, $value)
    {
        if (auth('user')->check()) {
            DB::table('txn_user_carts')->updateOrInsert(
                [
                    'user_id' => auth('user')->id(),
                    'storage_key' => $key
                ],
                [
                    'storage_value' => serialize($value),
                    'updated_at' => now()
                ]
            );
        } else {
            session()->put($key, $value);
        }
    }
}
