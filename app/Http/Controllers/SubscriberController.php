<?php

namespace App\Http\Controllers;

use App\Contracts\FailedSubscribeResponseInterface;
use App\Contracts\SubscriberBrokerInterface;
use App\Contracts\SuccessfulSubscribeResponseInterface;
use App\Events\Subscribed;
use App\Facades\Subscriber;
use Illuminate\Http\Request;
use App\Contracts\SubscriberRepositoryInterface;
use Laravel\Fortify\Fortify;

class SubscriberController extends Controller
{

    protected SubscriberRepositoryInterface $subscriberRepository;

    public function __construct(SubscriberRepositoryInterface $subscriberRepository)
    {
        $this->subscriberRepository = $subscriberRepository;
    }

    public function subscribe(Request $request)
    {
        event(new Subscribed($this->subscriberRepository->store($request->all())));

        $status = $this->broker()->sendGreetingEmail(
            $request->only(Fortify::email())
        );

        return $status == Subscriber::SUBSCRIBED_EMAIL_SENT
            ? app(SuccessfulSubscribeResponseInterface::class, ['status' => $status])
            : app(FailedSubscribeResponseInterface::class, ['status' => $status]);
    }

    /**
     * Get the broker to be used during password reset.
     *
     * @return SubscriberBrokerInterface
     */
    protected function broker(): SubscriberBrokerInterface
    {
        return Subscriber::broker(config('emailing.subscribers'));
    }
}
