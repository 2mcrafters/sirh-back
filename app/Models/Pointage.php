<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pointage extends Model
{
    protected $fillable = ['employe_id', 'date', 'heureEntree', 'heureSortie', 'statutJour', 'overtimeHours'];

    public function employe() {
        return $this->belongsTo(Employe::class);
    }
}
