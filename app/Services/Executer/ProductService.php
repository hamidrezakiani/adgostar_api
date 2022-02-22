<?php
namespace App\Services\Executer;

use App\Http\Resources\Executer\ProductResource;
use App\Lib\ResponseTemplate;
use App\Repositories\Eloquent\CategoryRepository;
use App\Repositories\Eloquent\ProductRepository;

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
            $products = $this->productRepository->getViewableByCategory($search);
            $this->setData(new ProductResource($products));
        }
        else
        {
            $this->setStatus(403);
        }
        return $this->response();
    }
}
