<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Pointage;
use Illuminate\Support\Facades\Log;

class StatistiquesController extends Controller
{
    public function statistiquesPresence(Request $request)
    {
        try {
            $user = auth()->user(); 
            $periode = $request->get('periode', 'jour');
            
            Log::info('Paramètres reçus:', [
                'periode' => $periode,
                'date' => $request->get('date'),
                'dateDebut' => $request->get('dateDebut'),
                'dateFin' => $request->get('dateFin'),
                'mois' => $request->get('mois')
            ]);

            // Déterminer la période en fonction du type sélectionné
            switch ($periode) {
                case 'semaine':
                    if (!$request->has('dateDebut') || !$request->has('dateFin')) {
                        return response()->json(['message' => 'Les dates de début et de fin sont requises pour la période semaine'], 400);
                    }
                    $dateDebut = Carbon::parse($request->get('dateDebut'));
                    $dateFin = Carbon::parse($request->get('dateFin'));
                    $start = $dateDebut->startOfDay();
                    $end = $dateFin->endOfDay();
                    break;
                case 'mois':
                    if (!$request->has('mois')) {
                        return response()->json(['message' => 'Le mois est requis pour la période mois'], 400);
                    }
                    $mois = Carbon::parse($request->get('mois'));
                    $start = $mois->copy()->startOfMonth();
                    $end = $mois->copy()->endOfMonth();
                    break;
                default: // jour
                    if (!$request->has('date')) {
                        return response()->json(['message' => 'La date est requise pour la période jour'], 400);
                    }
                    $date = Carbon::parse($request->get('date'));
                    $start = $date->copy()->startOfDay();
                    $end = $date->copy()->endOfDay();
                    break;
            }

            Log::info('Période calculée:', [
                'start' => $start->toDateTimeString(),
                'end' => $end->toDateTimeString()
            ]);

            // Récupérer les employés selon le rôle
            if ($user->hasRole('RH')) {
                $employes = User::all();
            } elseif ($user->hasRole('CHEF_DEP')) {
                $employes = User::where('departement_id', $user->departement_id)->get();
            } else {
                return response()->json(['message' => 'Non autorisé'], 403);
            }

            $userIds = $employes->pluck('id');

            // Récupérer les pointages dans la période
            $pointages = Pointage::whereBetween('date', [$start, $end])
                ->whereIn('user_id', $userIds)
                ->get();

            Log::info('Nombre de pointages trouvés:', ['count' => $pointages->count()]);

            $present = $pointages->where('statutJour', 'present')->count();
            $absent = $pointages->where('statutJour', 'absent')->count();
            $enRetard = $pointages->where('statutJour', 'retard')->count();

            $totalUsers = $employes->count();
            
            // Calculer les pourcentages
            $presentPercentage = $totalUsers ? number_format(($present / $totalUsers) * 100, 2) : 0;
            $absentPercentage = $totalUsers ? number_format(($absent / $totalUsers) * 100, 2) : 0;
            $enRetardPercentage = $totalUsers ? number_format(($enRetard / $totalUsers) * 100, 2) : 0;

            $response = [
                'periode' => $periode,
                'date' => $start->toDateString(),
                'dateDebut' => $periode === 'semaine' ? $dateDebut->toDateString() : null,
                'dateFin' => $periode === 'semaine' ? $dateFin->toDateString() : null,
                'mois' => $periode === 'mois' ? $mois->format('Y-m') : null,
                'total_employes' => $totalUsers,
                'present' => $present,
                'absent' => $absent,
                'en_retard' => $enRetard,
                'pourcentage_present' => $presentPercentage,
                'pourcentage_absent' => $absentPercentage,
                'pourcentage_en_retard' => $enRetardPercentage,
            ];

            Log::info('Réponse envoyée:', $response);

            return response()->json($response);
        } catch (\Exception $e) {
            Log::error('Erreur dans statistiquesPresence:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['message' => 'Une erreur est survenue lors du traitement des statistiques'], 500);
        }
    }
} 