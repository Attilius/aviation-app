<?php

namespace App\Contracts;

use App\Models\Subscriber;

interface SubscriberRepositoryInterface
{
    /**
     * List all subscriber
     *
     * @return mixed
     */
    public function findAll();

    /**
     * Get only subscriber with id
     *
     * @param $id
     * @return mixed
     */
    public function findByOne($id);

    /**
     * @param array $data
     * @return Subscriber
     */
    public function store(array $data): Subscriber;

    /**
     * @param $id
     * @param array $data
     * @return Subscriber
     */
    public function update($id, array $data = []): Subscriber;

    /**
     * Remove subscriber
     *
     * @param $id
     * @return void
     */
    public function destroy($id): void;
}
