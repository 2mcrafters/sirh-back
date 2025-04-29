<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employe extends Model
{
    protected $fillable = [
        'cin', 'rib', 'situationFamiliale', 'nbEnfants', 'adresse',
        'nom', 'prenom', 'date_naissance', 'tel', 'email', 'role',
        'statut', 'typeContrat', 'departement_id'
    ];
    public function departement() {
        return $this->belongsTo(Departement::class);
    }
    public function pointages() {
        return $this->hasMany(Pointage::class);
    }

    public function absenceRequests() {
        return $this->hasMany(AbsenceRequest::class);
    }
}
