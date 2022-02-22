<?php
namespace App\Services\Representation\User;

use App\Http\Resources\Representation\User\TicketResource;
use App\Lib\ResponseTemplate;
use App\Models\UserTicket;
use App\Repositories\Eloquent\RepresentationDetailRepository;

class TicketService extends ResponseTemplate
{
    protected $representationDetailRepository,$tickets;

    public function __construct(RepresentationDetailRepository $representationDetailRepository)
    {
        $this->representationDetailRepository = $representationDetailRepository;
        $this->tickets = auth('user')->user()->tickets();
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
