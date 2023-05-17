<?php

namespace App\Actions\Subscriber;

use App\Models\Subscriber;
use Illuminate\Support\Facades\Validator;
use App\Contracts\CreatesNewSubscribers;
use Illuminate\Validation\ValidationException;

class CreateNewSubscriber implements CreatesNewSubscribers
{

    /**
     * Validate and create a new subscriber.
     *
     * @param array<string, string> $input
     * @throws ValidationException
     * @return Subscriber
     */
    public function create(array $input): Subscriber
    {
        Validator::make($input, [
            'email' => ['required', 'string', 'email', 'max:255', 'unique:subscribers']
        ])->validate();

        return Subscriber::create([
            'email' => $input['email']
        ]);
    }
}
