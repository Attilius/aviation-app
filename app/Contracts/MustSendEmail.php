<?php

namespace App\Contracts;

interface MustSendEmail
{
    /**
     * Send the subscribed email notification.
     *
     * @return void
     */
    public function sendEmailSubscribeNotification();
}
