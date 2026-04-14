<?php

namespace App\Http\Controllers\Ingresos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ActividadTramite;
use App\Models\DocumentoVigencia;
use App\Models\OrdenCobro;
use Carbon\Carbon;

class HistorialController extends Controller
{
    public function index(Request $request)
    {
        $areaId = 4; // Ingresos
        
        $actividades = ActividadTramite::with('user', 'contribuyente')
            ->where('area_id', $areaId)
            ->orderBy('created_at', 'desc')
            ->get();
        
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
        
        $vigentes = DocumentoVigencia::deArea($areaId)->vigentes()->count();
        $vencidos = DocumentoVigencia::deArea($areaId)->vencidos()->count();
        $proximos = DocumentoVigencia::deArea($areaId)->proximosAVencer(30)->count();
        
        return view('ingresos.historial', compact(
            'actividades', 
            'vigentes', 
            'vencidos',
            'proximos',
            'documentos'
        ));
    }
    
    public function exportarCSV(Request $request)
    {
        $request->validate([
            'filtro' => 'required|in:hoy,ayer,rango',
            'fecha_inicio' => 'required_if:filtro,rango|date',
            'fecha_fin' => 'required_if:filtro,rango|date',
        ]);
        
        $areaId = 4; // Ingresos
        
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
        
        $actividades = ActividadTramite::with(['contribuyente', 'user'])
            ->where('area_id', $areaId)
            ->whereBetween('created_at', [$fechaInicio . ' 00:00:00', $fechaFin . ' 23:59:59'])
            ->orderBy('created_at', 'desc')
            ->get();
        
        $nombreArchivo = 'historial_ingresos_' . $fechaInicio . '_al_' . $fechaFin . '.csv';
        
        $handle = fopen('php://temp', 'w+');
        fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));
        
        fputcsv($handle, [
            'FECHA', 'HORA', 'USUARIO', 'TRÁMITE', 'DOCUMENTO',
            'CONTRIBUYENTE', 'APELLIDO PATERNO', 'APELLIDO MATERNO',
            'EMPRESA', 'RFC', 'GIRO', 'TELÉFONO', 'TIPO',
            'FOLIO', 'ORDEN DE COBRO', 'COTIZACIÓN'
        ]);
        
        foreach ($actividades as $actividad) {
            // Buscar orden de cobro del contribuyente
            $orden = OrdenCobro::where('contribuyente_id', $actividad->contribuyente_id)
                ->first();
            
            fputcsv($handle, [
                $actividad->created_at->format('d/m/Y'),
                $actividad->created_at->format('H:i:s'),
                $actividad->user->name ?? '',
                $actividad->tramite ?? '',
                $actividad->documento_nombre ?? '',
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
    
    public function verDetalle($id)
    {
        $documento = DocumentoVigencia::with('contribuyente')->findOrFail($id);
        return view('ingresos.detalle_documento', compact('documento'));
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
        
        ActividadTramite::create([
            'contribuyente_id' => $documento->contribuyente_id,
            'tramite' => 'Renovación de documento',
            'documento_nombre' => $documento->nombre_documento,
            'fecha_vencimiento' => $documento->fecha_vencimiento,
            'accion' => 'renovó'
        ]);
        
        return redirect()->route('ingresos.historial')
            ->with('success', 'Vigencia actualizada correctamente');
    }
    
    public function eliminarDocumento($id)
    {
        $documento = DocumentoVigencia::findOrFail($id);
        
        if ($documento->estado != 'vencido') {
            return redirect()->route('ingresos.historial')
                ->with('error', 'Solo se pueden eliminar documentos vencidos');
        }
        
        $documento->delete();
        
        ActividadTramite::create([
            'contribuyente_id' => $documento->contribuyente_id,
            'tramite' => 'Eliminación de documento',
            'documento_nombre' => $documento->nombre_documento,
            'accion' => 'eliminó'
        ]);
        
        return redirect()->route('ingresos.historial')
            ->with('success', 'Documento eliminado correctamente');
    }
}