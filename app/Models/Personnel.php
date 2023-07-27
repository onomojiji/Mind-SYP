<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personnel extends Model
{
    use HasFactory;

    protected $fillable = ["nom", "prenom", "sexe"];

    public function user(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(User::class);
    }
}
