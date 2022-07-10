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
    
    public function getReadyServices()
    {
       return $this->model->readyService()->get();
    }
    
    public function previous($id)
    {
      $product = $this->model->find($id);
      return $this->model->where('category_id',$product->category_id)
        ->where('tab_index','<',$product->tab_index)
          ->orderBy('tab_index','DESC')->first();
    }
    
    public function next($id)
    {
      $product = $this->model->find($id);
      return $this->model->where('category_id',$product->category_id)
        ->where('tab_index','>',$product->tab_index)
          ->orderBy('tab_index','ASC')->first();
    }

    public function getByCategory($category_id) :?Collection
    {
        return $this->model->where('category_id',$category_id)->orderBy('tab_index','ASC')->get();
    }
}
