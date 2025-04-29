<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AbsenceRequest;

class AbsenceRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AbsenceRequest::insert([
            [
                'employe_id' => 1,
                'type' => 'Congé',
                'dateDebut' => '2025-05-10',
                'dateFin' => '2025-05-15',
                'motif' => 'Vacances familiales',
                'statut' => 'en_attente',
                'justificationUrl' => 'justificatifs/conge1.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'employe_id' => 2,
                'type' => 'maladie',
                'dateDebut' => '2025-04-20',
                'dateFin' => '2025-04-22',
                'motif' => 'Fièvre et fatigue',
                'statut' => 'validé',
                'justificationUrl' => 'justificatifs/maladie2.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'employe_id' => 3,
                'type' => 'autre',
                'dateDebut' => '2025-04-28',
                'dateFin' => '2025-04-28',
                'motif' => 'Rendez-vous administratif',
                'statut' => 'validé',
                'justificationUrl' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'employe_id' => 4,
                'type' => 'maladie',
                'dateDebut' => '2025-05-01',
                'dateFin' => '2025-05-03',
                'motif' => 'Grippe saisonnière',
                'statut' => 'rejeté',
                'justificationUrl' => 'justificatifs/maladie4.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'employe_id' => 5,
                'type' => 'Congé',
                'dateDebut' => '2025-05-20',
                'dateFin' => '2025-05-30',
                'motif' => 'Voyage prévu',
                'statut' => 'en_attente',
                'justificationUrl' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
