<?php

namespace App\Http\Controllers;

use App\Models\Facture;
use App\Models\Client;
use App\Models\Emplacement;
use App\Models\information;
use App\Models\ModePaiement;
use App\Models\Produit;
use App\Models\ProduitType;
use DateTime; // Importez la classe DateTime en haut de votre fichier
use Exception;
use Symfony\Component\HttpFoundation\Response;
use PDF;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;


class FactureController extends Controller
{
    //

    public function index()
    {
        // Récupérer l'utilisateur connecté
        $user = Auth::user();
        //dd($user);
        // Vous pouvez maintenant accéder aux propriétés de l'utilisateur
        $nom = $user->name;
        $role=$user->role_id;
        //dd($role);

        // Récupérer la somme du montantFinal pour l'utilisateur connecté et le rôle donné
        $sommeMontant = Facture::where('user_id', $user->id)
            // ->where('role_id', $role)
            ->whereDate('date', now()) // Filtre pour la date du jour
            ->sum('montantFinal');

            //dd($sommeMontant);

        $factures = Facture::all();
        // Créez une collection unique en fonction des colonnes code, date, client et totalHT
        // $codesFacturesUniques = $factures
        // ->unique(function ($facture) {
        //     return $facture->code . $facture->date . $facture->client . $facture->totalHT . $facture->emplacement;
        // })
        // ->sortByDesc('created_at');

        $codesFacturesUniques = $factures
        ->unique(function ($facture) {
            return $facture->code . $facture->date . $facture->client . $facture->totalHT . $facture->emplacement;
        })
        ->sortByDesc('created_at');

        // Paginer les résultats obtenus
        $perPage = 10;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentPageItems = $codesFacturesUniques->slice(($currentPage - 1) * $perPage, $perPage)->all();

        // Créer une instance de LengthAwarePaginator
        $codesFacturesUniques = new LengthAwarePaginator(
            $currentPageItems,
            $codesFacturesUniques->count(),
            $perPage,
            $currentPage,
            ['path' => LengthAwarePaginator::resolveCurrentPath()]
        );
            

        //$factures = Facture::orderBy('code')->get()->groupBy('code');
       // dd($codesFacturesUniques);
        return view('Factures.index', compact('factures', 'codesFacturesUniques','nom','role'));
    }

    public function point()
    {
        // Récupérer l'utilisateur connecté
        $user = Auth::user();
        //dd($user);
        // Vous pouvez maintenant accéder aux propriétés de l'utilisateur
        $nom = $user->name;
        $role=$user->role_id;
        //dd($role);

       // Récupérer le rôle et l'identifiant de l'utilisateur
       $role_id = $user->role_id;
       $user_id = $user->id;

       // Si l'utilisateur a le rôle avec role_id=2
       if ($role_id === 2 or $role_id === 3) {
           // Récupérer la somme du montantFinal pour le rôle avec role_id=2 et user_id de l'utilisateur connecté
            $sommeMontant = Facture::where('user_id', $user_id)
               ->whereDate('date', now()) // Filtre pour la date du jour
               ->sum('montantFinal');
       } else {
           // Récupérer la somme totale du montantFinal pour la journée
            $sommeMontant = Facture::whereDate('date', now())->sum('montantFinal');
        }
           //dd($sommeMontant);
            $factures = Facture::all();

       // Récupérer les factures du jour pour l'utilisateur connecté
       $codesFacturesUniques = Facture::whereDate('date', Carbon::today())
       ->get();
       //dd($codesFacturesUniques);

        // Paginer les résultats obtenus
        $perPage = 10;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentPageItems = $codesFacturesUniques->slice(($currentPage - 1) * $perPage, $perPage)->all();

        // Créer une instance de LengthAwarePaginator
        $codesFacturesUniques = new LengthAwarePaginator(
            $currentPageItems,
            $codesFacturesUniques->count(),
            $perPage,
            $currentPage,
            ['path' => LengthAwarePaginator::resolveCurrentPath()]
        );
            

        //$factures = Facture::orderBy('code')->get()->groupBy('code');
       // dd($codesFacturesUniques);
        return view('Factures.point', compact('factures', 'codesFacturesUniques','nom','role','sommeMontant'));
    }


    public function details($code, $date)
    {
        // Récupérez les informations nécessaires à partir des paramètres (code et date) et envoyez-les à la vue

        $factures = Facture::all();
        //dd($factures);
        return view('Factures.details', compact('date', 'code', 'factures'));
    }

    
    public function annuler(Request $request)
    {
        // Récupérez les informations nécessaires à partir des paramètres (code et date) et envoyez-les à la vue
        //dd($code);
       // $factures = Facture::where('code',$code)->get();
       $code=$request->factureCode;
      //dd($code);
        $factures = Facture::select('produit', 'quantite')->where('code', $code)->get();
        //dd($request,$factures);
        foreach ($factures as $facture) {
            //c'est la tu feras le jeu
            $produit = Produit::where('libelle', $facture->produit)->first();

            if ($produit) {
                $nouvelleQuantite = $produit->quantite + $facture->quantite - $facture->quantite; // Mettez à jour la nouvelle quantité
        
                // Assurez-vous de mettre à jour le produit avec la nouvelle quantité correcte
                $produit->quantite = $nouvelleQuantite;
                $produit->save();
            }
           // dd($produit);
        }
        //dd($produit);
        // Suppression de toutes les factures avec le code spécifié
        Facture::where('code', $code)->delete();

        //dd($fa);
        return back()->with('success_message', 'La facture a été annulée avec succès.');
    }


    public function create()
    {
        $emplacements = Emplacement::all();
        $clients = Client::all();
        $produits = Produit::all();
        //$produits = Produit::where('produitType_id', 1)->get();
        //dd($produits);
        $produitTypes = ProduitType::all();

        $quantiteSortieParProduit = Facture::select( 'produit', DB::raw('SUM(quantite) as total_quantite'))
        ->groupBy( 'produit')
        ->get();

            //dd($quantiteSortieParProduit);

        // Créez un tableau associatif pour stocker la quantité de sortie par produit
        $quantiteSortieParProduitArray = [];
        foreach ($quantiteSortieParProduit as $sortie) {
            $quantiteSortieParProduitArray[$sortie->produit] = $sortie->total_quantite;
        }

        // Calculez le stock actuel pour chaque produit
        foreach ($produits as $produit) {
            if (isset($quantiteSortieParProduitArray[$produit->libelle])) {
                $stockActuel = $produit->quantite - $quantiteSortieParProduitArray[$produit->libelle];
                $produit->stock_actuel = $stockActuel;
               //dd($stockActuel);
            } else {
                // Si la quantité de sortie n'est pas définie, le stock actuel est égal à la quantité totale
                $produit->stock_actuel = $produit->quantite;
                //dd($produit);
            }
            //$produit= $produit->quantite;
            //dd($produits);
        }
        return view('Factures.create', compact('clients', 'emplacements','produits','produitTypes'));
    }

    public function store(Request $request)
    { 

        if (Auth::check()) {

            // Récupérer les données JSON envoyées depuis le formulaire
            $donnees = json_decode($request->input('donnees'));
            //dd($donnees);
            $client = $request->client;
            //dd($client);
            $dateString = $request->date;
            $totalHT = $request->totalHT;
            $totalTVA = $request->totalTVA;
            $totalTTC = $request->totalTTC;
            $montantPaye = $request->montantPaye;
            $remise = $request->remise;
            $montantFinal = $request->montantFinal;

            $produitType = $request->produitType;
            // Récupère l'utilisateur connecté
            $user = Auth::user();
            //dump($user);
            
            // Vous pouvez accéder aux propriétés de l'utilisateur, par exemple :
            $idUser = $user->id;
            
            $prefix = 'Fact_';
            $nombreAleatoire = rand(0, 10000); // Utilisation de rand()

            // Formatage du nouveau matricule avec la partie numérique
            $code = $prefix . $nombreAleatoire;

            // Convertissez la date en un objet DateTime
            $date = new DateTime($dateString);
            try {
                // Parcourez chaque élément de $donnees et enregistrez-les dans la base de données
                foreach ($donnees as $donnee) {
                    // Créez une nouvelle instance du modèle Facture pour chaque élément
                    $facture = new Facture();

                    // Remplissez les propriétés du modèle avec les données
                    $facture->client = $client; 
                    $facture->date = $date;
                    $facture->produitType_id = $produitType;
                    $facture->totalHT = $totalHT;
                    $facture->totalTVA = $totalTVA;
                    $facture->totalTTC = $totalTTC;
                    $facture->montantPaye =  $montantPaye;
                    $facture->montantRendu =  $montantPaye - $totalTTC;
                    // Vous pouvez accéder aux propriétés de chaque objet JSON
                    $facture->quantite = $donnee->quantite;
                    $facture->produit= $donnee->produit; // Assurez-vous d'utiliser la bonne clé ici
                    $facture->prix = $donnee->prix;
                    $facture->total = $donnee->total;
                    $facture->code = $code;
                    $facture->user_id =$idUser;
                    $facture->reduction =$remise;
                    $facture->montantFinal =$montantFinal;

                    //dd($facture);
                    // Sauvegardez la facture dans la base de données
                    $facture->save();
                }
                return new Response(200);
            } catch (Exception $e) {
                dd($e);
                return new Response(500);
            }
        }else {
            // Aucun utilisateur n'est connecté
            // Rediriger vers la page de connexion avec un message
            return redirect()->route('login')
                            ->with('success_message', 'Veuillez vous connecter pour accéder à cette page.');
        }

        // Répondez avec une réponse de confirmation
        return response()->json(['message' => 'Données enregistrées avec succès']);
    }

    public function pdf($facture,Request $request)
    {
        $date = $request->input('date');
        $code = $request->input('code');
        //$id = $request->input('id');

        //dd($facture);
        try {
            //recuperer tout les information de l'entreprise
            $factures = Facture::all();
            $info = information::first();

            //$name= $facture['date'];
          // Chargez la vue Laravel que vous souhaitez convertir en PDF
        $html = View::make('Factures.facture',compact('factures','info','date','code'))->render();


            // Créez une instance de Dompdf
        $dompdf = new Dompdf();

        // Chargez le contenu HTML dans Dompdf
        $dompdf->loadHtml($html);

        // Rendez le PDF
        $dompdf->render();

        // Téléchargez le PDF
        return $dompdf->stream('Facture .pdf', ['Attachment' => false]);

        } catch (Exception $e) {
            dd($e);
            throw new Exception("Une erreur est survenue lors du téléchargement de la liste");
        }
    }

}
