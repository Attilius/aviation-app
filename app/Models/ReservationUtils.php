<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static find()
 * @method static where(string $string, string $id)
 */
class ReservationUtils extends Model
{
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'pax',
        'target_of_plane_choosing',
        'travel_type',
        'flight_numbers',
        'return_flight_numbers',
        'airplane_type',
        'return_airplane_type',
        'target_of_plane_choosing_back',
        'checked_baggage_items'
    ];

    /**
     * Get the reservation that owns the reservationUtils.
     */
    public function reservation(): BelongsTo
    {
        return $this->belongsTo(Reservation::class);
    }
}
