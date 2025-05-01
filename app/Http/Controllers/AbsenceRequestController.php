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
        return AbsenceRequest::with(['user.departement'])->get();
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
            'user_id' => 'required|exists:users,id',
            'type' => 'required|in:Congé,maladie,autre',
            'dateDebut' => 'required|date',
            'dateFin' => 'required|date|after_or_equal:dateDebut',
            'motif' => 'nullable|string',
            'statut' => 'required|in:en_attente,validé,rejeté',
            'justification' => 'nullable|file|mimes:jpeg,png,pdf|max:2048', 
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
                    $a['justification'] = 'storage/justifications/' . $fileName;
                }
                
                // Ensure user_id is included
                if (!isset($a['user_id'])) {
                    return response()->json(['error' => 'user_id is required'], 422);
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
                $data['justification'] = 'storage/justifications/' . $fileName;
            }
            
            // Ensure user_id is included
            if (!isset($data['user_id'])) {
                return response()->json(['error' => 'user_id is required'], 422);
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
    public function update(Request $request)
    {
        // Handle file + JSON case
        $inputData = $request->has('data')
            ? json_decode($request->input('data'), true)
            : $request->all();

        foreach ($inputData as $updateData) {
            $absence = AbsenceRequest::findOrFail($updateData['id']);

            $rules = [
                'type' => 'sometimes|in:Congé,maladie,autre',
                'dateDebut' => 'sometimes|date',
                'dateFin' => 'sometimes|date|after_or_equal:dateDebut',
                'motif' => 'nullable|string',
                'statut' => 'sometimes|in:en_attente,validé,rejeté',
                'justification' => 'nullable|file|mimes:jpeg,png,pdf|max:2048',
            ];

            $validator = validator($updateData, $rules);
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 422);
            }

            $validated = $validator->validated();

            // If file uploaded with this request
            if ($request->hasFile('justification')) {
                // Delete the old file if it exists
                if ($absence->justification) {
                    $oldPath = str_replace('storage/', 'public/', $absence->justification);
                    \Storage::delete($oldPath);
                }
            
                $file = $request->file('justification');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('public/justifications', $fileName);
                $validated['justification'] = 'storage/justifications/' . $fileName;
            } else {
                // Preserve the existing file URL if no new file was sent
                $validated['justification'] = $absence->justification;
            }
            

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
