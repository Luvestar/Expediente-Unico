<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Requisito extends Model
{
    protected $fillable = ['subtramite_id', 'nombre', 'es_archivo', 'multiple', 'orden'];

    public function subtramite()
    {
        return $this->belongsTo(Subtramite::class);
    }
}