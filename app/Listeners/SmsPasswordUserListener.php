<?php

namespace App\Listeners;

use App\Events\FastUserEvent;
use App\Services\SmsService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SmsPasswordUserListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public $smsService;
    public function __construct(SmsService $smsService)
    {
        $this->smsService = $smsService;
    }

    /**
     * Handle the event.
     *
     * @param  FastUserEvent  $event
     * @return void
     */
    public function handle(FastUserEvent $event)
    {
        $user = $event->user;
        $password = $event->password;
        $this->smsService->newPassword($user->phone,$password);
    }
}
