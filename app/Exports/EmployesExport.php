<?php

namespace App\Exports;

use App\Models\Employe;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EmployesExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Employe::with('departement')
            ->get()
            ->map(function ($e) {
                return [
                    'nom' => $e->nom,
                    'prenom' => $e->prenom,
                    'cin'=> $e->cin,
                    'rib'=> $e->rib,
                    'email' => $e->email,
                    'telephone' => $e->tel,
                    'adresse' => $e->adresse,
                    'dateNaissance' => $e->date_naissance,
                    'situationFamiliale' => $e->situationFamiliale,
                    'nbreEnfants' => $e->nbEnfants,
                    'departement' => optional($e->departement)->nom,
                    'role' => $e->role,
                    'statut' => $e->statut,
                    'typeContrat' => $e->typeContrat,
                ];
            });
    }

    public function headings(): array
    {
        return ['Nom', 'Prénom',"Carte Nationale d'identité",'RIB bancaire', 'Email','Télephone','Adresse','Date de Naissance','situation Familiale','Nombre des Enfants', 'Département', 'Rôle', 'Statut', 'Type Contrat'];
    }

}
