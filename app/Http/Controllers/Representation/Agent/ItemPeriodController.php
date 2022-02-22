<?php

namespace App\Http\Controllers\Representation\Agent;

use App\Http\Controllers\Controller;
use App\Http\Requests\Representation\Agent\UpdateRepresentationPeriodRequest;
use App\Services\Representation\Agent\RepresentationItemPeriodService;
use Illuminate\Http\Request;

class ItemPeriodController extends Controller
{

    protected $representationItemPeriodService;

    public function __construct(RepresentationItemPeriodService $representationItemPeriodService)
    {
        $this->representationItemPeriodService = $representationItemPeriodService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($item_id)
    {
        return $this->representationItemPeriodService->index($item_id);
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    public function update(UpdateRepresentationPeriodRequest $request, $id)
    {
        return $this->representationItemPeriodService->update($request->all(),$id);
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
}
