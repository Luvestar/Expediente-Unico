<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tramite extends Model
{
    protected $fillable = ['nombre', 'orden'];

    public function subtramites()
    {
        return $this->hasMany(Subtramite::class);
    }
}