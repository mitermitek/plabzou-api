<?php

use App\Http\Controllers\API\Auth\AuthController;
use App\Http\Controllers\API\Building\BuildingController;
use App\Http\Controllers\API\Category\CategoryController;
use App\Http\Controllers\API\City\CityController;
use App\Http\Controllers\API\Conversation\ConversationController;
use App\Http\Controllers\API\Course\CourseController;
use App\Http\Controllers\API\Import\ImportController;
use App\Http\Controllers\API\Learner\LearnerController;
use App\Http\Controllers\API\Message\MessageController;
use App\Http\Controllers\API\Mode\ModeController;
use App\Http\Controllers\API\Place\PlaceController;
use App\Http\Controllers\API\Promotion\PromotionController;
use App\Http\Controllers\API\Request\RequestController;
use App\Http\Controllers\API\Room\RoomController;
use App\Http\Controllers\API\Status\StatusController;
use App\Http\Controllers\API\Teacher\TeacherController;
use App\Http\Controllers\API\Timeslot\TimeslotController;
use App\Http\Controllers\API\Training\TrainingController;
use App\Http\Controllers\API\User\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::prefix('auth')->group(static function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::middleware('auth:sanctum')->post('logout', [AuthController::class, 'logout']);
    Route::middleware('auth:sanctum')->get('me', [AuthController::class, 'getAuthenticatedUser']);
});

Route::middleware('auth:sanctum')->group(static function () {
    Route::patch('users/me', [UserController::class, 'updateCurrent']);

    Route::apiResource('users', UserController::class)->middleware('role:administrativeEmployee');
    Route::apiResource('promotions', PromotionController::class)->middleware('role:administrativeEmployee');
    Route::apiResource('messages', MessageController::class)->middleware('role:administrativeEmployee,teacher');
    Route::apiResource('conversations', ConversationController::class)->middleware('role:administrativeEmployee,teacher');
    Route::apiResource('categories', CategoryController::class)->middleware('role:administrativeEmployee');
    Route::apiResource('courses', CourseController::class)->middleware('role:administrativeEmployee');
    Route::apiResource('trainings', TrainingController::class)->middleware('role:administrativeEmployee');
    Route::apiResource('timeslots', TimeslotController::class)->middleware('role:administrativeEmployee');
    Route::apiResource('requests', RequestController::class)->only('index', 'store', 'show', 'destroy')->middleware('role:administrativeEmployee');
    Route::apiResource('requests', RequestController::class)->only('update')->middleware('role:administrativeEmployee,teacher');
    Route::apiResource('cities', CityController::class)->middleware('role:administrativeEmployee');
    Route::apiResource('places', PlaceController::class)->middleware('role:administrativeEmployee');
    Route::apiResource('buildings', BuildingController::class)->middleware('role:administrativeEmployee');
    Route::apiResource('rooms', RoomController::class)->middleware('role:administrativeEmployee');

    Route::get('statuses', [StatusController::class, 'index'])->middleware('role:administrativeEmployee');
    Route::get('modes', [ModeController::class, 'index'])->middleware('role:administrativeEmployee');

    Route::prefix('learners')->controller(LearnerController::class)->group(static function () {
        Route::get('', 'index');
        Route::get('{learner}', 'show');
    })->middleware('role:administrativeEmployee,learner');

    Route::prefix('teachers')->controller(TeacherController::class)->group(static function () {
        Route::get('', 'index');
        Route::get('{teacher}', 'show');
    })->middleware('role:administrativeEmployee,teacher');

    Route::prefix('imports')->controller(ImportController::class)->group(static function () {
        Route::post('trainings', 'importTrainings');
        Route::post('teachers', 'importTeachers');
        Route::post('administrative-employees', 'importAdministrativeEmployees');
        Route::post('rooms', 'importRooms');
        Route::post('promotions', 'importPromotions');
        Route::post('learners', 'importLearners');
    })->middleware('role:administrativeEmployee');
});
