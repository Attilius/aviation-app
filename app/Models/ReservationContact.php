<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static create(array $array)
 */
class ReservationContact extends Model
{
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'phone_number',
        'email_address',
    ];

    /**
     * Get the comments for the blog post.
     */
    public function reservation(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }
}
