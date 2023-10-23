<?php

namespace App\Services\Reservation;

use App\Models\FlightDetails;
use App\Models\Reservation;
use App\Models\User;
use App\Services\Payment\PaymentService;
use App\Utils\KeyGenerator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;

class ReservationService
{
    /**
     * Creating a new reservation resource.
     *
     * @param int $id
     * @param string $pax
     * @param string $travelType
     * @return void
     */
    public function createReservation(int $id, string $pax, string $travelType): void
    {
        $authUser = Auth::user();
        $keyGenerator = new KeyGenerator();
        $user = User::find($authUser->getAuthIdentifier());
        $paymentService = new PaymentService();
        $reservationUtils = new ReservationUtilsService();

        $flightDeatils = FlightDetails::find($id);
        $reservation = $flightDeatils->reservations()->create([
            'id' => $keyGenerator->generate(40, 'mix'),
            'reservation_number' => $id . '-' . $keyGenerator->generate(6, 'mix'),
            'date_of_reservation' => Date::now()
        ]);

        $user->reservations()->attach($reservation->id);
        $reservationUtils->createReservationUtils($reservation->id, $pax, $travelType);
        $paymentService->createPaymentStatus($reservation->id);
    }

    /**
     * Creating a new reservation resource.
     *
     * @param int $id
     * @return void
     */
    private function updateReservation(int $id): void
    {
        $keyGenerator = new KeyGenerator();

        $flight = FlightDetails::find($id);
        $flight->reservations()->update([
            'reservation_number' => $id . '-' . $keyGenerator->generate(6, 'mix'),
            'date_of_reservation' => Date::now()
        ]);
    }

    /**
     * Getting currently reservation id.
     *
     * @return string
     */
    public function getReservationId(): string
    {
        $authUser = Auth::user();
        $user = User::find($authUser->getAuthIdentifier());

        return $user->reservations()->get()->last()['id'];
    }

    /**
     * Checking the reservation is exists.
     *
     * @param string $id
     * @return bool
     */
    public function isReservationAlreadyExist(string $id): bool
    {
        return !is_null(Reservation::find($id));
    }
}
