<?php

namespace App\Http\Controllers\Checkout;

use App\Http\Controllers\Controller;
use App\Models\FlightCost;
use App\Models\FlightDetails;
use App\Models\Passenger;
use App\Models\Reservation;
use App\Models\ReservationUtils;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PassengerController extends Controller
{
    /**
     * Display a listing of the resource.
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

        return Inertia::render('Booking/Passengers/CreatePassenger', [
            'title' => 'Set passengers',
            'progressId' => '3',
            'cost' => strval($reservation->flightCost->cost),
            'targetOfPlaneChoosing' => $reservationUtils->target_of_plane_choosing,
            'passengers' => $passengers
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function createFlightCost(Request $request): RedirectResponse
    {
        if($this->flightCostIsAlreadyExist($request)){
            $this->updateFlightCost($request);
        } else {
            $reservation = Reservation::find($request->session()->getId());
            $reservation->flightCost()->create([
                'cost' => $request->get('cost')
            ]);

            $this->updateReservationUtils($request, $reservation->id);
        }

        $this->updateFlightDetails($request);

        return redirect()->route('create-passenger');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return void
     */
    public function storePassenger(Request $request): void
    {
        foreach ($request->get('passengers') as $passenger) {
            $_passenger = new Passenger();

            $_passenger->first_name = $passenger['first_name'];
            $_passenger->last_name = $passenger['last_name'];

            $_passenger->save();

            $reservation = Reservation::find($request->session()->getId());
            $_passenger->reservations()->attach($reservation);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @return void
     */
    public function updateFlightCost(Request $request): void
    {
        $reservation = Reservation::find($request->session()->getId());
        $reservation->flightCost()->update([
            'cost' => $request->get('cost')
        ]);

        $this->updateReservationUtils($request, $reservation->id);
    }

    /**
     * Update the specified resource in storage.
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Update the specified resource in reservation utils.
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
     * Checking the reservation is exists.
     *
     * @param Request $request
     * @return bool
     */
    private function flightCostIsAlreadyExist(Request $request): bool
    {
        return !is_null(FlightCost::where('reservation_id', $request->session()->getId())->first());
    }
}
