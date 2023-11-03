<?php

namespace App\Services\User;

use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class UserService
{
    /**
     * Récupérer la liste des utilisateurs
     *
     * @return Collection
     */
    public static function getUsers(): Collection
    {
        return User::with(['administrativeEmployee', 'teacher', 'learner'])->get();
    }

    /**
     * Enregistrer un nouvel utilisateur
     *
     * @param array $data
     * @return User
     */
    public static function createUser(array $data): User
    {
        $user = User::create(self::formatUserData($data));
        self::fillUser($user, $data);

        return $user;
    }

    /**
     * Formater les données
     *
     * @param array $data
     * @return array
     */
    private static function formatUserData(array $data): array
    {
        $data['first_name'] = ucwords(strtolower($data['first_name']));
        $data['last_name'] = strtoupper($data['last_name']);
        $data['email'] = strtolower($data['email']);

        if (empty($data['password'])) {
            unset($data['password']);
        } else {
            $data['password'] = bcrypt($data['password']);
        }

        return $data;
    }

    /**
     * Remplire l'instance à partir des données fournies
     *
     * @param User $user
     * @param array $data
     * @return void
     */
    private static function fillUser(User $user, array $data): void
    {
        if (isset($data['is_super_admin'])) {
            $user->administrativeEmployee()?->onlyTrashed()?->restore();
            $user->administrativeEmployee()->updateOrCreate(['user_id' => $user->id], ['is_super_admin' => $data['is_super_admin']]);
        } else {
            $user->administrativeEmployee()->delete();
        }

        if (isset($data['teacher_status'])) {
            $user->teacher()?->onlyTrashed()?->restore();
            $user->teacher()->updateOrCreate(['user_id' => $user->id], ['status' => $data['teacher_status']]);
        } else {
            $user->teacher()->delete();
        }

        if (isset($data['learner_mode'])) {
            $user->learner()?->onlyTrashed()?->restore();
            $user->learner()->updateOrCreate(['user_id' => $user->id], ['mode_id' => $data['learner_mode']]);
        } else {
            $user->learner()->delete();
        }
    }

    /**
     * Mettre à jour les informations de l'utilisateur
     *
     * @param User $user
     * @param array $data
     * @return User
     */
    public static function updateUser(User $user, array $data): User
    {
        $user->fill(self::formatUserData($data));
        self::fillUser($user, $data);
        $user->save();

        return $user;
    }

    /**
     * Mettre à jour le profil de l'utilisateur
     *
     * @param array $data
     * @return User
     */
    public static function updateCurrentUSer(array $data): User
    {
        $user = Auth::user();

        if (array_key_exists('password', $data))
            $data['password'] = bcrypt($data['password']);

        $user->update($data);

        return $user;
    }
}
