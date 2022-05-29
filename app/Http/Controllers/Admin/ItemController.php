<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateItemRequest;
use App\Http\Requests\Admin\UpdateItemRequest;
use App\Services\Admin\ItemService;
use Illuminate\Http\Request;

class ItemController extends Controller
{

    protected $itemService;
    
    public function __construct(ItemService $itemService)
    {
        $this->itemService = $itemService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $this->itemService->index($request->flag,$request->product_id);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateItemRequest $request)
    {
       return $this->itemService->store($request);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateItemRequest $request, $id)
    {
        return $this->itemService->update($request,$id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    
    /**
     * Move a item with the
     * previous item by changing the index.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function moveUp($id)
    {
        return $this->itemService->moveUp($id);
    }
    
    /**
     * Move a item with the
     * next item by changing the index.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function moveDown($id)
    {
        return $this->itemService->moveDown($id);
    }
}
