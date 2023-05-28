<?php

namespace App\Actions\Jetstream;

use App\Contracts\SubscriberRepositoryInterface;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Laravel\Fortify\Actions\ConfirmPassword;
use Laravel\Jetstream\Contracts\DeletesUsers;
use Illuminate\Http\Response;

class CurrentUserController extends Controller
{
    /**
     * The subscriber repository implementation.
     *
     * @var SubscriberRepositoryInterface
     */
    private SubscriberRepositoryInterface $subscriberRepository;

    /**
     * Create a new subscriber repository instance.
     *
     * @param SubscriberRepositoryInterface $subscriberRepository
     */
    public function __construct(SubscriberRepositoryInterface $subscriberRepository)
    {
        $this->subscriberRepository = $subscriberRepository;
    }

    /**
     * Delete the current user.
     *
     * @param Request $request
     * @param StatefulGuard $guard
     * @return Response
     * @throws ValidationException
     */
    public function destroy(Request $request, StatefulGuard $guard): Response
    {
        $confirmed = app(ConfirmPassword::class)(
            $guard, $request->user(), $request->password
        );

        if (! $confirmed) {
            throw ValidationException::withMessages([
                'password' => __('The password is incorrect.'),
            ]);
        }

        // Check and handling subscriber role during user account deleting
        if ($this->subscriberRepository->isSubscriberExist($request->user()['email'])) {
            $request['remove']
                ?  $this->subscriberRepository->destroy(null, $request->user()['email'])
                :  $this->subscriberRepository->update([
                       'old_email' => $request->user()['email'],
                       'role' => 'guest'
                   ]);
        }

        app(DeletesUsers::class)->delete($request->user()->fresh());

        $guard->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Inertia::location(url('/'));
    }
}
