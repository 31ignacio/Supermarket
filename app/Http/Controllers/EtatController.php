<?php

namespace App\Http\Controllers;

use App\Models\Facture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EtatController extends Controller
{
    //
    public function search(Request $request)
    {
        $query = Facture::query();
    
        if ($request->filled('dateDebut')) {
            $query->where('date', '>=', $request->dateDebut);
        }
    
        if ($request->filled('dateFin')) {
            $query->where('date', '<=', $request->dateFin);
        }
    
        if ($request->filled('client')) {
            $query->where('client', 'like', '%' . $request->nom . '%');
        }
        
    
        $results = $query->groupBy('code')->get();
        //dd($results);
    
        return view('Etats/index', compact('results'));
    }
    
    

}
