<?php

namespace App\Http\Controllers;

use App\Models\Livraison;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LivraisonController extends Controller
{
    /**
     * Affiche la liste des livraisons
     */
    public function index()
    {
        $livraisons = Livraison::with(['commande', 'user', 'livreur'])->get();
        return response()->json($livraisons);
    }

    /**
     * Enregistre une nouvelle livraison
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'co_id' => 'required|exists:commandes,co_id',
            'user_id' => 'nullable|exists:users,user_id',
            'livreur_id' => 'nullable|exists:livreurs,livreur_id',
            'rue' => 'required|string|max:255',
            'ville' => 'required|string|max:100',
            'code_postal' => 'required|string|max:20',
            'pays' => 'required|string|max:100',
            'livraison_status' => 'nullable|in:En attente,En cours,Livrée,Annulée',
            'date_livraison_estimee' => 'required|date',
            'moyen_transport' => 'nullable|string|max:50',
            'commentaires' => 'nullable|string'
        ]);

        $livraison = Livraison::create($validated);

        // Mettre à jour le statut de livraison dans la commande associée
        if ($livraison->commande) {
            $livraison->commande->update(['livraison_creer' => true]);
        }

        return response()->json($livraison->load(['commande', 'user', 'livreur']), 201);
    }

    /**
     * Affiche une livraison spécifique
     */
    public function show($id)
    {
        $livraison = Livraison::with(['commande', 'user', 'livreur'])->findOrFail($id);
        return response()->json($livraison);
    }

    /**
     * Met à jour une livraison
     */
    public function update(Request $request, $id)
    {
        $livraison = Livraison::findOrFail($id);

        $validated = $request->validate([
            'livreur_id' => 'nullable|exists:livreurs,livreur_id',
            'livraison_status' => 'sometimes|in:En attente,En cours,Livrée,Annulée',
            'date_livraison_effective' => 'nullable|date|required_if:livraison_status,Livrée',
            'moyen_transport' => 'nullable|string|max:50',
            'commentaires' => 'nullable|string'
        ]);

        // Si la livraison est marquée comme livrée, enregistrer la date effective
        if (isset($validated['livraison_status']) && $validated['livraison_status'] === 'Livrée') {
            if ($validated['livraison_status'] === 'Livrée' && empty($validated['date_livraison_effective'])) {
                $validated['date_livraison_effective'] = now();
            }
        }

        $livraison->update($validated);

        return response()->json($livraison->load(['commande', 'user', 'livreur']));
    }

    /**
     * Supprime une livraison
     */
    public function destroy($id)
    {
        $livraison = Livraison::findOrFail($id);
        $livraison->delete();
        return response()->json(null, 204);
    }

    /**
     * Recherche des livraisons
     */
    public function search(Request $request)
    {
        $query = Livraison::query()->with(['commande', 'user', 'livreur']);

        if ($request->has('co_id')) {
            $query->where('co_id', $request->commande_id);
        }

        if ($request->has('statut')) {
            $query->where('livraison_status', $request->statut);
        }

        if ($request->has('livreur_id')) {
            $query->where('livreur_id', $request->livreur_id);
        }

        if ($request->has('date_debut')) {
            $query->where('created_at', '>=', $request->date_debut);
        }

        if ($request->has('date_fin')) {
            $query->where('created_at', '<=', $request->date_fin);
        }

        $livraisons = $query->orderBy('created_at', 'desc')->get();
        return response()->json($livraisons);
    }

    /**
     * Mettre à jour le statut de livraison
     */
    public function updateStatut(Request $request, $id)
    {
        $request->validate([
            'livraison_status' => 'required|in:En attente,En cours,Livrée,Annulée'
        ]);

        $livraison = Livraison::findOrFail($id);
        $livraison->livraison_status = $request->statut_livraison;

        if ($request->livraison_status === 'Livrée') {
            $livraison->date_livraison_effective = now();
        }

        $livraison->save();

        return response()->json($livraison);
    }
}
