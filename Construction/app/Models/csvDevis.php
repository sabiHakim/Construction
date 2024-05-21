<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class csvDevis extends Model
{
    use HasFactory;
    public $table = 'csvdevis';
    public $timestamps = false;
    protected $primaryKey = 'id';
    public $fillable = [
        'id',
        'client',
        'reference',
        'maison',
        'finition',
        'taux_finition',
        'datedevis',
        'datedebut',
        'lieu'
    ];
    public static function insert($data){
        $csvDevis = new CsvDevis();
        $csvDevis->client = $data['client'];
        $csvDevis->reference = $data['reference'];
        $csvDevis->maison = $data['maison'];
        $csvDevis->finition = $data['finition'];
        $csvDevis->taux_finition = $data['taux_finition'];
        $csvDevis->datedevis = $data['datedevis'];
        $csvDevis->datedebut = $data['datedebut'];
        $csvDevis->lieu = $data['lieu'];
        $csvDevis->save();
    }
}
