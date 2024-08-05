<?php

use App\Http\Controllers\TrainingController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
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

Route::middleware('admin')->get('/test-admin', function () {
    return response()->json(['message' => 'You are an admin!']);
});

// AUTH + ADMIN
Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::get('/test-admin', function () {
        return response()->json(['message' => 'You are an admin!']);
    });

    Route::post('/trainings', [TrainingController::class, 'store']);
    Route::put('/trainings/{training}', [TrainingController::class, 'update']);
    Route::delete('/trainings/{training}', [TrainingController::class, 'destroy']);


    Route::get('/subordinates', [UserController::class, 'index']);
    Route::post('/subordinates', [UserController::class, 'store']);
    Route::put('/subordinates/{user}', [UserController::class, 'update']);
    Route::delete('/subordinates/{user}', [UserController::class, 'destroy']);
});

// AUTH ONLY
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/trainings', [TrainingController::class, 'index']);
//    Route::get('/protected-route', function (Request $request) {
//        return ['Acesso' => 'Liberado'];
//    });
//
//    Route::post('/logout', [AuthController::class, 'logout']);

//    Route::get('/trainings/{training}', [TrainingController::class, 'show']);
});
