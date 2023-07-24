<?php

namespace App\Utils;

class DistanceCalculator
{
    const EARTH_RADIUS = 6371000;
    const METER_TO_MILES = 0.000621371192;
    const METER_TO_KILOMETER = 0.001;
    private float $departure_latitude;
    private float $departure_longitude;
    private float $arriving_latitude;
    private float $arriving_longitude;

    public function __construct(
        float $departure_latitude,
        float $departure_longitude,
        float $arriving_latitude,
        float $arriving_longitude)
    {
        $this->departure_latitude = $departure_latitude;
        $this->departure_longitude = $departure_longitude;
        $this->arriving_latitude = $arriving_latitude;
        $this->arriving_longitude = $arriving_longitude;
    }

    /**
     * Calculates the great-circle distance between two points, with
     * the Haversine formula.
     *
     * @param string $unitOfMeasurement
     * @return float|int
     */
    public function calculate(string $unitOfMeasurement): float|int
    {
        $reault = 0;

        // Convert from degrees to radians
        $latFrom = deg2rad($this->departure_latitude);
        $lonFrom = deg2rad($this->departure_longitude);
        $latTo = deg2rad($this->arriving_latitude);
        $lonTo = deg2rad($this->arriving_longitude);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
                cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));

        switch ($unitOfMeasurement){
            case'': {
                $reault = $angle * self::EARTH_RADIUS;
                break;
            }
            case'kilometer': {
                $reault = floor(($angle * self::EARTH_RADIUS) * self::METER_TO_KILOMETER);
                break;
            }
            case'miles': {
                $reault = floor(($angle * self::EARTH_RADIUS) * self::METER_TO_MILES);
                break;
            }
            default:{}
        }

        return $reault;
    }
}
