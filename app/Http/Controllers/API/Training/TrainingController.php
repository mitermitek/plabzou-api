<?php

namespace App\Http\Controllers\API\Training;

use App\Http\Controllers\API\BaseController;
use App\Http\Requests\API\Training\TrainingRequest;
use App\Models\Training;
use App\Services\Training\TrainingService;
use Exception;
use Illuminate\Http\JsonResponse;

class TrainingController extends BaseController
{
    public function index(): JsonResponse
    {
        $trainings = TrainingService::getTrainings();

        return $this->success($trainings->toArray(), 'Formations récupérées avec succès.');
    }

    /**
     * @throws Exception
     */
    public function store(TrainingRequest $request): JsonResponse
    {
        $training = TrainingService::createTraining($request->validated());

        return $this->success($training->toArray(), 'Formation créée avec succès.');
    }

    public function show(Training $training): JsonResponse
    {
        $training->load(
            'teachers',
            'categories',
            'courses'
        );

        return $this->success($training->toArray(), 'Formation récupérée avec succès.');
    }

    /**
     * @throws Exception
     */
    public function update(TrainingRequest $request, Training $training): JsonResponse
    {
        $training = TrainingService::updateTraining($training, $request->validated());

        return $this->success($training->toArray(), 'Formation mise à jour avec succès.');
    }

    public function destroy(Training $training): JsonResponse
    {
        $training->delete();

        return $this->success([], 'Formation supprimée avec succès.');
    }
}
