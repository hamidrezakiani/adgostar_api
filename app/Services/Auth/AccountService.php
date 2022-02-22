<?php
namespace App\Services\Auth;

use App\Lib\ResponseTemplate;
use App\Repositories\Eloquent\AccountRepository;
use Illuminate\Http\Request;

class AccountService extends ResponseTemplate{

    protected $accountRepository;

    public function __construct()
    {
        $this->accountRepository = new AccountRepository();
    }

    public function createOrUpdate($phone,$password)
    {
       if(!$account = $this->accountRepository->updatePassword($phone,$password))
           $account = $this->accountRepository->create(['phone' => $phone,'password' => $password]);
       return $account;
    }
}
