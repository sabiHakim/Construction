<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class csvmaison extends Model
{
    use HasFactory;
    public $timestamps = false;
    public $table = 'csvmaison';
//    protected $primaryKey = 'id';
    protected  $fillable = [
        'type_maison',
        'description',
        'surface',
        'code_travaux',
        'type_travaux',
        'unite',
        'prix_unitaire ',
        'quantite',
        'duree_travaux'
    ];
    public static function insert($data){
        $csvMaison = new CsvMaison();
        $csvMaison->type_maison = $data['maison'];
        $csvMaison->description = $data['description'];
        $csvMaison->surface = $data['surface'];
        $csvMaison->code_travaux = $data['code'];
        $csvMaison->type_travaux = $data['nomcode'];
        $csvMaison->unite = $data['unite'];
        $csvMaison->prix_unitaire = $data['pu'];
        $csvMaison->quantite = $data['quantite'];
        $csvMaison->duree_travaux = $data['duree'];
        $csvMaison->save();
    }
}
