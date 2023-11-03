<?php

namespace App\Http\Controllers\API\Course;

use App\Http\Controllers\API\BaseController;
use App\Http\Requests\API\Course\CourseRequest;
use App\Models\Course;
use App\Services\Course\CourseService;
use Exception;
use Illuminate\Http\JsonResponse;

class CourseController extends BaseController
{
    public function index(): JsonResponse
    {
        $courses = CourseService::getCourses();

        return $this->success($courses->toArray(), 'Cursus récupérés avec succès.');
    }

    /**
     * @throws Exception
     */
    public function store(CourseRequest $request): JsonResponse
    {
        $course = CourseService::createCourse($request->validated());

        return $this->success($course->toArray(), 'Cursus créé avec succès.');
    }

    public function show(Course $course): JsonResponse
    {
        $course->load('trainings');

        return $this->success($course->toArray(), 'Cursus récupéré avec succès.');
    }

    public function update(CourseRequest $request, Course $course): JsonResponse
    {
        $course = CourseService::updateCourse($course, $request->validated());

        return $this->success($course->toArray(), 'Cursus mis à jour avec succès.');
    }

    public function destroy(Course $course): JsonResponse
    {
        CourseService::deleteCourse($course);

        return $this->success([], 'Cursus supprimé avec succès.');
    }
}
