<?php

namespace App\Exports;

use App\Models\Departement;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DepartementsExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Departement::with('employes')->get()->map(function ($departement) {
            $nomsEmployes = $departement->employes->map(function ($employe) {
                return $employe->nom . ' ' . $employe->prenom;
            })->implode(', ');

            return [
                'Nom Département' => $departement->nom,
                'Employés' => $nomsEmployes,
            ];
        });
    }

    public function headings(): array
    {
        return ['Nom Département', 'Employés'];
    }
}
