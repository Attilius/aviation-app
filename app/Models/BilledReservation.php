<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BilledReservation extends Model
{
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'payer_id',
        'payer_email',
        'address_name',
        'address_street',
        'address_zip',
        'address_country_code',
        'quantity',
        'transaction_id',
        'payment_gross',
        'payment_date',
        'currency_code',
        'invoice_id',
        'billed_date',
        'reservation_number'
    ];
}
