<?php

namespace App\Contracts;

use App\Models\Subscriber;

interface CreatesNewSubscribers
{
    /**
     * Validate and create a new subscriber.
     *
     * @param  array  $input
     * @return Subscriber
     */
    public function create(array $input): Subscriber;
}
