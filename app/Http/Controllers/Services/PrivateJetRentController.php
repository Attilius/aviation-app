<?php

namespace App\Http\Controllers\Services;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PrivateJetRentController extends Controller
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

        return Inertia::render('Services/PrivateJetRent', [
            'title' => $service->title,
            'headerImageTitles' => $service->headerImageTitles,
            'styles' => $service->styles,
            'description' => $service->description,
            'categories' => $service->categories
        ]);
    }
}
