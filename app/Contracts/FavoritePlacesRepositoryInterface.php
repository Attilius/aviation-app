<?php

namespace App\Contracts;

use Illuminate\Support\Collection;

interface FavoritePlacesRepositoryInterface
{
    /**
     * Get a specific user all favorite place and return with a collection.
     *
     * @param int $id
     * @return Collection
     */
    public function findAllFavoritePlaceByUserId(int $id): Collection;

    /**
     * Store a new favorite place item(s).
     *
     * @param array $data
     * @return void
     */
    public function storeFavoritePlace(array $data): void;

    /**
     * Remove favorite place item(s).
     *
     * @param string $service_id
     * @return void
     */
    public function destroyFavoritePlace(string $service_id): void;
}
