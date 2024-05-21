<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Login extends Model
{
    public  $timestamps = false;
    protected  $table = 'login';
    use HasFactory;
    protected  $fillable = ['id','nom','mdp','role'];
        public static  function  checkisAdmin($nom,$mdp)
        {
            $result = DB::table('login')->where('nom', $nom)->where('mdp',$mdp)->first();
//            $result   = DB::select("SELECT  * FROM login where nom = ? and  mdp = ?",[$nom,$mdp]);
            return $result;
        }


}
