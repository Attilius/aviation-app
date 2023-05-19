<?php

namespace App\Contracts;

use App\Models\Subscriber;

interface SubscriberProviderInterface
{
    /**
     * Retrieve a subscriber by their unique identifier.
     *
     * @param int $identifier
     * @return Subscriber|null
     */
    public function retrieveById(int $identifier): Subscriber|null;

    /**
     * Retrieve a user by the given credentials.
     *
     * @param array $credentials
     * @return Subscriber|null
     */
    public function retrieveByCredentials(array $credentials): Subscriber|null;
}
