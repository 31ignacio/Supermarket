<?php

namespace App\Http\Controllers;
use App\Http\Requests\saveClientRequest;
use Exception;
use App\Models\Client;
use App\Models\Facture;
use App\Models\Rembourssement;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\Response;
use PDF;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;


class ClientController extends Controller
{
    //

    public function index()
    {
        $clients = Client::paginate(10);

        return view('Clients.index',compact('clients'));
    }


    public function detailRembourssement(Request $request){

            
        $code = $request->id2;
        $remboursementss = Rembourssement::where('facture_id', $code)->get();
        
        // if( $remboursementss->items == []){
        //     return back()->with('success', 'Pas de detail de rembourssement pour cette facture');
        // }
        // dd($remboursementss);
        return view('Clients.voir', compact('remboursementss'));

    }
    
    

    public function detail($client)
    {

        $factures = Facture::where('client_id', $client)->get();
        //dd($factures);

        $rembourssements = Rembourssement::all();

        // Créez une collection unique en fonction des colonnes code, date, client et totalHT
        $codesFacturesUniques = $factures->unique(function ($facture) {
            return $facture->code . $facture->date . $facture->totalTTC . $facture->montantPaye . $facture->mode;
        });

        //dd($codesFacturesUniques,$rembourssements);

        return view('Clients.detail', compact('codesFacturesUniques','client','rembourssements'));
    }

    public function create()
    {
        return view('Clients.create');
    }

    public function store(Client $client, saveClientRequest $request)
    {
        //dd(1);
        //Enregistrer un nouveau client
        try {
            $client->nom = $request->nom;
            $client->prenom = $request->prenom;

            $client->societe = $request->societe;

            $client->sexe = $request->sexe;
            $client->telephone = $request->telephone;

            $client->ifu = $request->ifu;

            $client->save();

           // dd($client);

            return redirect()->route('client.index')->with('success_message', 'Client enregistré avec succès');
        } catch (Exception $e) {
            dd($e);
        }
    }

    public function rembourssement(Rembourssement $rembourssement, Request $request){


       // dd($request);
       $dateDuJour = Carbon::now()->format('Y-m-d H:i:s');
        try{
        $rembourssement->date = $dateDuJour;
        $rembourssement->mode = "Rembourssement";
        $rembourssement->montant = $request->rembourssement;
        $rembourssement->facture_id = $request->factureId;
        $rembourssement->save();

        $factures = Facture::where('id', $request->factureId)->first();
        //$facture = Facture::find($request->factureId);

        $montantDu = $factures->montantDu;
       // dd($montantDu);

       
        $resteAPayer = $montantDu - $request->rembourssement;

        Facture::where('id', $request->factureId)->update(['montantDu' => $resteAPayer]);
          

            return new Response(200);
        } catch (Exception $e) {
            dd($e);
            return new Response(500);
        }
    }

    public function edit(Client $client)
    {
        return view('Clients.edit', compact('client'));
    }

    public function update(Client $client, saveClientRequest $request)
    {
        //Enregistrer un nouveau département
        try {
            $client->societe = $request->societe;
            $client->nom = $request->nom;
            $client->prenom = $request->prenom;
            $client->sexe = $request->sexe;
            $client->ifu = $request->ifu;
            $client->telephone = $request->telephone;

            $client->update();

            return redirect()->route('client.index')->with('success_message', 'Client mis à jour avec succès');
        } catch (Exception $e) {
            dd($e);
        }
    }

    public function delete(Client $client)
    {
        //Enregistrer un nouveau département
        try {
            $client->delete();

            return redirect()->route('client.index')->with('success_message', 'Client supprimé avec succès');
        } catch (Exception $e) {
            dd($e);
        }
    }

    public function pdf($rembourssement,$code,Request $request)
    {

        //dd($rembourssement,$code);
          // Obtenir la date du jour
          $dateDuJour = Carbon::now();

          // Vous pouvez formater la date selon vos besoins
          $dateJour = $dateDuJour->format('Y-m-d H:i:s');
  
        try {
            //recuperer tout les information de l'entreprise
            $remboursementss = Rembourssement::where('facture_id',$rembourssement)->get();
            // $remboursements = Remboursement::where('facture_id', $remboursement)->get();

           // dd($remboursementss);
            //$name= $facture['date'];
          // Chargez la vue Laravel que vous souhaitez convertir en PDF
        $html = View::make('Clients.rembourssementFacture',compact('remboursementss','code','dateJour'))->render();


            // Créez une instance de Dompdf
        $dompdf = new Dompdf();

        // Chargez le contenu HTML dans Dompdf
        $dompdf->loadHtml($html);

        // Rendez le PDF
        $dompdf->render();

        // Téléchargez le PDF
        return $dompdf->stream('EtatRembourssement .pdf', ['Attachment' => false]);

        } catch (Exception $e) {
            dd($e);
            throw new Exception("Une erreur est survenue lors du téléchargement de la liste");
        }
    }




}
