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
            'isPrivate' => true
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

    /**
     * Creating a new reservation resource.
     *
     * @param int $id
     * @return void
     */
    private function createReservation(int $id): void
    {
        $authUser = Auth::user();
        $keyGenerator = new KeyGenerator();
        $user = User::find($authUser->getAuthIdentifier());

        $flightDeatils = FlightDetails::find($id);
        $reservation = $flightDeatils->reservations()->create([
            'id' => $keyGenerator->generate(40, 'mix'),
            'reservation_number' => $id . '-' . $keyGenerator->generate(6, 'mix'),
            'date_of_reservation' => Date::now()
        ]);

        $user->reservations()->attach($reservation->id);

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
