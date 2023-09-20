<?php

namespace App\Models;

use Illuminate\Support\Facades\File;

class Destination
{
    const JSON_FILE_PATH = 'resources/data/destinations.json';

    /**
     * Return one distance by city name.
     *
     * @param string $city
     * @return object
     */
    public static function findByCityName(string $city): object
    {
        $jsonData = File::get(base_path(self::JSON_FILE_PATH));
        $destination = [];

        foreach (json_decode($jsonData) as $value) {
            if($value->city->name === $city) {
                $destination = $value;
            }
        }

        return $destination;
    }
}
