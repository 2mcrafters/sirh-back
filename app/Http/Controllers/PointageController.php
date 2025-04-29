<?php

namespace App\Http\Controllers;

use App\Models\Pointage;
use Illuminate\Http\Request;

class PointageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {
        return Pointage::all();
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
            'date' => 'required|date',
            'heureEntree' => 'nullable|date_format:H:i',
            'heureSortie' => 'nullable|date_format:H:i',
            'statutJour' => 'required|in:present,absent,retard',
            'overtimeHours' => 'nullable|numeric',
        ];

        $data = $request->all();
        if (isset($data[0])) {
            foreach ($data as $p) {
                // Check for existing pointage on the same day
                $existingPointage = Pointage::where('employe_id', $p['employe_id'])
                    ->whereDate('date', $p['date'])
                    ->first();

                if ($existingPointage) {
                    return response()->json([
                        'message' => 'Un pointage existe déjà pour cet employé à cette date',
                        'error' => true
                    ], 422);
                }

                validator($p, $rules)->validate();
                Pointage::create($p);
            }
            return response()->json(['message' => 'Pointages ajoutés']);
        } else {
            // Check for existing pointage on the same day
            $existingPointage = Pointage::where('employe_id', $data['employe_id'])
                ->whereDate('date', $data['date'])
                ->first();

            if ($existingPointage) {
                return response()->json([
                    'message' => 'Un pointage existe déjà pour cet employé à cette date',
                    'error' => true
                ], 422);
            }

            $validated = validator($data, $rules)->validate();
            return Pointage::create($validated);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Pointage $pointage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pointage $pointage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request) {
        foreach ($request->all() as $updateData) {
            $pointage = Pointage::findOrFail($updateData['id']);
            $rules = [
                'heureEntree' => 'sometimes|date_format:H:i',
                'heureSortie' => 'sometimes|date_format:H:i',
                'statutJour' => 'sometimes|in:present,absent,retard',
                'overtimeHours' => 'nullable|numeric',
            ];
            $validated = validator($updateData, $rules)->validate();
            $pointage->update($validated);
        }
        return response()->json(['message' => 'Pointages modifiés']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request) {
        $ids = $request->input('ids');
        Pointage::whereIn('id', $ids)->delete();
        return response()->json(['message' => 'Pointages supprimés']);
    }

}
