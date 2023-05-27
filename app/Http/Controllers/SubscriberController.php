<?php

namespace App\Http\Controllers;

use App\Contracts\FailedSubscribeResponseInterface;
use App\Contracts\SubscriberBrokerInterface;
use App\Contracts\SuccessfulSubscribeResponseInterface;
use App\Events\Subscribed;
use App\Facades\Subscriber as SubscriberFacade;
use App\Http\Responses\FailedSubscribeResponse;
use App\Http\Responses\SuccessfulSubscribeResponse;
use Illuminate\Http\Request;
use App\Contracts\SubscriberRepositoryInterface;
use Laravel\Fortify\Fortify;
use App\Models\Subscriber;

class SubscriberController extends Controller
{

    /**
     * The subscriber repository implementation.
     *
     * @var SubscriberRepositoryInterface
     */
    protected SubscriberRepositoryInterface $subscriberRepository;

    /**
     * Create a subscriber repository instance.
     *
     * @param SubscriberRepositoryInterface $subscriberRepository
     * @return void
     */
    public function __construct(SubscriberRepositoryInterface $subscriberRepository)
    {
        $this->subscriberRepository = $subscriberRepository;
    }

    /**
     * Send a greeting email for the new subscriber.
     *
     * @param Request $request
     * @return SuccessfulSubscribeResponse|FailedSubscribeResponse
     */
    public function subscribe(Request $request): SuccessfulSubscribeResponse|FailedSubscribeResponse
    {
        $status = $this->broker()->sendGreetingEmail(
            $request->only(Fortify::email())
        );

         // We'll store this subscriber if his already not exist.
         // After storing we send a greeting email and a success response.
         // If it's exist we respond an error message with failed response.

        if($this->isSubscriberAlreadyExist($request['email'])){
            event(new Subscribed($this->subscriberRepository->store($request->all())));
        }

        return $status == SubscriberFacade::SUBSCRIBED_EMAIL_SENT
            ? app(SuccessfulSubscribeResponseInterface::class, ['status' => $status])
            : app(FailedSubscribeResponseInterface::class, ['status' => $status]);
    }

    /**
     * Get the broker to be used during subscribing.
     *
     * @return SubscriberBrokerInterface
     */
    private function broker(): SubscriberBrokerInterface
    {
        return SubscriberFacade::broker(config('emailing.subscribers'));
    }

    /**
     * Get subscriber for with email address from subscribers table.
     *
     * @param string $email
     * @return bool
     */
    private function isSubscriberAlreadyExist(string $email): bool
    {
        $subscriber = Subscriber::where('email', $email)->get();

        return count($subscriber) == 0;
    }
}
