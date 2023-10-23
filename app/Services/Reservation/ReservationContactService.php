<?php

namespace App\Services\Reservation;

use App\Models\Reservation;
use App\Models\ReservationContact;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ReservationContactService
{
    /**
     * Store a newly created reservation contact resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function storeReservationContact(Request $request): RedirectResponse
    {
        $reservationService = new ReservationService();

        $reservationContact = ReservationContact::create([
            'phone_number' => $request->get('country_code') . $request->get('phone_number'),
            'email_address' => $request->get('email_address')
        ]);

        Reservation::where('id', $reservationService->getReservationId())->update([
            'reservation_contact_id' => $reservationContact->id
        ]);

        return redirect(route('create-ancillaries'));
    }
}
