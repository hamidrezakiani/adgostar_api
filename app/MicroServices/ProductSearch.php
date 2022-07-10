<?php 

namespace App\MicroServices;
use App\Repositories\Eloquent\CategoryRepository;
use App\Repositories\Eloquent\ProductRepository;

class ProductSearch
{
  protected $productRepository;
  protected $categoryRepository;
  private $scope = 'all';
  
  public function __construct()
  {
     $this->productRepository = new ProductRepository();
     $this->categoryRepository = new CategoryRepository();
  }
  
  public function readyService()
  {
    $this->scope = 'readyService';
    return $this;
  }
  
  public function searchByCatId($cat_id)
  {
     $category = $this->categoryRepository->find($cat_id);
     if($category->count_subCat == 0)
       return $this->productRepository->getViewableByCategory($cat_id,$this->scope);
     
     $subCats = $this->categoryRepository->showSubCats($cat_id);
     $products = collect([]);
     foreach ($subCats as $category)
     {
        $products = $products->concat($this->searchByCat($category->id));
     }
     
     return $products;
  }
  
  public function all()
  {
    return $this->productRepository->getReadyServices();
  }
}