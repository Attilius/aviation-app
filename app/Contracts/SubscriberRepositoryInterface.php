<?php

namespace App\Contracts;

interface SubscriberRepositoryInterface extends CrudInterface
{
    /**
     * Check if subscriber existing.
     *
     * @param string $email
     * @return bool
     */
    public function isSubscriberExist(string $email): bool;
}
