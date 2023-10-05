<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Airport;
use App\Models\Page;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    /**
     * @param Request $request
     * @return Response
     */
    public function index(Request$request): Response
    {
        $firstPartOfUri = explode('/', $request->getRequestUri())[1];
        $page = Page::GET($firstPartOfUri);
        $airports = Airport::ALL('public');

        return Inertia::render('Home', [
            'title' => $page->title,
            'airports' => $airports,
            'isPrivate' => false
        ]);
    }
}
