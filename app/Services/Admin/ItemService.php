<?php
namespace App\Services\Admin;

use App\Events\ItemCreatedEvent;
use App\Events\SetItemProductEvent;
use App\Events\UnsetItemProductEvent;
use App\Http\Resources\Admin\ItemCollection;
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
            $this->setData(new ItemCollection($items));
        }
        elseif($flag == 'all')
        {
            $items = $this->itemRepository->all();
            $this->setData(new ItemCollection($items));
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
        return $this->index('productItems',$item->product_id);
    }

    public function store($request)
    {
       $item = $this->itemRepository->create($request->all());
       event(new ItemCreatedEvent($item));
       $this->setStatus(200);
       return $this->index('productItems',$item->product_id);
    }
    
    public function moveUp($id)
    {
      $item = $this->itemRepository->find($id);
      $previousItem = $this->itemRepository->previous($id);
      if($previousItem)
      {
        $new_tab_index = $previousItem->tab_index;
        $previousItem->update(['tab_index' => $item->tab_index]);
        $item->update(['tab_index' => $new_tab_index]);
      }
      return $this->index('productItems',$item->product_id);
    }
    
    public function moveDown($id)
    {
      $item = $this->itemRepository->find($id);
      $nextItem = $this->itemRepository->next($id);
      if($nextItem)
      {
        $new_tab_index = $nextItem->tab_index;
        $nextItem->update(['tab_index' => $item->tab_index]);
        $item->update(['tab_index' => $new_tab_index]);
      }
      return $this->index('productItems',$item->product_id);
    }
}
