<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class OrdenCobro extends Model
{
    protected $table = 'ordenes_cobro';
    
    protected $fillable = [
        'contribuyente_id',
        'area_id',
        'orden_cobro_pdf',
        'cotizacion_pdf'
    ];
    
    public function contribuyente()
    {
        return $this->belongsTo(Contribuyente::class);
    }
    
    public function area()
    {
        return $this->belongsTo(Area::class);
    }
    
    public function getOrdenCobroExistsAttribute()
    {
        return $this->orden_cobro_pdf && Storage::disk('public')->exists($this->orden_cobro_pdf);
    }
    
    public function getCotizacionExistsAttribute()
    {
        return $this->cotizacion_pdf && Storage::disk('public')->exists($this->cotizacion_pdf);
    }
    
    public function getAreaNombreAttribute()
    {
        return match($this->area_id) {
            1 => 'Industria y Comercio',
            2 => 'Desarrollo Urbano',
            3 => 'Protección Civil',
            4 => 'Ingresos',
            default => 'Desconocido'
        };
    }
}