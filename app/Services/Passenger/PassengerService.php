<?php

namespace App\Services\Passenger;

use App\Models\Passenger;
use App\Models\Reservation;
use App\Services\Reservation\ReservationService;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use JetBrains\PhpStorm\NoReturn;

class PassengerService
{
    /**
     * Store a newly created passenger resource in storage.
     *
     * @param Request $request
     * @return void
     */
    public function storePassenger(Request $request): void
    {
        $reservationService = new ReservationService();

        $reservation = Reservation::find($reservationService->getReservationId());
        $passengersId = $reservation->passengers->pluck('id');

        if(count($passengersId) < 1) {
            foreach ($request->get('passengers') as $passenger)
            {
                $_passenger = new Passenger();

                $_passenger->first_name = $passenger['first_name'];
                $_passenger->last_name = $passenger['last_name'];
                $_passenger->save();
                $_passenger->reservations()->attach($reservation);
            }
        } else {
            $this->updatePassenger($request, $passengersId);
        }
    }

    /**
     * Update the passenger resource in storage.
     *
     * @param Collection $passengersId
     * @param Request $request
     * @return void
     */
    #[NoReturn] public function updatePassenger(Request $request, Collection $passengersId): void
    {
        $reservationService = new ReservationService();

        $reservation = Reservation::find($reservationService->getReservationId());

        foreach ($passengersId as $id) {
            Passenger::find($id)->reservations()->detach($reservation);
        }

        foreach ($request->get('passengers') as $passenger)
        {
            $_passenger = new Passenger();

            $_passenger->first_name = $passenger['first_name'];
            $_passenger->last_name = $passenger['last_name'];
            $_passenger->save();
            $_passenger->reservations()->attach($reservation);
        }

        $this->isHaveReservation($passengersId);
    }

    /**
     * Remove the passenger resource from storage.
     *
     * @param int $id
     * @return void
     */
    public function destroyPassenger(int $id): void
    {
        Passenger::where('id', $id)->delete();
    }

    /**
     * When updating it checks whether the passenger also belongs to another reservation.
     * If not it passes it to the delete method.
     *
     * @param Collection $passengersId
     * @return void
     */
    #[NoReturn] private function isHaveReservation(Collection $passengersId): void
    {
        $reservations = Reservation::all();

        foreach($reservations as $reservation){
            $activePassengersId = $reservation->passengers->pluck('id');

            foreach ($activePassengersId as $activeId){
                foreach ($passengersId as $passengerId){
                    if($passengerId !== $activeId){
                        $this->destroyPassenger($passengerId);
                    }
                }
            }
        }
    }
}
