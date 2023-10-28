<?php

namespace App\Models;

use Illuminate\Support\Facades\File;

class Airport
{
    const PRIVATE_JSON_FILE_PATH = 'resources/data/airports.json';

    const PUBLIC_JSON_FILE_PATH = 'resources/data/publicAirports.json';

    /**
     * Getting all data of specific main page
     *
     * @param string $cityName
     * @return array|string
     */
    public static function GET(string $cityName): array|string
    {
        $jsonData = File::get(base_path(self::PRIVATE_JSON_FILE_PATH));
        $failedMessage = 'Sorry, the specified location is not exist in our database';

        $airports = array();

        foreach (json_decode($jsonData) as $value)
        {
            if ($value->municipality == $cityName && $value->type !== 'heliport' && $value->type !== 'closed')
            {
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
        $jsonData = File::get(base_path(self::PRIVATE_JSON_FILE_PATH));

        $airports = array();

        for ($i = 0; $i < count($iata); $i++)
        {
            $key = array_search($iata[$i], array_column(json_decode($jsonData), 'iata_code'));
            $airports[$i] = json_decode($jsonData)[$key];
        }

        return $airports;
    }

    /**
     * Return all airports in the world, without closed or hospital airport.
     *
     * @param string $typeOfService
     * @return array
     */
    public static function ALL(string $typeOfService = 'private'): array
    {
        $jsonData = File::get(base_path(self::PRIVATE_JSON_FILE_PATH));
        $airports = array();

        if ($typeOfService !== 'private')
        {
            $jsonData = File::get(base_path(self::PUBLIC_JSON_FILE_PATH));

            foreach (json_decode($jsonData) as $value)
            {
                $airports[] = $value;
            }
        } else {
            foreach (json_decode($jsonData) as $value)
            {
                if ($value->type !== 'heliport' && $value->type !== 'closed' && $value->iata_code !== '' &&
                    $value->type !== 'small_airport' && $value->iata_code !== 'FCO')
                {
                    $airports[] = $value;
                }
            }
        }

        return $airports;
    }
}
