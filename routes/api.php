<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeExcelController;
use App\Http\Controllers\AbsenceRequestExcelController;
use App\Http\Controllers\PointageExcelController;
use App\Http\Controllers\DepartementExcelController;

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

