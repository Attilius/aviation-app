<?php

namespace App\Contracts;

use App\Mail\Subscribers\SubscriberBroker;

interface SubscriberBrokerFactoryInterface
{
    /**
     * Get a subscriber broker instance by name.
     *
     * @param string|null $name
     * @return SubscriberBroker
     */
    public function broker(string $name = null): SubscriberBrokerInterface;
}
