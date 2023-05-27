<?php

namespace App\Contracts;

//use App\Models\Subscriber;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface SubscriberRepositoryInterface
{
    /**
     * Get all subscriber.
     *
     * @return Collection
     */
    public function findAll(): Collection;

    /**
     * Get only subscriber with id.
     *
     * @param $id
     * @return Model
     */
    public function findById($id): Model;

    /**
     * @param array $data
     * @return Model
     */
    public function store(array $data): Model;

    /**
     * @param $id
     * @param array $data
     * @return Model
     */
    public function update($id, array $data = []): Model;

    /**
     * Remove subscriber
     *
     * @param $id
     * @return void
     */
    public function destroy($id): void;
}
