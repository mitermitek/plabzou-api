<?php

namespace App\Services\Course;

use App\Models\Course;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class CourseService
{
    /**
     * Récuperer la liste des cursus
     *
     * @return Collection
     */
    public static function getCourses(): Collection
    {
        return Course::all();
    }

    /**
     * Enregistrer un nouveau cursus
     *
     * @param array $data
     * @return Course
     *
     * @throws Exception
     */
    public static function createCourse(array $data): Course
    {
        DB::beginTransaction();
        try {
            $course = Course::create(self::formatCourseData($data));
            // Association des formations suivies
            $course->trainings()->attach(Collection::make($data['trainings'])->pluck('id'));
            $course->save();
            DB::commit();

            return $course;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Formater les données du cursus
     *
     * @param array $data
     * @return array
     */
    private static function formatCourseData(array $data): array
    {
        return [
            'name' => $data['name'],
        ];
    }

    /**
     * Récuper un cursus à partir de son ID
     *
     * @param int $id
     * @return Course
     */
    public static function findCourseById(int $id): Course
    {
        return Course::findOrFail($id);
    }

    /**
     * Mettre à jour les informations du cursus
     *
     * @param Course $course
     * @param array $data
     * @return Course
     * @throws Exception
     */
    public static function updateCourse(Course $course, array $data): Course
    {
        DB::beginTransaction();
        try {
            $course->update(self::formatCourseData($data));

            // Synchronisation des formations suivies (suppression ou ajout)
            $course->trainings()->sync(Collection::make($data['trainings'])->pluck('id'));
            $course->save();
            DB::commit();

            return $course;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Supprimer un cursus
     *
     * @param Course $course
     * @return void
     */
    public static function deleteCourse(Course $course): void
    {
        $course->delete();
    }
}
