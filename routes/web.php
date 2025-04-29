<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

// Route::get('/departements/import', function () {
//     return view('import-departements');
// })->name('departements.import.view');

// Route::get('/import-employes', function () {
//     return view('import_employes');
// });
