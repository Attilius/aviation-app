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
     * @param $id
     * @param array $data
     * @return Model
     * @throws ValidationException
     */
    public function update($id, array $data = []): Model
    {
       /* Validator::make($data, [
            'email' => ['required', 'string', 'email', 'max:255', 'unique:subscribers']
        ])->validate(); */

       /* $subsciber = $this->findById($id);

        return $subsciber::edit([
            'email' => $data['email'],
            'role' => $data['role'] ?? 'guest'
        ]); */

        if (count(Subscriber::where('email', $user->email)->get()) > 0){
            $subscriber = Subscriber::where('email', $user->email)->get();

            Subscriber::where('id', $subscriber[0]['id'])->update([
                'email' => $input['email'],
                'role' => 'user'
            ]);
        }
    }

    public function destroy($id): void
    {
        // TODO: Implement destroy() method.
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
}
