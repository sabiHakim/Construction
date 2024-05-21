<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\DevisModel;
use App\Models\Login;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public  function  traitInscri(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);
        $tel  = $request->name;
        $client = Client::checkUser($tel);
        if ($client)
        {
            Session()->put('user',$client->id);
            $devisClient = DB::select("select *  from vue_devis where  idclient = ?",[Session('user')]);
            return view('acceuil.acc',compact('devisClient'));
        }
        else
        {
            $tel = $request->name;
            $insert = Client::insertCli($tel);
            $last  = Client::get_farany();
            foreach ($last as $v){
                Session()->put('user',$v->id);
            }
            $devisClient = DB::select("select *  from vue_devis where  idclient = ?",[Session('user')]);
            return view('acceuil.acc',compact('devisClient'));
        }
    }
    public static  function  acceuil()
    {

        return view('acceuil.acc');
    }
    public static  function  acceuilAdmin()
    {
        $dev = DevisModel::getAllDevis();
        $sum = DevisModel::getsumAllDevis();
        return view('acceuilAdmin.accAdmin',compact('dev','sum'));
    }
    public  function  traitLogin(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'mdp' => 'required',
        ]);
        $nom = $request->name;
        $mpd = $request->mdp;
        $user = Login::checkisAdmin($nom,$mpd);
//        dd($user);
        if ($user)
        {
                Session()->put('admin',$user->id);
                $dev = DevisModel::getAllDevis();
                $sum = DevisModel::getsumAllDevis();
                return view('acceuilAdmin.accAdmin',compact('dev','sum'));
        }
        else
        {
            return redirect()->back()->with('diso', 'verifier il ya erreur ');
        }

    }
    public function logout()
    {
        Session()->forget('user');
        Session()->forget('admin');
        return redirect('/')->with('status', 'Déconnecté avec succès');
    }
    public function reinitialiser()
    {
        DB::select("DELETE FROM login WHERE id != 1");
//        DB::select("delete from ftest;");
//        DB::select("delete from test;");
        return redirect('/')->with('statuss', 'Reinitialiser');
    }
    public  function  test(){ dd('test'); }
}
