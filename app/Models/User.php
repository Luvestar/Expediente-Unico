<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

   protected $fillable = [
    'name',
    'nombre_completo',
    'email',
    'telefono',
    'password',
    'area_id',
    'rol',
    'activo',
    'last_login_at',  // ← Agrega esto
];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relación con área
    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    // Verificar si es administrador
    public function esAdministrador()
    {
        return $this->rol === 'administrador';
    }

    // Verificar si pertenece a un área específica
    public function perteneceArea($areaNombre)
    {
        return $this->area && $this->area->nombre === $areaNombre;
    }
}