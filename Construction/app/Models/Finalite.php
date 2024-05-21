<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Finalite extends Model
{
    use HasFactory;
    public  $timestamps = false;
    protected  $table = 'finition';
    protected  $fillable= ['id','nom','pourcentage'];
    public static function get_ID_BY_nom($nom)
    {
          $res =   DB::select("select id from finition where nom =?",[$nom]);
          foreach ($res as $r){
             $result  =  $r->id;
          }
          return $result;
    }
}
