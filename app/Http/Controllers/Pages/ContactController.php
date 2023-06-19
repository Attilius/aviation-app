<?php

namespace App\Http\Controllers\Pages;

use App\Contracts\ContactMessageRepositoryInterface;
use App\Contracts\ContactMessageResponseInterface;
use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ContactController extends Controller
{
    /**
     * The contact message repository implementation.
     *
     * @var ContactMessageRepositoryInterface
     */
    private ContactMessageRepositoryInterface $contactRepository;

    /**
     * Create a contact message repository instance.
     *
     * @param ContactMessageRepositoryInterface $contactRepository
     * @return void
     */
    public function __construct(ContactMessageRepositoryInterface $contactRepository)
    {
        $this->contactRepository = $contactRepository;
    }

    /**
     * Render the contact page.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request$request): Response
    {
        $firstPartOfUri = explode('/', $request->getRequestUri())[1];
        $page = Page::GET($firstPartOfUri);

        return Inertia::render('Contact', [
            'title' => $page->title,
            'pageTitle' => $page->pageTitle,
            'contactData' => $page->contactData,
            'status' => session('status')
        ]);
    }

    /**
     * Storage the contact message and his data.
     *
     * @param Request $request
     * @return ContactMessageResponseInterface
     */
    public function store(Request $request): ContactMessageResponseInterface
    {
        $status = 'contact.stored';
        $this->contactRepository->store($request->all());

        return app(ContactMessageResponseInterface::class, ['status' => $status]);
    }
}
