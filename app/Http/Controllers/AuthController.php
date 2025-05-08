<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{
    // Enregistrement d'un nouvel utilisateur
    public function register(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'sexe' => 'required|string|max:5',
            'email' => 'nullable|email|unique:users,email',
            'telephone' => 'required|string|max:20',
            'user_password' => 'required|string|min:6',
            'rue' => 'nullable|string|max:255',
            'ville' => 'nullable|string|max:100',
            'code_postal' => 'nullable|string|max:20',
            'pays' => 'nullable|string|max:100',
            'notification_option' => 'nullable|in:sms,email,none',
            'picture' => 'nullable|string|max:255',
            'user_type' => 'nullable|in:admin,user,Particulier,Bars,Resto,Buvette',
        ]);

        $user = User::create($validated);

        $token = $user->createToken('API Token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
        ], 201);
    }

    // Connexion de l'utilisateur
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email_or_phone' => 'required|string',
            'user_password' => 'required|string',
        ]);

        $user = User::where('email', $credentials['email_or_phone'])
            ->orWhere('telephone', $credentials['email_or_phone'])
            ->first();

        // Vérifier si l'utilisateur existe et si le mot de passe est correct
        if (!$user || !\Illuminate\Support\Facades\Hash::check($credentials['user_password'], $user->user_password)) {
            return response()->json(['message' => 'Identifiants invalides'], 401);
        }

        // Vérifier si l'utilisateur est déjà connecté
        // ceci va empcher de se connecter plusieurs fois, donc sur plusieurs appareils
        /*if ($user->is_connected) {
            // Si l'utilisateur est déjà connecté, ne pas générer un nouveau token
            return response()->json([
                'message' => 'Vous êtes déjà connecté.',
                'user' => $user
            ], 200);
        }
        */
        // Si l'utilisateur n'est pas connecté, on le connecte
        $user->is_connected = true;
        $user->save();

        // Générer un nouveau token
        $token = $user->createToken('API Token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
        ], 200);
    }

    // Déconnexion
    public function logout(Request $request)
    {
        $user = $request->user();

        // Mettre à jour l'état de l'utilisateur (deconnecté)
        $user->is_connected = false;
        $user->save();

        // Supprimer le token actuel
        $user->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Déconnexion réussie',
        ]);
    }
}
