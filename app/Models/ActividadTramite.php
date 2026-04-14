<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ActividadTramite extends Model
{
    protected $table = 'actividad_tramites';

    protected $fillable = [
        'user_id',
        'area_id',
        'contribuyente_id',
        'tramite_id',
        'tramite',
        'documento_nombre',
        'fecha_vencimiento',
        'documentos_subidos',
        'accion'
    ];

    protected $casts = [
        'documentos_subidos' => 'array',
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
            
            if (is_null($model->user_id)) {
                $model->user_id = Auth::id();
            }
            
            if (is_null($model->accion)) {
                $model->accion = 'registró';
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function contribuyente()
    {
        return $this->belongsTo(Contribuyente::class);
    }
    
    public function area()
    {
        return $this->belongsTo(Area::class);
    }
}