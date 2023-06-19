<?php

namespace App\Http\Controllers\Services;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Service;

class TravelInsuranceController extends Controller
{
    /**
     * Service page render.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        $secondPartOfUri = explode('/', $request->getRequestUri())[2];
        $service = Service::GET($secondPartOfUri);

        return Inertia::render('Services/TravelInsurance', [
            'title' => $service->title,
            'headerImageTitles' => $service->headerImageTitles,
            'styles' => $service->styles,
            'description' => $service->description,
            'categories' => $service->categories
        ]);
    }
}
