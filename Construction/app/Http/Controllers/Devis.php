<?php

namespace App\Http\Controllers;

use App\Models\DevisModel;
use App\Models\Finalite;
use App\Models\Maison;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class Devis extends Controller
{
    public  function  addDevis()
    {
            $allMaison = Maison::all();
            $finition = Finalite::all();
            return view('devis.addDevis',compact('allMaison','finition'));
    }
    public  function  Detail($idM)
    {
        $res = DevisModel::detail($idM);
        return view('devis.detailDevis',compact('res'));
    }
    public  function  exporter($idd)
    {
        $res = DevisModel::detail($idd);
        $pdf = PDF::loadView('devis.pdf', compact('res'));
        return $pdf->download('PdfDevis.pdf');
    }
    public  function  traitAddDevis(Request $request)
    {
        $user = session('user');
        $m = $request->input('maison');
        $f = $request->input('finition');
        $d = $request->input('date');
        $reference = $request->input('reference');
        $lieu = $request->input('lieu');
         DevisModel::insertDevisClient($reference,$user,$m,$f,$d,$lieu);
         return redirect()->back();
    }
    public  function  addpayement()
    {
         $id =  session('user');
        $allDevise = DevisModel::getDevis($id);
        return view('devis.payement',compact('allDevise'));
    }
    public  function  DetailDevisAdmin($id)
    {
        $res = DevisModel::getTravaux_MaisonAdmin($id);
//            dd($res);
        return view('acceuilAdmin.detailTravauxMaison', compact('res'));
    }
    public function getSumDevisByYear(Request $request)
    {
        $year = $request->input('date');
        $query = "
        SELECT
            TO_CHAR(date_debut_travaux, 'Month') AS month,
            SUM(prixtotal) AS total
        FROM devis_client
        WHERE EXTRACT(YEAR FROM date_debut_travaux) =?
        GROUP BY month;
    ";
        $results = DB::select($query, [$year]);
        $formattedResults = [];
        foreach ($results as $result) {
            $formattedResults[ucfirst($result->month)] = $result->total;
        }
        $dev = DevisModel::getAllDevis();
        $sum = DevisModel::getsumAllDevis();
        return view('acceuilAdmin.accAdmin', compact('formattedResults','dev','sum')); // Assurez-vous que 'chart' est le nom de votre vue
    }


}
