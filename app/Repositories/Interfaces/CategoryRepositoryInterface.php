<?php

namespace App\Repositories\Interfaces;

use App\Models\Account;
use App\Models\Representation;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface CategoryRepositoryInterface
{
    public function subCats($id) : ?Collection;

    public function parents() :?Collection;

    public function showParents($flag):?Collection;

    public function showSubCats($id,$flag):?Collection;

    public function allowed($code):?Collection;
}
