<?php

namespace App\Actions\Fortify;

use App\Contracts\SubscriberRepositoryInterface;
use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

class UpdateUserProfileInformation implements UpdatesUserProfileInformation
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
     * @return void
     */
    public function __construct(SubscriberRepositoryInterface $subscriberRepository)
    {
        $this->subscriberRepository = $subscriberRepository;
    }

    /**
     * Validate and update the given user's profile information.
     *
     * @param array<string, string> $input
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(User $user, array $input): void
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'photo' => ['nullable', 'mimes:jpg,jpeg,png', 'max:1024'],
        ])->validateWithBag('updateProfileInformation');

        if (isset($input['photo'])) {
            $user->updateProfilePhoto($input['photo']);
        }

        // Update subscriber email too if already subscribe before
        $this->subscriberRepository->update([
            'old_email' => $user->email,
            'new_email' => $input['email']
            ]);

        if ($input['email'] !== $user->email &&
            $user instanceof MustVerifyEmail) {
            $this->updateVerifiedUser($user, $input);
        } else {
            $user->forceFill([
                'name' => $input['name'],
                'email' => $input['email'],
            ])->save();
        }
    }

    /**
     * Update the given verified user's profile information.
     *
     * @param  array<string, string>  $input
     */
    protected function updateVerifiedUser(User $user, array $input): void
    {
        // Update subscriber email too if already subscribe before
        $this->subscriberRepository->update([
            'old_email' => $user->email,
            'new_email' => $input['email']
        ]);

        $user->forceFill([
            'name' => $input['name'],
            'email' => $input['email'],
            'email_verified_at' => null,
        ])->save();

        $user->sendEmailVerificationNotification();
    }
}
