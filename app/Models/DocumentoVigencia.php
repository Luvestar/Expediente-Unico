<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DocumentoVigencia extends Model
{
    protected $table = 'documentos_vigencia';

    protected $fillable = [
        'contribuyente_id',
        'area_id',
        'tramite_documento_id',
        'nombre_documento',
        'archivo_path',
        'fecha_vencimiento',
        'estado'
    ];

    protected $casts = [
        'fecha_vencimiento' => 'date'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (is_null($model->area_id)) {
                $user = Auth::user();
                if ($user && $user->area_id) {
                    $model->area_id = $user->area_id;
                }
            }
            
            // Calcular estado automáticamente
            if ($model->fecha_vencimiento) {
                $model->estado = $model->fecha_vencimiento->isPast() ? 'vencido' : 'vigente';
            }
        });
        
        static::updating(function ($model) {
            // Actualizar estado automáticamente al actualizar
            if ($model->fecha_vencimiento) {
                $model->estado = $model->fecha_vencimiento->isPast() ? 'vencido' : 'vigente';
            }
        });
    }

    public function contribuyente()
    {
        return $this->belongsTo(Contribuyente::class);
    }
    
    public function area()
    {
        return $this->belongsTo(Area::class);
    }
    
    public function tramiteDocumento()
    {
        return $this->belongsTo(TramiteDocumento::class, 'tramite_documento_id');
    }
    
    // Scopes para facilitar consultas
    public function scopeDeArea($query, $areaId)
    {
        return $query->where('area_id', $areaId);
    }
    
    public function scopeVigentes($query)
    {
        return $query->where('estado', 'vigente');
    }
    
    public function scopeVencidos($query)
    {
        return $query->where('estado', 'vencido');
    }
    
    public function scopeProximosAVencer($query, $dias = 30)
    {
        return $query->where('estado', 'vigente')
            ->where('fecha_vencimiento', '<=', Carbon::now()->addDays($dias));
    }
}