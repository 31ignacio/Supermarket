<?php

namespace App\Http\Controllers;

use App\Http\Requests\saveProduitRequest;
use App\Models\Produit;
use App\Models\ProduitType;
use App\Models\Categories;
use App\Models\Emplacement;
use App\Models\Fournisseur;
use Exception;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;


use Illuminate\Http\Request;

class ProduitController extends Controller
{
    //
    public function index()
    {
        $produits = Produit::all();
        // $produits = Produit::all()->filter(function ($produit) {
        //     return $produit->produitType_id == 1;
        // });

            // Liste des gros filtré en gros
        // $produitsGros = Produit::all()->filter(function ($produit) {
        //     return $produit->produitType_id == 2;
        // });

        //dd($produits,$produitsGros);
      
        

        return view('Produits.index',compact('produits'));
    }

    // listte des produits filtré en gros
    public function index2()
    {
       
        $produitsGros = Produit::all()->filter(function ($produit) {
            return $produit->produitType_id == 2;
        });

        //dd($produits,$produitsGros);
      
        

        return view('Produits.index2',compact('produitsGros'));
    }


    public function create()
    {
        $categories = Categories::all();
        $emplacements = Emplacement::all();
        $fournisseurs = Fournisseur::all();
        $produitTypes = ProduitType::all();


        return view('Produits.create',compact('categories','emplacements','fournisseurs','produitTypes'));
    }

    public function store(Produit $produit, Request $request)
    {
       $nombreAleatoire = rand(0, 1000); // Utilisation de rand()
       $codeTroisPremiereLettre= substr($request->libelle, 0, 3);
       //dd($codeTroisPremiereLettre);


       // Formatage du nouveau matricule avec la partie numérique
       $code = $codeTroisPremiereLettre . '_' . $nombreAleatoire;

        //Enregistrer un nouveau client
        try {
            $produit->code = $code;
            $produit->categorie_id = $request->categorie;
            $produit->fournisseur_id = $request->fournisseur;
            $produit->emplacement_id = $request->emplacement;
            $produit->libelle = $request->libelle;
            $produit->prix = $request->prix;

            $produit->produitType_id=$request->produitType;
           // dd($request->produitType);
            $produit->quantite = $request->quantite;
            $produit->dateExpiration = $request->dateExpiration;
            $produit->dateReception = $request->dateReception;

            if($request->categorie=="" || $request->fournisseur=="" || $request->emplacement=="" || $request->produitType==""){

                return back()->with('success_message','Vueillez remplir tout les champs');
            }

            //dd($produit);
            $produit->save();

            if($request->produitType == 1){

                return redirect()->route('produit.index')->with('success_message', 'Produit enregistré avec succès');

            }else{
                return redirect()->route('produit.index2')->with('success_message', 'Produit enregistré avec succès');

            }

           // dd($client);

           //return new Response(200);
        } catch (Exception $e) {
            dd($e);
            return new Response(500);
        }
    }

    public function detail($produit)
    {

        $produits = Produit::where('id', $produit)->get();
        //dd($produits);

        return view('Produits.detail',compact('produits'));
    }


    public function edit(Produit $produit)
    {
        //dd($produit);
        $categories = Categories::all();
        $emplacements = Emplacement::all();
        $fournisseurs = Fournisseur::all();
        $produitTypes = ProduitType::all();

        return view('Produits.edit', compact('produit','categories','emplacements','fournisseurs','produitTypes'));
    }

    public function update(Produit $produit, Request $request)
    {
        //Enregistrer un nouveau département
        //dd($produit);        
        try {
            $produit->id = $request->id;
            $produit->code = $request->code;
            $produit->categorie_id = $request->categorie;
            $produit->fournisseur_id = $request->fournisseur;
            $produit->emplacement_id = $request->emplacement;
            $produit->libelle = $request->libelle;
            $produit->prix = $request->prix;
            $produit->produitType_id=$request->produitType;
            $produit->quantite = $request->quantite;
            $produit->dateExpiration = $request->dateExpiration;
            $produit->dateReception = $request->dateReception;
            //dd($produit);
            $produit->update();
            //dd($produit);

            if($produit->produitType_id == 1){

                return redirect()->route('produit.index')->with('success_message', 'Produit modifié avec succès');

            }else{
                return redirect()->route('produit.index2')->with('success_message', 'Produit modifié avec succès');

            }

           // }
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
