<?php

namespace App\Repositories\Eloquent;

use App\Models\Product;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class ProductRepository extends BaseRepository implements ProductRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(new Product());
    }

    public function getViewableByCategory($category_id,$flag = 'all') :?Collection
    {
        if($flag == 'all')
        {
            return $this->model->viewable()
            ->where('category_id', $category_id)->get();
        }
        elseif($flag == 'readyService')
        {
           return $this->model->readyService()
           ->where('category_id',$category_id)->get();
        }
        else
        {
            return NULL;
        }

    }

    public function getByCategory($category_id) :?Collection
    {
        return $this->model->where('category_id',$category_id)->get();
    }
}
