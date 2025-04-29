<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Employe;

class EmployeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Employe::insert([
            [
                'cin' => 'AB123456',
                'rib' => 'MA123456789012345678901234',
                'situationFamiliale' => 'Célibataire',
                'nbEnfants' => 0,
                'adresse' => 'Rabat',
                'nom' => 'El Khattabi',
                'prenom' => 'Sara',
                'date_naissance' => '1990-03-15',
                'tel' => '0600000001',
                'email' => 'sara.khattabi@example.com',
                'role' => 'Employe',
                'statut' => 'Present',
                'typeContrat' => 'Permanent',
                'departement_id' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'cin' => 'CD789012',
                'rib' => 'MA987654321098765432109876',
                'situationFamiliale' => 'Marié',
                'nbEnfants' => 2,
                'adresse' => 'Casablanca',
                'nom' => 'Benali',
                'prenom' => 'Mohamed',
                'date_naissance' => '1985-07-20',
                'tel' => '0600000002',
                'email' => 'mohamed.benali@example.com',
                'role' => 'Chef_Dep',
                'statut' => 'Congé',
                'typeContrat' => 'Temporaire',
                'departement_id' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'cin' => 'EF345678',
                'rib' => 'MA112233445566778899001122',
                'situationFamiliale' => 'Divorcé',
                'nbEnfants' => 1,
                'adresse' => 'Fès',
                'nom' => 'Alaoui',
                'prenom' => 'Yassine',
                'date_naissance' => '1992-11-05',
                'tel' => '0600000003',
                'email' => 'yassine.alaoui@example.com',
                'role' => 'RH',
                'statut' => 'Malade',
                'typeContrat' => 'Permanent',
                'departement_id' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'cin' => 'GH901234',
                'rib' => 'MA334455667788990011223344',
                'situationFamiliale' => 'Célibataire',
                'nbEnfants' => 0,
                'adresse' => 'Tanger',
                'nom' => 'El Idrissi',
                'prenom' => 'Imane',
                'date_naissance' => '1995-09-01',
                'tel' => '0600000004',
                'email' => 'imane.idrissi@example.com',
                'role' => 'Employe',
                'statut' => 'Absent',
                'typeContrat' => 'Temporaire',
                'departement_id' => 3,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'cin' => 'IJ567890',
                'rib' => 'MA445566778899001122334455',
                'situationFamiliale' => 'Marié',
                'nbEnfants' => 3,
                'adresse' => 'Agadir',
                'nom' => 'Bennani',
                'prenom' => 'Omar',
                'date_naissance' => '1980-12-10',
                'tel' => '0600000005',
                'email' => 'omar.bennani@example.com',
                'role' => 'Employe',
                'statut' => 'Present',
                'typeContrat' => 'Permanent',
                'departement_id' => 4,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'cin' => 'KL678901',
                'rib' => 'MA556677889900112233445566',
                'situationFamiliale' => 'Célibataire',
                'nbEnfants' => 0,
                'adresse' => 'Meknès',
                'nom' => 'Naciri',
                'prenom' => 'Rania',
                'date_naissance' => '1993-05-22',
                'tel' => '0600000006',
                'email' => 'rania.naciri@example.com',
                'role' => 'RH',
                'statut' => 'Present',
                'typeContrat' => 'Permanent',
                'departement_id' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'cin' => 'MN789012',
                'rib' => 'MA667788990011223344556677',
                'situationFamiliale' => 'Marié',
                'nbEnfants' => 2,
                'adresse' => 'Oujda',
                'nom' => 'El Hachmi',
                'prenom' => 'Karim',
                'date_naissance' => '1987-06-17',
                'tel' => '0600000007',
                'email' => 'karim.hachmi@example.com',
                'role' => 'Employe',
                'statut' => 'Congé',
                'typeContrat' => 'Temporaire',
                'departement_id' => 5,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'cin' => 'OP890123',
                'rib' => 'MA778899001122334455667788',
                'situationFamiliale' => 'Divorcé',
                'nbEnfants' => 1,
                'adresse' => 'Kenitra',
                'nom' => 'Zahiri',
                'prenom' => 'Nour',
                'date_naissance' => '1991-02-08',
                'tel' => '0600000008',
                'email' => 'nour.zahiri@example.com',
                'role' => 'Employe',
                'statut' => 'Absent',
                'typeContrat' => 'Permanent',
                'departement_id' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'cin' => 'QR901234',
                'rib' => 'MA889900112233445566778899',
                'situationFamiliale' => 'Célibataire',
                'nbEnfants' => 0,
                'adresse' => 'Tétouan',
                'nom' => 'Baraka',
                'prenom' => 'Siham',
                'date_naissance' => '1994-04-30',
                'tel' => '0600000009',
                'email' => 'siham.baraka@example.com',
                'role' => 'Chef_Dep',
                'statut' => 'Present',
                'typeContrat' => 'Permanent',
                'departement_id' => 3,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'cin' => 'ST012345',
                'rib' => 'MA990011223344556677889900',
                'situationFamiliale' => 'Marié',
                'nbEnfants' => 4,
                'adresse' => 'El Jadida',
                'nom' => 'Kabbaj',
                'prenom' => 'Hassan',
                'date_naissance' => '1978-10-12',
                'tel' => '0600000010',
                'email' => 'hassan.kabbaj@example.com',
                'role' => 'RH',
                'statut' => 'Malade',
                'typeContrat' => 'Temporaire',
                'departement_id' => 4,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
