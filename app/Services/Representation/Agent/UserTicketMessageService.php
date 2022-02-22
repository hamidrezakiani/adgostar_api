<?php
namespace App\Services\Representation\Agent;

use App\Http\Resources\Representation\Agent\UserTicketMessageResource;
use App\Lib\ResponseTemplate;
use App\Models\UserTicket;

class UserTicketMessageService extends ResponseTemplate
{
    public function index($id)
    {
        $this->setData(new UserTicketMessageResource(UserTicket::with(['messages','user.account'])->find($id)));
        return $this->response();
    }

    public function store($data,$id)
    {
        $ticket = UserTicket::find($id);
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
