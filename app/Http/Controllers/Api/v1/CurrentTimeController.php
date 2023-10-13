<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CurrentTimeController extends Controller
{
    public function __invoke(Request $request)
    {
        $area = $request->query('area');
        $city = $request->query('city');
        $response = Http::get("https://timeapi.io/api/Time/current/zone?timeZone=$area/$city");

        return $response->json();
    }
}
