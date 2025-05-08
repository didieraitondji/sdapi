<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use Illuminate\Http\Request;

class CategorieController extends Controller
{
    /**
     * Affiche la liste des catégories
     */
    public function index()
    {
        $categories = Categorie::with(['user', 'typeProduit'])->get();
        return response()->json($categories);
    }

    /**
     * Enregistre une nouvelle catégorie
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,user_id',
            'tp_id' => 'required|exists:type_produits,id_type_produit',
            'c_name' => 'required|string|max:255',
            'c_description' => 'nullable|string',
            'c_image' => 'nullable|url|max:2083',
            'c_status' => 'nullable|in:Active,Inactive'
        ]);

        $categorie = Categorie::create($validated);
        return response()->json($categorie, 201);
    }

    /**
     * Affiche une catégorie spécifique
     */
    public function show($id)
    {
        $categorie = Categorie::with(['user', 'typeProduit'])->findOrFail($id);
        return response()->json($categorie);
    }

    /**
     * Met à jour une catégorie
     */
    public function update(Request $request, $id)
    {
        $categorie = Categorie::findOrFail($id);

        $validated = $request->validate([
            'user_id' => 'sometimes|exists:users,user_id',
            'tp_id' => 'sometimes|exists:type_produits,tp_id',
            'c_name' => 'sometimes|string|max:255',
            'c_description' => 'nullable|string',
            'c_image' => 'nullable|url|max:2083',
            'c_status' => 'nullable|in:Active,Inactive'
        ]);

        $categorie->update($validated);
        return response()->json($categorie);
    }

    /**
     * Supprime une catégorie
     */
    public function destroy($id)
    {
        $categorie = Categorie::findOrFail($id);
        $categorie->delete();
        return response()->json(null, 204);
    }
}
