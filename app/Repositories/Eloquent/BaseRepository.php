<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Interfaces\EloquentRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class BaseRepository implements EloquentRepositoryInterface
{

   protected $model;

   public function __construct(Model $model)
   {
       $this->model = $model;
   }

   public function create(array $attributes) : Model
   {
       return $this->model->create($attributes);
   }

   public function update(array $attributes,$id): Bool
   {
       return $this->find($id)->update($attributes);
   }

   public function find($id): ? Model
   {
       return $this->model->find($id);
   }

   public function all() :?Collection
   {
       return $this->model->all();
   }

}
