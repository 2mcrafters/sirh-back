<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    protected static ?string $password;
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::insert([
            [
                'cin' => 'AB123456',
                'rib' => 'MA123456789012345678901234',
                'situationFamiliale' => 'Célibataire',
                'nbEnfants' => 0,
                'adresse' => 'Rabat',
                'name' => 'El Khattabi',
                'password' => static::$password ??= Hash::make('password'),
                'prenom' => 'Sara',
                'date_naissance' => '1990-03-15',
                'tel' => '0600000001',
                'email' => 'sara.khattabi@example.com',
                'role' => 'Employe',
                'statut' => 'Present',
                'typeContrat' => 'Permanent',
                "picture"=>"img.png",
                'departement_id' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
