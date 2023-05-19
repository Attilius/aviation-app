<?php

namespace App\Repository;

use App\Contracts\SubscriberRepositoryInterface;
use App\Models\Subscriber;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class SubscriberRepository implements SubscriberRepositoryInterface
{

    public function findAll()
    {
        // TODO: Implement findAll() method.
    }

    public function findByOne($id)
    {
        // TODO: Implement findByOne() method.
    }

    /**
     * @param array $data
     * @return Subscriber
     * @throws ValidationException
     */
    public function store(array $data): Subscriber
    {
        Validator::make($data, [
            'email' => ['required', 'string', 'email', 'max:255', 'unique:subscribers']
        ])->validate();

        return Subscriber::create([
            'email' => $data['email']
        ]);
    }

    /**
     * @param $id
     * @param array $data
     * @return Subscriber
     */
    public function update($id, array $data = []): Subscriber
    {
        return Subscriber::update([]);
    }

    public function destroy($id): void
    {
        // TODO: Implement destroy() method.
    }
}
