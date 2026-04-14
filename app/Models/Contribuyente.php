<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Encryptable;

class Contribuyente extends Model
{
    use HasFactory, Encryptable;

    protected $encryptable = [
        'rfc',
        'curp',
        'email',
        'telefono',
        'direccion'
    ];

    protected $fillable = [
        'nombre',
        'apellido_paterno',
        'apellido_materno',
        'rfc',
        'curp',
        'email',
        'telefono',
        'direccion',
        'giro_comercial',
        'nombre_empresa',
        'tipo_persona',
        'user_id',
        'area_id',
        'activo',
    ];

    public function getNombreCompletoAttribute()
    {
        return "{$this->nombre} {$this->apellido_paterno} {$this->apellido_materno}";
    }

    public function documentos()
    {
        return $this->hasMany(Documento::class);
    }
}