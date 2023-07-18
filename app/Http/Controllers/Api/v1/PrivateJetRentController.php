<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Airplanes;
use App\Models\FlightDetails;
use App\Models\Reservation;
use App\Models\ReservationUtils;
use App\Utils\DistanceCalculator;
use App\Utils\TripDurationCalculator;
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
        $airports = $this->getAirports($request);
        $distanceInKilometer = $this->calculateTravelDistance($airports);
        $passengers = array_sum(explode('-',$request->query->get('pax')));
        $airplanes = Airplanes::findByDistanceAndPassengers($distanceInKilometer, $passengers);
        $airplanesWithTripDuration = $this->addTripDuration($distanceInKilometer, $airplanes);
        $reservationUtils = ReservationUtils::all();
        $id = $reservationUtils->get('id');
        $this->updateReservationUtils($request, $id);

        return Inertia::render('API/PrivateJetRent', [
            'title' => 'Jet Rent',
            'progressId' => '2',
            'departure' => $airports[0]->municipality,
            'arriving' => $airports[1]->municipality,
            'passengers' => strval($passengers),
            'airplanes' => $airplanesWithTripDuration,
            'pax' => $request->query->get('pax')
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
        $airport = new Airport();

        if($request->get('travel_type') == 'ROUNDTRIP'){
            $departure_iata = explode('-', explode('>', $request->get('connections'))[0])[0];
            $arriving_iata = explode('-', explode('>', $request->get('connections'))[1])[0];
        } else {
            $departure_iata = explode('>', $request->get('connections'))[0];
            $arriving_iata = explode('>', $request->get('connections'))[1];
        }

        $airports = $airport->FindByIata([$departure_iata, $arriving_iata]);

        $flight = FlightDetails::create([
            'flight_number' => '*',
            'airline' => 'Lorem Airlines',
            'airplane_type' => '*',
            'source_airport' => $airports[0]->municipality . ',' . $airports[0]->name,
            'destination_airport' => $airports[1]->municipality . ',' . $airports[1]->name,
            'departure_date' => $request->get('departure_date'),
            'return_date' => $request->get('return_date') ? $request->get('return_date') : null
        ]);

        $this->createReservation($flight->id);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request  $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Update the specified resource in reservation utils.
     *
     * @param Request $request
     * @param int $id
     * @return void
     */
    private function updateReservationUtils(Request $request, int $id): void
    {
        $reservation = Reservation::find($id);
        $reservation->reservationUtils()->update([
            'pax' => $request->query->get('pax'),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param int $id
     * @return void
     */
    private function createReservation(int $id): void
    {
        $flight = FlightDetails::find($id);
        $reservation = $flight->reservations()->create([
            'reservation_number' => $id . '-' . KeyGenerator::generate(5),
            'date_of_reservation' => Date::now()
        ]);

        $this->createReservationUtils($reservation->id);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param int $id
     * @return void
     */
    private function createReservationUtils(int $id): void
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
     * Calculate distance of trip.
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
}
