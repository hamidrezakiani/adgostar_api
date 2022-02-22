<?php
namespace App\Services\Representation\Agent;

use App\Http\Resources\Representation\Agent\TicketMessageResource;
use App\Lib\ResponseTemplate;
use App\Models\RepresentationTicket;

class TicketMessageService extends ResponseTemplate
{
    public function index($id)
    {
        $this->setData(new TicketMessageResource(RepresentationTicket::with(['messages'])->find($id)));
        return $this->response();
    }

    public function store($data,$id)
    {
        $ticket = RepresentationTicket::find($id);
        $ticket->messages()->create([
            'text' => $data->text,
        ]);
        $ticket->status = 'PENDING';
        $ticket->save();
        $this->setStatus(201);
        return $this->response();
    }
}
