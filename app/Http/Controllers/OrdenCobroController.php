<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contribuyente;
use App\Models\OrdenCobro;
use Illuminate\Support\Facades\Storage;

class OrdenCobroController extends Controller
{
    public function form($contribuyenteId, $ordenId = null)
    {
        $contribuyente = Contribuyente::findOrFail($contribuyenteId);
        $orden = null;
        
        if ($ordenId) {
            $orden = OrdenCobro::find($ordenId);
        }
        
        $area = $this->getAreaFromUrl();
        $layout = $area;
        $routeStore = $area . '.orden.cobro.store';
        $routeBack = $area . '.consultar';
        
        return view('orden_cobro.form', compact(
            'contribuyente', 'orden', 'layout', 'routeStore', 'routeBack', 'area'
        ))->with('usuario', auth('sanctum')->user());
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'contribuyente_id' => 'required|exists:contribuyentes,id',
            'orden_cobro_pdf' => 'nullable|file|mimes:pdf|max:5120',
            'cotizacion_pdf' => 'nullable|file|mimes:pdf|max:5120',
        ]);
        
        $area = $this->getAreaFromUrl();
        $areaId = $this->getAreaId($area);
        
        $orden = OrdenCobro::updateOrCreate(
            ['id' => $request->orden_id],
            [
                'contribuyente_id' => $request->contribuyente_id,
                'area_id' => $areaId,
            ]
        );
        
        if ($request->hasFile('orden_cobro_pdf')) {
            if ($orden->orden_cobro_pdf && Storage::disk('public')->exists($orden->orden_cobro_pdf)) {
                Storage::disk('public')->delete($orden->orden_cobro_pdf);
            }
            
            $path = $request->file('orden_cobro_pdf')->store(
                'ordenes_cobro/' . date('Y/m'),
                'public'
            );
            $orden->orden_cobro_pdf = $path;
        }
        
        if ($request->hasFile('cotizacion_pdf')) {
            if ($orden->cotizacion_pdf && Storage::disk('public')->exists($orden->cotizacion_pdf)) {
                Storage::disk('public')->delete($orden->cotizacion_pdf);
            }
            
            $path = $request->file('cotizacion_pdf')->store(
                'ordenes_cobro/' . date('Y/m'),
                'public'
            );
            $orden->cotizacion_pdf = $path;
        }
        
        $orden->save();
        
        return redirect()->route($area . '.consultar')
            ->with('success', 'Orden de cobro guardada correctamente');
    }
    
    public function index()
    {
        $ordenes = OrdenCobro::with(['contribuyente', 'area'])
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('orden_cobro.lista', compact('ordenes'))->with('usuario', auth('sanctum')->user());
    }
    
    public function show($id)
    {
        $orden = OrdenCobro::with(['contribuyente', 'area'])->findOrFail($id);
        return view('orden_cobro.detalle', compact('orden'))->with('usuario', auth('sanctum')->user());
    }
    
    public function porContribuyente($contribuyenteId)
    {
        $contribuyente = Contribuyente::findOrFail($contribuyenteId);
        $ordenes = OrdenCobro::with(['area'])
            ->where('contribuyente_id', $contribuyenteId)
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('ingresos.consulta.ordenes_contribuyente', compact('contribuyente', 'ordenes'))->with('usuario', auth('sanctum')->user());
    }
    
    public function descargarPdf($id, $tipo)
    {
        $orden = OrdenCobro::findOrFail($id);
        
        $campo = ($tipo === 'orden') ? 'orden_cobro_pdf' : 'cotizacion_pdf';
        $nombre = ($tipo === 'orden') ? 'orden_cobro' : 'cotizacion';
        
        if (!$orden->$campo || !Storage::disk('public')->exists($orden->$campo)) {
            abort(404, 'Archivo no encontrado');
        }
        
        $contribuyente = $orden->contribuyente;
        $filename = $nombre . '_' . $contribuyente->id . '_' . date('Ymd') . '.pdf';
        
        return Storage::disk('public')->download($orden->$campo, $filename);
    }
    
    public function verPdf($id, $tipo)
    {
        $orden = OrdenCobro::findOrFail($id);
        
        $campo = ($tipo === 'orden') ? 'orden_cobro_pdf' : 'cotizacion_pdf';
        
        if (!$orden->$campo || !Storage::disk('public')->exists($orden->$campo)) {
            abort(404, 'Archivo no encontrado');
        }
        
        $path = storage_path('app/public/' . $orden->$campo);
        
        return response()->file($path, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . basename($path) . '"'
        ]);
    }
    
    private function getAreaFromUrl()
    {
        $url = url()->current();
        if (str_contains($url, '/industria/')) {
            return 'industria';
        } elseif (str_contains($url, '/desarrollo/')) {
            return 'desarrollo';
        } elseif (str_contains($url, '/proteccion/')) {
            return 'proteccion';
        }
        return 'industria';
    }
    
    private function getAreaId($area)
    {
        return match($area) {
            'industria' => 1,
            'desarrollo' => 2,
            'proteccion' => 3,
            default => null
        };
    }
}