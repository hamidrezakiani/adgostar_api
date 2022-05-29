<?php

namespace App\Repositories\Eloquent;

use App\Models\Category;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class CategoryRepository extends BaseRepository implements CategoryRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(new Category());
    }

    public function subCats($id) :?Collection
    {
        return $this->model->find($id)->subCats()->orderBy('tab_index','ASC')->get();
    }
    
    public function brothers($id) :?Collection
    {
        $category = $this->model->find($id);
        return $this->model->where('parent_id',$category->parent_id)->orderBy('tab_index','ASC')->get();
    }

    public function parents() :?Collection
    {
        return $this->model->where('parent_id',NULL)->orderBy('tab_index','ASC')->get();
    }

    public function showParents($flag = 'all'):?Collection
    {
        switch($flag)
        {
          case 'all' :
            return $this->model->where('showParent_id',NULL)->get();
            break;
          case 'readyServices' :
            return $this->model->where('showParent_id', NULL)
            ->readyService()->get();
            break;
          case 'readyParticipation':
            return $this->model->where('showParent_id', NULL)
            ->readyParticipation()->get();
            break;
          default :
             return NULL;
             break;
        }
    }

    public function showSubCats($id,$flag = 'all'):?Collection
    {
        switch ($flag) {
            case 'all':
                return $this->model->find($id)->showSubCats()->get();
                break;
            case 'readyServices':
                return $this->model->find($id)->showSubCats()
                ->readyService()->get();
                break;
            case 'readyParticipation':
                return $this->model->find($id)->showSubCats()
                ->readyParticipation()->get();
            default :
                return NULL;
                break;
        }

    }

    public function allowedProduct():?Collection
    {
        return $this->model->where('count_subCat',0)->get();
    }
    

    public function allowed($id):?Collection
    {
        $cats = $this->model->all();
        $allowed = $cats->map(function($cat)use($id){
           $temp = $cat;
           $cat->allowed = false;
           for($i=0;$temp;$i++)
           {
              if($temp->id != $id)
              {
                  if(!$temp->parent)
                  {
                    $cat->allowed = true;
                    $temp = false;
                  }
                  else
                   $temp = $temp->parent;
              }
              else
              {
                  $temp = false;
              }

           }
           return $cat;
        });
        return $allowed;
    }
    
    public function previous($id)
    {
      $category = $this->model->find($id);
      return $this->model->where('parent_id',$category->parent_id)
        ->where('tab_index','<',$category->tab_index)
          ->orderBy('tab_index','DESC')->first();
    }
    
    public function next($id)
    {
      $category = $this->model->find($id);
      return $this->model->where('parent_id',$category->parent_id)
        ->where('tab_index','>',$category->tab_index)
          ->orderBy('tab_index','ASC')->first();
    }
}
