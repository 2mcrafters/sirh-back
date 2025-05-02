<?php

namespace App\Http\Controllers;

use App\Models\AbsenceRequest;
use Illuminate\Http\Request;

class AbsenceRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    // public function index() {
    //     return AbsenceRequest::all();
    // }


    public function index(Request $request)
    {

        $user = $request->user();
        $absences = AbsenceRequest::all();


        return response()->json([
            'user' => $user,
            'absences' => $absences
        ]);
        $user = $request->user();
        if ($user->role === 'RH') {
            $absences = AbsenceRequest::all();
        } elseif ($user->role === 'CHEF_DEP') {
           
            $departementId = $user->departement_id;  
            $absences = AbsenceRequest::whereHas('user', function ($query) use ($departementId) {
                $query->where('departement_id', $departementId);
            })->get();
        } else {
           
            $absences = $user->absenceRequests;
        }

       
        return response()->json([
            'user' => $user,
            'absences' => $absences
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */

     public function store(Request $request)
     {
         $rules = [
             'user_id' => 'required|exists:users,id',
             'type' => 'required|in:Congé,maladie,autre',
             'dateDebut' => 'required|date',
             'dateFin' => 'required|date|after_or_equal:dateDebut',
             'motif' => 'nullable|string',
             'statut' => 'required|in:en_attente,validé,rejeté',
             'justification' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
         ];
     
         // Valider les champs
         $validator = validator($request->all(), $rules);
     
         if ($validator->fails()) {
             return response()->json(['error' => $validator->errors()], 422);
         }
     
         $data = $validator->validated();
     
         // Traitement du fichier
         if ($request->hasFile('justification')) {
             $file = $request->file('justification');
             $fileName = time() . '_' . $file->getClientOriginalName();
             $file->storeAs('public/justifications', $fileName);
             $data['justification'] = 'storage/justifications/' . $fileName;
         }
     
         // Enregistrer la demande
         $absence = AbsenceRequest::create($data);
     
         return response()->json(['message' => 'Absence ajoutée', 'absence' => $absence]);
     }
     
    

    /**
     * Display the specified resource.
     */
    public function show(AbsenceRequest $absenceRequest)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AbsenceRequest $absenceRequest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
{
    // dd($request);
    // ✅ Assure-toi que l'ID est bien présent dans FormData
    $rules = [
        'id' => 'required|exists:absence_requests,id',
        'user_id' => 'required|exists:users,id',
        'type' => 'required|in:Congé,maladie,autre',
        'dateDebut' => 'required|date',
        'dateFin' => 'required|date|after_or_equal:dateDebut',
        'motif' => 'nullable|string',
        'statut' => 'required|in:en_attente,validé,rejeté',
        'justification' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
    ];


    $validator = validator($request->all(), $rules);
    if ($validator->fails()) {
        return response()->json(['error' => $validator->errors()], 422);
    }

    $absence = AbsenceRequest::findOrFail($request->id);
    $data = $validator->validated();

    if ($request->hasFile('justification')) {
        if ($absence->justification) {
            $oldPath = str_replace('storage/', 'public/', $absence->justification);
            \Storage::delete($oldPath);
        }

        $file = $request->file('justification');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $file->storeAs('public/justifications', $fileName);
        $data['justification'] = 'storage/justifications/' . $fileName;
    }

    $absence->update($data);

    return response()->json(['message' => 'Absence modifiée', 'absence' => $absence]);
}


    /**
     * Remove the specified resource from storage.
     */

    public function destroy(Request $request) {
        $ids = $request->input('ids');
        AbsenceRequest::whereIn('id', $ids)->delete();
        return response()->json(['message' => 'Absences supprimées']);
    }
}
