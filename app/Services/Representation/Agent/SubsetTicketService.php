<?php
namespace App\Services\Representation\Agent;

use App\Http\Resources\Representation\Agent\SubsetTicketResource;
use App\Lib\ResponseTemplate;
use App\Models\RepresentationTicket;

class SubsetTicketService extends ResponseTemplate
{
    protected $representation;
    public function __construct()
    {
        $this->representation = auth('representation')->user();
    }

    public function index()
    {
        $representation_id = $this->representation->id;
        $tickets = RepresentationTicket::whereHas('representation',function($subQuery) use($representation_id){
            $subQuery->where('parent_id', '=', $representation_id);
        })->with('representation')->get();
        $this->setData(new SubsetTicketResource($tickets));
        return $this->response();
    }

    public function store($data)
    {
        $ticket = RepresentationTicket::create([
           'representation_id' => $data->representation_id,
           'title' => $data->title,
           'priority' => $data->priority,
           'status' => 'ANSWERED',
           'created_by' => $this->representation->id,
        ]);
        $ticket->messages()->create([
            'text' => $data->text,
            'representation_id' => $this->representation->id,
        ]);
        $this->setStatus(201);
        return $this->response();
    }

}
