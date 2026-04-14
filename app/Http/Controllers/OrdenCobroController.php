<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contribuyente;
use App\Models\OrdenCobro;

class OrdenCobroController extends Controller
{
    // Mostrar formulario (crear o editar)
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
        ));
    }
    
    // Guardar orden de cobro
    public function store(Request $request)
    {
        $request->validate([
            'contribuyente_id' => 'required|exists:contribuyentes,id',
            'folio' => 'required|string|max:50',
            'orden_cobro' => 'nullable|string',
            'cotizacion' => 'nullable|string',
        ]);
        
        $area = $this->getAreaFromUrl();
        $areaId = $this->getAreaId($area);
        
        OrdenCobro::updateOrCreate(
            [
                'id' => $request->orden_id,
            ],
            [
                'contribuyente_id' => $request->contribuyente_id,
                'area_id' => $areaId,
                'folio' => $request->folio,
                'orden_cobro' => $request->orden_cobro,
                'cotizacion' => $request->cotizacion,
            ]
        );
        
        return redirect()->route($area . '.consultar')
            ->with('success', 'Orden de cobro guardada correctamente');
    }
    
    // Ver todas las órdenes (solo para Ingresos)
    public function index()
    {
        $ordenes = OrdenCobro::with(['contribuyente', 'area'])
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('orden_cobro.lista', compact('ordenes'));
    }
    
    // Ver detalle de una orden (solo para Ingresos)
    public function show($id)
    {
        $orden = OrdenCobro::with(['contribuyente', 'area'])->findOrFail($id);
        return view('orden_cobro.detalle', compact('orden'));
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

    // Ver órdenes de cobro de un contribuyente específico (para Ingresos)
public function porContribuyente($contribuyenteId)
{
    $contribuyente = Contribuyente::findOrFail($contribuyenteId);
    
    $ordenes = OrdenCobro::with(['area'])
        ->where('contribuyente_id', $contribuyenteId)
        ->orderBy('created_at', 'desc')
        ->get();
    
    return view('ingresos.consulta.ordenes_contribuyente', compact('contribuyente', 'ordenes'));
}
}