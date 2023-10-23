<?php

namespace App\Services\Payment;

use App\Models\Reservation;
use Illuminate\Support\Facades\Date;

class PaymentService
{
    /**
     * Show the form for creating a new resource.
     *
     * @param string $id
     * @return void
     */
    public function createPaymentStatus(string $id): void
    {
        $reservation = Reservation::find($id);
        $reservation->paymentStatus()->create([
            'payment_due_date' => Date::now(),
            'payment_amount' => 0
        ]);
    }

    /**
     * Update the specified resource in reservation utils.
     *
     * @param string $id
     * @param int $paymentAmount
     * @return void
     */
    public function updatePaymentStatus(string $id, int $paymentAmount): void
    {
        $reservation = Reservation::find($id);
        $reservation->paymentStatus()->update([
            'payment_due_date' => Date::now(),
            'payment_amount' => $paymentAmount,
        ]);
    }
}
