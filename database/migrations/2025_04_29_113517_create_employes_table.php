<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('employes', function (Blueprint $table) {
            $table->id();
            $table->string('cin')->unique();
            $table->string('rib')->nullable();
            $table->enum('situationFamiliale', ['Célibataire', 'Marié','Divorcé']);
            $table->integer('nbEnfants')->default(0);
            $table->string('nom');
            $table->string('adresse')->nullable();
            $table->string('prenom');
            $table->date('date_naissance');
            $table->string('tel')->nullable();
            $table->string('email')->unique();
            $table->enum('role', ['Employe', 'Chef_Dep', 'RH']);
            $table->enum('statut', [ 'Present','Absent', 'Congé', 'Malade']);
            $table->enum('typeContrat', [ 'Permanent', 'Temporaire']);
            $table->string('picture')->nullable();
            $table->foreignId('departement_id')->nullable()->constrained()->nullOnDelete();        
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employes');
    }
};
