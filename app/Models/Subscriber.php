<?php

namespace App\Models;

use App\Mail\MustSendEmail;
use App\Mail\Subscribers\CanSendNewsletter;
use App\Contracts\CanSendNewsletterInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

/**
 * @method static create(array $array)
 * @method static where(string $string, string $email)
 */
class Subscriber extends Model implements CanSendNewsletterInterface
{
    use HasFactory;
    use Notifiable;
    use MustSendEmail;
    use CanSendNewsletter;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'role'
    ];
}
