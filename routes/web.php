<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserExcelController;
use App\Http\Controllers\DepartementExcelController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/departements/import', function () {
    return view('import-departements');
})->name('departements.import.view');

Route::get('/import-employes', function () {
    return view('import_employes');
});


Route::post('/departements/import', [DepartementExcelController::class, 'importDepartements'])->name('departements.import');
Route::post('/import-employes', [UserExcelController::class, 'import'])->name('import.employes');

