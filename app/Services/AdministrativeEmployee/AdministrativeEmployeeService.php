<?php

namespace App\Services\AdministrativeEmployee;

use App\Models\AdministrativeEmployee;
use Illuminate\Support\Collection;

class AdministrativeEmployeeService
{
    /**
     * Permet de récupérer tous les identifiants des admins
     *
     * @return Collection
     */
    public static function getAllAdministrativeEmployeeId(): Collection
    {
        return AdministrativeEmployee::all()->pluck('user_id');
    }

}
