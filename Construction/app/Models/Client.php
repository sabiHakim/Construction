<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Client extends Model
{
    use HasFactory;
    public  $timestamps = false;
    protected  $table = 'client';
    protected $fillable =['num'];
    public  static function  checkUser($num)
    {
        $result = DB::table('client')->where('num', $num)->first();
        return $result;
    }
    public  static  function  insertCli($tel)
    {
       $result  = DB::table('client')->insert(['num' => $tel]);
        return $result;
    }
    public  static function  get_farany()
    {
        $result = DB::select("SELECT id from client order by  id DESC  limit 1");
        return $result;
    }
    public static function get_ID_BY_num($num)
    {
        $res =   DB::select("select id from client where num =?",[$num]);
        foreach ($res as $r){
            $result  =  $r->id;
        }
        return $result;
    }
}
