<?php

namespace App\Services\Representation;

use App\Http\Resources\Representation\ItemResource;
use App\Http\Resources\Representation\ServiceResource;
use App\Lib\ResponseTemplate;
use App\Repositories\Eloquent\CategoryRepository;
use App\Repositories\Eloquent\ItemRepository;
use App\Repositories\Eloquent\ParticipationPeriodRepository;
use App\Repositories\Eloquent\ProductRepository;
use App\Repositories\Eloquent\RepresentationItemPeriodRepository;
use App\Repositories\Eloquent\RepresentationRepository;
use Exception;
use Illuminate\Support\Facades\DB;

class ServiceService extends ResponseTemplate
{
    protected $productRepository;
    protected $itemRepository;
    protected $categoryRepository;
    protected $representationRepository;
    protected $participationPeriodRepository;
    protected $representationItemPeriodRepository;

    public function __construct($domain)
    {
        $this->productRepository = new ProductRepository();
        $this->itemRepository = new ItemRepository();
        $this->categoryRepository = new CategoryRepository();
        $this->representationItemPeriodRepository = new RepresentationItemPeriodRepository();
        $this->participationPeriodRepository = new ParticipationPeriodRepository();
        $this->representationRepository = new RepresentationRepository($domain);
        $this->representation = $this->representationRepository->findByDomain();
    }

    public function getAllCategoryViewableProduct($category_id)
    {
        $category = $this->categoryRepository->find($category_id);
        if ($category->count_subCat == 0) {
            return $this->productRepository->getViewableByCategory($category_id, 'readyService');
        } else {
            $subCats = $this->categoryRepository->showSubCats($category_id);
            $products = collect([]);
            foreach ($subCats as $category) {
                $products = $products->concat($this->getAllCategoryViewableProduct($category->id));
            }
            return $products;
        }
    }

    public function baseCost($itemPeriod, $representation)
    {
            if ($representation->parent) {
                $rPeriod = $this->representationItemPeriodRepository->findByItemPeriodId($representation->parent->id, $itemPeriod->id);
                if ($representation->kind == 'SPECIAL') {
                    return round((1 + $rPeriod->seniorRepresentationProfit / 100) *
                        $this->baseCost($itemPeriod, $representation->parent));
                } else {
                    return round((1 + $rPeriod->normalRepresentationProfit / 100) *
                        $this->baseCost($itemPeriod, $representation->parent));
                }
            }
            return $this->participationPeriodRepository
                ->matchPeriod($itemPeriod->item_id, $itemPeriod->start, $itemPeriod->end)
                ->cost;
    }

    public function itemPeriods($item_id,$domain)
    {
        $maxOrder =  $this->participationPeriodRepository->maxOrder($item_id);
        $rPeriods  = $this->representationItemPeriodRepository->getByItemId($this->representation->id, $item_id);
        $rPeriods = $rPeriods->map(function ($rPeriod) use ($maxOrder) {
            $rPeriod->baseCost = $this->baseCost($rPeriod->itemPeriod, $this->representation);
            $rPeriod->cost = round($rPeriod->baseCost * (1 + $rPeriod->userProfit / 100));
            if ($rPeriod->itemPeriod->end == NULL || $rPeriod->itemPeriod->end > $maxOrder)
                $rPeriod->itemPeriod->end = $maxOrder;
            return $rPeriod;
        });
        return $rPeriods;
    }

    public function index($flag = NULL,$domain,$category_id = NULL)
    {
        if ($flag == 'categoryServices') {
            $products = $this->getAllCategoryViewableProduct($category_id);
            $products = $products->map(function($product)use($domain){
              $product->items = $product->items()->readyService()->get();
              $product->items = $product->items->map(function($item)use($domain){
                 $item->periods = $this->itemPeriods($item->id,$domain);
                 $item->maxOrder = $this->participationPeriodRepository->maxOrder($item->id);
                 return $item;
              });
              return $product;
            });
            $this->setData(new ServiceResource($products));
        } elseif ($flag == 'all') {
            $showParents = $this->categoryRepository->showParents();
            $products = collect([]);
            foreach ($showParents as $category) {
                $products = $products->concat($this->getAllCategoryViewableProduct($category->id));
            }
            $products = $products->map(function ($product) use ($domain) {
                $product->items = $product->items->map(function ($item) use ($domain) {
                    $item->periods = $this->itemPeriods($item->id, $domain);
                    $item->maxOrder = $this->participationPeriodRepository->maxOrder($item->id);
                    return $item;
                });
                return $product;
            });
            $this->setData(new ServiceResource($products));
        }
        else {
            $this->setStatus(403);
        }
        return $this->response();
    }
    
    

    public function show($id,$domain)
    {
       $item = $this->itemRepository->find($id);
       $item->periods = $this->itemPeriods($item->id, $domain);
       $item->maxOrder = $this->participationPeriodRepository->maxOrder($item->id);
       $this->setData(new ItemResource($item));
        return $this->response();
    }
}
