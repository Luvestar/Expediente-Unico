<?php

namespace App\Http\Controllers\Industria;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ActividadTramite;
use App\Models\DocumentoVigencia;
use Carbon\Carbon;

class HistorialController extends Controller
{
    public function index(Request $request)
    {
        $areaId = 1; // Industria
        
        // Actividades detalladas
        $actividades = ActividadTramite::with('user', 'contribuyente')
            ->where('area_id', $areaId)
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Documentos de vigencia con detalles
        $documentosQuery = DocumentoVigencia::with('contribuyente')
            ->where('area_id', $areaId);
        
        if ($request->has('estado') && in_array($request->estado, ['vigente', 'vencido', 'proximo'])) {
            if ($request->estado == 'proximo') {
                $documentosQuery->proximosAVencer(30);
            } else {
                $documentosQuery->where('estado', $request->estado);
            }
        }
        
        $documentos = $documentosQuery->orderBy('fecha_vencimiento', 'asc')->get();
        
        // Estadísticas
        $vigentes = DocumentoVigencia::deArea($areaId)->vigentes()->count();
        $vencidos = DocumentoVigencia::deArea($areaId)->vencidos()->count();
        $proximos = DocumentoVigencia::deArea($areaId)->proximosAVencer(30)->count();
        
        return view('industria.historial', compact(
            'actividades', 
            'vigentes', 
            'vencidos',
            'proximos',
            'documentos'
        ));
    }
    
    public function renovarDocumento($id)
    {
        $documento = DocumentoVigencia::findOrFail($id);
        
        return view('industria.renovar_documento', compact('documento'));
    }
    
    public function actualizarVigencia(Request $request, $id)
    {
        $request->validate([
            'fecha_vencimiento' => 'required|date|after:today',
        ]);
        
        $documento = DocumentoVigencia::findOrFail($id);
        $documento->fecha_vencimiento = $request->fecha_vencimiento;
        $documento->estado = 'vigente';
        $documento->save();
        
        // Registrar actividad
        ActividadTramite::create([
            'contribuyente_id' => $documento->contribuyente_id,
            'tramite' => 'Renovación de documento',
            'documento_nombre' => $documento->nombre_documento,
            'fecha_vencimiento' => $documento->fecha_vencimiento,
            'accion' => 'renovó'
        ]);
        
        return redirect()->route('industria.historial')
            ->with('success', 'Vigencia actualizada correctamente');
    }
    
    public function eliminarDocumento($id)
    {
        $documento = DocumentoVigencia::findOrFail($id);
        
        // Solo permitir eliminar si está vencido
        if ($documento->estado != 'vencido') {
            return redirect()->route('industria.historial')
                ->with('error', 'Solo se pueden eliminar documentos vencidos');
        }
        
        $documento->delete();
        
        // Registrar actividad
        ActividadTramite::create([
            'contribuyente_id' => $documento->contribuyente_id,
            'tramite' => 'Eliminación de documento',
            'documento_nombre' => $documento->nombre_documento,
            'accion' => 'eliminó'
        ]);
        
        return redirect()->route('industria.historial')
            ->with('success', 'Documento eliminado correctamente');
    }
    
    public function verDetalle($id)
    {
        $documento = DocumentoVigencia::with('contribuyente')->findOrFail($id);
        return view('industria.detalle_documento', compact('documento'));
    }

    public function exportarCSV(Request $request)
{
    $request->validate([
        'filtro' => 'required|in:hoy,ayer,rango',
        'fecha_inicio' => 'required_if:filtro,rango|date',
        'fecha_fin' => 'required_if:filtro,rango|date',
    ]);
    
    $areaId = 1; // Industria
    
    switch ($request->filtro) {
        case 'hoy':
            $fechaInicio = now()->format('Y-m-d');
            $fechaFin = now()->format('Y-m-d');
            break;
        case 'ayer':
            $fechaInicio = now()->subDay()->format('Y-m-d');
            $fechaFin = now()->subDay()->format('Y-m-d');
            break;
        case 'rango':
            $fechaInicio = $request->fecha_inicio;
            $fechaFin = $request->fecha_fin;
            break;
    }
    
    // Obtener actividades
    $actividades = ActividadTramite::with(['contribuyente', 'user'])
        ->where('area_id', $areaId)
        ->whereBetween('created_at', [$fechaInicio . ' 00:00:00', $fechaFin . ' 23:59:59'])
        ->orderBy('created_at', 'desc')
        ->get();
    
    // Nombre del archivo
    $nombreArchivo = 'historial_' . $fechaInicio . '_al_' . $fechaFin . '.csv';
    
    // Crear contenido CSV
    $handle = fopen('php://temp', 'w+');
    
    // Agregar BOM para UTF-8 (evita problemas con caracteres especiales)
    fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));
    
    // Encabezados
    fputcsv($handle, [
        'FECHA',
        'HORA',
        'USUARIO',
        'TRÁMITE',
        'CONTRIBUYENTE',
        'APELLIDO PATERNO',
        'APELLIDO MATERNO',
        'EMPRESA',
        'RFC',
        'GIRO',
        'TELÉFONO',
        'TIPO',
        'FOLIO',
        'ORDEN DE COBRO',
        'COTIZACIÓN'
    ]);
    
    // Datos
    foreach ($actividades as $actividad) {
        // Buscar orden de cobro
        $orden = \App\Models\OrdenCobro::where('contribuyente_id', $actividad->contribuyente_id)
            ->where('area_id', $areaId)
            ->first();
        
        fputcsv($handle, [
            $actividad->created_at->format('d/m/Y'),
            $actividad->created_at->format('H:i:s'),
            $actividad->user->name ?? '',
            $actividad->tramite ?? '',
            $actividad->contribuyente->nombre ?? '',
            $actividad->contribuyente->apellido_paterno ?? '',
            $actividad->contribuyente->apellido_materno ?? '',
            $actividad->contribuyente->nombre_empresa ?? '',
            $actividad->contribuyente->rfc ?? '',
            $actividad->contribuyente->giro_comercial ?? '',
            $actividad->contribuyente->telefono ?? '',
            $actividad->contribuyente->tipo_persona ?? '',
            $orden->folio ?? '',
            $orden->orden_cobro ?? '',
            $orden->cotizacion ?? '',
        ]);
    }
    
    rewind($handle);
    $csvContent = stream_get_contents($handle);
    fclose($handle);
    
    return response($csvContent, 200, [
        'Content-Type' => 'text/csv; charset=UTF-8',
        'Content-Disposition' => 'attachment; filename="' . $nombreArchivo . '"',
    ]);
}
}