<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'descripcion', 'activa'];

    // Relación con usuarios
    public function usuarios()
    {
        return $this->hasMany(User::class);
    }

    // Relación con documentos
    public function documentos()
    {
        return $this->hasMany(Documento::class);
    }
}