<?php

namespace App\Http\Responses;

use App\Contracts\FailedSubscribeResponseInterface;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FailedSubscribeResponse implements FailedSubscribeResponseInterface
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
     * @throws ValidationException
     */
    public function toResponse($request): Response
    {
        if ($request->wantsJson()) {
            throw ValidationException::withMessages([
                'email' => [trans($this->status)],
            ]);
        }

        return back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => trans($this->status)]);
    }
}
