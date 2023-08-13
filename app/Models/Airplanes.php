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
        $airplanes = array();

        foreach (json_decode($jsonData) as $value) {
            $airplanes[] = $value;
        }

        return $airplanes;
    }

    /**
     * Return all airplanes which is inside range of distance and passenger capacity.
     *
     * @param string $type
     * @return object
     */
    public static function findByType(string $type): object
    {
        $jsonData = File::get(base_path(self::JSON_FILE_PATH));
        $airplanes = '';

        foreach (json_decode($jsonData) as $value) {
            if($value->name == $type) {
                $airplanes = $value;
            }
        }

        return $airplanes;
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
        $airplanes = array();

        foreach (json_decode($jsonData) as $value) {
            if($value->range_distance >= $distance && $value->passenger_capacity >= $passengers) {
                $airplanes[] = $value;
            }
        }

        return $airplanes;
    }
}
