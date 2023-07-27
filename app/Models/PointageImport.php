<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PointageImport extends Model
{
    use HasFactory;

    protected $fillable = ["prenom", "nom", "sexe", "structure", "poste", "date", "entree", "sortie", "total"];
}
