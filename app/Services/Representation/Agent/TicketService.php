<?php
namespace App\Services\Representation\Agent;

use App\Http\Resources\Representation\Agent\TicketResource;
use App\Lib\ResponseTemplate;

class TicketService extends ResponseTemplate
{
    protected $ticket;
    public function __construct()
    {
        $this->tickets = auth('representation')->user()->tickets();
    }

    public function index()
    {
        $this->setData(new TicketResource($this->tickets->get()));
        return $this->response();
    }

    public function store($data)
    {
        $ticket = $this->tickets->create([
           'title' => $data->title,
           'priority' => $data->priority,
           'status' => 'PENDING',
        ]);
        $ticket->messages()->create([
            'text' => $data->text,
        ]);
        $this->setStatus(201);
        return $this->response();
    }
}
