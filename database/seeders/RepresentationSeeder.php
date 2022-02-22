<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\Representation;
use Illuminate\Database\Seeder;

class RepresentationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $adgostarRepresentation = Representation::create([
            'title' => 'ادگستر',
            'logo' => '/media/images/representation/logo/adgostar.jpg',
            'backgroundLogin' => '/media/images/representation/backgroundLogin/adgostar.jpg',
            'domain' => '127.0.0.1:8001',
            'kind' => 'SPECIAL'
        ]);

        $specialRepresentation = Representation::create([
           'title' => 'شاهین',
           'logo' => '/media/images/representation/logo/shahin.jpg',
            'backgroundLogin' => '/media/images/representation/backgroundLogin/shahin.jpg',
           'domain' => '127.0.0.1:8002',
           'kind' => 'SPECIAL',
           'parent_id' => $adgostarRepresentation->id
        ]);
        $normalRepresentation = Representation::create([
            'title' => 'سفیر',
            'logo' => '/media/images/representation/logo/safir.jpg',
            'backgroundLogin' => '/media/images/representation/backgroundLogin/safir.jpg',
            'domain' => '127.0.0.1:8003',
            'kind' => 'NORMAL',
            'parent_id' => $specialRepresentation->id
         ]);
    }
}
