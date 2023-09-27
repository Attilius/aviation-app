<?php

namespace App\Mail\Subscribers;

use App\Contracts\SubsciberAuthenticableInterface;

class GenericSubscriber implements SubsciberAuthenticableInterface
{
    /**
     * All of user's attributes.
     *
     * @var array
     */
    protected array $attributes;

    /**
     * Create a new generic User object.
     *
     * @param array $attributes
     * @return void
     */
    public function __construct(array $attributes)
    {
        $this->attributes = $attributes;
    }

    /**
     * Get the name of the unique identifier for the user.
     *
     * @return string
     */
    public function getAuthIdentifierName(): string
    {
        return 'id';
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthEmail(): string
    {
        return $this->attributes['email'];
    }
}
