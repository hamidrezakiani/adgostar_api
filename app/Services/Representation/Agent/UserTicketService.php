<?php
namespace App\Services\Representation\Agent;

use App\Http\Resources\Representation\Agent\UserTicketResource;
use App\Lib\ResponseTemplate;
use App\Models\UserTicket;
use App\Repositories\Eloquent\RepresentationDetailRepository;

class UserTicketService extends ResponseTemplate
{
    protected $representation;
    public function __construct()
    {
        $this->representation = auth('representation')->user();
    }

    public function index()
    {
        $representation_id = $this->representation->id;
        $tickets = UserTicket::whereHas('user',function($subQuery) use($representation_id){
            $subQuery->where('representation_id', '=', $representation_id);
        })->with('user.account')->get();
        $this->setData(new UserTicketResource($tickets));
        return $this->response();
    }

    public function store($data)
    {
        $ticket = UserTicket::create([
           'user_id' => $data->user_id,
           'title' => $data->title,
           'priority' => $data->priority,
           'status' => 'ANSWERED',
           'representation_id' => $this->representation->id,
        ]);
        $ticket->messages()->create([
            'text' => $data->text,
            'representation_id' => $this->representation->id,
        ]);
        $this->setStatus(201);
        return $this->response();
    }
}
