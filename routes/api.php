<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DepartementController;
use App\Http\Controllers\AbsenceRequestController;
use App\Http\Controllers\PointageController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\RoleMiddleware;


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
});

Route::middleware(['auth:sanctum', 'role:RH'])->group(function () {
    Route::post('/assign-role', [AuthController::class, 'assignRole']);
    Route::get('/user_permission', function () {
        $user = auth()->user();
        return response()->json([
            'user' => $user->name,
            'roles' => $user->getRoleNames(),
            'permissions' => $user->getAllPermissions(),
        ]);
    });
});




Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/employes', [UserController::class, 'index']);
Route::post('/employes', [UserController::class, 'store']);
Route::put('/employes', [UserController::class, 'update']);
Route::delete('/employes', [UserController::class, 'destroy']); 


Route::get('/departements', [DepartementController::class, 'index']);
Route::post('/departements', [DepartementController::class, 'store']);
Route::put('/departements', [DepartementController::class, 'update']);
Route::delete('/departements', [DepartementController::class, 'destroy']);


Route::get('/absences', [AbsenceRequestController::class, 'index']);
Route::post('/absences', [AbsenceRequestController::class, 'store']);
Route::put('/absences', [AbsenceRequestController::class, 'update']);
Route::delete('/absences', [AbsenceRequestController::class, 'destroy']);


Route::get('/pointages', [PointageController::class, 'index']);
Route::post('/pointages', [PointageController::class, 'store']);
Route::put('/pointages', [PointageController::class, 'update']);
Route::delete('/pointages', [PointageController::class, 'destroy']);
