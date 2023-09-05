<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Personnel;
use App\Models\Pointage;
use App\Models\Structure;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function index(){

        // get all users form users table
        $users = User::all();
        $allUsers = [];
        foreach ($users as $user){
            $personnel = $user->personnel;
            $user->structure_id != null ? $structure = $user->structure->nom : $structure = "/";
            $allUsers[] = [
                "id" => $user->id,
                "personnel_id" => $personnel->id,
                "nom" => $personnel->nom,
                "prenom" => $personnel->prenom,
                "sexe" => $personnel->sexe,
                "email" => $user->email,
                "structure" => $structure,
                "status" => $user->is_active,
                "admin" => $user->is_admin
            ];
        }

        return view("Users.index", ["users" => $allUsers]);
    }

    public function create(){
        $sructures = Structure::orderBy("nom", 'asc')->get();

        return view("Users.create", ["structures" => $sructures]);
    }

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'nom' => 'required|min:3',
            'prenom' => '',
            'sexe' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required|min:6|max:20',
            'confirm' => 'required',
            "structure_id" => "required"
        ]);

        // check of password != confirm
        if ($request->password !== $request->confirm){
            return redirect()->back()->with("fail", "Erreur : Les mots de passe sont différents.");
        }

        // create personnel with nom, premom, sexe
        $personnel = Personnel::create([
            "nom" => $request->nom,
            "prenom" => $request->prenom,
            "sexe" => $request->sexe
        ]);

        // create user with $personnel->, email and password
        User::create([
            "personnel_id" => $personnel->id,
            "email" => $request->email,
            "password" => Hash::make($request->password),
            "structure_id" => $request->structure_id
        ]);

        return redirect()->back()->with("success", "Utilisateur créé avec succès.");
    }

    public function edit(int $id){
        $user = User::findOrfail($id);
        $userStructure = $user->structure;
        $structures = Structure::orderBy("nom", "asc")->get();
        return view('Users.edit', ["user" => $user, "structures" => $structures, "userStructure" => $userStructure]);
    }

    public function update(Request $request, int $id){
        $user = User::find($id);

        $request->validate([
            'nom' => 'required|min:3',
            'prenom' => '',
            'sexe' => 'required',
            'email' => 'required',
            'oldpassword' => '',
            'password' => 'nullable|max:20',
            'confirm' => '',
            'structure_id' => 'required'
        ]);

        // verify
        if ($request->oldpassword != null){

            if ($request->password != $request->confirm){
                return redirect()->back()->with("fail", "Les nouveaux mot de passe sont differents, veuillez réessayer...");
            }else{
                $user->personnel->update([
                    "nom" => $request->nom,
                    "prenom" => $request->prenom,
                    "sexe" => $request->sexe
                ]);

                $user->update([
                    "email" => $request->email,
                    'structure_id' => $request->structure_id,
                    "password" => Hash::make($request->password),
                ]);
            }

        }else{
            $user->personnel->update([
                "nom" => $request->nom,
                "prenom" => $request->prenom,
                "sexe" => $request->sexe
            ]);

            $user->update([
                "email" => $request->email,
                'structure_id' => $request->structure_id,
            ]);

        }

        return redirect()->back()->with("success", "Informations modifiées avec succès.");

    }

    public function setActiveStatus(int $id){
        $user = User::find($id);
        $is_active = $user->is_active;
        $user->update(["is_active" => !$is_active]);

        return redirect()->back()->with("success", "Statut de l'utilisateur mis à jour avec succès");
    }

    public function setAdminStatus(int $id){
        $user = User::find($id);
        $is_admin = $user->is_admin;
        $user->update(["is_admin" => !$is_admin]);

        return redirect()->back()->with("success", "Statut de l'utilisateur mis à jour avec succès");
    }

}
