<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommandeController extends Controller
{
    /**
     * Affiche la liste des commandes
     */
    public function index()
    {
        $commandes = Commande::with(['user', 'produits'])->get();
        return response()->json($commandes);
    }

    /**
     * Enregistre une nouvelle commande
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,user_id',
            'co_total' => 'required|numeric|min:0',
            'co_status' => 'nullable|in:En attente,Payée,Annulée,Livrée',
            'moyen_paiement' => 'required|in:Carte bancaire,Espèces,PayPal,Mobile Money',
            'est_a_livrer' => 'nullable|boolean',
            'livraison_creer' => 'nullable|boolean',
            'rue_livraison' => 'required|string|max:255',
            'ville_livraison' => 'required|string|max:100',
            'code_postal_livraison' => 'nullable|string|max:20',
            'pays_livraison' => 'required|string|max:100',
            'commentaires' => 'nullable|string',
            'produits' => 'required|array',
            'produits.*.id_produit' => 'required|exists:produits,p_id',
            'produits.*.quantite' => 'required|integer|min:1',
            'produits.*.prix_unitaire' => 'required|numeric|min:0',
            'produits.*.remise' => 'nullable|numeric|min:0'
        ]);

        DB::beginTransaction();

        try {
            // Création de la commande
            $commande = Commande::create([
                'user_id' => $validated['user_id'],
                'co_total' => $validated['co_total'],
                'co_status' => $validated['co_status'] ?? 'En attente',
                'moyen_paiement' => $validated['moyen_paiement'],
                'est_a_livrer' => $validated['est_a_livrer'] ?? true,
                'livraison_creer' => $validated['livraison_creer'] ?? false,
                'rue_livraison' => $validated['rue_livraison'],
                'ville_livraison' => $validated['ville_livraison'],
                'code_postal_livraison' => $validated['code_postal_livraison'] ?? null,
                'pays_livraison' => $validated['pays_livraison'],
                'commentaires' => $validated['commentaires'] ?? null
            ]);

            // Ajout des produits à la commande
            foreach ($validated['produits'] as $produit) {
                $commande->produits()->attach($produit['p_id'], [
                    'quantite' => $produit['quantite'],
                    'prix_unitaire' => $produit['prix_unitaire'],
                    'remise' => $produit['remise'] ?? 0
                ]);
            }

            DB::commit();

            return response()->json($commande->load('produits'), 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Erreur lors de la création de la commande: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Affiche une commande spécifique
     */
    public function show($id)
    {
        $commande = Commande::with(['user', 'produits'])->findOrFail($id);
        return response()->json($commande);
    }

    /**
     * Met à jour une commande
     */
    public function update(Request $request, $id)
    {
        $commande = Commande::findOrFail($id);

        $validated = $request->validate([
            'co_status' => 'sometimes|in:En attente,Payée,Annulée,Livrée',
            'livraison_creer' => 'sometimes|boolean',
            'commentaires' => 'nullable|string'
        ]);

        $commande->update($validated);
        return response()->json($commande->load('produits'));
    }

    /**
     * Supprime une commande
     */
    public function destroy($id)
    {
        $commande = Commande::findOrFail($id);
        $commande->produits()->detach();
        $commande->delete();
        return response()->json(null, 204);
    }

    /**
     * Recherche des commandes
     */
    public function search(Request $request)
    {
        $query = Commande::query()->with(['user', 'produits']);

        if ($request->has('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->has('statut')) {
            $query->where('co_status', $request->statut);
        }

        if ($request->has('date_debut')) {
            $query->where('co_date', '>=', $request->date_debut);
        }

        if ($request->has('date_fin')) {
            $query->where('co_date', '<=', $request->date_fin);
        }

        if ($request->has('livraison')) {
            $query->where('est_a_livrer', $request->livraison === 'true');
        }

        $commandes = $query->orderBy('co_date', 'desc')->get();
        return response()->json($commandes);
    }
}
