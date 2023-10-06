<?php

namespace App\Http\Controllers\Pages\TravelGuide;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TravelGuideController extends Controller
{
    public function index(Request$request)
    {
       // $firstPartOfUri = explode('/', $request->getRequestUri())[1];
       // $page = Page::GET($firstPartOfUri);

        return Inertia::render('TravelGuide/TravelGuide', [

        ]);
    }
}
