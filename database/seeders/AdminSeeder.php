<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\Admin;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::create([
            'firstName' => 'امیر',
            'lastName' => 'صادقی',
            'phone' => '09128451015',
            'password' => '12345678',
            'avatar' => '/media/images/avatar/amirs.jpg'
        ]);
    }
}
