<?php

namespace App\Services\Travel;

use App\Repository\FlightRepository;
use App\Utils\DistanceCalculator;
use App\Utils\TripDurationCalculator;
use DateInterval;
use DateTime;
use Exception;
use Illuminate\Database\Eloquent\Collection;

class TravelService
{
    /**
     * Airplanes list of public flight.
     *
     * @var array|array[]
     */
    private array $airplanes = [
        0 => [
            'type' => 'Airbus A321-200',
            'travelSpeed' => 900
        ],
        1 => [
            'type' => 'Airbus A320-200',
            'travelSpeed' => 900
        ],
        2 => [
            'type' => 'Boeing 737-800',
            'travelSpeed' => 900
        ],
    ];

    /**
     * Getting and set duration of travel in flight model.
     *
     * @param float|int $distanceInKilometer
     * @param array $data
     * @return void
     */
    public function getTripDuration(float|int $distanceInKilometer, array $data = []): void
    {
        foreach ($this->airplanes as $airplane)
        {
            $tripDurationCalculator = new TripDurationCalculator($airplane['travelSpeed'], $distanceInKilometer);
            $tripDuration = str_replace('h', ':', $tripDurationCalculator->calculate());
            $repository = new FlightRepository();
            $flights = $repository->findAll()->where('airplane_type', '=', $airplane['type']);

            $this->updateFlight($flights, $data, $tripDuration);
        }
    }

    /**
     * Refresh the flight model.
     *
     * @param Collection $collection
     * @param array $data
     * @param string $tripDurationTime
     * @return void
     */
    private function updateFlight(Collection $collection, array $data, string $tripDurationTime): void
    {
        foreach ($collection as $item)
        {
            if($item['direction'] === 'departure')
            {
                $item['departure_place'] = $data['airports'][0]->municipality;
                $item['arriving_place'] = $data['airports'][1]->municipality;
                $item['departure_date'] = $data['request']->query->get('departure_date');
            } else {
                if ($data['request']->query->get('travel_type') === 'ROUNDTRIP')
                {
                    $item['departure_place'] = $data['airports'][1]->municipality;
                    $item['arriving_place'] = $data['airports'][0]->municipality;
                    $item['departure_date'] = $data['request']->query->get('return_date');
                }
            }

            $item['arriving_time'] = date("H:i",
                strtotime($item['departure_time'].'+'.explode(':',
                        $tripDurationTime ?? '00:00')[0].' hour'.explode(':',
                        $tripDurationTime ?? '00:00')[1].' minutes'
                )
            );
            $item['free_seats'] = rand(1,11);
            $item->save();
        }
    }

    /**
     * Calculate distance of trip. Result get in specify unit of measurement. Option unit of measurements are
     * [kilometer, miles] or empty parameter is equals meter.
     *
     * @param array $airports
     * @return float|int
     */
    public static function calculateTravelDistance(array $airports): float|int
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

    /**
     * Return the time interval during the travel.
     *
     * @param object $travel
     * @return DateInterval|string
     * @throws Exception
     */
    public function calculateTravelTimeInterval(object $travel): DateInterval | string
    {
        $time1 = new DateTime($travel['departure_time']);
        $time2 = new DateTime($travel['arriving_time']);

        if ($time2 < $time1)
        {
            $referenceTime = new DateTime('00:00');
            $cloneOfReferenceTime = clone $referenceTime;
            $PM_partOfTime = $time1->diff(new DateTime('23:59'));
            $AM_partOfTime = $referenceTime->diff($time2);
            $firstStringCharacter = substr($cloneOfReferenceTime
                ->diff($referenceTime)
                ->format("%Hh%I"), 0, 1);

            $referenceTime->add($PM_partOfTime);
            $referenceTime->add($AM_partOfTime);

            return $firstStringCharacter === '0'
                ? substr($cloneOfReferenceTime->diff($referenceTime)->format("%Hh%I"), 1)
                : $cloneOfReferenceTime->diff($referenceTime)->format("%Hh%I");

        } else {
            return $time1->diff($time2);
        }
    }
}
