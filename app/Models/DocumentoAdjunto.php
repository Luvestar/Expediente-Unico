<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentoAdjunto extends Model
{
    protected $table = 'documentos_adjuntos';
    
    protected $fillable = [
        'tramite_documento_id',
        'nombre_documento',
        'archivo_path',
        'mostrar_en_cotejo',
    ];
    
    public function tramiteDocumento()
    {
        return $this->belongsTo(TramiteDocumento::class);
    }
}