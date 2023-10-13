<?php

namespace App\Services\Flight;

use App\Contracts\ServiceHandlerInterface;
use App\Repository\FlightDetailsRepository;
use Illuminate\Http\Request;

class FlightChain
{
    /**
     * Parts of chained process
     *
     * @var array
     */
    private array $chainLinks = [];

    /**
     * Add a new successor for chained process
     *
     * @param ServiceHandlerInterface $chainLink
     * @return $this
     */
    public function addChainLink(ServiceHandlerInterface $chainLink): static
    {
        $lastChainLink = end($this->chainLinks);

        if ($lastChainLink != null)
        {
            $lastChainLink->setSuccessor($chainLink);
        }

        $this->chainLinks[] = $chainLink;

        return $this;
    }

    /**
     * Start the chained process
     *
     * @param Request $request
     * @param Response $props
     * @return void
     */
    public function start(Request $request, Response $props): void
    {
        $repository = new FlightDetailsRepository();

        $flightDetailsModel = $repository->store([
            'flightNumber' => '*',
            'airline' => 'Lorem Airlines',
            'airplaneType' => '*',
            'cabinClass' => $request->query->get('cabin_class'),
            'sourceAirport' => '*',
            'destinationAirport' => '*',
            'departureDate' => explode('T', $request->query->get('departure_date'))[0] ?? $request->query->get('departure_date'),
            'departureTime' => explode('T', $request->query->get('departure_date'))[1] ?? '00:00:00',
            'returnDate' => $request->query->get('return_date') ?? null
        ]);

        $passengers = array_sum(explode('-',$request->query->get('pax')));

        $props->addProps('isRoundTrip', $request->query->get('travel_type') === 'ROUNDTRIP');
        $props->addProps('passengers', strval($passengers));

        //$this->createReservation($flightDetailsModel->getAttributeValue('id'));

        reset($this->chainLinks)->handle($request, $flightDetailsModel, $props);
    }
}
