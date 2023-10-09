<?php

namespace App\Providers;

use App\Mail\Subscribers\SubscriberBrokerManager;
use App\Mail\Subscribers\SubscriberManager;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class SubscriberServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register(): void
    {
        $this->registerSubscriberBroker();
    }

    /**
     * Register the subscriber services.
     *
     * @return void
     */
    protected function registerSubscriberBroker(): void
    {
        $this->app->singleton('subscriber', fn ($app) => new SubscriberManager($app));
        $this->app->singleton('subscriber.subscribers', function ($app) {
            return new SubscriberBrokerManager($app);
        });
        $this->app->bind('subscriber.subscribers.broker', function ($app) {
            return $app->make('subscriber.subscribers')->broker();
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides(): array
    {
        return ['subscriber.subscribers', 'subscriber.subscribers.broker'];
    }
}
