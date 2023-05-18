<?php

namespace App\Http\Controllers;

use App\Events\Subscribed;
use Illuminate\Http\Request;
use App\Contracts\SubscriberRepositoryInterface;

class SubscriberController extends Controller
{

    protected SubscriberRepositoryInterface $subscriberRepository;

    public function __construct(SubscriberRepositoryInterface $subscriberRepository)
    {
        $this->subscriberRepository = $subscriberRepository;
    }

    public function subscribe(Request $request)
    {
        $status = event(new Subscribed($this->subscriberRepository->store($request->all())));
        dd($status);
    }
}
