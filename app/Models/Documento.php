<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre', 'tipo', 'numero_oficial', 'fecha_expedicion',
        'fecha_vigencia', 'estado', 'archivo_path', 'observaciones',
        'contribuyente_id', 'area_id', 'user_id'
    ];

    protected $casts = [
        'fecha_expedicion' => 'date',
        'fecha_vigencia' => 'date',
    ];

    // Relaciones
    public function contribuyente()
    {
        return $this->belongsTo(Contribuyente::class);
    }

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Calcular estado automáticamente
    public function actualizarEstado()
    {
        if (!$this->fecha_vigencia) {
            $this->estado = 'vigente';
        } else {
            $dias_restantes = now()->diffInDays($this->fecha_vigencia, false);
            
            if ($dias_restantes < 0) {
                $this->estado = 'vencido';
            } elseif ($dias_restantes <= 30) {
                $this->estado = 'por_vencer';
            } else {
                $this->estado = 'vigente';
            }
        }
        
        $this->saveQuietly();
    }
}