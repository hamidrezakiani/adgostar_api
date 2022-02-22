<?php
namespace App\Services\Auth;

use App\Lib\ResponseTemplate;
use App\Repositories\Eloquent\Auth\LogoutRepository;
use Illuminate\Http\Request;

class LogoutService extends ResponseTemplate{

    protected $logoutRepository;

    public function __construct(LogoutRepository $logoutRepository)
    {
        $this->logoutRepository = $logoutRepository;
    }

    public function register(Request $request)
    {
       $this->data = $this->logoutRepository->removeToken($request);
       return $this->response();
    }
}
