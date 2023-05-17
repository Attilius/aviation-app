<?php

namespace App\Mail;

use App\Notifications\SendEmailNotification;

trait MustSendEmail
{
    /**
     * Send the email verification notification.
     *
     * @return void
     */
    public function sendEmailSubscribeNotification()
    {
        $details = [
            'greeting' => 'Hello Test',
            'body' => 'Test body',
            'actionText' => 'Test action',
            'actionUrl' => '/test',
            'endText' => 'Test end'

        ];
        $this->notify(new SendEmailNotification($details));
    }
}
