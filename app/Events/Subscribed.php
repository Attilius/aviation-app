<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;

class Subscribed
{
    use SerializesModels;

    public $subscriber;

    /**
     * Create a new event instance.
     *
     * @param $subscriber
     * @return void
     */
    public function __construct($subscriber)
    {
        $this->subscriber = $subscriber;
    }
}
