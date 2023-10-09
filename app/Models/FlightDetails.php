<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static create(string[] $array)
 * @method static find(int $int)
 * @method static where(string $string, $flight_details_id)
 */
class FlightDetails extends Model
{
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'flight_number',
        'airline',
        'airplane_type',
        'cabin_class',
        'source_airport',
        'destination_airport',
        'departure_date',
        'departure_time',
        'return_date',
    ];

    /**
     * Get the reservation for the flight details.
     */
    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }
}
