<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Model;

interface SubscriberProviderInterface
{
    /**
     * Retrieve a subscriber by their unique identifier.
     *
     * @param int $identifier
     * @return Model|null
     */
    public function retrieveById(int $identifier): Model|null;

    /**
     * Retrieve a user by the given credentials.
     *
     * @param array $credentials
     * @return Model|null
     */
    public function retrieveByCredentials(array $credentials): Model|null;
}
