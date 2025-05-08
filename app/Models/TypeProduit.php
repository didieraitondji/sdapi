<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeProduit extends Model
{
    use HasFactory;

    // Table associée à ce modèle
    protected $table = 'type_produit';

    // Attributs qui peuvent être assignés en masse
    protected $fillable = [
        'tp_name',
        'tp_description',
    ];

    // Les timestamps sont gérés automatiquement (created_at, updated_at)
    public $timestamps = true;
}
