<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index() {
    //     $users = User::all();
    //     foreach ($users as $user) {
    //         $user->profile_picture_url = $user->profile_picture_url;
    //     }
    //     return $users;
    // }



    public function index(Request $request)
    {

        // $user = $request->user();
        // $departementId = $user->departement_id;  
        $users = User::all();
        return response()->json($users);


        
        if ($user->role === 'Employe') {
            
            $users = [$user]; 
        } elseif ($user->role === 'Chef_Dep') {
            
            $departementId = $user->departement_id;  
            $users = User::where('departement_id', $departementId)->get();  
        } elseif ($user->role === 'RH') {
            
            $users = User::all();
        } else {
            
            return response()->json(['message' => 'Role non autorisé'], 403);
        }

        return response()->json($users);
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
            'name' => 'required|string|max:100',
            'cin' => 'required|string|max:20',
            'rib' => 'required|string|max:32',
            'situationFamiliale' => 'required|in:Célibataire,Marié,Divorcé',
            'nbEnfants' => 'required|integer|min:0',
            'adresse' => 'required|string|max:255',
            'prenom' => 'required|string|max:50',
            'tel' => 'required|string|max:20',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => 'required|in:Employe,Chef_Dep,RH',
            'typeContrat' => 'required|in:Permanent,Temporaire',
            'date_naissance' => 'required|date',
            'statut' => 'required|in:Actif,Inactif,Congé,Malade',

            'departement_id' => 'required|exists:departements,id',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    
        $data = $request->all();
    
        if (isset($data[0])) {
            foreach ($data as $record) {
                $validator = Validator::make($record, $rules);
    
                if ($validator->fails()) {
                    return response()->json(['error' => $validator->errors()], 422);
                }
    
                $validated = $validator->validated();
    
                // Handle picture as base64 or skip it
                if (!empty($record['picture'])) {
                    $image = $record['picture'];
                    $fileName = time() . '_' . uniqid() . '.jpg';
                    \Storage::disk('public')->put("profile_picture/$fileName", base64_decode($image));
                    $validated['picture'] = $fileName;
                }
    
                $validated['password'] = Hash::make($validated['password']);
                $user = User::create($validated);
    
                if (isset($validated['role'])) {
                    $user->assignRole($validated['role']);
                }
            }
    
            return response()->json(['message' => 'Employés ajoutés']);
        }
    
        // Single user
        $validated = $request->validate($rules);
    
        if ($request->hasFile('picture') && $request->file('picture')->isValid()) {
            $profilePicture = $request->file('picture');
            $fileName = time() . '_' . $profilePicture->getClientOriginalName();
            $profilePicture->storeAs('profile_picture', $fileName, 'public');
            $validated['picture'] = $fileName;
        }
    
        $validated['password'] = Hash::make($validated['password']);
        $user = User::create($validated);
    
        if (isset($validated['role'])) {
            $user->assignRole($validated['role']);
        }
    
        return $user;
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
                'role' => 'sometimes|in:Employe,Chef_Dep,Rh',
                'typeContrat' => 'sometimes|in:Permanent,Temporaire',
                'date_naissance' => 'sometimes|date',
                'statut' => 'sometimes|in:Actif,Inactif,Congé,Malade',
                'departement_id' => 'sometimes|exists:departements,id',
                'picture' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
            ];
            
            $validator = Validator::make($updateData, $rules);
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 422);
            }
            
            $validated = $validator->validated();
            
            // Handle profile picture update if present
            if (isset($updateData['picture']) && is_string($updateData['picture'])) {
                // Handle base64 image
                $image = $updateData['picture'];
                $fileName = time() . '_' . uniqid() . '.jpg';
                Storage::disk('public')->put("profile_picture/$fileName", base64_decode($image));
                
                // Delete old profile picture if exists
                if ($user->picture) {
                    Storage::disk('public')->delete('profile_picture/' . $user->picture);
                }
                
                $validated['picture'] = $fileName;
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