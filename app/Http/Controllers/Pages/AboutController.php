<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class AboutController extends Controller
{
    /**
     * Render the about page.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request$request): Response
    {
        $firstPartOfUri = explode('/', $request->getRequestUri())[1];
        $page = Page::GET($firstPartOfUri);

        return Inertia::render('About', [
            'title' => $page->title,
            'pageTitle' => $page->page_title,
            'articleUs' => $page->article_us,
            'articleExperience' => $page->article_experience,
            'articleServices' => $page->article_services
        ]);
    }
}
