<?php
namespace App\Services\Representation;

use App\Http\Resources\Representation\AccountResource;
use App\Lib\ResponseTemplate;
use App\Repositories\Eloquent\RepresentationDetailRepository;

class AccountService extends ResponseTemplate
{
    protected $representationDetailRepository;

    public function __construct(RepresentationDetailRepository $representationDetailRepository)
    {
        $this->representationDetailRepository = $representationDetailRepository;
    }

    public function find()
    {
        $this->setData(new AccountResource(auth('account')->user()));
        return $this->response();
    }
}
