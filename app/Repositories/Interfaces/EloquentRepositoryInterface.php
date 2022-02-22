<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface EloquentRepositoryInterface
{

   public function create(array $attributes): Model;

   public function update(array $attributes,$id): Bool;

   public function find($id): ?Model;

   public function all(): ?Collection;
}
