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

use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{
    //

    public function index()
    {
        $clients = Client::paginate(10);

        return view('Clients.index',compact('clients'));
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

    public function rembourssement(Rembourssement $facture, Request $request){


       // dd($request);
        try {
            // Obtenir la date du jour
        $dateDuJour = Carbon::now();

        // Vous pouvez formater la date selon vos besoins
        $dateFormatee = $dateDuJour->format('Y-m-d H:i:s');

            $facture->date = $dateFormatee;
            $facture->mode= "Rembourssement";

            $facture->montant = $request->rembourssement;
            $facture->facture_id = $request->factureId;

                ///dd($facture);

            $facture->save();

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




}
