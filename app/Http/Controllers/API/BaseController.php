<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class BaseController extends Controller
{
    /**
     * Permet de retourner une réponse JSON de succès
     *
     * @param array $data
     * @param string $message
     * @param int $code
     * @return JsonResponse
     */
    public function success(array $data, string $message, int $code = 200): JsonResponse
    {
        return $this->response(true, $data, $message, $code);
    }

    /**
     * Permet de retourner une réponse JSON d'erreur
     *
     * @param string $message
     * @param int $code
     * @return JsonResponse
     */
    public function error(string $message, int $code = 500): JsonResponse
    {
        return $this->response(false, [], $message, $code);
    }

    /**
     * Permet de définir un format de réponse JSON pour toutes les routes de l'API
     *
     * @param bool $success
     * @param array $data
     * @param string $message
     * @param int $code
     * @return JsonResponse
     */
    private function response(bool $success, array $data, string $message, int $code = 200): JsonResponse
    {
        return response()->json([
            'success' => $success,
            'data' => $data,
            'message' => $message,
        ], $code);
    }
}
