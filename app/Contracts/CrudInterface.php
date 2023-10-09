<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface CrudInterface
{
    /**
     * Get all element of specify model.
     *
     * @return Collection
     */
    public function findAll(): Collection;

    /**
     * Get one element of specify model by id.
     *
     * @param int $id
     * @return Model
     */
    public function findById(int $id): Model;

    /**
     * Create a new model element.
     *
     * @param array $data
     * @return Model
     */
    public function store(array $data): Model;

    /**
     * Update one specify element of model.
     *
     * @param int $id
     * @param array $data
     * @return Model
     */
    public function update(int $id, array $data): Model;

    /**
     * Remove one specify element of model.
     *
     * @param int $id
     * @return void
     */
    public function destroy(int $id): void;
}
