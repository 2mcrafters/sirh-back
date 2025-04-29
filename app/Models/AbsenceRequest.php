<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AbsenceRequest extends Model
{
    protected $fillable = ['employe_id', 'type', 'dateDebut', 'dateFin', 'motif', 'statut', 'justificationUrl'];

    public function employe() {
        return $this->belongsTo(Employe::class);
    }
}
