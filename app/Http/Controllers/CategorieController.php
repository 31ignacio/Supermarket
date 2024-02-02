<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CategorieController extends Controller
{
    //

    public function index()
    {
        $categories = Categories::paginate(10);

        return view('Categories.index',compact('categories'));
    }

    public function create()
    {
        return view('Categories.create');
    }

    public function store(Categories $categorie, Request $request)
    {
        //Enregistrer un nouveau client
        try {
            $categorie->categorie = $request->categorie;
        
            $categorie->save();

            return new Response(200);
        } catch (Exception $e) {
            dd($e);
            return new Response(500);
        }
    }

    public function delete(Categories $categorie)
    {
        //Enregistrer un nouveau département
        try {
            $categorie->delete();

            return redirect()->route('categorie.index')->with('success_message', 'Catégorie supprimé avec succès');
        } catch (Exception $e) {
            dd($e);
        }
    }

    public function edit(Categories $categorie)
    {
        return view('Categories.edit', compact('categorie'));
    }

    public function update(Categories $categorie, Request $request)
    {
        //Enregistrer un nouveau département
        try {
            $categorie->categorie = $request->categorie;

            $categorie->update();

            return redirect()->route('categorie.index')->with('success_message', 'Catégorie mis à jour avec succès');
        } catch (Exception $e) {
            dd($e);
        }
    }

}
