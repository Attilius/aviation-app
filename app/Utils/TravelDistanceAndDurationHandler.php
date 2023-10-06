<?php

namespace App\Utils;

use App\Models\Airport;
use App\Repository\FlightRepository;
use Illuminate\Http\Request;

class TravelDistanceAndDurationHandler
{
    /**
     * Return source and destination airports from json file.
     *
     * @param Request $request
     * @return array
     */
    public function getAirports(Request $request): array
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
    public function calculateTravelDistance(array $airports): float|int
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
    public function addTripDuration(float|int $distanceInKilometer, array $airplanes): array
    {
        return array_map(function ($airplane) use ($distanceInKilometer) {
            $tripDurationCalculator = new TripDurationCalculator($airplane->travel_speed , $distanceInKilometer);
            $airplane = (array)$airplane;
            $airplane['trip_duration'] = $tripDurationCalculator->calculate();

            return $airplane;

        },$airplanes);
    }

    public function getTripDuration(float|int $distanceInKilometer, object $typeOfAirplanes, array $data = []): void
    {
        foreach ($typeOfAirplanes as $airplane){
            switch($airplane['airplane_type']){
                case 'Airbus A321-200': {
                    $travelSpeed = 876;
                    $tripDurationCalculator = new TripDurationCalculator($travelSpeed , $distanceInKilometer);

                    $tripDuration = str_replace('h', ':', $tripDurationCalculator->calculate());

                    $repository = new FlightRepository();
                    $flights = $repository->findAll()->where('airplane_type', 'Airbus A321-200');

                    foreach ($flights as $flight) {
                        if($flight['direction'] === 'departure'){
                            $repository->update($flight['id'],[
                                'departurePlace' => $data['airports'][0]->municipality,
                                'arrivingPlace' => $data['airports'][1]->municipality,
                                'departureDate' => $data['request']->query->get('departure_date'),
                                'arrivingTime' => $tripDuration
                            ]);
                        } else {
                            $repository->update($flight['id'],[
                                'departurePlace' => $data['airports'][1]->municipality,
                                'arrivingPlace' => $data['airports'][0]->municipality,
                                'departureDate' => $data['request']->query->get('return_date'),
                                'arrivingTime' => $tripDuration
                            ]);
                        }
                    }

                    break;
                }
                case 'Airbus A320-200': {
                    $travelSpeed = 903;
                    $tripDurationCalculator = new TripDurationCalculator($travelSpeed , $distanceInKilometer);

                    $tripDuration = str_replace('h', ':', $tripDurationCalculator->calculate());

                    $repository = new FlightRepository();
                    $flights = $repository->findAll()->where('airplane_type', 'Airbus A320-200');

                    foreach ($flights as $flight) {
                        if($flight['direction'] === 'departure'){
                            $repository->update($flight['id'],[
                                'departurePlace' => $data['airports'][0]->municipality,
                                'arrivingPlace' => $data['airports'][1]->municipality,
                                'departureDate' => $data['request']->query->get('departure_date'),
                                'arrivingTime' => $tripDuration
                            ]);
                        } else {
                            $repository->update($flight['id'],[
                                'departurePlace' => $data['airports'][1]->municipality,
                                'arrivingPlace' => $data['airports'][0]->municipality,
                                'departureDate' => $data['request']->query->get('return_date'),
                                'arrivingTime' => $tripDuration
                            ]);
                        }
                    }

                    break;
                }
                case 'Boeing 737-800': {
                    $travelSpeed = 946;
                    $tripDurationCalculator = new TripDurationCalculator($travelSpeed , $distanceInKilometer);

                    $tripDuration = str_replace('h', ':', $tripDurationCalculator->calculate());

                    $repository = new FlightRepository();
                    $flights = $repository->findAll()->where('airplane_type', 'Boeing 737-800');

                    foreach ($flights as $flight) {
                        if($flight['direction'] === 'departure'){
                            $repository->update($flight['id'],[
                                'departurePlace' => $data['airports'][0]->municipality,
                                'arrivingPlace' => $data['airports'][1]->municipality,
                                'departureDate' => $data['request']->query->get('departure_date'),
                                'arrivingTime' => $tripDuration
                            ]);
                        } else {
                            $repository->update($flight['id'],[
                                'departurePlace' => $data['airports'][1]->municipality,
                                'arrivingPlace' => $data['airports'][0]->municipality,
                                'departureDate' => $data['request']->query->get('return_date'),
                                'arrivingTime' => $tripDuration
                            ]);
                        }
                    }

                    break;
                }
            }
        }
    }
}
