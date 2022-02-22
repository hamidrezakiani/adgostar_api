<?php
namespace App\Services\Representation\Agent;

use App\Http\Resources\Representation\Agent\SubsetTicketMessageResource;
use App\Lib\ResponseTemplate;
use App\Models\RepresentationTicket;
use App\Models\UserTicket;

class SubsetTicketMessageService extends ResponseTemplate
{
    public function index($id)
    {
        $this->setData(new SubsetTicketMessageResource(RepresentationTicket::with(['messages','representation.detail'])->find($id)));
        return $this->response();
    }

    public function store($data,$id)
    {
        $ticket = RepresentationTicket::find($id);
        $ticket->messages()->create([
            'text' => $data->text,
            'representation_id' => auth('representation')->id(),
        ]);
        $ticket->status = 'ANSWERED';
        $ticket->save();
        $this->setStatus(201);
        return $this->response();
    }
}
