<?php

namespace App\Services\Flight;

use App\Models\FlightDetails as Flight_Details;
use App\Models\Reservation;
use App\Services\Reservation\ReservationService;
use Illuminate\Http\Request;

class FlightDetails
{
    /**
     * Update the flight details resource in storage.
     *
     * @param  Request  $request
     * @return void
     */
    public function updateFlightDetails(Request $request): void
    {
        $reservationService = new ReservationService();

        $reservation = Reservation::find($reservationService->getReservationId());

        Flight_Details::where('id', $reservation->flight_details_id)->update([
            'flight_number' => $request->get('returnFlightNumber'),
            'airplane_type' => $request->get('returnAirplaneType')
        ]);
    }
}
