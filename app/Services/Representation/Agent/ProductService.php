<?php
namespace App\Services\Representation\Agent;

use App\Http\Resources\Representation\Agent\ProductResource;
use App\Lib\ResponseTemplate;
use App\Repositories\Eloquent\CategoryRepository;
use App\Repositories\Eloquent\ProductRepository;
use Illuminate\Support\Facades\DB;

class ProductService extends ResponseTemplate
{
    protected $productRepository;
    protected $categoryRepository;
    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
        $this->categoryRepository = new CategoryRepository();
    }

    public function getAllCategoryViewableProduct($category_id)
    {
        $category = $this->categoryRepository->find($category_id);
        if($category->count_subCat == 0)
        {
           return $this->productRepository->getViewableByCategory($category_id,'readyService');
        }
        else
        {
          $subCats = $this->categoryRepository->showSubCats($category_id);
          $products = collect([]);
          foreach($subCats as $category)
          {
           $products = $products->concat($this->getAllCategoryViewableProduct($category->id));
          }
          return $products;
        }
    }

    public function index($flag = NULL,$search = NULL)
    {
        if($flag == 'categoryProducts')
        {
            $products = $this->getAllCategoryViewableProduct($search);
            $this->setData(new ProductResource($products));
        }
        elseif($flag == 'all')
        {
            $showParents = $this->categoryRepository->showParents();
            $products = collect([]);
            foreach($showParents as $category)
            {
                $products = $products->concat($this->getAllCategoryViewableProduct($category->id));
            }
            $this->setData(new ProductResource($products));
        }
        else
        {
            $this->setStatus(403);
        }
        return $this->response();
    }

    public function update($request,$id)
    {
       if($request->category_id)
       {
           $this->productRepository->find($id)->category
           ->update(['count_product' => DB::raw('count_product-1')]);
           $this->categoryRepository->find($request->category_id)
           ->update(['count_product' => DB::raw('count_product+1')]);
       }
       $this->productRepository->update($request->all(),$id);
       $this->setStatus(204);
       return $this->response();
    }

    public function store($request)
    {
       $product = $this->productRepository->create($request->all());
       $product->category->update(['count_product' => DB::raw('count_product+1')]);
       $this->setStatus(204);
       return $this->response();
    }
}
