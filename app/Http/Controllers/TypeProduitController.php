<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TypeProduit;

class TypeProduitController extends Controller
{
    /**
     * Affiche la liste des types de produits.
     */
    public function index()
    {
        $types = TypeProduit::all();
        return response()->json($types);
    }

    /**
     * Affiche un formulaire de création (si tu utilises Blade).
     */
    public function create()
    {
        return view('type_produits.create');
    }

    /**
     * Enregistre un nouveau type de produit dans la base.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tp_name' => 'required|string|max:255',
            'tp_description' => 'nullable|string',
        ]);

        $typeProduit = TypeProduit::create($request->all());
        return response()->json($typeProduit, 201);
    }

    /**
     * Affiche un type de produit spécifique.
     */
    public function show(string $id)
    {
        $typeProduit = TypeProduit::findOrFail($id);
        return response()->json($typeProduit);
    }

    /**
     * Affiche un formulaire d'édition d'un type de produit.
     */
    public function edit(TypeProduit $typeProduit)
    {
        return view('type_produits.edit', compact('typeProduit'));
    }

    /**
     * Met à jour un type de produit existant.
     */
    public function update(Request $request, string $id)
    {
        $typeProduit = TypeProduit::findOrFail($id);

        $request->validate([
            'tp_name' => 'required|string|max:255',
            'tp_description' => 'nullable|string',
        ]);

        $typeProduit->update($request->all());
        return response()->json($typeProduit);
    }

    /**
     * Supprime un type de produit.
     */
    public function destroy(string $id)
    {
        $typeProduit = TypeProduit::findOrFail($id);
        $typeProduit->delete();
        return response()->json(['message' => 'Type de produit supprimé avec succès.']);
    }
}
