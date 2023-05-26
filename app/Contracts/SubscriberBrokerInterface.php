<?php

namespace App\Contracts;

use Closure;

interface SubscriberBrokerInterface
{
    /**
     * Constant representing a successfully sent reminder.
     *
     * @var string
     */
    const SUBSCRIBED_EMAIL_SENT = 'subscriber.sent';

    /**
     * Constant representing the subscriber not found response.
     *
     * @var string
     */
    const SUBSCRIBER_ALREADY_SUBSCRIBED = 'subscriber.subscribed';

    /**
     * Constant representing a successfully removed subscriber.
     *
     * @var string
     */
    const SUBSCRIBER_REMOVED = 'subscriber.removed';

    /**
     * Send a greeting email to a new subscriber.
     *
     * @param array $credentials
     * @param Closure|null $callback
     * @return string
     */
    public function sendGreetingEmail(array $credentials, Closure $callback = null): string;

    /**
     * Remove subscriber from subscribers table.
     *
     * @param array $credentials
     * @param Closure|null $callback
     * @return string
     */
    public function unsubscribe(array $credentials, Closure $callback = null): string;
}
