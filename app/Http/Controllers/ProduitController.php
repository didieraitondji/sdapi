<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use Illuminate\Http\Request;

class ProduitController extends Controller
{
    /**
     * Affiche la liste des produits
     */
    public function index()
    {
        $produits = Produit::with(['user', 'categorie'])->get();
        return response()->json($produits);
    }

    /**
     * Enregistre un nouveau produit
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'nullable|exists:users,user_id',
            'p_name' => 'required|string|max:255',
            'p_description' => 'nullable|string',
            'c_id' => 'required|exists:categories,c_id',
            'p_type' => 'required|string|max:255',
            'prix' => 'required|numeric|min:0',
            'quantite_stock' => 'required|integer|min:0',
            'p_status' => 'nullable|in:Disponible,Indisponible,En rupture',
            'est_en_promotion' => 'nullable|boolean',
            'prix_promotionnel' => 'nullable|numeric|min:0',
            'date_debut_promotion' => 'nullable|date',
            'date_fin_promotion' => 'nullable|date|after_or_equal:date_debut_promotion',
            'p_image' => 'nullable|string|max:255'
        ]);

        $produit = Produit::create($validated);
        return response()->json($produit, 201);
    }

    /**
     * Affiche un produit spécifique
     */
    public function show($id)
    {
        $produit = Produit::with(['user', 'categorie'])->findOrFail($id);
        return response()->json($produit);
    }

    /**
     * Met à jour un produit
     */
    public function update(Request $request, $id)
    {
        $produit = Produit::findOrFail($id);

        $validated = $request->validate([
            'user_id' => 'nullable|exists:users,user_id',
            'p_name' => 'sometimes|string|max:255',
            'p_description' => 'nullable|string',
            'c_id' => 'sometimes|exists:categories,c_id',
            'p_type' => 'sometimes|string|max:255',
            'prix' => 'sometimes|numeric|min:0',
            'quantite_stock' => 'sometimes|integer|min:0',
            'p_status' => 'nullable|in:Disponible,Indisponible,En rupture',
            'est_en_promotion' => 'nullable|boolean',
            'prix_promotionnel' => 'nullable|numeric|min:0|required_if:est_en_promotion,true',
            'date_debut_promotion' => 'nullable|date|required_with:prix_promotionnel',
            'date_fin_promotion' => 'nullable|date|after_or_equal:date_debut_promotion|required_with:prix_promotionnel',
            'p_image' => 'nullable|string|max:255'
        ]);

        $produit->update($validated);
        return response()->json($produit);
    }

    /**
     * Supprime un produit
     */
    public function destroy($id)
    {
        $produit = Produit::findOrFail($id);
        $produit->delete();
        return response()->json(null, 204);
    }

    /**
     * Recherche des produits
     */
    public function search(Request $request)
    {
        $query = Produit::query()->with(['user', 'categorie']);

        if ($request->has('nom')) {
            $query->where('p_name', 'like', '%' . $request->nom . '%');
        }

        if ($request->has('categorie')) {
            $query->where('c_id', $request->categorie);
        }

        if ($request->has('min_price')) {
            $query->where('prix', '>=', $request->min_price);
        }

        if ($request->has('max_price')) {
            $query->where('prix', '<=', $request->max_price);
        }

        if ($request->has('statut')) {
            $query->where('p_status', $request->statut);
        }

        if ($request->has('promotion')) {
            $query->where('est_en_promotion', $request->promotion === 'true');
        }

        $produits = $query->get();
        return response()->json($produits);
    }
}
