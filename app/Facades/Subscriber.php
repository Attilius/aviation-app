<?php

namespace App\Facades;

use App\Contracts\SubscriberBrokerInterface;
use App\Mail\Subscribers\SubscriberBrokerManager;
use Illuminate\Support\Facades\Facade;

/**
 * @method static SubscriberBrokerInterface broker(string|null $name = null)
 *
 * @see SubscriberBrokerManager
 */
class Subscriber extends Facade
{
    /**
     * Constant representing a successfully sent reminder.
     *
     * @var string
     */
    const SUBSCRIBED_EMAIL_SENT = SubscriberBrokerInterface::SUBSCRIBED_EMAIL_SENT;

    /**
     * Constant representing the subscriber not found response.
     *
     * @var string
     */
    const SUBSCRIBER_ALREADY_SUBSCRIBED = SubscriberBrokerInterface::SUBSCRIBER_ALREADY_SUBSCRIBED;

    /**
     * Constant representing a successfully removed subscriber.
     *
     * @var string
     */
    const SUBSCRIBER_REMOVED = SubscriberBrokerInterface::SUBSCRIBER_REMOVED;

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'subscriber.subscribers';
    }
}
