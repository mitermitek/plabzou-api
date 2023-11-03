<?php
namespace App\Services\Request;

use App\Models\Request;
use App\Models\Timeslot;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use InvalidArgumentException;

class RequestService
{

    /**
     * Permet de récupérer la liste des requêtes avec le formateur, l'admin et le créneau associé
     * y compris les demandes annulées
     *
     * @return Builder[]|Collection
     */
    public static function getRequestsWithRelations(): Collection|array
    {
        return Request::with('teacher', 'timeslot.training', 'administrativeEmployee')->withTrashed()->orderBy('created_at', 'desc')->get();
    }

    /**
     * Permet de créer les demandes à partir de la création du créneau
     *
     * @param Timeslot $timeslot
     * @return void
     */
    public static function createRequests(Timeslot $timeslot): void
    {
        $timeslot->load('teachers');
        $teachers = $timeslot->teachers;

        foreach ($teachers as $teacher) {

            Request::create([
                'teacher_id' => $teacher->user_id,
                'timeslot_id' => $timeslot->id,
                'administrative_employee_id' => Auth::id()
            ]);
        }
    }

    /**
     * Permet de mettre à jour une demande
     *
     * @param Request $request
     * @param array $validated
     * @return Request
     */
    public static function updateRequest(Request $request, array $validated): Request
    {

        if (is_null($validated['is_approved_by_teacher']) && !is_null($validated['is_approved_by_admin'])) {
            throw new InvalidArgumentException("Vous ne pouvez pas valider/rejetter cette demande tant que le formateur n'y a pas répondu");
        }

        if ($validated['is_approved_by_teacher'] === false && (isset($validated['is_approved_by_admin']) && $validated['is_approved_by_admin'] === true)) {
            throw new InvalidArgumentException("Vous ne pouvez pas valider la demande de créneaux, le formateur l'a refusée");
        }

        $request->update($validated);
        return $request;
    }

    public static function checkIfRequestExists(int $timeslotId, int $teacherId)
    {
        return Request::where('timeslot_id', '=', $timeslotId)
            ->where('teacher_id', '=', $teacherId)
            ->withTrashed()
            ->first();
    }

    /**
     * Permet de créer une nouvelle demande
     *
     * @param array $validated
     * @return mixed
     * @throws ValidationException
     */
    public static function createRequest(array $validated): mixed
    {
        $existingRequest = RequestService::checkIfRequestExists($validated['timeslot_id'], $validated['teacher_id']);

        if ($existingRequest && $existingRequest->deleted_at) {
            $timeslot = Timeslot::find($validated['timeslot_id']);
            $timeslot->teachers()->attach($validated['teacher_id']);
            $existingRequest->restore();
            return $existingRequest;
        }

        if ($existingRequest) {
            throw new InvalidArgumentException('Une demande existe déjà sur ce créneau pour ce formateur');
        }

        if (isset($validated['is_approved_by_admin'])) {
            throw new InvalidArgumentException("Vous ne pouvez pas envoyer de réponse avant que le formateur est répondu");
        }

        $request = Request::create($validated);
        $timeslot = Timeslot::find($validated['timeslot_id']);
        $timeslot->teachers()->attach($validated['teacher_id']);

        return $request;
    }

    /**
     * Supprimer une demande (annulation car suppression partielle)
     *
     * @param Request $request
     * @return void
     */
    public static function deleteRequest(Request $request): void
    {
        $timeslot = Timeslot::find($request->timeslot_id);
        $timeslot->teachers()->detach($request->teacher_id);
        $request->delete();
    }

    /**
     * Mettre à jour les demandes suite à une modification du créneau
     *
     * @param Collection $oldTeachers
     * @param Collection $newTeachers
     * @param Timeslot $timeslot
     * @return void
     * @throws ValidationException
     */
    public static function updateRequestsAfterUpdateTimeslot(Collection $oldTeachers, Collection $newTeachers, Timeslot $timeslot): void
    {

        $newTeachersIds = $newTeachers->pluck('user_id');
        //On suppr les requests pour les formateurs suppr de la liste
        foreach ($oldTeachers as $oldTeacher) {
            if (!$newTeachersIds->contains($oldTeacher->user_id)) {
                $oldTeacher->requests()->where('timeslot_id', $timeslot->id)->first()->delete();
            }
        }

        //On créé les nouvelles pour ceux ajoutés
        foreach ($newTeachers as $newTeacher) {
            $existingRequest = RequestService::checkIfRequestExists($timeslot->id, $newTeacher->user_id);
            if ($existingRequest && $existingRequest->deleted_at) {
                $existingRequest->restore();
            }

            if (!$existingRequest) {
                RequestService::createRequest([
                    'teacher_id' => $newTeacher->user_id,
                    'administrative_employee_id' => Auth::id(),
                    'timeslot_id' => $timeslot->id
                ]);
            }
        }
    }
}
