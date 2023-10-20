<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Facture;
use Illuminate\Http\Request;

class AccueilController extends Controller
{
    //

    public function index(){

        $clients = Client::all();
        $factures = Facture::all()->unique('code');
        $sommeTotalTTC = 0;
        $sommeMontantDu=0;
        foreach ($factures as $facture) {
            $sommeTotalTTC += $facture->totalTTC;
            $sommeMontantDu += $facture->montantDu;

        }
        
        //dd($sommeTotalTTC,$sommeMontantDu);
        $nombreClient=count($clients);

        return view('Accueil.index',compact('nombreClient','sommeTotalTTC','sommeMontantDu'));
    }
}
