<?php
namespace App\Services\Admin;

use App\Events\ItemCreatedEvent;
use App\Events\SetItemProductEvent;
use App\Events\UnsetItemProductEvent;
use App\Http\Resources\Admin\ItemResource;
use App\Lib\ResponseTemplate;
use App\Repositories\Eloquent\ItemRepository;
use App\Repositories\Eloquent\ProductRepository;
use Illuminate\Support\Facades\DB;

class ItemService extends ResponseTemplate
{
    protected $itemRepository;
    protected $productRepository;
    public function __construct(ItemRepository $itemRepository)
    {
        $this->itemRepository = $itemRepository;
        $this->productRepository = new ProductRepository();
    }

    public function index($flag = NULL,$search = NULL)
    {
        if($flag == 'productItems')
        {
            $items = $this->itemRepository->getByProduct($search);
            $this->setData(new ItemResource($items));
        }
        elseif($flag == 'all')
        {
            $items = $this->itemRepository->all();
            $this->setData(new ItemResource($items));
        }
        else
        {
            $this->setStatus(403);
        }
        return $this->response();
    }

    public function update($request,$id)
    {
        $item = $this->itemRepository->find($id);
        event(new UnsetItemProductEvent($item));
        $item->update($request->all());
        $item = $this->itemRepository->find($id);
        event(new SetItemProductEvent($item));
        $this->setStatus(204);
        return $this->response();
    }

    public function store($request)
    {

       $item = $this->itemRepository->create($request->all());
       event(new ItemCreatedEvent($item));
       $this->setStatus(204);
       return $this->response();
    }
}
