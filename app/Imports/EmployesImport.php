<?php

namespace App\Imports;

use App\Models\Employe;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\Departement;

class EmployesImport implements ToModel,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        
        $nomDepartement = trim($row['nom_departement']);  

        
        $departement = Departement::firstOrCreate([
            'nom' => $nomDepartement,
        ]);

        
        return new Employe([
            'cin' => $row["cin"],                     
            'rib' => $row['rib'],             
            'situationFamiliale' => $row['situation_familiale'],
            'nbEnfants' => $row['nombre_enfants'],
            'adresse' => $row['adresse'],
            'nom' => $row['nom'],                    
            'prenom' => $row['prenom'],               
            'date_naissance' => $row['date_naissance'], 
            'tel' => $row['telephone'],             
            'email' => $row['email'],                 
            'role' => $row['role'],                   
            'statut' => $row['statut'],               
            'typeContrat' => $row['type_contrat'],     
            'departement_id' => $departement->id,     
        ]);
    }
}
