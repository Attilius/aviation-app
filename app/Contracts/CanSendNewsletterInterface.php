<?php

namespace App\Contracts;

interface CanSendNewsletterInterface
{
    /**
     * Get the e-mail address where newsletters are sent.
     *
     * @return string
     */
    public function getEmailForNewsletterSend(): string;

    /**
     * Send the newsletter notification.
     *
     * @return void
     */
    public function sendNewsletterNotification(): void;
}
