<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Airplanes;
use App\Models\FlightCost;
use App\Models\FlightDetails;
use App\Models\Passenger;
use App\Models\Reservation;
use App\Models\ReservationUtils;
use App\Models\User;
use App\Repository\FlightDetailsRepository;
use App\Repository\ReservationRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Inertia\Inertia;
use Inertia\Response;
use App\Utils\KeyGenerator;
use App\Utils\TravelDistanceAndDurationHandler;

class PrivateJetRentController extends Controller
{
    private TravelDistanceAndDurationHandler $travelHandler;
    private FlightDetailsRepository $flightDetailsRepository;
    private ReservationRepository $reservationRepository;

    public function __construct(
        TravelDistanceAndDurationHandler $travelHandler,
        FlightDetailsRepository $flightDetailsRepository,
        ReservationRepository $reservationRepository
    )
    {
        $this->travelHandler = $travelHandler;
        $this->flightDetailsRepository = $flightDetailsRepository;
        $this->reservationRepository = $reservationRepository;
    }

    /*/**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    /*public function index(Request $request): Response
    {
        //Store flight details in db
        //$this->storeFlightDetails($request);

        //Get airports and work with
        //$airports = $this->travelHandler->getAirports($request);
        //$distanceInKilometer = $this->travelHandler->calculateTravelDistance($airports);

        //Get passengers from request and work with
        //$passengers = array_sum(explode('-',$request->query->get('pax')));

        //Get airplanes and work with
        //$airplanes = Airplanes::findByDistanceAndPassengers($distanceInKilometer, $passengers);
        //$airplanesWithTripDuration = $this->travelHandler->addTripDuration($distanceInKilometer, $airplanes);

        $this->updateReservationUtils($request);
        $this->updatePaymentStatus($request);
        return Inertia::render('API/PrivateJetRent', [
            'title' => 'Jet Rent',
            'progressId' => '2',
            'departure' => $airports[0]->municipality,
            'arriving' => $airports[1]->municipality,
            'passengers' => strval($passengers),
            'airplanes' => $airplanesWithTripDuration,
            'isPrivate' => true
        ]);
    }*/

    /*/**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return void
     */
    /*public function storeFlightDetails(Request $request): void
    {
        if($this->isReservationAlreadyExist($request)){
            $this->updateFlightDetails($request);
        } else {
            $airports = $this->travelHandler->getAirports($request);

            $flightDetails = $this->flightDetailsRepository->store([
                'flightNumber' => '*',
                'airline' => 'Lorem Airlines',
                'airplaneType' => '*',
                'cabinClass' => $request->query->get('cabin_class'),
                'sourceAirport' => $airports[0]->municipality . ',' . $airports[0]->name,
                'destinationAirport' => $airports[1]->municipality . ',' . $airports[1]->name,
                'departureDate' => explode('T', $request->query->get('departure_date'))[0],
                'departureTime' => explode('T', $request->query->get('departure_date'))[1],
                'returnDate' => $request->query->get('return_date') ?? null
            ]);

            $this->createReservation($flightDetails->getAttributeValue('id'));
        }
    }*/

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
    private function updateFlightDetails(Request $request): void
    {
        $reservation = Reservation::find($request->session()->getId());
        $airports = $this->travelHandler->getAirports($request);
        $id = $reservation->flight_details_id;

        $this->flightDetailsRepository->update($id, [
            'flightNumber' => '*',
            'airline' => 'Lorem Airlines',
            'airplaneType' => '*',
            'cabinClass' => $request->query->get('cabin_class'),
            'sourceAirport' => $airports[0]->municipality . ',' . $airports[0]->name,
            'destinationAirport' => $airports[1]->municipality . ',' . $airports[1]->name,
            'departureDate' => explode('T', $request->query->get('departure_date'))[0],
            'departureTime' => explode('T', $request->query->get('departure_date'))[1],
            'returnDate' => $request->query->get('return_date') ?? null
        ]);

        $this->updateReservation($reservation->flight_details_id);
    }


}
