<?php

namespace App\Services\Flight;

use App\Models\Airplanes;
use App\Services\AbstractServiceHandler;
use App\Services\Reservation\ReservationService;
use App\Services\Travel\TravelService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class AirplaneServiceHandler extends  AbstractServiceHandler
{

    public function handle(Request $request, Model $model, Response $props): void
    {
        $travelService = new TravelService();
        $reservationService = new ReservationService();

        if ($request->query->get('private') === 'true')
        {
            $airplanes = Airplanes::findByDistanceAndPassengers(
                $props->getProps()['distanceInKilometer'], $props->getProps()['passengers']
            );
            $airplanesWithTripDuration = $travelService->addTripDuration(
                $props->getProps()['distanceInKilometer'], $airplanes
            );

            $props->addProps('title', 'Jet Rent');
            $props->addProps('airplanes', $airplanesWithTripDuration);
            $props->addProps('isPrivate', true);
            $reservationService->createReservation(
                $model['id'], $request->query->get('pax'), $request->query->get('travel_type')
            );

        } else {
            $this->processNext($request, $model, $props);
        }
    }
}
