<?php

namespace App\Http\Controllers\API\Import;

use App\Http\Controllers\API\BaseController;
use App\Http\Requests\API\Import\ImportRequest;
use App\Imports\AdministrativeEmployeesImport;
use App\Imports\LearnersImport;
use App\Imports\PromotionsImport;
use App\Imports\RoomsImport;
use App\Imports\TeachersImport;
use App\Imports\TrainingsImport;
use Exception;
use Illuminate\Http\JsonResponse;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends BaseController
{
    /**
     * Importer les formations
     *
     * @param ImportRequest $request
     * @return JsonResponse
     */
    public function importTrainings(ImportRequest $request): JsonResponse
    {
        try {
            Excel::import(new TrainingsImport, $request->file('import_file'));

            return $this->success([], "L'import des formations a réussi");
        } catch (Exception $e) {
            return $this->error("Erreur lors de l'import, verifiez le contenu du fichiers.");
        }
    }

    /**
     * Importer les formateurs
     *
     * @param ImportRequest $request
     * @return JsonResponse
     */
    public function importTeachers(ImportRequest $request): JsonResponse
    {
        try {
            Excel::import(new TeachersImport, $request->file('import_file'));

            return $this->success([], "L'import des formateurs a réussi");
        } catch (Exception $e) {
            return $this->error("Erreur lors de l'import, verifiez le contenu du fichiers.");
        }
    }

    /**
     * Importer les employés administratifs
     *
     * @param ImportRequest $request
     * @return JsonResponse
     */
    public function importAdministrativeEmployees(ImportRequest $request): JsonResponse
    {
        try {
            Excel::import(new AdministrativeEmployeesImport, $request->file('import_file'));

            return $this->success([], "L'import des employés administratifs a réussi");
        } catch (Exception $e) {
            return $this->error("Erreur lors de l'import, verifiez le contenu du fichiers.");
        }
    }

    /**
     * Importer les salles
     *
     * @param ImportRequest $request
     * @return JsonResponse
     */
    public function importRooms(ImportRequest $request): JsonResponse
    {
        try {
            Excel::import(new RoomsImport, $request->file('import_file'));

            return $this->success([], "L'import des salles a réussi");
        } catch (Exception $e) {
            return $this->error("Erreur lors de l'import, verifiez le contenu du fichiers.");
        }
    }

    /**
     * Importer les promotions
     *
     * @param ImportRequest $request
     * @return JsonResponse
     */
    public function importPromotions(ImportRequest $request): JsonResponse
    {
        try {
            Excel::import(new PromotionsImport(), $request->file('import_file'));

            return $this->success([], "L'import des promotions a réussi");
        } catch (Exception $e) {
            return $this->error("Erreur lors de l'import, verifiez le contenu du fichiers.");
        }
    }

    /**
     * Importer les apprenants
     *
     * @param ImportRequest $request
     * @return JsonResponse
     */
    public function importLearners(ImportRequest $request): JsonResponse
    {
        try {
            Excel::import(new LearnersImport, $request->file('import_file'));

            return $this->success([], "L'import des apprenants a réussi");
        } catch (Exception $e) {
            return $this->error("Erreur lors de l'import, verifiez le contenu du fichiers.");
        }
    }

}
