<?php
namespace App\Services\Auth;

use App\Http\Resources\Representation\RepresentationLoginResource;
use App\Repositories\Eloquent\Auth\LoginRepository;
use App\Lib\ResponseTemplate;
use App\Repositories\Eloquent\Auth\AdminLoginRepository;
use App\Repositories\Eloquent\Auth\ExecuterLoginRepository;
use App\Repositories\Eloquent\Auth\UserLoginRepository;
use App\Repositories\Eloquent\RepresentationDetailRepository;
use App\Repositories\Eloquent\RepresentationRepository;
use Illuminate\Http\Request;

class LoginService extends ResponseTemplate{

    protected $loginRepository;

    public function __construct()
    {

    }

    public function RepresentationLoginPage(Request $request)
    {
        $detailRepository = new RepresentationDetailRepository($request->domain);
        if($representation = $detailRepository->findBYDomain() ?? NULL)
        {
            $this->setData(new RepresentationLoginResource($representation));
        }
        else
        {
            $this->setStatus(410);
        }
        return $this->response();
    }

    public function RepresentationLogin(Request $request)
    {
        $domain = $request->domain ? $request->domain : request()->headers->get('origin'); 
        $loginRepository = new UserLoginRepository();
        $representationRepository = new RepresentationRepository($request->domain);
        $representation = $representationRepository->findByDomain();
        if($user = $loginRepository->checkPassword($request->phone,$request->password,$representation->id))
        {
            $user = $loginRepository->updateToken($user);
            if($user->role == 'OWNER')
            {
                $representation->update([
                    'api_token' => $user->api_token,
                ]);
            }
            $this->setData($user);
        }
        else
        {
            $this->setErrors(['auth' => ['موبایل یا پسورد اشتباه است']]);
            $this->setStatus(401);
        }

        return $this->response();
    }

    public function adminLogin(Request $request)
    {
        $loginRepository = new AdminLoginRepository();
        if($admin = $loginRepository->checkPassword($request->phone,$request->password))
        {
            // $user = $this->loginRepository->updateToken($user);
            $this->setData($admin);
        }
        else
        {
            $this->setErrors(['email' => ['موبایل یا پسورد اشتباه است']]);
            $this->setStatus(401);
        }

        return $this->response();
    }

    public function executerLogin(Request $request)
    {
        $loginRepository = new ExecuterLoginRepository();
        if ($executer = $loginRepository->checkPassword($request->phone, $request->password)) {
            // $user = $this->loginRepository->updateToken($user);
            $this->setData($executer);
        } else {
            $this->setErrors(['email' => ['موبایل یا پسورد اشتباه است']]);
            $this->setStatus(401);
        }

        return $this->response();
    }
}
