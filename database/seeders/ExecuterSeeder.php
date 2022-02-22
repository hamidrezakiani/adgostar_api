<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\Executer;
use Illuminate\Database\Seeder;

class ExecuterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Executer::create([
            'firstName' => 'امیر',
            'lastName' => 'صادقی',
            'phone' => '09128451015',
            'password' => '12345678',
            'avatar' => '/media/images/avatar/amirs.jpg'
        ]);

        Executer::create([
            'firstName' => 'حسین',
            'lastName' => 'رضایی',
            'phone' => '09369422072',
            'password' => '00000000',
            'avatar' => '/media/images/avatar/hossein.png'
        ]);
    }
}
