<?php

namespace App\Models;

use App\Mail\MustSendEmail;
use App\Mail\Subscribers\CanSendNewsletter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Subscriber extends Model
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
        'email'
    ];
}
