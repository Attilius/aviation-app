<?php

namespace App\Listeners;

use App\Events\Subscribed;

class SendEmailSubscribeNotification
{
    /**
     * @param Subscribed $event
     * @return void
     */
    public function handle(Subscribed $event): void
    {
        $event->subscriber->sendEmailSubscribeNotification();
    }
}
