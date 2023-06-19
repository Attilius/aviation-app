<?php

namespace App\Models;

use Illuminate\Support\Facades\File;

class Page
{
    const JSON_FILE_PATH = 'resources/data/pages.json';

    /**
     * Getting all data of specific main page
     *
     * @param string $serviceName
     * @return mixed
     */
    public static function GET(string $serviceName): mixed
    {
        $jsonData = File::get(base_path(self::JSON_FILE_PATH));

        return json_decode($jsonData)->$serviceName;
    }
}
