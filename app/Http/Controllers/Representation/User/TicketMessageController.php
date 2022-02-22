<?php

namespace App\Http\Controllers\Representation\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Representation\User\IndexTicketMessageRequest;
use App\Http\Requests\Representation\User\StoreTicketMessageRequest;
use App\Services\Representation\User\TicketMessageService;
use Illuminate\Http\Request;

class TicketMessageController extends Controller
{
    protected $ticketMessageService;

    public function __construct(TicketMessageService $ticketMessageService)
    {
        $this->ticketMessageService = $ticketMessageService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(IndexTicketMessageRequest $request,$id)
    {
        return $this->ticketMessageService->index($id);
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
    public function store(StoreTicketMessageRequest $request,$id)
    {
        return $this->ticketMessageService->store($request,$id);
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
    public function update(Request $request, $id)
    {
        //
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
