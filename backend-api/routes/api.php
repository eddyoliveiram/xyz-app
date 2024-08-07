<?php

use App\Http\Controllers\TrainingController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
use App\Http\Controllers\AuthController;

Route::post('/login', [AuthController::class, 'login']);

// AUTH + ADMIN
Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::get('/trainings', [TrainingController::class, 'index']);
    Route::post('/trainings', [TrainingController::class, 'store']);
    Route::put('/trainings/{training}', [TrainingController::class, 'update']);
    Route::delete('/trainings/{training}', [TrainingController::class, 'destroy']);
    Route::get('/training-summary/{id}', [TrainingController::class, 'getTrainingSummary']);
    Route::get('/subordinate-trainings/{id}', [TrainingController::class, 'getTrainingsBySubordinate']);

    Route::get('/subordinates', [UserController::class, 'index']);
    Route::post('/subordinates', [UserController::class, 'store']);
    Route::put('/subordinates/{user}', [UserController::class, 'update']);
    Route::delete('/subordinates/{user}', [UserController::class, 'destroy']);
});

// AUTH
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/users/{user}/all-trainings', [UserController::class, 'allTrainings']);
    Route::get('/users/{user}/completed-trainings', [UserController::class, 'completedTrainings']);

    Route::post('/trainings/{training}/enroll', [TrainingController::class, 'enroll']);
    Route::post('/trainings/{training}/cancel-enrollment', [TrainingController::class, 'cancelEnrollment']);
    Route::post('/trainings/{training}/update-status', [TrainingController::class, 'updateStatus']);
});
