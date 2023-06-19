<?php

namespace App\Http\Responses;

use App\Contracts\ContactMessageResponseInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ContactMessageResponse implements ContactMessageResponseInterface
{
    /**
     * The response status language key.
     *
     * @var string
     */
    protected string $status;

    /**
     * Create a new response instance.
     *
     * @param string $status
     * @return void
     */
    public function __construct(string $status)
    {
        $this->status = $status;
    }

    /**
     * Create an HTTP response that represents the object.
     *
     * @param Request $request
     * @return Response
     */
    public function toResponse($request): Response
    {
        return $request->wantsJson()
            ? new JsonResponse(['message' => trans($this->status)], 200)
            : back()->with('status', trans($this->status));
    }
}
