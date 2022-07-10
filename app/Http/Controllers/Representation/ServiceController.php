<?php

namespace App\Http\Controllers\Representation;

use App\Http\Controllers\Controller;
use App\Services\Representation\ServiceService;
use Illuminate\Http\Request;

class ServiceController extends Controller
{

    protected $serviceService;

    public function __construct(Request $request)
    {
        $this->serviceService = new ServiceService($request->domain);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $this->serviceService->index($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id,Request $request)
    {
        return $this->serviceService->show($id,$request->domain);
    }

}
