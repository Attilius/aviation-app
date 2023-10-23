<?php

namespace App\Services\Flight;

use App\Models\Reservation;
use App\Models\ReservationUtils;
use App\Services\AbstractServiceHandler;
use App\Services\Reservation\ReservationService;
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
        $reservationService = new ReservationService();
        $reservationUtils = ReservationUtils::where('reservation_id',$reservationService->getReservationId());
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
            $flight['departure_iata'] = $request->query->get('direction') === 'departure'
                ? explode('>', (explode('-',$request->query->get('connections'))[0]))[0]
                : explode('>', (explode('-',$request->query->get('connections'))[0]))[1];
            $flight['arriving_iata'] = $request->query->get('direction') === 'departure'
                ? explode('>', (explode('-',$request->query->get('connections'))[0]))[1]
                : explode('>', (explode('-',$request->query->get('connections'))[0]))[0];
            $flight['departure_airport'] = $request->query->get('direction') === 'departure'
                ? $airports[0]->name : $airports[1]->name;
            $flight['arriving_airport'] = $request->query->get('direction') === 'departure'
                ? $airports[1]->name : $airports[0]->name;
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

        $props->addProps('request', $request);
        $props->addProps('airplanes', $sortedAvailableFlights);
        $props->addProps('cost', strval($request->query->get('cost')) ?? '0');
        $props->removeItem('airports');

        if ($request->query->get('direction') === 'departure')
        {
            $reservationService->createReservation(
                $model['id'], $request->query->get('pax'), $request->query->get('travel_type')
            );
        } else {
            $reservation = Reservation::find($reservationService->getReservationId());
            $reservationCosts = $reservation->reservationCosts()->create([
                'item_name' => 'Departure fligt cost',
                'price' => $request->query->get('cost')
            ]);

            Reservation::where('id', $reservationService->getReservationId())->update([
                'reservation_costs_id' => $reservationCosts->id
            ]);

            $reservationUtils->update([
                'airplane_type' => $request->query->get('awayAirplaneType'),
                'flight_numbers' => $request->query->get('awayFlightNumber')
            ]);
        }
    }
}
