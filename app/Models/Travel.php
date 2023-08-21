<?php

namespace App\Models;

use Illuminate\Support\Facades\File;

class Travel
{
    const JSON_FILE_PATH = 'resources/data/services.json';

    /**
     * Return all travels.
     *
     * @return array
     */
    public static function ALL(): array
    {
        $jsonData = File::get(base_path(self::JSON_FILE_PATH));
        return json_decode($jsonData)->travel_insurance->categories;
    }

    /**
     * Return all travels.
     *
     * @param string $passengerTypes
     * @return int
     */
    public static function getTravelPrices(string $passengerTypes): int
    {
        $result = 0;
        $jsonData = File::get(base_path(self::JSON_FILE_PATH));
        $travels = json_decode($jsonData)->travel_insurance->categories;

        $pax = explode('-', $passengerTypes);

        for($i = 0; $i < count($pax); $i++) {
            switch($i) {
                case 0:
                {
                    if ($pax[0] !== '0') {
                        for ($j = 0; $j < intval($pax[0]); $j++) {
                            $result += $travels[3]->price;
                        }
                    }
                    break;
                }
                case 1:
                {
                    if ($pax[1] !== '0') {
                        for ($j = 0; $j < intval($pax[1]); $j++) {
                            $result += $travels[1]->price;
                        }
                    }
                    break;
                }
                case 2:
                {
                    if ($pax[2] !== '0') {
                        for ($j = 0; $j < intval($pax[2]); $j++) {
                            $result += $travels[0]->price;;
                        }
                    }
                    break;
                }
                case 3:
                {
                    if ($pax[3] !== '0') {
                        for ($j = 0; $j < intval($pax[3]); $j++) {
                            $result += $travels[4]->price;
                        }
                    }
                    break;
                }
                case 4:
                {
                    if ($pax[4] !== '0') {
                        for ($j = 0; $j < intval($pax[4]); $j++) {
                            $result += $travels[2]->price;
                        }
                    }
                    break;
                }
                default:{}
            }
        }

        return $result;
    }
}
