<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\API\BaseController;
use App\Http\Requests\API\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class AuthController extends BaseController
{
    /**
     * Connexion de l'utilisateur
     *
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return $this->error('Mauvais identifiants', 401);
        }

        return $this->success([
            'token' => 'Bearer ' . $user->createToken('auth_token')->plainTextToken,
            'expires_at' => Carbon::now()->addMinutes(config('sanctum.expiration'))->timestamp,
        ], 'Utilisateur connecté avec succès.');
    }

    /**
     * Déconnexion de l'utilisateur
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->tokens()->delete();

        return $this->success([], 'Utilisateur déconnecté avec succès.');
    }

    /**
     * Récupération de l'utilisateur connecté
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getAuthenticatedUser(Request $request): JsonResponse
    {
        $user = $request->user();
        $user->load(
            'administrativeEmployee',
            'learner',
            'teacher.requests.timeslot.room', 'teacher.requests.administrativeEmployee',
            'conversations.messages.sender',
            'conversations.teacher.user'
        );

        return $this->success($user->toArray(), 'Utilisateur récupéré avec succès.');
    }
}
