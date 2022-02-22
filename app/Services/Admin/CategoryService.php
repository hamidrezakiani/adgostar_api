<?php
namespace App\Services\Admin;

use App\Events\CategoryCreatedEvent;
use App\Events\SetCategoryParentEvent;
use App\Events\UnsetCategoryParentEvent;
use App\Http\Resources\Admin\CategoryResource;
use App\Http\Resources\Admin\CategoryRouteResource;
use App\Lib\ResponseTemplate;
use App\Models\Category;
use App\Repositories\Eloquent\CategoryRepository;
use Illuminate\Support\Facades\DB;

class CategoryService extends ResponseTemplate
{
    protected $categoryRepository;
    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function index($flag = NULL,$search = NULL)
    {
        if($flag == 'parents')
        {
            $categories = $this->categoryRepository->parents();
            $this->setData(new CategoryResource($categories));
        }
        elseif($flag == 'subCats')
        {
            $categories = $this->categoryRepository->subCats($search);
            $this->setData(new CategoryResource($categories));
        }
        elseif($flag == 'all')
        {
            $categories = $this->categoryRepository->all();
            $this->setData(new CategoryResource($categories));
        }
        elseif($flag == 'allowed')
        {
           $categories = $this->categoryRepository->allowed($search);
           $this->setData(new CategoryResource($categories));
        }
        elseif($flag == 'allowedProduct')
        {
           $categories = $this->categoryRepository->allowedProduct();
           $this->setData(new CategoryResource($categories));
        }
        elseif($flag == 'routes')
        {
           $category = $this->categoryRepository->find($search);
           $pageRoute = $this->routePage($category);
           $this->setData($pageRoute);
        }
        else
        {
            $this->setStatus(403);
        }
        return $this->response();
    }

    public function update($request,$id)
    {
       $category = $this->categoryRepository->find($id);
       event(new UnsetCategoryParentEvent($category));
       $category->update($request->all());
       $category = $this->categoryRepository->find($id);
       event(new SetCategoryParentEvent($category));
       $this->setStatus(204);
       return $this->response();
    }

    public function store($request)
    {
       $category =  $this->categoryRepository->create($request->all());
       event(new CategoryCreatedEvent($category));
       $this->setStatus(204);
       return $this->response();
    }

    public function routePage($parent)
    {
        if($parent)
          return array_merge($this->routePage($parent->parent),[['id' => $parent->id,'name'=>$parent->name]]);
        else
          return [];
    }
}
