<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AbsenceRequestExcelController;
use App\Http\Controllers\PointageExcelController;
use App\Http\Controllers\DepartementExcelController;

use App\Http\Controllers\AuthController;

use App\Http\Controllers\EmployeController;

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


// imports

Route::post('/departements/import', [DepartementExcelController::class, 'importDepartements'])->name('departements.import');
Route::post('/import-employes', [EmployeExcelController::class, 'import'])->name('import.employes');

// exports

Route::get('/export-employes', [EmployeExcelController::class, 'exportEmployes']);
Route::get('/export-absence-requests', [AbsenceRequestExcelController::class, 'exportAbsences']);
Route::get('/export-pointages', [PointageExcelController::class, 'exportPointages']);
Route::get('/export-departements', [DepartementExcelController::class, 'exportDepartements']);

