<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cokolada extends Model
{
    use HasFactory;

    protected $table = 'cokoladas';

    protected $fillable = [
        'naziv',
        'opis',
        'slika',
        'cena',
    ];
}
