<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $primaryKey = 'user_id';

    protected $fillable = [
        'first_name',
        'last_name',
        'sexe',
        'email',
        'telephone',
        'user_password',
        'rue',
        'ville',
        'code_postal',
        'pays',
        'last_connexion',
        'notification_option',
        'picture',
        'user_type',
        'is_activated',
        'is_connected',
    ];

    protected $hidden = [
        'user_password',
        'remember_token',
    ];

    protected $casts = [
        'last_connexion' => 'datetime',
        'is_activated' => 'boolean',
        'is_connected' => 'boolean',
        'email_verified_at' => 'datetime',
    ];

    /**
     * Mutator pour hasher automatiquement le mot de passe lors de l'attribution.
     */
    public function setUserPasswordAttribute($value)
    {
        if (!empty($value)) {
            $this->attributes['user_password'] = bcrypt($value);
        }
    }
}
