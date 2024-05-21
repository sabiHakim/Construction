<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/',function (){
    return view('index.index');
});
Route::get('/re',function (){
    \Illuminate\Support\Facades\DB::select("SELECT reinitialiser()");
});
Route::get('/admin', function () {
    $admin  = \Illuminate\Support\Facades\DB::select("select * from login");
    return view('Login.login',compact('admin'));
});
Route::get('client', function () {
    return view('register.register');
});
Route::get('acceuil',[\App\Http\Controllers\LoginController::class,'acceuil']);
Route::get('acceuilAdmin',[\App\Http\Controllers\LoginController::class,'acceuilAdmin']);
Route::post('traitLogin',[\App\Http\Controllers\LoginController::class,'traitLogin'])->name('traitLogin');
Route::post('traitInscri',[\App\Http\Controllers\LoginController::class,'traitInscri'])->name('traitInscri');
Route::get('logout',[\App\Http\Controllers\LoginController::class,'logout']);
Route::get('reinitialiser',[\App\Http\Controllers\LoginController::class,'reinitialiser']);
//
Route::get('addDevis',[\App\Http\Controllers\Devis::class,'addDevis']);
Route::get('traitAddDevis',[\App\Http\Controllers\Devis::class,'traitAddDevis']);
Route::get('Detail/{id}',[\App\Http\Controllers\Devis::class,'Detail']);
Route::get('exporter/{id}',[\App\Http\Controllers\Devis::class,'exporter']);
//
Route::get('addpayement',[\App\Http\Controllers\Devis::class,'addpayement']);
Route::get('traitpayement',[\App\Http\Controllers\PayementController::class,'traitpayement']);
//
Route::get('DetailDevisAdmin/{id}',[\App\Http\Controllers\Devis::class,'DetailDevisAdmin']);
//
Route::get('histo',[\App\Http\Controllers\Devis::class,'getSumDevisByYear']);
//
Route::get('import',[\App\Http\Controllers\ImportController::class,'import']);
Route::post('MaisonDevis',[\App\Http\Controllers\ImportController::class,'MaisonDevis']);
Route::post('payement',[\App\Http\Controllers\ImportController::class,'payement']);
//
Route::middleware('securityAdmin')->group(function (){
        Route::get('test',[\App\Http\Controllers\LoginController::class,'test']);
}) ;
