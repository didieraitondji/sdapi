<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Livraison extends Model
{
    use HasFactory;

    protected $table = 'livraisons';
    protected $primaryKey = 'livraison_id';
    public $timestamps = true;

    protected $fillable = [
        'co_id',
        'user_id',
        'livreur_id',
        'rue',
        'ville',
        'code_postal',
        'pays',
        'livraison_status',
        'date_livraison_estimee',
        'date_livraison_effective',
        'moyen_transport',
        'commentaires'
    ];

    protected $casts = [
        'date_livraison_estimee' => 'datetime',
        'date_livraison_effective' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // Relation avec la commande
    public function commande()
    {
        return $this->belongsTo(Commande::class, 'co_id');
    }

    // Relation avec l'utilisateur
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relation avec le livreur
    public function livreur()
    {
        return $this->belongsTo(Livreur::class, 'livreur_id');
    }
}
