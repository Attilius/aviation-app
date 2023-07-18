<?php

namespace App\Models;

use Illuminate\Support\Facades\File;

class Airport
{
    const JSON_FILE_PATH = 'resources/data/airports.json';

    /**
     * Getting all data of specific main page
     *
     * @param string $cityName
     * @return array|string
     */
    public static function GET(string $cityName): array|string
    {
        $jsonData = File::get(base_path(self::JSON_FILE_PATH));
        $failedMessage = 'Sorry, the specified location is not exist in our database';

        $airports = array();

        foreach (json_decode($jsonData) as $value) {
            if ($value->municipality == $cityName && $value->type !== 'heliport' && $value->type !== 'closed') {
                $airports[] = $value;
            }
        }

        return !empty($airports) ? $airports : $failedMessage;
    }

    /**
     * Getting all data of specific main page
     *
     * @param array $iata
     * @return array
     */
    public function FindByIata(array $iata): array
    {
        $jsonData = File::get(base_path(self::JSON_FILE_PATH));

        $airports = array();

        foreach (json_decode($jsonData) as $value) {
            if ($value->iata_code == $iata[0]) {
                $airports[0] = $value;
            }
            if ($value->iata_code == $iata[1]) {
                $airports[1] = $value;
            }
        }

        return $airports;
    }

    /**
     * Return all airports in the world, without closed or hospital airport.
     *
     * @return array
     */
    public static function ALL(): array
    {
        $jsonData = File::get(base_path(self::JSON_FILE_PATH));
        $airports = array();

        foreach (json_decode($jsonData) as $value) {
            if ($value->type !== 'heliport' && $value->type !== 'closed' && $value->iata_code !== '' &&
                $value->type !== 'small_airport' && $value->iata_code !== 'FCO') {
                $airports[] = $value;
            }
        }

        return $airports;
    }
}
