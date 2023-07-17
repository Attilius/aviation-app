<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ServicesController extends Controller
{
    /**
     * Render the service page.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request$request): Response
    {
        $firstPartOfUri = explode('/', $request->getRequestUri())[1];
        $page = Page::GET($firstPartOfUri);

        return Inertia::render('Services', [
            'title' => $page->title,
            'headerImage' => $page->headerImage,
            'cards' => $page->cards,
            'banner' => $page->banner
        ]);
    }
}
