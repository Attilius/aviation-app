<?php

namespace App\Models;

use Illuminate\Support\Facades\File;

class Airplanes
{
    const JSON_FILE_PATH = 'resources/data/airplanes.json';

    /**
     * Return all airplanes.
     *
     * @return array
     */
    public static function ALL(): array
    {
        $jsonData = File::get(base_path(self::JSON_FILE_PATH));
        $airports = array();

        foreach (json_decode($jsonData) as $value) {
            $airports[] = $value;
        }

        return $airports;
    }

    /**
     * Return all airplanes which is inside range of distance and passenger capacity.
     *
     * @param Int $distance
     * @param Int $passengers
     * @return array
     */
    public static function findByDistanceAndPassengers(Int $distance, Int $passengers): array
    {
        $jsonData = File::get(base_path(self::JSON_FILE_PATH));
        $airports = array();

        foreach (json_decode($jsonData) as $value) {
            if($value->range_distance >= $distance && $value->passenger_capacity >= $passengers) {
                $airports[] = $value;
            }
        }

        return $airports;
    }
}
