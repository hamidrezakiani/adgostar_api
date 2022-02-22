<?php
namespace App\Services\Admin;

use App\Events\ItemCreatedEvent;
use App\Events\ProductCreatedEvent;
use App\Events\SetProductCategoryEvent;
use App\Events\UnsetProductCategoryEvent;
use App\Http\Resources\Admin\CategoryResource;
use App\Http\Resources\Admin\CategoryRouteResource;
use App\Http\Resources\Admin\ProductResource;
use App\Lib\ResponseTemplate;
use App\Models\Category;
use App\Repositories\Eloquent\CategoryRepository;
use App\Repositories\Eloquent\ProductRepository;
use App\Repositories\Eloquent\PropertyRepository;
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

    public function index($flag = NULL,$search = NULL)
    {
        if($flag == 'categoryProducts')
        {
            $products = $this->productRepository->getByCategory($search);
            $this->setData(new ProductResource($products));
        }
        elseif($flag == 'all')
        {
            $products = $this->productRepository->all();
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
       $product = $this->productRepository->find($id);
       event(new UnsetProductCategoryEvent($product));
       $product->update($request->all());
       $product = $this->productRepository->find($id);
       event(new SetProductCategoryEvent($product));
       $this->setStatus(204);
       return $this->response();
    }

    public function store($request)
    {
       $product = $this->productRepository->create($request->all());
       event(new ProductCreatedEvent($product));
       $firstItem = $product->items()->first();
       event(new ItemCreatedEvent($firstItem));
       $this->setStatus(204);
       return $this->response();
    }
}
