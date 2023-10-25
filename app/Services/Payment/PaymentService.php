<?php

namespace App\Services\Payment;

use App\Models\Reservation;
use Illuminate\Support\Facades\Date;

class PaymentService
{
    /**
     * Show the form for creating a new payment status resource.
     *
     * @param string $id
     * @return void
     */
    public function createPaymentStatus(string $id): void
    {
        Reservation::find($id)->paymentStatus()->create([
            'payment_due_date' => Date::now(),
            'payment_amount' => 0
        ]);
    }

    /**
     * Update the specified resource in payment status.
     *
     * @param string $id
     * @param array $data
     * @return void
     */
    public static function updatePaymentStatus(string $id, array $data): void
    {
        Reservation::find($id)->paymentStatus()->update($data);
    }
}
