<?php

namespace App\Services\Flight;

use App\Models\Airport;
use App\Services\AbstractServiceHandler;
use App\Services\Travel\TravelService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class AirportServiceHandler extends AbstractServiceHandler
{
    /**
     * Find and store airports data
     *
     * @param Request $request
     * @param Model $model
     * @param Response $props
     * @return void
     */
    public function handle(Request $request, Model $model, Response $props): void
    {
        $airport = new Airport();
        $travelService = new TravelService();

        if($request->query->get('travel_type') === 'ROUNDTRIP')
        {
            $departure_iata = explode('-', explode('>', $request->query->get('connections'))[0])[0];
            $arriving_iata = explode('-', explode('>', $request->query->get('connections'))[1])[0];
        } else {
            $departure_iata = explode('>', $request->query->get('connections'))[0];
            $arriving_iata = explode('>', $request->query->get('connections'))[1];
        }

        $airports = $airport->FindByIata([$departure_iata, $arriving_iata]);

        $model['source_airport'] = $request->query->get('direction') === 'departure'
            ? $airports[0]->municipality . ',' . $airports[0]->name
            : $airports[1]->municipality . ',' . $airports[1]->name;
        $model['destination_airport'] = $request->query->get('direction') === 'departure'
            ? $airports[1]->municipality . ',' . $airports[1]->name
            : $airports[0]->municipality . ',' . $airports[0]->name;
        $model->save();

        $props->addProps('progressId', $request->query->get('direction') === 'departure' ? '2' : '3');
        $props->addProps('departure', $request->query->get('direction') === 'departure'
            ? $airports[0]->municipality : $airports[1]->municipality);
        $props->addProps('arriving', $request->query->get('direction') === 'departure'
            ? $airports[1]->municipality : $airports[0]->municipality);
        $props->addProps('distanceInKilometer', $travelService->calculateTravelDistance($airports));
        $props->addProps('airports', $airports);

        foreach ($props->getKeys() as $keyItem)
        {
            if (!array_key_exists($keyItem, $props->getProps()))
            {
                $this->processNext($request, $model, $props);
            }
        }
    }
}
