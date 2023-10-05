<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(string[] $array)
 * @method static find(int $int)
 * @method static where(string $string, $flight_details_id)
 */
class Flight extends Model
{
    use HasFactory;

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'departure_place',
        'arriving_place',
        'flight_number',
        'carrier_name',
        'airplane_type',
        'departure_date',
        'direction',
        'departure_time',
        'arriving_time',
        'free_seats'
    ];
}
