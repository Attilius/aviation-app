<?php

namespace App\Contracts;

interface SubsciberAuthenticableInterface
{
    /**
     * Get the unique identifier for the subscriber.
     *
     * @return string
     */
    public function getAuthIdentifierName(): string;

    /**
     * Get the email for the subscriber.
     *
     * @return string
     */
    public function getAuthEmail(): string;
}
