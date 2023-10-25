<?php

namespace App\Services\Reservation;

use App\Models\Reservation;
use App\Models\ReservationUtils;
use Illuminate\Http\Request;

class ReservationUtilsService
{
    /**
     * Show the form for creating a new resource.
     *
     * @param string $id
     * @param string $pax
     * @param string $travelType
     * @return void
     */
    public function createReservationUtils(string $id, string $pax, string $travelType = '*'): void
    {
        $reservation = Reservation::find($id);
        $reservation->reservationUtils()->create([
            'pax' => $pax,
            'target_of_plane_choosing' => '*',
            'travel_type' => $travelType
        ]);
    }

    /**
     * Update the reservation utils resource.
     *
     * @param string $id
     * @param Request $request
     * @return void
     */
    public function updateReservationUtils(Request $request, string $id): void
    {
        ReservationUtils::where('reservation_id', $id)->update([
            'target_of_plane_choosing' => $request->get('targetOfPlaneChoosing'),
            'return_flight_numbers' => $request->get('returnFlightNumber'),
            'return_airplane_type' => $request->get('returnAirplaneType')
        ]);
    }
}
