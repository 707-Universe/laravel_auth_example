<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class PasswordResetToken extends Model
{
    /** @use HasFactory<\Database\Factories\PasswordResetTokenFactory> */
    use HasFactory, Notifiable;

    protected $primaryKey = null;

    public $incrementing = false;

    const UPDATED_AT = null;

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'email',
        'token',
    ];
}
