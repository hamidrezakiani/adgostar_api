<?php

namespace App\Http\Controllers\Representation\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Representation\User\StoreTicketRequest;
use App\Services\Representation\User\TicketService;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    protected $ticketService;

    public function __construct(TicketService $ticketService)
    {
        $this->ticketService = $ticketService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $this->ticketService->index($request->type);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTicketRequest $request)
    {
        return $this->ticketService->store($request);
    }

}
