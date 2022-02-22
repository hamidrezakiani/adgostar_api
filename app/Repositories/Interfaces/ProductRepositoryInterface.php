<?php

namespace App\Repositories\Interfaces;

use App\Models\Account;
use App\Models\Representation;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface ProductRepositoryInterface
{
    public function getByCategory($category_id):?Collection;
    public function getViewableByCategory($category_id,$flag):?Collection;
}
