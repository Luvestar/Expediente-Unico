<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrdenCobro extends Model
{
    protected $table = 'ordenes_cobro';
    
    protected $fillable = [
        'contribuyente_id',
        'area_id',
        'folio',
        'orden_cobro',
        'cotizacion'
    ];
    
    public function contribuyente()
    {
        return $this->belongsTo(Contribuyente::class);
    }
    
    public function area()
    {
        return $this->belongsTo(Area::class);
    }
}