<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Model\Admin;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::updateOrCreate(
            ['email' => 'siddiquimahfooz327@gmail.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('asdasdasd'),
                'super_admin' => true,
                'status' => true,
            ]
        );
    }
}
