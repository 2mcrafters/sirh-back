<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeController;
use App\Http\Controllers\DepartementController;
use App\Http\Controllers\AbsenceRequestController;
use App\Http\Controllers\PointageController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



Route::get('/employes', [EmployeController::class, 'index']);
Route::post('/employes', [EmployeController::class, 'store']);
Route::put('/employes', [EmployeController::class, 'update']);
Route::delete('/employes', [EmployeController::class, 'destroy']); 


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
