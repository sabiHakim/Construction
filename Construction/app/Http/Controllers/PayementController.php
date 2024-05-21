<?php

namespace App\Http\Controllers;

use App\Models\DevisModel;
use App\Models\Payement;
use Illuminate\Http\Request;

class PayementController extends Controller
{
    //
    public  function traitpayement(Request $request)
    {
            $request->validate([
                'payement'=>'required',
                'date'=>'required',
            ],
            [
                'payement.required'=>'champs payement requis',
                'date.required'=> 'champs date requis'
            ]);
        $devisId = $request->input('devis');
        $montantPayement = $request->input('payement');
        $devis = DevisModel::find($devisId);
             Payement::inserPayement(session('user'),$request->input('devis'),$request->input('payement'),$request->input('date'));
            return  redirect()->back();
    }
}
