<?php

namespace App\Http\Controllers;

use App\Imports\DevisImport;
use App\Imports\MaisonImport;
use App\Imports\PayementImport;
use App\Models\csvDevis;
use App\Models\csvmaison;
use App\Models\csvPayement;
use App\Models\DevisModel;
use App\Models\Maison;
use App\Models\Payement;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
//
public  function  testDate()
{
  dd(Maison::checkDate('10/01/2024'));
}
public function  import(Request $request)
    {
        return view('import.import');
    }
    public  function  MaisonDevis(Request $request)
    {
        DB::beginTransaction();
        try {
            if ($request->hasFile('file') && $request->hasFile('filedevis')) {
//            maison et travaux
                $file = $request->file("file");
                $nomFichier = Carbon::now()->format('Ymd_His') .'_'. $file->getClientOriginalName();
                $file->move(public_path('upload'), $nomFichier);
                $data = Excel::toArray(new MaisonImport(), 'upload/'. $nomFichier);
                $error = [];
                $tab = [];
//            convertion virgule en point et emplacement de données
                foreach($data as $tableau){
                    for($i = 0 ; $i < count($tableau); $i++){
                        if(isset($tableau[$i]['surface']) && isset($tableau[$i]['prix_unitaire']) && isset($tableau[$i]['quantite']) && isset($tableau[$i]['duree_travaux'])){
                            $tableau[$i]['surface'] = str_replace(',', '.', $tableau[$i]['surface']);
                            $tableau[$i]['prix_unitaire'] = str_replace(',', '.', $tableau[$i]['prix_unitaire']);
                            $tableau[$i]['quantite'] = str_replace(',', '.', $tableau[$i]['quantite']);
                            $tableau[$i]['duree_travaux'] = str_replace(',', '.', $tableau[$i]['duree_travaux']);
                        }
                    }
                    array_push($tab,$tableau);
                }
//                dd($tab);
//             teste erreur maison et travaux
                foreach ($tab as $data){
                    for($i = 0 ; $i < count($data) ; $i++){
                        if(!Maison::checkNombre($data[$i]['surface'])){
                            $error[] = "Erreur sur le fichier maison .Surface à la ligne ". ($i + 1)." : ".$data[$i]['surface'];
                        }
                        if(!Maison::checkNombre($data[$i]['prix_unitaire'])){
                            $error[] = "Erreur sur le fichier maison .Prix unitaire pour la ligne ". ($i + 1)." : ".$data[$i]['prix_unitaire'];
                        }
                        if(!Maison::checkNombre($data[$i]['quantite'])){
                            $error[] = "Erreur sur le fichier maison la quantite pour la ligne ". ($i + 1)." : ".$data[$i]['quantite'];
                        }
                        if(!Maison::checkNombre($data[$i]['duree_travaux'])){
                            $error[] = "Erreur sur le fichier maison la durée de travaux pour la ligne ". ($i + 1)." : ".$data[$i]['duree_travaux'];
                        }
                    }
                }
//            devis
                $filedevis = $request->file("filedevis");
                $nomFichierdevis = Carbon::now()->format('Ymd_His') .'_'. $file->getClientOriginalName();
                $filedevis->move(public_path('upload'), $nomFichierdevis);
                $dataDevis = Excel::toArray(new DevisImport(), 'upload/'. $nomFichierdevis);
                $tabDevis = [];
                foreach($dataDevis as $tableauDevis){
                    for($i = 0 ; $i < count($tableauDevis); $i++){
                        if(isset($tableauDevis[$i])){
                            $tableauDevis[$i]['taux_finition'] = str_replace(',', '.', $tableauDevis[$i]['taux_finition']);
                            $tableauDevis[$i]['taux_finition'] = str_replace('%', '', $tableauDevis[$i]['taux_finition']);
                        }
                    }
                    array_push($tabDevis,$tableauDevis);
                }

//                dd($tabDevis);
//                teste erreur devis
                foreach ($tabDevis as $devis){
                    for($i = 0 ; $i < count($devis) ; $i++){
                        if(!Maison::checkNombre($devis[$i]['taux_finition'])){
                            $error[] = "Erreur sur le fichier devis .Taux finition à la ligne ". ($i + 1)." : ".$devis[$i]['taux_finition'];
                        }
                        if(!Maison::checkDate($devis[$i]['date_devis'])){
                            $error[] = "Erreur sur le fichier devis .Date de devis à la ligne ". ($i + 1)." : ".$devis[$i]['date_devis'];
                        }
                        if(!Maison::checkDate($devis[$i]['date_debut'])){
                            $error[] = "Erreur sur le fichier devis .Date de debut à la ligne ". ($i + 1)." : ".$devis[$i]['date_debut'];
                        }
                    }
                }
                if(!empty($error)) {
                    return view('import.import',compact('error'));
                }else{
//                maison et travaux
                    foreach ($tab as $data) {
                        for ($i = 0; $i < count($data) ; $i++) {
                            $dataMaison = array(
                                'maison' => $data[$i]['type_maison'],
                                'description' => $data[$i]['description'],
                                'surface' => $data[$i]['surface'],
                                'code' => $data[$i]['code_travaux'],
                                'nomcode' => $data[$i]['type_travaux'],
                                'unite' => $data[$i]['unite'],
                                'pu' => $data[$i]['prix_unitaire'],
                                'quantite' => $data[$i]['quantite'],
                                'duree' =>  $data[$i]['duree_travaux'],
                            );
                            csvmaison::insert($dataMaison);
                        }
                    }
//                    dd($dataMaison);
//                    devis
                    foreach ($tabDevis as $dataDev){
                        for ($i = 0; $i < count($dataDev) ; $i++) {
                            csvDevis::create([
                                'client' => $dataDev[$i]['client'],
                                'reference' => $dataDev[$i]['ref_devis'],
                                'maison' => $dataDev[$i]['type_maison'],
                                'finition' => $dataDev[$i]['finition'],
                                'taux_finition' => $dataDev[$i]['taux_finition'],
                                'datedevis' => $dataDev[$i]['date_devis'],
                                'datedebut' => $dataDev[$i]['date_debut'],
                                'lieu' => $dataDev[$i]['lieu']
                            ]);
                        }
                    }
                    Maison::generateMaison();
                    Maison::generate_unite();
                    Maison::generate_travaux();
                    Maison::generate_travaux_Detail();
                    DevisModel::generate_client();
                    DevisModel::generate_finition();
                    DevisModel::generateDevis();
                    DB::commit();
                    return redirect()->back();
                }
            }
        }catch(\Exception $e){
            DB::rollBack();
            echo $e->getMessage();
            return redirect()->back()->with('error',$e->getMessage());


        }
    }
    public  function  payement(Request $request)
    {
        DB::beginTransaction();
        try {
            if ($request->hasFile('file')) {
//           payement
                $file = $request->file("file");
                $nomFichier = Carbon::now()->format('Ymd_His') .'_'. $file->getClientOriginalName();
                $file->move(public_path('upload'), $nomFichier);
                $data = Excel::toArray(new PayementImport(), 'upload/'. $nomFichier);
                $error = [];
                foreach ($data as $dat){
                    for($i = 0 ; $i < count($dat) ; $i++){
                        if(!Maison::checkNombre($dat[$i]['montant'])){
                            $error[] = "Erreur sur le fichier payement .montant à la ligne ". ($i + 1)." : ".$dat[$i]['montant'];
                        }
                        if(!Maison::checkDate($dat[$i]['date_paiement'])){
                            $error[] = "Erreur sur le fichier payement .date_paiement à la ligne ". ($i + 1)." : ".$dat[$i]['date_paiement'];
                        }

                    }
                }

                if(!empty($error)) {
                    return view('import.import',compact('error'));
                }else{
//             payement
                    foreach ($data as $dataa) {
                        for ($i = 0; $i < count($dataa) ; $i++) {
                            Payement::inserPayementcsv( $dataa[$i]['ref_paiement'], DevisModel::get_id_Devis_by($dataa[$i]['ref_devis']),$dataa[$i]['montant'],$dataa[$i]['date_paiement']);
                        }
                    }
                    DB::commit();
                    return redirect()->back();
                }
            }
        }catch(\Exception $e){
            DB::rollBack();
            echo $e->getMessage();
            return redirect()->back()->with('error',$e->getMessage());


        }
    }
}
