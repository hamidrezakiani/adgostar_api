<?php

namespace App\Repositories\Eloquent;

use App\Models\Property;
use App\Repositories\Interfaces\PropertyRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class PropertyRepository extends BaseRepository implements PropertyRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(new Property());
    }

    public function getByProduct($product_id) :?Collection
    {
        return $this->model->where('product_id',$product_id)->get();
    }
}
