<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    use HasFactory;

    protected $table = 'categories';
    protected $primaryKey = 'c_id';
    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'tp_id',
        'c_name',
        'c_description',
        'c_image',
        'c_status'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'c_status' => 'string'
    ];

    // Relation avec l'utilisateur
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relation avec le type de produit
    public function typeProduit()
    {
        return $this->belongsTo(TypeProduit::class, 'tp_id');
    }
}
