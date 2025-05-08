<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    use HasFactory;

    protected $table = 'commandes';
    protected $primaryKey = 'id_commande';
    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'co_total',
        'co_status',
        'moyen_paiement',
        'est_a_livrer',
        'livraison_creer',
        'rue_livraison',
        'ville_livraison',
        'code_postal_livraison',
        'pays_livraison',
        'co_date',
        'commentaires'
    ];

    protected $casts = [
        'co_total' => 'decimal:2',
        'est_a_livrer' => 'boolean',
        'livraison_creer' => 'boolean',
        'co_date' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // Relation avec l'utilisateur
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relation avec les produits (via la table pivot commande_produits)
    public function produits()
    {
        return $this->belongsToMany(Produit::class, 'commande_produits', 'co_id', 'p_id')
            ->withPivot('quantite', 'prix_unitaire', 'remise')
            ->withTimestamps();
    }
}
