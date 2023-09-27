<?php

namespace App\Http\Controllers\Pages\TravelGuide;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use App\Repository\FavoritePlacesRepository;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class FavoritePlacesController extends Controller
{
    /**
     * Get a specific user all favorite place then show it.
     *
     * @return Response
     */
    public function index(): Response
    {
        $repository = new FavoritePlacesRepository();
        $userID = auth()->user()->getAuthIdentifier();
        $result = $repository->findAllFavoritePlaceByUserId($userID);

        return Inertia::render('Personal/FavoritePlaces', [
            'favoritePlaces' => $result,
            'title' => 'Favorite places'
        ]);
    }

    /**
     * Store a new favorite place item.
     *
     * @param Request $request
     * @return void
     */
    public function addFavoritePlace(Request $request): void
    {
        $favoritePlaces = $request->get('add_favorite_places');
        $repository = new FavoritePlacesRepository();
        $data = [];

        for($i = 0; $i < count($favoritePlaces); $i++){
            $serviceId = explode('-', $favoritePlaces[$i])[0];
            $cityName = explode('-', $favoritePlaces[$i])[1];
            $data['serviceId'] = $serviceId;
            $data['cityName'] = $cityName;
            $destination = Destination::findByCityName($cityName);

            foreach($destination->attractions as $attraction){
                if($attraction->id === $serviceId){
                    $setteredData = $this->setServiceData($data, $attraction);
                    $repository->storeFavoritePlace($setteredData);
                }
            }

            foreach($destination->hotels as $hotel){
                if($hotel->id === $serviceId){
                    $setteredData = $this->setServiceData($data, $hotel);
                    $repository->storeFavoritePlace($setteredData);
                }
            }

            foreach($destination->restaurants as $restaurant){
                if($restaurant->id === $serviceId){
                    $setteredData = $this->setServiceData($data, $restaurant);
                    $repository->storeFavoritePlace($setteredData);
                }
            }
        }
    }

    /**
     * Remove favorite place item.
     *
     * @param Request $request
     * @return void
     */
    public function deleteFavoritePlace(Request $request): void
    {
        $favoritePlaces = $request->get('remove_favorite_places');
        $repository = new FavoritePlacesRepository();

        for($i = 0; $i < count($favoritePlaces); $i++){
            $repository->destroyFavoritePlace($favoritePlaces[$i]);
        }
    }

    /**
     * Set data object which will have been pass to the Favorite Place repository.
     *
     * @param array $data
     * @param $serviceItem
     * @return array
     */
    private function setServiceData(array $data, $serviceItem): array
    {
        $data['serviceName'] = $serviceItem->name;
        $data['serviceType'] = $serviceItem->label;
        $data['serviceImage'] = $serviceItem->image;
        $data['serviceAddress'] = property_exists($serviceItem, 'address') ? $serviceItem->address : null;
        $data['servicePhone'] = property_exists($serviceItem, 'tel') ? $serviceItem->tel : null;

        return $data;
    }
}
