<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCategoryRequest;
use App\Http\Requests\Admin\UpdateCategoryRequest;
use App\Models\Category;
use App\Services\Admin\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected $categoryService;
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $this->categoryService->index($request->flag,$request->parent_id);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategoryRequest $request)
    {
        return $this->categoryService->store($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $c = Category::where(function($subQuery)use($id){
            return $subQuery->where('parent_id',$id)
             ->where('show','YES');
         })->orWhere(function($subQuery)use($id){
            return $subQuery->whereHas('showParent',function($subQuery)use($id){
                return $subQuery->where('id',$id);
            });
         })->get();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id,UpdateCategoryRequest $request)
    {
        return $this->categoryService->update($request,$id);
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
     * Move a category with the
     * previous category by changing the index.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function moveUp($id)
    {
        return $this->categoryService->moveUp($id);
    }
    
    /**
     * Move a category with the
     * next category by changing the index.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function moveDown($id)
    {
        return $this->categoryService->moveDown($id);
    }
}
