<?php

namespace App\Http\Controllers\V1\Auth;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\Auth\LogoutRepositoryInterface;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    private  $logoutRepository;

    public function __construct(LogoutRepositoryInterface $logoutRepository)
    {
        $this->logoutRepository = $logoutRepository;
    }
    public function logout(Request $request)
    {
        $this->logoutRepository->removeToken($request);
        return response()->json(['data' =>[],'errors' => []]);
    }
}
