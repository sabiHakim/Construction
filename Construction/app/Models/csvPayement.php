<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class csvPayement extends Model
{
    use HasFactory;
    public $timestamps = false;
    public $table = 'csvpayement';
//    protected $primaryKey = 'id';
    protected  $fillable = [
        'ref_devis',
        'ref_paiement',
        'date_paiement',
        'montant'
    ];
}
