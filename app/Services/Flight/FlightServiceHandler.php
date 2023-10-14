<?php

namespace App\Services\Flight;

use App\Repository\FlightRepository;
use App\Services\AbstractServiceHandler;
use App\Services\Travel\TravelService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Exception;

class FlightServiceHandler extends AbstractServiceHandler
{
    /**
     * @throws Exception
     */
    public function handle(Request $request, Model $model, Response $props): void
    {
        $travelService = new TravelService();
        $flightRepository = new FlightRepository();
        $airports = $props->getProps()['airports'];

        $props->addProps('title', 'Choose a flight');

        $travelService->getTripDuration($props->getProps()['distanceInKilometer'], [
           'airports' => $airports,
           'request' => $request
        ]);

        if ($request->query->get('departure_date') === date('Y-m-d'))
        {
           $availableFlights = $flightRepository->findAll()
               ->where('direction','=','departure')
               ->where('departure_time', '>', date('H:i:s', strtotime('+2 hours')));
        } else {
            $availableFlights = $flightRepository->findAll()->where('direction', 'departure');
        }

        $props->addProps('title', 'Jet Rent');
        $props->addProps('isPrivate', false);
        $props->addProps('availableFlights', $availableFlights);

        $props->removeItem('distanceInKilometer');

        foreach ($props->getKeys() as $keyItem)
        {
            if (!array_key_exists($keyItem, $props->getProps()))
            {
                $this->processNext($request, $model, $props);
            }
        }
    }
}