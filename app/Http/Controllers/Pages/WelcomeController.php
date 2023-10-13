<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class WelcomeController extends Controller
{
    /**
     * Render the welcome page.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        $firstPartOfUri = explode('/', $request->getRequestUri())[0];
        $page = Page::GET($firstPartOfUri);

        return Inertia::render('Welcome', [
            'title' => $page->title,
            'greeting' => $page->greeting,
            'binderWord' => $page->binderWord,
            'companyName' => $page->companyName,
            'authNavLinkAttributes' => $page->authNavLinkAttributes,
            'subscriberMessage' => $page->subscriberMessage,
            'status' => session('status')
        ]);
    }
}
