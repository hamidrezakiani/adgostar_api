<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface PropertyRepositoryInterface
{
    public function getByProduct($product_id):?Collection;
}
