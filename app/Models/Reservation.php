<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @method static find(int $id)
 * @method static where(string $string, string $getId)
 */
class Reservation extends Model
{
    public $timestamps = false;

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    public $primaryKey = 'id';

    /**
     * Indicates if the model's ID is auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The data type of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'reservation_number',
        'date_of_reservation',
    ];

    /**
     * Get the reservation utils associated with the reservation.
     */
    public function reservationUtils(): HasOne
    {
        return $this->hasOne(ReservationUtils::class);
    }

    /**
     * Get the payment status associated with the reservation.
     */
    public function paymentStatus(): HasOne
    {
        return $this->hasOne(PaymentStatus::class);
    }

    /**
     * Get the reservation contact associated with the reservation.
     */
    public function reservationContact(): BelongsTo
    {
        return $this->belongsTo(ReservationContact::class);
    }

    /**
     * Get the flight details that owns the reservation.
     */
    public function flightDetails(): BelongsTo
    {
        return $this->belongsTo(FlightDetails::class);
    }

    /**
     * The passengers that belong to the reservation.
     */
    public function passengers(): BelongsToMany
    {
        return $this->belongsToMany(Passenger::class, 'reservation_passengers');
    }

    /**
     * Get the comments for the blog post.
     */
    public function reservationCosts(): HasMany
    {
        return $this->hasMany(ReservationCost::class);
    }
}
