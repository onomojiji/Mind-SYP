<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Poste extends Model
{
    use HasFactory;

    protected $fillable = ["nom", "description"];

    public function pointages(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Pointage::class);
    }
}
