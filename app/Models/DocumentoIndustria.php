<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DocumentoIndustria extends Model
{
    protected $table = 'documentos_industria';
    
    protected $fillable = [
        'contribuyente_id',
        'proceso',
        'tipo',
        'rfc_actualizada',
        'comprobante_domicilio',
        'constancia_pc',
        'licencia_suelo',
        'licencia_alineamiento',
        'fotografias',
        'contrato_arrendamiento',
        'ine_propietario',
        'cedula_anterior',
        'factura_anterior',
        'observaciones',
        'user_id',
        'vigente'
    ];
    
    protected $casts = [
        'fotografias' => 'array',
        'vigente' => 'boolean'
    ];
    
    public function contribuyente(): BelongsTo
    {
        return $this->belongsTo(Contribuyente::class);
    }
    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}