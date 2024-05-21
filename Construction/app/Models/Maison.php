<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DateTime;
use Illuminate\Support\Facades\DB;

class Maison extends Model
{
    use HasFactory;
    public  $timestamps = false;
    protected $table = 'maisons';
    protected $fillable = ['id','nom','description','surface','dureconstruction'];
    public static function checkNombre($nombre) {
        $pattern = '/[^a-zA-Z0-9.\sàâäèéêëïîôöùûüÀÂÄÈÉÊËÏÎÔÖÙÛÜ]/';
        if (preg_match($pattern, $nombre)) {
            return false;
        }
        if ($nombre < 0) {
            return false;
        }
        return true;
    }
    public static function get_ID_BY_nomM($nom)
    {
        $res =   DB::select("select id from maisons where nom =?",[$nom]);
        foreach ($res as $r){
            $result  =  $r->id;
        }
        return $result;
    }
//    public static function checkDate($date, $format = 'd/m/Y') {
//        $d = DateTime::createFromFormat($format, $date);
//        $date_errors = DateTime::getLastErrors();
//        dd($date_errors);
//        if ($date_errors['warning_count'] || $date_errors['error_count']) {
//            return false;
//        }
//        return true;
//    }
    public static function generateMaison(){
        DB::select("select generate_maison()");
    }
    public static function generate_unite(){
        DB::select("select generate_unite()");
    }
    public static function generate_travaux(){
        DB::select("select generate_travaux()");
    }
    public static function generate_travaux_Detail(){
            $maisons = Maison::all();
            foreach ($maisons as $m) {
                $detail_travaux = DB::select("SELECT code_travaux, type_travaux, unite, prix_unitaire, quantite FROM csvmaison WHERE type_maison =?", [$m->nom]);
                if(!empty($detail_travaux)){
                    foreach ($detail_travaux as $c) {
                    $idTravaux =  DB::select("select id from travauxx where code_travaux = ?",[$c->code_travaux]);
                    foreach ($idTravaux  as $id){
                        $konty = new DetailTravaux();
                        $konty->maisonid = $m->id;
                        $konty->idtravaux = $id->id;
                        $konty->unite = Unite::where('nom', $c->unite)->first()->id;
                        $konty->qte = $c->quantite;
                        $konty->pu = $c->prix_unitaire;
                        $konty->save();
                     }
                    }
                }
            }

    }
   public  static function  checkDate($date)
    {
        $dateParts = explode("/", $date);
        $day = intval($dateParts[0]);
        $month =intval($dateParts[1]);
        $year = intval($dateParts[2]);
        $tab[0]=31;
        $tab[1]=28;
        $tab[2]=31;
        $tab[3]=30;
        $tab[4]=31;
        $tab[5]=30;
        $tab[6]=31;
        $tab[7]=31;
        $tab[8]=30;
        $tab[9]=31;
        $tab[10]=30;
        $tab[11]=31;
        if($year % 4 ==0)
        {
            $tab[1] = 29;
        }
        if($day > $tab[$month-1])
        {
            return false;
        }
        else{
            // echo" date valide";
            return true;
        }
    }
}
