<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LivreurController;
use App\Http\Controllers\TypeProduitController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\LivraisonController;
use App\Http\Controllers\AuthController;


// Authentification
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

// Route protégée (nécessite le token)
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Routes spécifiques AVANT les apiResource
Route::get('produits/search', [ProduitController::class, 'search'])->name('produits.search');
Route::get('commandes/search', [CommandeController::class, 'search'])->name('commandes.search');
Route::get('livraisons/search', [LivraisonController::class, 'search'])->name('livraisons.search');
Route::put('livraisons/{id}/statut', [LivraisonController::class, 'updateStatut'])->name('livraisons.updateStatut');

// Routes ressources API
Route::apiResource('users', UserController::class);
Route::apiResource('livreurs', LivreurController::class);
Route::apiResource('type-produits', TypeProduitController::class);
Route::apiResource('categories', CategorieController::class);
Route::apiResource('produits', ProduitController::class);
Route::apiResource('commandes', CommandeController::class);
Route::apiResource('livraisons', LivraisonController::class);
