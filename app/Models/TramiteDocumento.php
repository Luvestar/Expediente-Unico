<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class TramiteDocumento extends Model
{
    protected $table = 'tramites_documentos';

    protected $fillable = [
        'contribuyente_id',
        'area_id',
        'tramite',
        'user_id',
        'documento_final_path',
        'mostrar_en_cotejo',
    ];
    
    protected $casts = [
        'campos_texto' => 'array',
        'mostrar_en_cotejo' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (is_null($model->area_id)) {
                $user = auth('sanctum')->user();
                if ($user && $user->area_id) {
                    $model->area_id = $user->area_id;
                }
            }
        });
    }

    public function contribuyente()
    {
        return $this->belongsTo(Contribuyente::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    // Nueva relación con documentos adjuntos
    public function documentosAdjuntos()
    {
        return $this->hasMany(DocumentoAdjunto::class);
    }
    
    protected $appends = ['tipo_documento', 'archivos'];

    public function getTipoDocumentoAttribute()
    {
        if ($this->documento_final_path) {
            return 'Documento Final';
        }
        return 'Requisito';
    }
    
    // Mantener compatibilidad con código existente
    public function getArchivosAttribute()
    {
        // Retorna los documentos adjuntos como array para compatibilidad
        return $this->documentosAdjuntos->pluck('archivo_path', 'nombre_documento')->toArray();
    }
}