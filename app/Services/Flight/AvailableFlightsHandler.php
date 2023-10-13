<?php

namespace App\Services\Flight;

use App\Services\AbstractServiceHandler;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Services\Travel\TravelService;
use Exception;

class AvailableFlightsHandler extends AbstractServiceHandler
{
    /**
     * Setting and queuing of available flights according to departure time.
     *
     * @param Request $request
     * @param Model $model
     * @param Response $props
     * @return void
     * @throws Exception
     */
    public function handle(Request $request, Model $model, Response $props): void
    {
        $travelService = new TravelService();
        $airports = $props->getProps()['airports'];
        $availableFlights = $props->getProps()['availableFlights'];
        $sortedAvailableFlights = [];
        $availableFlightsIds = [];

        foreach ($availableFlights as $flight)
        {
            $flight['price'] = rand(100,150);
            $flight['trip_duration'] = isset($travelService->calculateTravelTimeInterval($flight)->h)
                ? $travelService->calculateTravelTimeInterval($flight)->h.'h'.$travelService->calculateTravelTimeInterval($flight)->i
                : $travelService->calculateTravelTimeInterval($flight);
            $flight['departure_iata'] = explode('>', (explode('-',$request->query->get('connections'))[0]))[0];
            $flight['arriving_iata'] = explode('>', (explode('-',$request->query->get('connections'))[0]))[1];
            $flight['departure_airport'] = $airports[0]->name;
            $flight['arriving_airport'] = $airports[1]->name;
            $flight['cabin_class'] = $request->query->get('cabin_class');
        }

        for ($i = 0; $i < count($availableFlights->keys()); $i++)
        {
            $index = $availableFlights->keys()[$i];
            $availableFlightsIds[] = $availableFlights[$index]->id;
        }

        asort($availableFlightsIds);

        foreach ($availableFlightsIds as $key => $value)
        {
            foreach ($availableFlights as $flight)
            {
                if ($flight['id'] === $value)
                {
                    $sortedAvailableFlights[] = $flight;
                }
            }
        }

        $props->addProps('airplanes', $sortedAvailableFlights);
        $props->removeItem('airports');
    }
}
