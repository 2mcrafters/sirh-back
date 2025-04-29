<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\EmployesImport;
use App\Exports\EmployesExport;
use Maatwebsite\Excel\Facades\Excel;

class EmployeExcelController extends Controller
{
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv', 
        ]);

        
        Excel::import(new EmployesImport, $request->file('file'));

        return back()->with('success', 'Les employés ont été importés avec succès.');
    }

    public function exportEmployes()
    {
        return Excel::download(new EmployesExport, 'employes.xlsx');
    }
}
