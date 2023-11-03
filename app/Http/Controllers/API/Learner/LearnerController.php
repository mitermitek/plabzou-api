<?php

namespace App\Http\Controllers\API\Learner;

use App\Http\Controllers\API\BaseController;
use App\Models\Learner;
use App\Services\Learner\LearnerService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LearnerController extends BaseController
{
    public function index(Request $request): JsonResponse
    {
        $learners = LearnerService::getLearners($request->all());

        return $this->success($learners->toArray(), 'Apprenants récupérés avec succès.');
    }

    public function show(Learner $learner): JsonResponse
    {
        $learner->load(
            'timeslots.promotions',
            'timeslots.training.categories',
            'timeslots.learners',
            'timeslots.teachers.requests',
            'timeslots.room',
        );

        return $this->success($learner->toArray(), 'Apprenant récupéré avec succès.');
    }
}
