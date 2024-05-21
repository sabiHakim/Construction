<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailTravaux extends Model
{
    use HasFactory;
    public $table = 'details_travaux';
    public $timestamps = false;
    protected $primaryKey = 'id';

    public $fillable = [
        'maisonid',
        'idtravaux',
        'unite_id',
        'quantite',
        'pu',
    ];
}
