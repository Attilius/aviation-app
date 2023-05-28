<?php

namespace App\Repository;

use App\Contracts\SubscriberRepositoryInterface;
use App\Models\Subscriber;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class SubscriberRepository implements SubscriberRepositoryInterface
{

    /**
     * Get all subscriber.
     *
     * @return Collection
     */
    public function findAll(): Collection
    {
        return Subscriber::all();
    }

    /**
     * Get only subscriber with id.
     *
     * @param $id
     * @return Model
     */
    public function findById($id): Model
    {
        return Subscriber::where('id', $id)->get();
    }

    /**
     * Store subscriber in subscribers table.
     *
     * @param array $data
     * @return Model
     * @throws ValidationException
     */
    public function store(array $data): Model
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
     * Update subscriber role and|or email.
     *
     * @param array $data
     * @return void
     * @throws ValidationException
     */
    public function update(array $data = ['new_email' => null]): void
    {
        if (count(Subscriber::where('email', $data['old_email'])->get()) > 0){
            $subscriber = Subscriber::where('email', $data['old_email'])->get();

            Subscriber::where('id', $subscriber[0]['id'])->update([
                'email' => $data['new_email'] ?? $subscriber[0]['email'],
                'role' => $data['role'] ?? 'user'
            ]);
        }
    }

    /**
     * Remove subscriber from subscribers table.
     *
     * @param $id
     * @param string $email
     * @return void
     */
    public function destroy($id, string $email): void
    {
        if ($id == null) {
            $id = Subscriber::where('email', $email)->get()[0]['id'];
        }

        Subscriber::where('id', $id)->delete();
    }

    /**
     * Find subscribed email in users table
     *
     * @param string $email
     * @return bool
     */
    private function isRegisteredUser(string $email): bool
    {
        $user = User::where('email', $email)->get();

        return count($user) > 0;
    }

    /**
     * Check if subscriber existing.
     *
     * @param string $email
     * @return bool
     */
    public function isSubscriberExist(string $email): bool
    {
        $subscriber = Subscriber::where('email', $email)->get();

        return count($subscriber) > 1;
    }
}
