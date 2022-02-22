<?php
namespace App\Services\Auth;

use App\Lib\ResponseTemplate;
use App\Repositories\Eloquent\Auth\RegisterRepository;
use Illuminate\Http\Request;

class RegisterService extends ResponseTemplate{

    protected $registerRepository;

    public function __construct(RegisterRepository $registerRepository)
    {
        $this->registerRepository = $registerRepository;
    }

    public function register(Request $request)
    {
       $this->data = $this->registerRepository->create($request->all());
       return $this->response();
    }
}
