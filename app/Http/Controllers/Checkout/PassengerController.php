<?php

namespace App\Http\Controllers\Checkout;

use App\Http\Controllers\Controller;
use App\Models\FlightDetails;
use App\Models\Passenger;
use App\Models\Reservation;
use App\Models\ReservationContact;
use App\Models\ReservationCost;
use App\Models\ReservationUtils;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use JetBrains\PhpStorm\NoReturn;
use Illuminate\Support\Collection;

class PassengerController extends Controller
{
    /**
     * Display create passenger resource page.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        $passengers = [];
        $reservation = Reservation::find($request->session()->getId());
        $reservationUtils = ReservationUtils::where('reservation_id', $reservation->id)->first();
        $pax = explode('-', $reservationUtils->pax);

        for($i = 0; $i < count($pax); $i++) {
            switch($i) {
                case 0:
                {
                    if ($pax[0] !== '0') {
                        for ($j = 0; $j < intval($pax[0]); $j++) {
                            $passengers[] = [
                                'id' => count($passengers) + 1,
                                'type' => 'Adult'
                            ];
                        }
                    }
                    break;
                }
                case 1:
                {
                    if ($pax[1] !== '0') {
                        for ($j = 0; $j < intval($pax[1]); $j++) {
                            $passengers[] = [
                                'id' => count($passengers) + 1,
                                'type' => 'Child'
                            ];
                        }
                    }
                    break;
                }
                case 2:
                {
                    if ($pax[2] !== '0') {
                        for ($j = 0; $j < intval($pax[2]); $j++) {
                            $passengers[] = [
                                'id' => count($passengers) + 1,
                                'type' => 'Infant'
                            ];
                        }
                    }
                    break;
                }
                case 3:
                {
                    if ($pax[3] !== '0') {
                        for ($j = 0; $j < intval($pax[3]); $j++) {
                            $passengers[] = [
                                'id' => count($passengers) + 1,
                                'type' => 'Senior'
                            ];
                        }
                    }
                    break;
                }
                case 4:
                {
                    if ($pax[4] !== '0') {
                        for ($j = 0; $j < intval($pax[4]); $j++) {
                            $passengers[] = [
                                'id' => count($passengers) + 1,
                                'type' => 'Youth'
                            ];
                        }
                    }
                    break;
                }
                default:{}
            }
        }
        return Inertia::render('Booking/CreatePassenger', [
            'title' => 'Set passengers',
            'progressId' => '3',
            'cost' => strval($reservation->reservationCosts[0]->price),
            'targetOfPlaneChoosing' => $reservationUtils->target_of_plane_choosing,
            'passengers' => $passengers
        ]);
    }

    /**
     * Creating a new reservation resource.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function createReservationCost(Request $request): RedirectResponse
    {
        /*$reservation = Reservation::find($request->session()->getId());
        $reservation->reservationCosts()->create([
            'item_name' => 'flight cost',
            'price' => $request->get('cost')
        ]);*/
        if($this->isReservationCostAlreadyExist($request)){
            $this->updateReservationCost($request);
            $this->updatePaymentStatus($request);
        } else {
            $reservation = Reservation::find($request->session()->getId());
            $reservationCosts = $reservation->reservationCosts()->create([
                'item_name' => 'Flight cost',
                'price' => $request->get('cost')
            ]);

            Reservation::where('id', $request->session()->getId())->update([
                'reservation_costs_id' => $reservationCosts->id
            ]);

            $this->updateReservationUtils($request, $reservation->id);
            $this->updatePaymentStatus($request);
        }

        $this->updateFlightDetails($request);

        return redirect()->route('create-passenger');
    }

    /**
     * Store a newly created passenger resource in storage.
     *
     * @param Request $request
     * @return void
     */
    public function storePassenger(Request $request): void
    {
        $reservation = Reservation::find($request->session()->getId());
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
     * Store a newly created reservation contact resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function storeReservationContact(Request $request): RedirectResponse
    {
        $reservationContact = ReservationContact::create([
            'phone_number' => $request->get('country_code') . $request->get('phone_number'),
            'email_address' => $request->get('email_address')
        ]);

        Reservation::where('id', $request->session()->getId())->update([
            'reservation_contact_id' => $reservationContact->id
        ]);

        return redirect(route('create-ancillaries'));
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
        $reservation = Reservation::find($request->session()->getId());

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
     * Update the flight cost resource in storage.
     *
     * @param  Request  $request
     * @return void
     */
    public function updateReservationCost(Request $request): void
    {
        $reservation = Reservation::find($request->session()->getId());
        $reservation->reservationCosts()->where('item_name', 'Flight cost')->update([
            'price' => $request->get('cost')
        ]);

        $this->updateReservationUtils($request, $reservation->id);
    }

    /**
     * Update the flight details resource in storage.
     *
     * @param  Request  $request
     * @return void
     */
    public function updateFlightDetails(Request $request): void
    {
        $reservation = Reservation::find($request->session()->getId());

        FlightDetails::where('id', $reservation->flight_details_id)->update([
            'flight_number' => $request->get('flightNumber'),
            'airplane_type' => $request->get('airplaneType')
        ]);
    }

    /**
     * Update the specified resource in payment status.
     *
     * @param Request $request
     * @return void
     */
    private function updatePaymentStatus(Request $request): void
    {
        $reservation = Reservation::find($request->session()->getId());
        $reservation->paymentStatus()->update([
            'payment_amount' => $request->get('cost')
        ]);
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
     * Update the reservation utils resource.
     *
     * @param string $id
     * @param Request $request
     * @return void
     */
    private function updateReservationUtils(Request $request, string $id): void
    {
        ReservationUtils::where('reservation_id', $id)->update([
            'target_of_plane_choosing' => $request->get('targetOfPlaneChoosing')
        ]);
    }

    /**
     * Checking the reservation cost is exists.
     *
     * @param Request $request
     * @return bool
     */
    private function isReservationCostAlreadyExist(Request $request): bool
    {
        return !is_null(ReservationCost::where('reservation_id', $request->session()->getId())->first());
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
