<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\Representation;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $normalRepresentation = Representation::where('kind','NORMAL')->first();
        $specialRepresentation = Representation::where('kind','SPECIAL')->get();
        User::create([
            'representation_id' => $specialRepresentation[0]->id,
            'firstName' => 'امیر',
            'lastName' => 'صادقی',
            'phone' => '09128451015',
            'password' => '12345678',
            'avatar' => '/media/images/avatar/amirs.jpg',
            'role' => 'OWNER',

        ]);
        User::create([
            'representation_id' => $specialRepresentation[0]->id,
            'firstName' => 'حسین',
            'lastName' => 'رضایی',
            'phone' => '09369422072',
            'password' => '00000000',
            'avatar' => '/media/images/avatar/hossein.jpg',
        ]);
        User::create([
            'representation_id' => $specialRepresentation[1]->id,
            'firstName' => 'محسن',
            'lastName' => 'رضایی',
            'phone' => '09165640475',
            'password' => '12345678',
            'role' => 'OWNER',
        ]);
        User::create([
            'representation_id' => $specialRepresentation[1]->id,
            'firstName' => 'محمد',
            'lastName' => 'نوروزی',
            'phone' => '09174785986',
            'password' => '12345678',
        ]);
        User::create([
            'representation_id' => $normalRepresentation->id,
            'firstName' => 'کوروش',
            'lastName' => 'طهماسبی',
            'phone' => '09169027218',
            'password' => '12345678',
            'role' => 'OWNER',
        ]);




    }
}
