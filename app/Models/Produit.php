<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    use HasFactory;

    protected $table = 'produits';
    protected $primaryKey = 'p_id';
    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'p_name',
        'p_description',
        'c_id',
        'p_type',
        'prix',
        'quantite_stock',
        'p_status',
        'est_en_promotion',
        'prix_promotionnel',
        'date_debut_promotion',
        'date_fin_promotion',
        'p_image'
    ];

    protected $casts = [
        'prix' => 'decimal:2',
        'prix_promotionnel' => 'decimal:2',
        'est_en_promotion' => 'boolean',
        'date_debut_promotion' => 'datetime',
        'date_fin_promotion' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // Relation avec l'utilisateur
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relation avec la catégorie
    public function categorie()
    {
        return $this->belongsTo(Categorie::class, 'c_id');
    }
}
