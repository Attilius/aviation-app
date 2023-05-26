<?php

namespace App\Repository;

use App\Contracts\SubscriberRepositoryInterface;
use App\Models\Subscriber;
use App\Models\User;
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
            'email' => ['required', 'string', 'email', 'max:255']
        ])->validate();

        return Subscriber::create([
            'email' => $data['email'],
            'role' => $this->isRegisteredUser($data['email']) ? 'user' : 'guest'
        ]);
    }

    /**
     * @param $id
     * @param array $data
     * @return Subscriber
     */
    public function update($id, array $data = []): Subscriber
    {
        //Todo return Subscriber::update([]);
    }

    public function destroy($id): void
    {
        // TODO: Implement destroy() method.
    }

    /**
     * Find subscribed email in user table
     *
     * @param string $email
     * @return bool
     */
    private function isRegisteredUser(string $email): bool
    {
        $user = User::where('email', $email)->get();

        return count($user) > 0;
    }
}
