<?php

namespace App\Providers;

use App\Contracts\ContactMessageRepositoryInterface;
use App\Contracts\ContactMessageResponseInterface;
use App\Contracts\FailedSubscribeResponseInterface;
use App\Contracts\SubscriberRepositoryInterface;
use App\Contracts\SuccessfulSubscribeResponseInterface;
use App\Contracts\UserRepositoryInterface;
use App\Http\Responses\ContactMessageResponse;
use App\Http\Responses\FailedSubscribeResponse;
use App\Http\Responses\SuccessfulSubscribeResponse;
use App\Repository\ContactMessageRepository;
use App\Repository\SubscriberRepository;
use App\Repository\UserRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(SubscriberRepositoryInterface::class, SubscriberRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(SuccessfulSubscribeResponseInterface::class, SuccessfulSubscribeResponse::class);
        $this->app->bind(FailedSubscribeResponseInterface::class, FailedSubscribeResponse::class);
        $this->app->bind(ContactMessageRepositoryInterface::class, ContactMessageRepository::class);
        $this->app->bind(ContactMessageResponseInterface::class, ContactMessageResponse::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
