<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Structure extends Model
{
    use HasFactory;

    protected $fillable = ["nom", "description"];

    public function pointages(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Pointage::class);
    }

    public function users(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(User::class);
    }
}
