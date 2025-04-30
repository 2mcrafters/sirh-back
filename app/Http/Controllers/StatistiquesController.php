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
    $user = auth()->user(); 
    $periode = $request->get('periode', 'jour');
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

    
    if ($user->hasRole('RH')) {
        $employes = User::all();
    } elseif ($user->hasRole('CHEF_DEP')) {
        $employes = User::where('departement_id', $user->departement_id)->get();
    } else {
        return response()->json(['message' => 'Non autorisé'], 403);
    }

    $userIds = $employes->pluck('id');

    $pointages = Pointage::whereBetween('date', [$start, $end])
        ->whereIn('user_id', $userIds)
        ->get();

    $present = $pointages->where('statutJour', 'present')->count();
    $absent = $pointages->where('statutJour', 'absent')->count();

    $conge = AbsenceRequest::where('type', 'Congé')
        ->where('statut', 'validé')
        ->whereIn('user_id', $userIds)
        ->where(function ($q) use ($start, $end) {
            $q->whereBetween('dateDebut', [$start, $end])
              ->orWhereBetween('dateFin', [$start, $end]);
        })->count();

    $malade = AbsenceRequest::where('type', 'maladie')
        ->where('statut', 'validé')
        ->whereIn('user_id', $userIds)
        ->where(function ($q) use ($start, $end) {
            $q->whereBetween('dateDebut', [$start, $end])
              ->orWhereBetween('dateFin', [$start, $end]);
        })->count();

    $totalUsers = $employes->count();
    
    $presentPercentage = $totalUsers ? number_format(($present / $totalUsers) * 100, 2) : 0;
    $absentPercentage = $totalUsers ? number_format(($absent / $totalUsers) * 100, 2) : 0;
    $congePercentage = $totalUsers ? number_format(($conge / $totalUsers) * 100, 2) : 0;
    $maladePercentage = $totalUsers ? number_format(($malade / $totalUsers) * 100, 2) : 0;
    

    return response()->json([
        'periode' => $periode,
        'date' => $date->toDateString(),
        'total_employes' => $totalUsers,
        'present' => $present,
        'absent' => $absent,
        'conge' => $conge,
        'malade' => $malade,
        'pourcentage_present' => $presentPercentage,
        'pourcentage_absent' => $absentPercentage,
        'pourcentage_conge' => $congePercentage,
        'pourcentage_malade' => $maladePercentage,
    ]);
}

} 