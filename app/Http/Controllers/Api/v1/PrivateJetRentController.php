<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Airplanes;
use App\Models\FlightCost;
use App\Models\FlightDetails;
use App\Models\Passenger;
use App\Models\Reservation;
use App\Models\ReservationUtils;
use App\Utils\DistanceCalculator;
use App\Utils\TripDurationCalculator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Airport;
use App\Utils\KeyGenerator;

class PrivateJetRentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        $this->storeFlightDetails($request);

        $airports = $this->getAirports($request);
        $distanceInKilometer = $this->calculateTravelDistance($airports);
        $passengers = array_sum(explode('-',$request->query->get('pax')));
        $airplanes = Airplanes::findByDistanceAndPassengers($distanceInKilometer, $passengers);
        $airplanesWithTripDuration = $this->addTripDuration($distanceInKilometer, $airplanes);
        $this->updateReservationUtils($request);

        return Inertia::render('API/PrivateJetRent', [
            'title' => 'Jet Rent',
            'progressId' => '2',
            'departure' => $airports[0]->municipality,
            'arriving' => $airports[1]->municipality,
            'passengers' => strval($passengers),
            'airplanes' => $airplanesWithTripDuration
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
            $airports = $this->getAirports($request);

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
    private function updateFlightDetails(Request $request): void
    {
        $reservation = Reservation::find($request->session()->getId());
        $airports = $this->getAirports($request);

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
        $flight = FlightDetails::find($id);
        $reservation = $flight->reservations()->create([
            'id' => $request->session()->getId(),
            'reservation_number' => $id . '-' . KeyGenerator::generate(5),
            'date_of_reservation' => Date::now()
        ]);

        $this->createReservationUtils($reservation->id);
    }

    /**
     * Creating a new reservation resource.
     *
     * @param int $id
     * @return void
     */
    private function updateReservation(int $id): void
    {
        $flight = FlightDetails::find($id);
        $flight->reservations()->update([
            'reservation_number' => $id . '-' . KeyGenerator::generate(5),
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
     * Return source and destination airports from json file.
     *
     * @param Request $request
     * @return array
     */
    private function getAirports(Request $request): array
    {
        $airport = new Airport();

        if($request->query->get('travel_type') == 'ROUNDTRIP'){
            $departure_iata = explode('-', explode('>', $request->query->get('connections'))[0])[0];
            $arriving_iata = explode('-', explode('>', $request->query->get('connections'))[1])[0];
        } else {
            $departure_iata = explode('>', $request->query->get('connections'))[0];
            $arriving_iata = explode('>', $request->query->get('connections'))[1];
        }

        return $airport->FindByIata([$departure_iata, $arriving_iata]);
    }

    /**
     * Calculate distance of trip. Result get in specify unit of measurement. Option unit of measurements are
     * [kilometer, miles] or empty parameter is equals meter.
     *
     * @param array $airports
     * @return float|int
     */
    private function calculateTravelDistance(array $airports): float|int
    {
        $calculator = new DistanceCalculator(
            $airports[0]->latitude_deg,
            $airports[0]->longitude_deg,
            $airports[1]->latitude_deg,
            $airports[1]->longitude_deg
        );

        return $calculator->calculate('kilometer');
    }

    /**
     * Expand airplanes array with value of trip duration finally return the expanded airplanes array.
     *
     * @param float|int $distanceInKilometer
     * @param array $airplanes
     * @return array
     */
    private function addTripDuration(float|int $distanceInKilometer, array $airplanes): array
    {
       return array_map(function ($airplane) use ($distanceInKilometer) {
            $tripDurationCalculator = new TripDurationCalculator($airplane->travel_speed , $distanceInKilometer);
            $airplane = (array)$airplane;
            $airplane['trip_duration'] = $tripDurationCalculator->calculate();

            return $airplane;

        },$airplanes);
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
