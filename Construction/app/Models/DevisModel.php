<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class DevisModel extends Model
{
    use HasFactory;
    public  $timestamps = false;
    public int $nbr;
    public String $nb;

    protected  $table = 'devis_client';
    protected  $fillable = ['id','reference','idclient','date_debut_travaux','date_fin','idmaison','date_devis'];
        public   static  function getDuree($idMaison)
        {
              $duree =  DB::select("select * from maisons where id = ?", [$idMaison]);
              return $duree;
        }
        public  static function getDevis($idc)
        {
                $res = DB::select("select * from devis_client where idclient = ?",[$idc]);
                return $res;
        }
        public static function  getlastDevis()
        {
            $result = DB::select("select * from devis_client order by id desc limit 1");
            return $result;
        }
        public  static function getTravauxByMaison($id)
        {
            $result = DB::select("SELECT * FROM  Details_travaux where maisonid = ? ",[$id]);
            return $result;
        }
        public  static function detail($id)
        {
            $result = DB::select("SELECT * FROM  vue_detail_travaux where iddevis = ? ",[$id]);
            return $result;
        }
        public static function getfinitionByid($id)
        {
            $f  = DB::select("select pourcentage from finition where id = ?",[$id]);
            foreach ($f as $finition){
                return $finition->pourcentage;
            }

        }
        public  static function getAllDevis()
        {
            $re = DB::select("select * from vue_devis_payement");
            return $re;
        }
        public  static function pourcentage($total,$payement)
        {
            $re = ($payement*100)/$total;
            return $re;
        }

        public  static function getTravaux_MaisonAdmin($id)
        {
            $res = DB::select("SELECT * FROM vue_details_travaux where maisonid = ?",[$id]);
            return $res;
        }
        public static function insertDevisClient($reference,$idClient,$date_devis,$idmaison,$fi,$lieu,$date_debut_travaux)
        {
                $fin = 0;
                $j  = (self::getDuree($idmaison));
                $date_debut = Carbon::parse($date_debut_travaux);
                foreach ($j as $jour){
                $fin  = $date_debut->addDays($jour->dureconstruction);
                $fin = $fin->toDateString();
            }
            $fin = $fin;
            $travaux=self::getTravauxByMaison($idmaison);
            $finition = self::getfinitionByid($fi);
            $total = 0;
            for ($i =  0; $i< count($travaux);$i++)
            {
                $var = ($travaux[$i]->pu*$travaux[$i]->qte);
                $total = $total +$var;
            }
            $total = $total+($total * ($finition/100));
            $result =  DB::select( "insert into devis_client(reference,idclient,date_devis,date_debut_travaux,date_fin,idmaison,finition,lieu,prixtotal) values(?,?,?,?,?,?,?,?,?)",[$reference,$idClient,$date_devis,$date_debut_travaux,$fin,$idmaison,$fi,$lieu,$total]);
            $last  = self::getlastDevis();
            foreach ($last as $l){
                $travaux=self::getTravauxByMaison($l->idmaison);
                foreach ($travaux as $trav)
                {
                    $result1 =  DB::select( "insert into detail_devis(iddevis,idtravaux,unite,qte,pu) values(?,?,?,?,?)",[$l->id,$trav->idtravaux,$trav->unite,$trav->qte,$trav->pu]);
                }
            }
        }
        public  static  function  getsumAllDevis()
        {
            $res = DB::select("select sum(prixtotal) from devis_client");
            return $res;
        }
    public static function generate_client(){
        DB::select("select generate_client()");
    }
    public static function generate_finition()
    {
        DB::select("select generate_finition()");
    }
    public static function generateDevis(){
        $csvDevis = CsvDevis::all();
        foreach ($csvDevis as $devi){
        self::insertDevisClient($devi->reference,Client::get_ID_BY_num($devi->client),$devi->datedevis,Maison::get_ID_BY_nomM($devi->maison),Finalite::get_ID_BY_nom($devi->finition), $devi->lieu,$devi->datedebut);
        }
    }
    public static function get_id_Devis_by($reference)
    {
        $res =  DB::select("select id from devis_client where reference =?",[$reference]);
        foreach ($res as $r)
        {
            $reulat = $r->id;
        }
        return $reulat ;
    }

}
