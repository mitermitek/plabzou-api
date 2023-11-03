<?php

namespace App\Http\Controllers\API\Timeslot;

use App\Http\Controllers\API\BaseController;
use App\Http\Requests\API\Timeslot\TimeslotRequest;
use App\Models\Timeslot;
use App\Services\Timeslot\TimeslotService;
use Exception;
use Illuminate\Http\JsonResponse;
use InvalidArgumentException;

class TimeslotController extends BaseController
{
    public function index(): JsonResponse
    {
        $timeslots = TimeslotService::getTimeslots();
        return $this->success($timeslots->toArray(), 'Créneaux récupérés avec succès.');
    }

    public function store(TimeslotRequest $request): JsonResponse
    {
        $validatedData = $request->validated();

        try {
            TimeslotService::checkTimeslotAvailability($validatedData);

            $timeslot = TimeslotService::createTimeslot($validatedData);

            return $this->success($timeslot->toArray(), 'Créneau créé avec succès, demandes envoyées aux formateurs.');
        } catch (InvalidArgumentException $e) {
            return $this->error($e->getMessage(), 400);
        } catch (Exception $e) {
            return $this->error('Une erreur est survenue lors de la création du créneau.');
        }
    }

    public function show(Timeslot $timeslot)
    {
        $timeslot->load(
            'room',
            'requests',
            'training',
            'teachers.requests',
            'learners',
            'promotions.learners', 'promotions.course'
        );

        return $this->success($timeslot->toArray(), 'Créneau récupéré avec succès.');
    }

    public function update(TimeslotRequest $request, Timeslot $timeslot): JsonResponse
    {
        $validatedData = $request->validated();

        try {
            TimeslotService::checkTimeslotAvailability($validatedData, $timeslot);

            $timeslot = TimeslotService::updateTimeslot($timeslot, $validatedData);

            return $this->success($timeslot->toArray(), 'Créneau mis à jour avec succès.');
        } catch (InvalidArgumentException $e) {
            return $this->error($e->getMessage(), 400);
        } catch (Exception $e) {
            return $this->error('Une erreur est survenue lors de la modification du créneau.');
        }
    }

    public function destroy(Timeslot $timeslot): JsonResponse
    {
        TimeslotService::deleteTimeslot($timeslot);

        return $this->success([], 'Créneau supprimé avec succès.');
    }
}
