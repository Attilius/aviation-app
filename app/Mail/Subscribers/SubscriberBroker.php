<?php

namespace App\Mail\Subscribers;

use App\Contracts\CanSendNewsletterInterface;
use App\Contracts\SubscriberBrokerInterface;
use App\Contracts\SubscriberProviderInterface;
use Closure;
use Illuminate\Support\Arr;
use UnexpectedValueException;

class SubscriberBroker implements SubscriberBrokerInterface
{
    /**
     * The subscriber provider implementation.
     *
     * @var SubscriberProviderInterface
     */
    protected SubscriberProviderInterface $subscribers;

    /**
     * Create a new subscriber broker instance.
     *
     * @param SubscriberProviderInterface $subscribers
     * @return void
     */
    public function __construct(SubscriberProviderInterface $subscribers)
    {
        $this->subscribers = $subscribers;
    }

    /**
     * @param array $credentials
     * @param Closure|null $callback
     * @return string
     */
    public function sendGreetingEmail(array $credentials, Closure $callback = null): string
    {
        $subscriber = $this->getSubscriber($credentials);

        if (is_null($subscriber)) {
            return static::SUBSCRIBED_EMAIL_SENT;
        }

        return static::SUBSCRIBER_ALREADY_SUBSCRIBED;
    }

    /**
     * @param array $credentials
     * @param Closure|null $callback
     * @return string
     */
    public function unsubscribe(array $credentials, Closure $callback = null): string
    {
        // TODO: Implement unsubscribe() method.
    }

    /**
     * Get the user for the given credentials.
     *
     * @param array $credentials
     * @return CanSendNewsletterInterface|null
     * @throws UnexpectedValueException
     */
    public function getSubscriber(array $credentials): CanSendNewsletterInterface|null
    {
        $credentials = Arr::except($credentials, ['role']);

        $subscriber = $this->subscribers->retrieveByCredentials($credentials);

        if ($subscriber && !$subscriber instanceof CanSendNewsletterInterface) {
            throw new UnexpectedValueException('Subscriber must implement CanSendNewsletter interface.');
        }

        return $subscriber;
    }
}
