<?php
namespace App\Services\Representation\User;

use App\Http\Resources\Representation\User\TicketMessageResource;
use App\Lib\ResponseTemplate;
use App\Models\UserTicket;
use App\Repositories\Eloquent\RepresentationDetailRepository;

class TicketMessageService extends ResponseTemplate
{
    public function index($id)
    {
        $this->setData(new TicketMessageResource(UserTicket::with('messages')->find($id)));
        return $this->response();
    }

    public function store($data,$id)
    {
        $ticket = UserTicket::find($id);
        $ticket->messages()->create([
            'text' => $data->text,
        ]);
        $ticket->status = 'PENDING';
        $ticket->save();
        $this->setStatus(201);
        return $this->response();
    }
}
