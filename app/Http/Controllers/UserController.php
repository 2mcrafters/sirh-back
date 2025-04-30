<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {
        $users = User::all();
        foreach ($users as $user) {
            $user->profile_picture_url = $user->profile_picture_url;
        }
        return $users;
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
            'situationFamiliale' => 'required|in:Célibataire,Marié,Divorcé',
            'nbEnfants' => 'required|integer|min:0',
            'adresse' => 'required|string|max:255',
            'name' => 'required|string|max:50',
            'prenom' => 'required|string|max:50',
            'tel' => 'required|string|max:20',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => 'required|in:EMPLOYE,CHEF_DEP,RH',
            'typeContrat' => 'required|in:Permanent,Temporaire',
            'date_naissance' => 'required|date',
            'statut' => 'required|in:Présent,Absent,Congé,Maladie',
            'departement_id' => 'required|exists:departements,id',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];

        $data = $request->all();
        if (isset($data[0])) {
            foreach ($data as $record) {
                $validated = $request->validate($rules);
                
                // Handle profile picture upload if present
                if (isset($record['profile_picture']) && $record['profile_picture']->isValid()) {
                    $profilePicture = $record['profile_picture'];
                    $fileName = time() . '_' . $profilePicture->getClientOriginalName();
                    $profilePicture->storeAs('profile_picture', $fileName, 'public');
                    $validated['profile_picture'] = $fileName;
                }
                
                // Hash password
                $validated['password'] = Hash::make($validated['password']);
                
                $user = User::create($validated);
                
                // Assign role after user creation
                if (isset($validated['role'])) {
                    $user->assignRole($validated['role']);
                }
            }
            return response()->json(['message' => 'Employés ajoutés']);
        } else {
            $validated = $request->validate($rules);
            
            // Handle profile picture upload if present
            if ($request->hasFile('profile_picture') && $request->file('profile_picture')->isValid()) {
                $profilePicture = $request->file('profile_picture');
                $fileName = time() . '_' . $profilePicture->getClientOriginalName();
                $profilePicture->storeAs('profile_picture', $fileName, 'public');
                $validated['profile_picture'] = $fileName;
            }
            
            // Hash password
            $validated['password'] = Hash::make($validated['password']);
            
            $user = User::create($validated);
            
            // Assign role after user creation
            if (isset($validated['role'])) {
                $user->assignRole($validated['role']);
            }
            
            return $user;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $user->profile_picture_url = $user->profile_picture_url;
        return $user;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request) {
        foreach ($request->all() as $updateData) {
            $user = User::findOrFail($updateData['id']);
            $rules = [
                'cin' => 'sometimes|string|max:20',
                'rib' => 'sometimes|string|max:32',
                'situationFamiliale' => 'sometimes|in:Célibataire,Marié,Divorcé',
                'nbEnfants' => 'sometimes|integer|min:0',
                'adresse' => 'sometimes|string|max:255',
                'name' => 'sometimes|string|max:50',
                'prenom' => 'sometimes|string|max:50',
                'tel' => 'sometimes|string|max:20',
                'email' => 'sometimes|email|unique:users,email,' . $updateData['id'],
                'password' => 'sometimes|string|min:6',
                'role' => 'sometimes|in:EMPLOYE,CHEF_DEP,RH',
                'typeContrat' => 'sometimes|in:Permanent,Temporaire',
                'date_naissance' => 'sometimes|date',
                'statut' => 'sometimes|in:Présent,Absent,Congé,Maladie',
                'departement_id' => 'sometimes|exists:departements,id',
                'profile_picture' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
            ];
            
            $validated = $request->validate($rules);
            
            // Handle profile picture update if present
            if (isset($updateData['profile_picture']) && $updateData['profile_picture']->isValid()) {
                // Delete old profile picture if exists
                if ($user->profile_picture) {
                    Storage::disk('public')->delete('profile_picture/' . $user->profile_picture);
                }
                
                $profilePicture = $updateData['profile_picture'];
                $fileName = time() . '_' . $profilePicture->getClientOriginalName();
                $profilePicture->storeAs('profile_picture', $fileName, 'public');
                $validated['profile_picture'] = $fileName;
            }
            
            // Hash password if provided
            if (isset($validated['password'])) {
                $validated['password'] = Hash::make($validated['password']);
            }
            
            $user->update($validated);
            
            // Update role if provided
            if (isset($validated['role'])) {
                $user->syncRoles([$validated['role']]);
            }
        }
        return response()->json(['message' => 'Employés modifiés']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request) {
        $ids = $request->input('ids');
        User::whereIn('id', $ids)->delete();
        return response()->json(['message' => 'Employés supprimés']);
    }
}