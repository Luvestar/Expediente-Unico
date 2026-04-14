<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contribuyente;
use App\Models\TramiteDocumento;
use App\Models\DocumentoVigencia;
use App\Models\User;
use App\Models\ActividadTramite;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // ==========================================
        // TARJETAS GLOBALES
        // ==========================================
        
        $totalContribuyentes = Contribuyente::count();
        $totalTramites = TramiteDocumento::count();
        $totalDocumentos = DocumentoVigencia::count();
        $totalUsuarios = User::count();
        
        // ==========================================
        // DOCUMENTOS POR ÁREA (AHORA CON 4 ÁREAS)
        // ==========================================
        
        $documentosPorArea = [
            'Industria' => DocumentoVigencia::where('area_id', 1)->count(),
            'Desarrollo' => DocumentoVigencia::where('area_id', 2)->count(),
            'Protección' => DocumentoVigencia::where('area_id', 3)->count(),
            'Ingresos' => DocumentoVigencia::where('area_id', 4)->count(),  // ← NUEVO
        ];
        
        // ==========================================
        // DOCUMENTOS UNIVERSALES
        // ==========================================
        
        $documentosUniversales = [
            'RFC actualizada' => $this->verificarDocumentoUniversal(['rfc', 'RFC']),
            'INE Propietario' => $this->verificarDocumentoUniversal(['ine', 'INE', 'identificacion']),
            'Comprobante de domicilio (Luz)' => $this->verificarDocumentoUniversal(['luz', 'Luz']),
            'Comprobante de domicilio (Agua)' => $this->verificarDocumentoUniversal(['agua', 'Agua']),
            'Comprobante de pago predial' => $this->verificarDocumentoUniversal(['predial', 'Predial']),
        ];
        
        // ==========================================
        // ACTIVIDAD RECIENTE
        // ==========================================
        
        $actividadReciente = ActividadTramite::with(['user', 'contribuyente'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();
        
        // ==========================================
        // TRÁMITES POR MES (últimos 6 meses)
        // ==========================================
        
        $tramitesPorMes = [];
        for ($i = 5; $i >= 0; $i--) {
            $fecha = now()->subMonths($i);
            $nombreMes = $fecha->locale('es')->monthName;
            $total = TramiteDocumento::whereYear('created_at', $fecha->year)
                ->whereMonth('created_at', $fecha->month)
                ->count();
            $tramitesPorMes[] = [
                'mes' => $nombreMes,
                'total' => $total
            ];
        }
        
        return view('admin.dashboard', compact(
            'totalContribuyentes',
            'totalTramites',
            'totalDocumentos',
            'totalUsuarios',
            'documentosPorArea',
            'documentosUniversales',
            'actividadReciente',
            'tramitesPorMes'
        ));
    }
    
    private function verificarDocumentoUniversal($palabrasBuscar)
    {
        $existe = TramiteDocumento::where(function($q) use ($palabrasBuscar) {
            foreach ($palabrasBuscar as $palabra) {
                $q->orWhere('tramite', 'LIKE', "%{$palabra}%");
            }
        })->exists();
        
        return $existe ? 'Activo' : 'Pendiente';
    }
}