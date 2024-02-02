<?php

namespace App\Http\Controllers;

use App\Http\Requests\createUsersRequest;
use App\Models\information;
use App\Models\User;
use App\Models\Role;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Exception;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session as FacadesSession;

class AdminController extends Controller
{
    //
    
    public function index(){
      // dd(Auth::id());
      $admins = User::where('estActif', 0)->get();
        return view('Admin.index',compact('admins'));
    }

    public function indexInfo(){

        $informations = information::all();
        return view('Informations.index',compact('informations'));
    }


    public function index2(){
        
        $admins = User::where('estActif', 1)->get();
        return view('Admin.index2',compact('admins'));
    }


    public function create(){

        $roles = Role::all();
        return view('Admin.create',compact('roles'));
    }


    public function store(User $user,createUsersRequest $request)
    {

        try {
            $confirm= $request->confirm_password;

            $user->name = $request->name;
            $user->email = $request->email;
            $user->telephone = $request->telephone;
            $user->role_id= $request->role;
            $user->password =Hash::make($request->password);
            $user->save();

            return redirect()->route('admin')->with('success_message', 'Utilisateur ajouté avec succès');
            
        } catch (Exception $e) {
            dd($e);
            throw new Exception('Une erreur est survenue lors de la création de cet utilisateur');
        }
    }

    public function createInfo(){

        return view('Informations.create');
    }


    public function storeInfo(information $info,Request $request)
    {

        try {

            $info->nom = $request->nom;
            $info->adresse = $request->adresse;
            $info->telephone = $request->telephone;
            $info->ifu= $request->ifu;
            //dd($user);

            $info->save();

            
            return redirect()->route('information')->with('success_message', 'Information ajoutée avec succès');
            
        } catch (Exception $e) {
            dd($e);
            throw new Exception('Une erreur est survenue lors de la création de cet utilisateur');
        }
    }

   
    public function logout(){

        FacadesSession::flush();
        Auth::logout();

        return redirect()->route('login');
    }

    public function disable(User $user)
    {
        $user->estActif = 1; // Pour désactiver l'utilisateur, on met estActif à 0
        $user->update();

        //dd($user);
        
        // Vous pouvez également retourner une réponse JSON si nécessaire
        return redirect()->route('admin')->with('success_message', 'Utilisateur désactivé avec succès');
    }

    
    public function active(User $user)
    {
        $user->estActif = 0; // Pour désactiver l'utilisateur, on met estActif à 0
        $user->update();
        
        // Vous pouvez également retourner une réponse JSON si nécessaire
        return redirect()->route('admin')->with('success_message', 'Utilisateur activé avec succès');
    }


    public function edit(User $admin)
    {
        
        return view('Admin.edit', compact('admin'));
    }

    public function update(User $admin, Request $request)
    {
        //Enregistrer un nouveau département
        try {
            $admin->name = $request->nom;
            $admin->email = $request->email;
            $admin->telephone = $request->telephone;
            $admin->role_id = $request->role;

            $admin->update();
            //return back()->with('success_message', 'Utilisateur mis à jour avec succès');

            return redirect()->route('admin')->with('success_message', 'Utilisateur mis à jour avec succès');
        } catch (Exception $e) {
            dd($e);
        }
    }


    public function editInfo(information $information)
    {
        return view('Informations.edit', compact('information'));
    }

    public function updateInfo(information $info, Request $request)
    {
        //dd($info);
        //Enregistrer un nouveau département
        try {
            $info->id = $request->id;

            $info->nom = $request->nom;
            $info->adresse = $request->adresse;
            $info->telephone = $request->telephone;
            $info->ifu= $request->ifu;
                //dd($info);
            $info->update();
            //return back()->with('success_message', 'Utilisateur mis à jour avec succès');
               // dd($info);
            return redirect()->route('information')->with('success_message', 'information modifiée avec succès');
        } catch (Exception $e) {
            dd($e);
        }
    }


    public function delete(User $admin)
    {
        //Enregistrer un nouveau département
        try {
            $admin->delete();

            return redirect()->route('admin')->with('success_message', 'Utilisateur supprimé avec succès');
        } catch (Exception $e) {
            dd($e);
        }
    }



}
