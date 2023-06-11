<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface CrudInterface
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
     * Store subscriber in subscribers table.
     *
     * @param array $data
     * @return Model
     */
    public function store(array $data): Model;

    /**
     * Update subscriber role and|or email.
     *
     * @param array $data
     * @return void
     */
    public function update(array $data = []): void;

    /**
     * Remove subscriber.
     *
     * @param $id
     * @param string $email
     * @return void
     */
    public function destroy($id, string $email): void;
}
