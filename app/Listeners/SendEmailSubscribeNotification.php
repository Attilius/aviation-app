<?php

namespace App\Listeners;

use App\Events\Subscribed;
use App\Contracts\MustSendEmail;

class SendEmailSubscribeNotification
{
    /**
     * @param Subscribed $event
     * @return void
     */
    public function handle(Subscribed $event)
    {
        $event->subscriber->sendEmailSubscribeNotification();
    }
}
