<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subtramite extends Model
{
    protected $fillable = ['tramite_id', 'nombre'];

    public function tramite()
    {
        return $this->belongsTo(Tramite::class);
    }

    public function requisitos()
    {
        return $this->hasMany(Requisito::class);
    }
}