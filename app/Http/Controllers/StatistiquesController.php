<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Pointage;
use App\Models\AbsenceRequest;

class StatistiquesController extends Controller
{
    public function statistiquesPresence(Request $request)
    {
        $periode = $request->get('periode', 'jour'); // jour, semaine, mois
        $date = Carbon::parse($request->get('date', now()));

        // Déterminer la période
        switch ($periode) {
            case 'semaine':
                $start = $date->copy()->startOfWeek();
                $end = $date->copy()->endOfWeek();
                break;
            case 'mois':
                $start = $date->copy()->startOfMonth();
                $end = $date->copy()->endOfMonth();
                break;
            default:
                $start = $date->copy()->startOfDay();
                $end = $date->copy()->endOfDay();
                break;
        }

        $totalUsers = User::count();

        $pointages = Pointage::whereBetween('date', [$start, $end])->get();
        $present = $pointages->where('statutJour', 'present')->count();
        $absent = $pointages->where('statutJour', 'absent')->count();

        // Absences de type Congé et Maladie
        $conge = AbsenceRequest::where('type', 'Congé')
            ->where('statut', 'validé')
            ->where(function ($q) use ($start, $end) {
                $q->whereBetween('dateDebut', [$start, $end])
                  ->orWhereBetween('dateFin', [$start, $end]);
            })->count();

        $malade = AbsenceRequest::where('type', 'maladie')
            ->where('statut', 'validé')
            ->where(function ($q) use ($start, $end) {
                $q->whereBetween('dateDebut', [$start, $end])
                  ->orWhereBetween('dateFin', [$start, $end]);
            })->count();

        return response()->json([
            'periode' => $periode,
            'date' => $date->toDateString(),
            'total_employes' => $totalUsers,
            'present' => $present,
            'absent' => $absent,
            'conge' => $conge,
            'malade' => $malade,
        ]);
    }
}
