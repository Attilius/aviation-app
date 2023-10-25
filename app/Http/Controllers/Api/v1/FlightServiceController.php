<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Flight;
use App\Repository\FlightRepository;
use App\Services\Flight\AirplaneServiceHandler;
use App\Services\Flight\AirportServiceHandler;
use App\Services\Flight\AvailableFlightsHandler;
use App\Services\Flight\FlightChain;
use App\Services\Flight\FlightServiceHandler;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Exception;
use App\Services\Flight\Response as Props;

class FlightServiceController extends Controller
{
    private FlightRepository $flightRepository;
    private FlightChain $chain;
    private Props $props;

    public function __construct(FlightRepository $flightRepository, FlightChain $chain, Props $props)
    {
        $this->flightRepository = $flightRepository;
        $this->chain = $chain;
        $this->props = $props;
    }

    /**
     * Show public or private flights.
     *
     * @param Request $request
     * @return Response
     * @throws Exception
     */
    public function index(Request $request): Response
    {
        $this->chain
            ->addChainLink(new AirportServiceHandler())
            ->addChainLink(new AirplaneServiceHandler())
            ->addChainLink(new FlightServiceHandler())
            ->addChainLink(new AvailableFlightsHandler());
        $this->chain->start($request, $this->props);

        $props = $this->props->getProps();
        return Inertia::render('API/PrivateJetRent', $props);
    }

    /**
     * Get only one flight.
     *
     * @param int $id
     * @return Model
     */
    public function getOnlyFlight(int $id): Model
    {
        return $this->flightRepository->findById($id);
    }

    /**
     * Create a new flight model item.
     *
     * @param Request $request
     * @return void
     */
    public function storeFlight(Request $request): void
    {
        $this->flightRepository->store([
            'departurePlace' => $request['departurePlace'],
            'arrivingPlace' => $request['arrivingPlace'],
            'flightNumber' => $request['flightNumber'],
            'carrierName' => $request['carrierName'],
            'airplaneType' => $request['airplaneType'],
            'departureDate' => $request['departureDate'],
            'direction' => $request['direction'],
            'departureTime' => $request['departureTime'],
            'arrivingTime' => $request['arrivingTime'],
            'freeSeats' => $request['freeSeats']
        ]);
    }

    /**
     * Update a flight model item.
     *
     * @param Request $request
     * @return void
     */
    public function updateFlight(Request $request): void
    {
        $flights = Flight::all();

        foreach ($flights as $flight)
        {
            $this->flightRepository->update($flight['id'], [
                'departurePlace' => $request['departurePlace'],
                'arrivingPlace' => $request['arrivingPlace'],
                'departureDate' => $request['departureDate'],
                'direction' => $request['direction'],
                'arrivingTime' => $request['arrivingTime']
            ]);
        }
    }

    /**
     * Delete a flight model item.
     *
     * @param int $id
     * @return void
     */
    public function removeFlight(int $id): void
    {
        $this->flightRepository->destroy($id);
    }
}
