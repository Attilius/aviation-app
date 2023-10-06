<?php

namespace App\Http\Controllers\Pages\TravelGuide;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use App\Repository\FavoritePlacesRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;
use Inertia\Response;

class DestinationController extends Controller
{
    /**
     * Render destination page.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        $user = Auth::user();
        $repository = new FavoritePlacesRepository();

        $favoritePlaces = $repository->findAllFavoritePlaceByUserId($user->id);

        $destination = Destination::findByCityName($request->get('city'));
        $response = Http::get("https://timeapi.io/api/Time/current/zone?timeZone=$destination->area/$destination->location");
        $destination->currentTime = strval($response->json()['time']);

        return Inertia::render('TravelGuide/Destination', [
            'destination' => $destination,
            'title' => $destination->city->name,
            'favoritePlaces' => $favoritePlaces
        ]);
    }

    /**
     * Render destination service page.
     *
     * @param Request $request
     * @return Response
     */
    public function showService(Request $request): Response
    {
        $addressesPageContent = $request->get('addressesPageContent');
        $addressesPageContent['cityName'] = str_replace('-', ' ', $request->get('cityName'));

        return Inertia::render('TravelGuide/Service', [
            'addressesPageContent' => $addressesPageContent
        ]);
    }
}
