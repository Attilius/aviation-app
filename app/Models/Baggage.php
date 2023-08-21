<?php

namespace App\Models;

use Illuminate\Support\Facades\File;

class Baggage
{
    const JSON_FILE_PATH = 'resources/data/services.json';

    /**
     * Return all baggages.
     *
     * @return array
     */
    public static function ALL(): array
    {
        $jsonData = File::get(base_path(self::JSON_FILE_PATH));
        return  json_decode($jsonData)->luggage_insurance->categories;
    }

    /**
     * Return private baggages.
     *
     * @return array
     */
    public static function getPrivateBaggages(): array
    {
        $jsonData = File::get(base_path(self::JSON_FILE_PATH));
        $allBaggages = json_decode($jsonData)->luggage_insurance->categories;
        $baggages = array();

        foreach ($allBaggages as $baggage){
            $weight = explode('kg', explode('/', $baggage->weight)[0])[0];
            if($weight == 10) {
                $baggages['accessory'] = $baggage;
            }

            if($weight == 15) {
                $baggages['handBaggage'] = $baggage;
            }

            if($weight == 25) {
                $baggages['checkedBaggage'] = $baggage;
            }
        }

        return $baggages;
    }
}
