<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Payement extends Model
{
    use HasFactory;
    public  $timestamps = false;
    protected  $table = 'payement';

    protected $fillable  = [ 'idpayement ', 'idclient','iddevis', 'montant ','date_payement' ];
    public  static function inserPayement($idclient,$iddevis,$montant,$date_payement)
    {
        DB::select("INSERT INTO payement(idclient,iddevis,montant,date_payement) values (?,?,?,?)",[$idclient,$iddevis,$montant,$date_payement]);
    }
    public  static function inserPayementcsv($reference,$iddevis,$montant,$date_payement)
    {
        DB::select("INSERT INTO payement(reference,iddevis,montant,date_payement) values (?,?,?,?)",[$reference,$iddevis,$montant,$date_payement]);
    }

    public function reste_a_Payer($iddevis)
    {
      $res  =  DB::select("select  prixtotal-sum as reste from vue_devis_payement where id_devis = ?",[$iddevis]);
      return $res;
    }

}
