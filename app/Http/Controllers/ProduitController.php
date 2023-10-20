<?php

namespace App\Http\Controllers;

use App\Http\Requests\saveProduitRequest;
use Exception;
use App\Models\Produit;
use Symfony\Component\HttpFoundation\Response;


use Illuminate\Http\Request;

class ProduitController extends Controller
{
    //
    public function index()
    {
        $produits = Produit::paginate(10);

        return view('Produits.index',compact('produits'));
    }

    public function create()
    {
        return view('Produits.create');
    }

    public function store(Produit $produit, Request $request)
    {
       // dd(1);
        //Enregistrer un nouveau client
        try {
            $produit->ref = $request->ref;
            $produit->libelle = $request->libelle;
            $produit->quantite = $request->quantite;
            $produit->date = $request->date;

            //dd($produit);
            $produit->save();

           // dd($client);

           return new Response(200);
        } catch (Exception $e) {
            dd($e);
            return new Response(500);
        }
    }

    public function edit(Produit $produit)
    {
        return view('Produits.edit', compact('produit'));
    }

    public function update(Produit $produit, Request $request)
    {
        //Enregistrer un nouveau département
        try {
            $produit->ref = $request->ref;
            $produit->libelle = $request->libelle;
            $produit->quantite = $request->quantite;
            $produit->date = $request->date;

            $produit->update();

            return redirect()->route('produit.index')->with('success_message', 'Produit mis à jour avec succès');
        } catch (Exception $e) {
            dd($e);
        }
    }

    public function delete(Produit $produit)
    {
        //Enregistrer un nouveau département
        try {
            $produit->delete();

            return redirect()->route('produit.index')->with('success_message', 'Produit supprimé avec succès');
        } catch (Exception $e) {
            dd($e);
        }
    }




}
