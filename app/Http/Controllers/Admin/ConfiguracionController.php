<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Area;
use App\Models\DocumentoVigencia;
use Illuminate\Support\Facades\Cache;

class ConfiguracionController extends Controller
{
    public function index()
    {
        // Configuraciones generales (desde cache o config)
        $configuracionGeneral = [
            'nombre_sistema' => Cache::get('nombre_sistema', 'Expediente Único'),
            'logo' => Cache::get('logo', 'images/Logo_Tepeaca.webp'),
            'tema' => Cache::get('tema', 'claro'),
        ];
        
        // Vigencias por defecto para tipos de documentos
        $vigencias = [
            'INE' => Cache::get('vigencia_ine', 3650), // 10 años en días
            'RFC' => Cache::get('vigencia_rfc', 3650), // 10 años
            'CURP' => Cache::get('vigencia_curp', 3650), // 10 años (NUEVO)
            'Comprobante domicilio (Luz)' => Cache::get('vigencia_luz', 60), // 2 meses
            'Comprobante domicilio (Agua)' => Cache::get('vigencia_agua', 60), // 2 meses
            'Comprobante predial' => Cache::get('vigencia_predial', 365), // 1 año
            'Licencia/Cédula' => Cache::get('vigencia_licencia', 365), // 1 año
        ];
        
        return view('admin.configuracion', compact('configuracionGeneral', 'vigencias'));
    }
    
    // ==========================================
    // CONFIGURACIÓN GENERAL
    // ==========================================
    
    public function actualizarConfiguracionGeneral(Request $request)
    {
        $request->validate([
            'nombre_sistema' => 'required|string|max:255',
            'tema' => 'required|in:claro,oscuro',
        ]);
        
        Cache::put('nombre_sistema', $request->nombre_sistema, 86400 * 30);
        Cache::put('tema', $request->tema, 86400 * 30);
        
        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('configuracion', 'public');
            Cache::put('logo', $path, 86400 * 30);
        }
        
        return redirect()->route('admin.configuracion')
            ->with('success', 'Configuración general actualizada');
    }
    
    // ==========================================
    // VIGENCIAS POR DEFECTO
    // ==========================================
    
    public function actualizarVigencias(Request $request)
    {
        $request->validate([
            'vigencia_ine' => 'required|integer|min:1',
            'vigencia_rfc' => 'required|integer|min:1',
            'vigencia_curp' => 'required|integer|min:1', // NUEVO
            'vigencia_luz' => 'required|integer|min:1',
            'vigencia_agua' => 'required|integer|min:1',
            'vigencia_predial' => 'required|integer|min:1',
            'vigencia_licencia' => 'required|integer|min:1',
        ]);
        
        Cache::put('vigencia_ine', $request->vigencia_ine, 86400 * 30);
        Cache::put('vigencia_rfc', $request->vigencia_rfc, 86400 * 30);
        Cache::put('vigencia_curp', $request->vigencia_curp, 86400 * 30); // NUEVO
        Cache::put('vigencia_luz', $request->vigencia_luz, 86400 * 30);
        Cache::put('vigencia_agua', $request->vigencia_agua, 86400 * 30);
        Cache::put('vigencia_predial', $request->vigencia_predial, 86400 * 30);
        Cache::put('vigencia_licencia', $request->vigencia_licencia, 86400 * 30);
        
        return redirect()->route('admin.configuracion')
            ->with('success', 'Vigencias actualizadas correctamente');
    }
}