<?php

namespace App\Http\Controllers;

use App\Models\Facture;
use App\Models\Produit;
use App\Models\Stock;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;


class StockController extends Controller
{
    //

    public function index()
    {

        return view('Stocks.index');
    }

    public function index2()
    {

        return view('Stocks.index2');
    }


    public function create()
    {
        //$produits = Produit::all();
        $produits = Produit::where('produitType_id', 1)->get();


        return view('Stocks.create', compact('produits'));
    }

    public function createGros()
    {
        //$produits = Produit::all();
        $produits = Produit::where('produitType_id', 2)->get();


        return view('Stocks.createGros', compact('produits'));
    }


    public function entrer()
    {
        //$stocks = Stock::all();
        $stocks = Stock::where('produitType_id', 1)->get();

        return view('Stocks.entrer', compact('stocks'));
    }
    public function entrerGros()
    {
        // $stocks = Stock::all();
        $stocks = Stock::where('produitType_id', 2)->get();

        //dd($stocks);

        return view('Stocks.entrerGros', compact('stocks'));
    }


    public function sortie()
    {
        // $factures = Facture::all();
        // dd($factures);

        $factures = Facture::select('date', 'produit', DB::raw('SUM(quantite) as total_quantite'))
    ->where('produitType_id', 1)
    ->groupBy('date', 'produit')
    ->orderBy('date', 'asc')
    ->get();
    //dd($factures);


        return view('Stocks.sortie', compact('factures'));
    }


    public function sortieGros()
    {
        // $factures = Facture::all();
        // dd($factures);

        $factures = Facture::select('date', 'produit', DB::raw('SUM(quantite) as total_quantite'))
    ->where('produitType_id', 2)
    ->groupBy('date', 'produit')
    ->orderBy('date', 'asc')
    ->get();


        return view('Stocks.sortieGros', compact('factures'));
    }


    public function actuel()
    {
        // $produits = Produit::all();

        // $produits = Produit::all()->filter(function ($produit) {
        //     return $produit->produitType_id == 1;
        // });
        $produits = Produit::where('produitType_id', 1)->get();

        // $quantiteSortieParProduit = Facture::select('produit', DB::raw('SUM(quantite) as total_quantite'))
        //     ->groupBy('produit')
        //     ->get();

        //Le stock en fonction de produitType_id
        $produitType_id = 1; // Remplacez cette valeur par celle que vous souhaitez
        $quantiteSortieParProduit = Facture::select('produit', 'produitType_id', DB::raw('SUM(quantite) as total_quantite'))
        ->where('produitType_id', $produitType_id)
        ->groupBy('produit', 'produitType_id')
        ->get();



        // Créez un tableau associatif pour stocker la quantité de sortie par produit
        $quantiteSortieParProduitArray = [];
        foreach ($quantiteSortieParProduit as $sortie) {
            $quantiteSortieParProduitArray[$sortie->produit] = $sortie->total_quantite;
        }

        // Calculez le stock actuel pour chaque produit
        foreach ($produits as $produit) {
            if (isset($quantiteSortieParProduitArray[$produit->libelle])) {
                $stockActuel = $produit->quantite - $quantiteSortieParProduitArray[$produit->libelle];
                $produit->stock_actuel = $stockActuel;$produit->produitType_id=1;
            } else {
                // Si la quantité de sortie n'est pas définie, le stock actuel est égal à la quantité totale
                $produit->stock_actuel = $produit->quantite;
            }
        }

        return view('Stocks.actuel', compact('produits'));
    }

    public function actuelGros()
    {
        // $produits = Produit::all();

        // $produits = Produit::all()->filter(function ($produit) {
        //     return $produit->produitType_id == 2;
        // });
        $produits = Produit::where('produitType_id', 2)->get();


        // $quantiteSortieParProduit = Facture::select('produit', DB::raw('SUM(quantite) as total_quantite'))
        //     ->groupBy('produit')
        //     ->get();

        $produitType_id = 2; // Remplacez cette valeur par celle que vous souhaitez

        $quantiteSortieParProduit = Facture::select('produit', 'produitType_id', DB::raw('SUM(quantite) as total_quantite'))
        ->where('produitType_id', $produitType_id)
        ->groupBy('produit', 'produitType_id')
        ->get();
        



        // Créez un tableau associatif pour stocker la quantité de sortie par produit
        $quantiteSortieParProduitArray = [];
        foreach ($quantiteSortieParProduit as $sortie) {
            $quantiteSortieParProduitArray[$sortie->produit] = $sortie->total_quantite;
        }

        // Calculez le stock actuel pour chaque produit
        foreach ($produits as $produit) {
            if (isset($quantiteSortieParProduitArray[$produit->libelle])) {
                $stockActuel = $produit->quantite - $quantiteSortieParProduitArray[$produit->libelle];
                $produit->stock_actuel = $stockActuel;$produit->produitType_id=2;
            } else {
                // Si la quantité de sortie n'est pas définie, le stock actuel est égal à la quantité totale
                $produit->stock_actuel = $produit->quantite;
            }
        }

        return view('Stocks.actuelGros', compact('produits'));
    }


    public function store(Request $request)
    {
        //dd($request);
        $stock = new Stock();

        // Obtenir la date du jour
        $dateDuJour = Carbon::now();

        // Vous pouvez formater la date selon vos besoins
        $dateFormatee = $dateDuJour->format('Y-m-d H:i:s');
        // Récupérer les données JSON envoyées depuis le formulaire
        $stock->libelle = $request->produit;
        //$stock->ref = 001;

        $stock->quantite = $request->quantite;
        $stock->date = $dateDuJour;
        $stock->produitType_id = 1;

        $stock->save();

        // $produit = Produit::where('libelle', $request->produit)->first();
        $produit = Produit::where('libelle', $request->produit)
                  ->where('produitType_id', 1)
                  ->first();
                 // dd($produit);


        //dd($produit);
        // Mettez à jour la quantité du produit
        $nouvelleQuantite = $produit->quantite + $request->quantite;
        $produit->update(['quantite' => $nouvelleQuantite]);

        return redirect()->route('stock.entrer')->with('success_message', 'Stock entrés avec succès.');
    }

    public function storeGros(Request $request)
    {
        //dd($request);
        $stock = new Stock();

        // Obtenir la date du jour
        $dateDuJour = Carbon::now();

        // Vous pouvez formater la date selon vos besoins
        $dateFormatee = $dateDuJour->format('Y-m-d H:i:s');
        // Récupérer les données JSON envoyées depuis le formulaire
        $stock->libelle = $request->produit;
        //$stock->ref = 001;

        $stock->quantite = $request->quantite;
        $stock->date = $dateDuJour;
        $stock->produitType_id = 2;

        $stock->save();

        // $produit = Produit::where('libelle', $request->produit)->first();

        $produit = Produit::where('libelle', $request->produit)
                  ->where('produitType_id', 2)
                  ->first();
            //dd($produit);

        //dd($produit);
        // Mettez à jour la quantité du produit
        $nouvelleQuantite = $produit->quantite + $request->quantite;
        $produit->update(['quantite' => $nouvelleQuantite]);

        return redirect()->route('stock.entrerGros')->with('success_message', 'Stock entrés avec succès.');
    }


    

    public function transferer(Request $request)
    {
        $produit_id = $request->input('produit_id');
        $produit_libelle = $request->input('produit_libelle');
        $produit_quantite = $request->input('produit_quantite');
        //dd($produit_id,$produit_libelle,$produit_quantite);

        return view('Stocks.transferer', compact('produit_id', 'produit_libelle', 'produit_quantite'));
    }


    public function final(Request $request)
    {
        $id = $request->input('produit_id');
        $libelle = $request->input('produit_libelle');
        $quantite = $request->input('produit_quantite');
        $transferer = $request->input('transferer');

        //control sur la quantité
        if ($quantite < $transferer) {
            return back()->with('success_message', "La quantité actuelle du produit est inférieure à la quantité que vous souhaitez transférer.");
        } else {





            $produits = Produit::all()->filter(function ($produit) {
                return $produit->produitType_id == 1;
            });



            //recupere le produit en detail qui a ce libelle
            $produitss = Produit::all()->filter(function ($produit) use ($libelle) {
                return $produit->produitType_id == 1 && $produit->libelle == $libelle;
            });
            //dd($produitss);
            if ($produitss->isEmpty()) {
                return back()->with('success_message', "Le produit que vous tentez de transférer n'existe pas dans les détails des produits.");
            } else {

                //recupere le produit en gros qui a ce libelle
                $produits1 = Produit::all()->filter(function ($produit) use ($libelle) {
                    return $produit->produitType_id == 2 && $produit->libelle == $libelle;
                });

                //recupere le premier produit
                $produit = $produitss->first(); // Supposons que vous souhaitez travailler avec le premier produit de la collection
                $produit1 = $produits1->first(); // Supposons que vous souhaitez travailler avec le premier produit de la collection

                // Récupérez la quantité du produit et ajoutez la quantité spécifiée dans $transferer
                $quantiteTotale = $produit->quantite + $transferer;
                $quantiteTotale1 = $produit1->quantite - $transferer;

                //dd($quantiteTotale);
                // Faites ce que vous souhaitez avec $quantiteTotale, par exemple, mettez à jour la quantité dans la base de données
                $produit->update(['quantite' => $quantiteTotale]);
                $produit1->update(['quantite' => $quantiteTotale1]);

                // Vous pouvez également créer un nouvel objet Produit avec la quantité mise à jour si nécessaire
                // $produitMiseAJour = new Produit(['quantite' => $quantiteTotale]);

                //dd($id, $libelle, $quantite, $transferer,$produits);

                return view('Stocks.actuel', compact('produits'));
            }
        }
    }
}
