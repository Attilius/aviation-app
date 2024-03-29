<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @method static find($id)
 * @method static where(string $string, int $id)
 * @property mixed $first_name
 * @property mixed $last_name
 */
class Passenger extends Model
{
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'is_have_luggagge',
        'amount_of_luggage',
        'amount_of_awaying_luggage',
        'amount_of_return_luggage',
        'price_of_awaying_luggage',
        'price_of_return_luggage',
        'ticket_number'
    ];

    /**
     * The reservations that belong to the passenger.
     */
    public function reservations(): BelongsToMany
    {
        return $this->belongsToMany(Reservation::class, 'reservation_passengers');
    }
}
