<?php

namespace App\Http\Controllers;

use App\Models\Employe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EmployeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {
        $employes = Employe::all();
        foreach ($employes as $employe) {
            $employe->profile_picture_url = $employe->profile_picture_url;
        }
        return $employes;
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
            'cin' => 'required|string|max:20',
            'rib' => 'required|string|max:32',
            'situation_familiale' => 'required|in:Célibataire,Marié,Divorcé',
            'nb_enfants' => 'required|integer|min:0',
            'adresse' => 'required|string|max:255',
            'nom' => 'required|string|max:50',
            'prenom' => 'required|string|max:50',
            'tel' => 'required|string|max:20',
            'email' => 'required|email|unique:employes,email',
            'role' => 'required|in:EMPLOYE,CHEF_DEP,RH',
            'type_contrat' => 'required|in:Permanent,Temporaire',
            'date_naissance' => 'required|date',
            'statut' => 'required|in:Présent,Absent,Congé,Maladie',
            'departement_id' => 'required|exists:departements,id',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];

        $data = $request->all();
        if (isset($data[0])) {
            foreach ($data as $record) {
                validator($record, $rules)->validate();
                
                // Handle profile picture upload if present
                if (isset($record['profile_picture']) && $record['profile_picture']->isValid()) {
                    $profilePicture = $record['profile_picture'];
                    $fileName = time() . '_' . $profilePicture->getClientOriginalName();
                    $profilePicture->storeAs('profile_picture', $fileName, 'public');
                    $record['profile_picture'] = $fileName;
                }
                
                Employe::create($record);
            }
            return response()->json(['message' => 'Employés ajoutés']);
        } else {
            $validated = validator($data, $rules)->validate();
            
            // Handle profile picture upload if present
            if ($request->hasFile('profile_picture') && $request->file('profile_picture')->isValid()) {
                $profilePicture = $request->file('profile_picture');
                $fileName = time() . '_' . $profilePicture->getClientOriginalName();
                $profilePicture->storeAs('profile_picture', $fileName, 'public');
                $validated['profile_picture'] = $fileName;
            }
            
            return Employe::create($validated);
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(Employe $employe)
    {
        $employe->profile_picture_url = $employe->profile_picture_url;
        return $employe;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employe $employe)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request) {
        foreach ($request->all() as $updateData) {
            $employe = Employe::findOrFail($updateData['id']);
            $rules = [
                'cin' => 'sometimes|string|max:20',
                'rib' => 'sometimes|string|max:32',
                'situation_familiale' => 'sometimes|in:Célibataire,Marié,Divorcé',
                'nb_enfants' => 'sometimes|integer|min:0',
                'adresse' => 'sometimes|string|max:255',
                'nom' => 'sometimes|string|max:50',
                'prenom' => 'sometimes|string|max:50',
                'tel' => 'sometimes|string|max:20',
                'email' => 'sometimes|email|unique:employes,email,' . $updateData['id'],
                'role' => 'sometimes|in:EMPLOYE,CHEF_DEP,RH',
                'type_contrat' => 'sometimes|in:Permanent,Temporaire',
                'date_naissance' => 'sometimes|date',
                'statut' => 'sometimes|in:Présent,Absent,Congé,Maladie',
                'departement_id' => 'sometimes|exists:departements,id',
                'profile_picture' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
            ];
            $validated = validator($updateData, $rules)->validate();
            
            // Handle profile picture update if present
            if (isset($updateData['profile_picture']) && $updateData['profile_picture']->isValid()) {
                // Delete old profile picture if exists
                if ($employe->profile_picture) {
                    Storage::disk('public')->delete('profile_picture/' . $employe->profile_picture);
                }
                
                $profilePicture = $updateData['profile_picture'];
                $fileName = time() . '_' . $profilePicture->getClientOriginalName();
                $profilePicture->storeAs('profile_picture', $fileName, 'public');
                $validated['profile_picture'] = $fileName;
            }
            
            $employe->update($validated);
        }
        return response()->json(['message' => 'Employés modifiés']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request) {
        $ids = $request->input('ids');
        Employe::whereIn('id', $ids)->delete();
        return response()->json(['message' => 'Employés supprimés']);
    }
}