<?php

namespace App\Repository;

use App\Contracts\FavoritePlacesRepositoryInterface;
use App\Models\FavoritePlace;
use Illuminate\Support\Collection;

class FavoritePlacesRepository implements FavoritePlacesRepositoryInterface
{
    /**
     * Get a specific user all favorite place and return with a collection.
     *
     * @param int $id
     * @return Collection
     */
    public function findAllFavoritePlaceByUserId(int $id): Collection
    {
        return FavoritePlace::all()->where('user_id', $id);
    }

    /**
     * Store a new favorite place item(s).
     *
     * @param array $data
     * @return void
     */
    public function storeFavoritePlace(array $data): void
    {
        $user = auth()->user();

        $user->favoritePlaces()->create([
            'city_name' => $data['cityName'],
            'service_id' => $data['serviceId'],
            'service_name' => $data['serviceName'],
            'service_type' => $data['serviceType'],
            'service_image' => $data['serviceImage'],
            'service_address' => $data['serviceAddress'],
            'service_phone' => $data['servicePhone']
        ]);
    }

    /**
     * Remove favorite place item(s).
     *
     * @param string $service_id
     * @return void
     */
    public function destroyFavoritePlace(string $service_id): void
    {
        $user = auth()->user();
        $favoritePlace = $user->favoritePlaces()->where('service_id', $service_id)->get()->first();
        $favoritePlace->delete();
    }
}
