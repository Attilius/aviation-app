<?php

namespace App\Models;

use Illuminate\Support\Facades\File;

class Service
{

    const JSON_FILE_PATH = 'resources/data/services.json';

    /**
     * Getting all data of specific service page.
     *
     * @param string $serviceName
     * @return mixed
     */
    public static function GET(string $serviceName): mixed
    {
        $jsonData = File::get(base_path(self::JSON_FILE_PATH));
        $key = self::transformToKey($serviceName);

        return json_decode($jsonData)->$key;
    }

    /**
     * Transform json key to url endpoint name.
     *
     * @param string $serviceName
     * @return string
     */
    private static function transformToKey(string $serviceName): string
    {
        return str_replace('-', '_', $serviceName);
    }
}
