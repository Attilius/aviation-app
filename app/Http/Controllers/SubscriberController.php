<?php

namespace App\Http\Controllers;

use App\Events\Subscribed;
use Illuminate\Http\Request;
//use App\Models\Subscriber;
//use App\Contracts\CreatesNewSubscribers;
use Laravel\Fortify\Contracts\RegisterResponse;
use App\Actions\Subscriber\CreateNewSubscriber;

class SubscriberController extends Controller
{

    public function store(Request $request, CreateNewSubscriber $subscribers): RegisterResponse
    {
        dd($request);
        event(new Subscribed($subscribers->create($request->all())));

        return app(RegisterResponse::class);
    }
}
