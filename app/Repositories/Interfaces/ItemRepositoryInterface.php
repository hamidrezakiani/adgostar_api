<?php

namespace App\Repositories\Interfaces;

use App\Models\ItemPeriod;
use Illuminate\Database\Eloquent\Collection;

interface ItemRepositoryInterface
{
    public function viewable():?Collection;
    public function getByProduct($product_id):?Collection;
    public function getViewableByProduct($product_id):?Collection;
    public function matchPeriod($count):?ItemPeriod;
}
