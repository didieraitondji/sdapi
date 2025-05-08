<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Livreur;

class LivreurController extends Controller
{
    /**
     * Affiche la liste des livreurs.
     */
    public function index()
    {
        $livreurs = Livreur::all();
        return response()->json($livreurs);
    }

    /**
     * Affiche le formulaire de création d’un livreur (si tu utilises Blade).
     */
    public function create()
    {
        return view('livreurs.create');
    }

    /**
     * Enregistre un nouveau livreur dans la base.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_users' => 'required|exists:users,id_users',
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'sexe' => 'required|string|max:5',
            'email' => 'nullable|email|unique:livreurs,email',
            'telephone' => 'required|string|max:20',
            'livreur_password' => 'required|string|min:6',
        ]);

        $livreur = Livreur::create($request->all());
        return response()->json($livreur, 201);
    }

    /**
     * Affiche un livreur spécifique.
     */
    public function show(string $id)
    {
        $livreur = Livreur::findOrFail($id);
        return response()->json($livreur);
    }

    /**
     * Affiche le formulaire d’édition d’un livreur.
     */
    public function edit(Livreur $livreur)
    {
        return view('livreurs.edit', compact('livreur'));
    }

    /**
     * Met à jour un livreur existant.
     */
    public function update(Request $request, string $id)
    {
        $livreur = Livreur::findOrFail($id);

        $request->validate([
            'email' => 'nullable|email|unique:livreurs,email,' . $livreur->livreur_id . ', livreur_id',
            'telephone' => 'required|string|max:20',
        ]);

        $livreur->update($request->all());
        return response()->json($livreur);
    }

    /**
     * Supprime un livreur.
     */
    public function destroy(string $id)
    {
        $livreur = Livreur::findOrFail($id);
        $livreur->delete();
        return response()->json(['message' => 'Livreur supprimé avec succès.']);
    }
}
