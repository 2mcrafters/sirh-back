<?php

namespace Database\Seeders;

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
                'user_id' => 1,
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
                'user_id' => 62,
                'type' => 'Congé',
                'dateDebut' => '2025-06-01',
                'dateFin' => '2025-06-05',
                'motif' => 'Mariage',
                'statut' => 'validé',
                'justificationUrl' => 'justificatifs/conge2.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 3,
                'type' => 'Congé',
                'dateDebut' => '2025-05-20',
                'dateFin' => '2025-05-22',
                'motif' => 'Raisons médicales',
                'statut' => 'rejeté',
                'justificationUrl' => 'justificatifs/conge3.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 4,
                'type' => 'Maladie',
                'dateDebut' => '2025-05-12',
                'dateFin' => '2025-05-14',
                'motif' => 'Mal de dos',
                'statut' => 'en_attente',
                'justificationUrl' => 'justificatifs/maladie1.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 5,
                'type' => 'Congé',
                'dateDebut' => '2025-06-10',
                'dateFin' => '2025-06-12',
                'motif' => 'Voyage d’affaires',
                'statut' => 'validé',
                'justificationUrl' => 'justificatifs/conge4.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 6,
                'type' => 'Congé',
                'dateDebut' => '2025-07-01',
                'dateFin' => '2025-07-07',
                'motif' => 'Séjour à l’étranger',
                'statut' => 'rejeté',
                'justificationUrl' => 'justificatifs/conge5.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 7,
                'type' => 'Maladie',
                'dateDebut' => '2025-05-30',
                'dateFin' => '2025-06-02',
                'motif' => 'Grippe',
                'statut' => 'en_attente',
                'justificationUrl' => 'justificatifs/maladie2.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 8,
                'type' => 'Congé',
                'dateDebut' => '2025-08-01',
                'dateFin' => '2025-08-05',
                'motif' => 'Voyage personnel',
                'statut' => 'validé',
                'justificationUrl' => 'justificatifs/conge6.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 60,
                'type' => 'Maladie',
                'dateDebut' => '2025-05-18',
                'dateFin' => '2025-05-19',
                'motif' => 'Entorse à la cheville',
                'statut' => 'rejeté',
                'justificationUrl' => 'justificatifs/maladie3.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 59,
                'type' => 'Congé',
                'dateDebut' => '2025-06-20',
                'dateFin' => '2025-06-25',
                'motif' => 'Vacances d’été',
                'statut' => 'en_attente',
                'justificationUrl' => 'justificatifs/conge7.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
