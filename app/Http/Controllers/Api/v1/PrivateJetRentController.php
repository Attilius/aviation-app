<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Airplanes;
use App\Models\FlightCost;
use App\Models\FlightDetails;
use App\Models\Passenger;
use App\Models\Reservation;
use App\Models\ReservationUtils;
//use App\Utils\DistanceCalculator;
use App\Utils\TripDurationCalculator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Airport;
use App\Utils\KeyGenerator;
use App\Utils\TravelDistanceAndDurationHandler;

class PrivateJetRentController extends Controller
{
    private TravelDistanceAndDurationHandler $travelHandler;

    public function __construct( TravelDistanceAndDurationHandler $travelHandler )
    {
        $this->travelHandler = $travelHandler;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        $this->storeFlightDetails($request);

        $airports = $this->travelHandler->getAirports($request);
        $distanceInKilometer = $this->travelHandler->calculateTravelDistance($airports);
        $passengers = array_sum(explode('-',$request->query->get('pax')));
        $airplanes = Airplanes::findByDistanceAndPassengers($distanceInKilometer, $passengers);
        $airplanesWithTripDuration = $this->travelHandler->addTripDuration($distanceInKilometer, $airplanes);
        $this->updateReservationUtils($request);
        $this->updatePaymentStatus($request);
        return Inertia::render('API/PrivateJetRent', [
            'title' => 'Jet Rent',
            'progressId' => '2',
            'departure' => $airports[0]->municipality,
            'arriving' => $airports[1]->municipality,
            'passengers' => strval($passengers),
            'airplanes' => $airplanesWithTripDuration,
            'isPrivate' => boolval($request->query->get('private'))
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return void
     */
    public function storeFlightDetails(Request $request): void
    {
        if($this->isReservationAlreadyExist($request)){
            $this->updateFlightDetails($request);
        } else {
            $airports = $this->travelHandler->getAirports($request);

            $flight = FlightDetails::create([
                'flight_number' => '*',
                'airline' => 'Lorem Airlines',
                'airplane_type' => '*',
                'source_airport' => $airports[0]->municipality . ',' . $airports[0]->name,
                'destination_airport' => $airports[1]->municipality . ',' . $airports[1]->name,
                'departure_date' => $request->query->get('departure_date'),
                'return_date' => $request->query->get('return_date') ? $request->query->get('return_date') : null
            ]);

            $this->createReservation($request, $flight->id);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return RedirectResponse
     */
    public function destroy(): RedirectResponse
    {
        $reservationId = ReservationUtils::all()->get('reservation_id');
        $flightDetailsId = Reservation::find($reservationId)->get('flight_details_id');
        $passengerId = Reservation::find($reservationId)->get('passenger_id');
        $flightCostId = FlightCost::all()->get('reservation_id');

        ReservationUtils::find()->delete();
        Reservation::find($reservationId)->delete();
        FlightDetails::find($flightDetailsId)->delete();
        if($passengerId){
            Passenger::find()->delete();
        }
        if($flightCostId){
            FlightCost::find()->delete();
        }

        return redirect('private-jet-rent');
    }

    /**
     * Update the specified resource in reservation utils.
     *
     * @param Request $request
     * @return void
     */
    private function updateReservationUtils(Request $request): void
    {
        $reservation = Reservation::find($request->session()->getId());
        $reservation->reservationUtils()->update([
            'pax' => $request->query->get('pax'),
            'target_of_plane_choosing' => '*'
        ]);
    }

    /**
     * Update the specified resource in reservation utils.
     *
     * @param Request $request
     * @return void
     */
    private function updatePaymentStatus(Request $request): void
    {
        $reservation = Reservation::find($request->session()->getId());
        $reservation->paymentStatus()->update([
            'payment_due_date' => Date::now(),
            'payment_amount' => 0,
        ]);
    }

    /**
     * Update the specified resource in reservation utils.
     *
     * @param Request $request
     * @return void
     */
    private function updateFlightDetails(Request $request): void
    {
        $reservation = Reservation::find($request->session()->getId());
        $airports = $this->travelHandler->getAirports($request);

        FlightDetails::where('id', $reservation->flight_details_id)->update([
            'flight_number' => '*',
            'airline' => 'Lorem Airlines',
            'airplane_type' => '*',
            'source_airport' => $airports[0]->municipality . ',' . $airports[0]->name,
            'destination_airport' => $airports[1]->municipality . ',' . $airports[1]->name,
            'departure_date' => $request->query->get('departure_date'),
            'return_date' => $request->query->get('return_date') ? $request->query->get('return_date') : null
        ]);

        $this->updateReservation($reservation->flight_details_id);
    }

    /**
     * Creating a new reservation resource.
     *
     * @param Request $request
     * @param int $id
     * @return void
     */
    private function createReservation(Request $request, int $id): void
    {
        $keyGenerator = new KeyGenerator();

        $flight = FlightDetails::find($id);
        $reservation = $flight->reservations()->create([
            'id' => $request->session()->getId(),
            'reservation_number' => $id . '-' . $keyGenerator->generate(6, 'mix'),
            'date_of_reservation' => Date::now()
        ]);

        $this->createReservationUtils($reservation->id);
        $this->createPaymentStatus($reservation->id);
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
     * Show the form for creating a new resource.
     *
     * @param string $id
     * @return void
     */
    private function createReservationUtils(string $id): void
    {
        $reservation = Reservation::find($id);
        $reservation->reservationUtils()->create([
            'pax' => '*',
            'target_of_plane_choosing' => '*'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param string $id
     * @return void
     */
    private function createPaymentStatus(string $id): void
    {
        $reservation = Reservation::find($id);
        $reservation->paymentStatus()->create([
            'payment_due_date' => Date::now(),
            'payment_amount' => 0
        ]);
    }

    /**
     * Checking the reservation is exists.
     *
     * @param Request $request
     * @return bool
     */
    private function isReservationAlreadyExist(Request $request): bool
    {
        return !is_null(Reservation::find($request->session()->getId()));
    }
}
