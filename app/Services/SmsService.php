<?php

namespace App\Services;

use App\Events\FastUserEvent;
use App\Lib\SmsIr;
use Exception;
use Illuminate\Support\Str;

class SmsService
{
    protected $smsIr,$parameterArray,$mobile,$templateId;

    public function __construct()
    {
        $this->smsIr = new SmsIr();
    }

    public function setParameter($parameterArray,$mobile,$templateId)
    {
       $this->parameterArray = $parameterArray;
       $this->mobile = $mobile;
       $this->templateId = $templateId;
    }

    public function send()
    {
       return $this->smsIr->ultraFastSend(array(
                "ParameterArray" => $this->parameterArray,
                "Mobile" => $this->mobile,
                "TemplateId" => $this->templateId
            ));
    }

    public function newPassword($mobile,$password)
    {
        $parameterArray = array(
            array(
               "Parameter" => "Password",
               "ParameterValue" => $password
            )
        );
        $this->setParameter($parameterArray,$mobile,53293);
        return $this->send();
    }

}
