<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Livreur extends Model
{
    use HasFactory;

    protected $table = 'livreurs'; // Nom de la table

    protected $primaryKey = 'livreur_id'; // Clé primaire personnalisée

    public $timestamps = true; // created_at et updated_at gérés automatiquement

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'sexe',
        'email',
        'telephone',
        'livreur_password',
        'rue',
        'ville',
        'code_postal',
        'pays',
        'livreur_status',
        'last_connexion',
        'notification_option',
        'is_activated',
        'is_connected',
        'vehicule_type',
        'vehicule_immatriculation',
    ];

    protected $casts = [
        'is_activated' => 'boolean',
        'is_connected' => 'boolean',
        'last_connexion' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relation avec User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
