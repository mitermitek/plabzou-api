<?php

namespace App\Http\Controllers\API\Status;

use App\Http\Controllers\API\BaseController;
use App\Services\Teacher\TeacherService;
use Illuminate\Http\JsonResponse;

class StatusController extends BaseController
{
    public function index(): JsonResponse
    {
        $statuses = TeacherService::getTeacherStatuses();

        return $this->success($statuses, 'Statuts récupérés avec succès.');
    }
}
