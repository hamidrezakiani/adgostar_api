<?php
namespace App\Services\Representation\Agent;

use App\Http\Resources\Representation\Agent\CategoryResource;
use App\Http\Resources\Representation\CategoryCollection;
use App\Lib\ResponseTemplate;
use App\Repositories\Eloquent\CategoryRepository;
use App\Repositories\Eloquent\ProductRepository;

class CategoryService extends ResponseTemplate
{
    protected $categoryRepository,$productRepository;
    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
        $this->productRepository = new ProductRepository();
    }

    public function index($flag = NULL,$search = NULL)
    {
        if($flag == 'parents')
        {
            $categories = $this->categoryRepository->showParents('readyServices');
            $this->setData(new CategoryResource($categories));
        }
        elseif($flag == 'subCats')
        {
            $categories = $this->categoryRepository->showSubCats($search, 'readyServices');
            $this->setData(new CategoryResource($categories));
        }
        elseif ($flag == 'routes') {
            $category = $this->categoryRepository->find($search);
            $pageRoute = $this->routePage($category);
            $this->setData($pageRoute);
        }
        elseif($flag == 'nested')
        {
          $showParents = $this->categoryRepository->showParents('all');
          foreach ($showParents as $cat){
            $cat->subCats = $this->nestedCategories($cat->id);
          }
          $this->setData(new CategoryCollection($showParents));
        }
        else
        {
            $this->setStatus(403);
            return $this->response();
        }
        return $this->response();
    }
    public function nestedCategories($categoryId)
    {
       $subCats = $this->categoryRepository->showSubCats($categoryId,'all');
       foreach ($subCats as $cat){
         $cat->subCats = $this->nestedCategories($cat->id);
       }
       
       return $subCats;
       
    }
    public function routePage($parent)
    {
        if ($parent)
            return array_merge($this->routePage($parent->showParent), [['id' => $parent->id, 'name' => $parent->name]]);
        else
            return [];
    }
}
