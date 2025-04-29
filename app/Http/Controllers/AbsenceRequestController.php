<?php

namespace App\Http\Controllers;

use App\Models\AbsenceRequest;
use Illuminate\Http\Request;

class AbsenceRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index() {
        return AbsenceRequest::all();
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

    public function store(Request $request) {
        $rules = [
            'employe_id' => 'required|exists:employes,id',
            'type' => 'required|in:Congé,maladie,autre',
            'dateDebut' => 'required|date',
            'dateFin' => 'required|date|after_or_equal:dateDebut',
            'motif' => 'nullable|string',
            'statut' => 'required|in:en_attente,validé,rejeté',
            'justification' => 'nullable|file|mimes:jpeg,png,pdf|max:1024', 
        ];
    
        $data = $request->except('justification');
    
        if (isset($data[0])) {
            foreach ($data as $a) {
                $validator = validator($a, $rules);
                if ($validator->fails()) {
                    return response()->json(['error' => $validator->errors()], 422);
                }
                
                if ($request->hasFile('justification')) {
                    $file = $request->file('justification');
                    $fileName = time() . '_' . $file->getClientOriginalName();
                    $file->storeAs('public/justifications', $fileName);
                    $a['justificationUrl'] = 'storage/justifications/' . $fileName;
                }
                
                AbsenceRequest::create($a);
            }
            return response()->json(['message' => 'Absences ajoutées']);
        } else {
            $validator = validator($data, $rules);
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 422);
            }
            
            if ($request->hasFile('justification')) {
                $file = $request->file('justification');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('public/justifications', $fileName);
                $data['justificationUrl'] = 'storage/justifications/' . $fileName;
            }
            
            return AbsenceRequest::create($data);
        }
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
    public function update(Request $request) {
        foreach ($request->all() as $updateData) {
            $absence = AbsenceRequest::findOrFail($updateData['id']);
            $rules = [
                'type' => 'sometimes|in:Congé,Maladie,Urgence',
                'dateDebut' => 'sometimes|date',
                'dateFin' => 'sometimes|date|after_or_equal:dateDebut',
                'motif' => 'nullable|string',
                'statut' => 'sometimes|in:en_attente,validé,rejeté',
                'justification' => 'nullable|file|mimes:jpeg,png,pdf|max:1024', // 1MB max size
            ];
            
            $data = $updateData;
            if ($request->hasFile('justification')) {
                // Delete old file if exists
                if ($absence->justificationUrl) {
                    $oldFilePath = str_replace('storage/', 'public/', $absence->justificationUrl);
                    \Storage::delete($oldFilePath);
                }
                
                $file = $request->file('justification');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('public/justifications', $fileName);
                $data['justificationUrl'] = 'storage/justifications/' . $fileName;
            }
            
            $validated = validator($data, $rules)->validate();
            $absence->update($validated);
        }
        return response()->json(['message' => 'Absences modifiées']);
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
