<?php

namespace App\Http\Controllers\Industria;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contribuyente;
use App\Models\TramiteDocumento;
use App\Models\DocumentoVigencia;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // ==========================================
        // TARJETAS DE RESUMEN
        // ==========================================
        
        // Total de contribuyentes
        $totalContribuyentes = Contribuyente::count();
        
        // Total de trámites realizados por Industria
        $totalTramites = TramiteDocumento::where('area_id', 1)->count();
        
        // Total de documentos subidos por Industria
        $totalDocumentos = DocumentoVigencia::where('area_id', 1)->count();
        
        // ==========================================
        // TRÁMITES POR MES (para la gráfica)
        // ==========================================
        
        $tramitesPorMes = TramiteDocumento::where('area_id', 1)
            ->select(
                DB::raw('YEAR(created_at) as año'),
                DB::raw('MONTH(created_at) as mes'),
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('año', 'mes')
            ->orderBy('año', 'asc')
            ->orderBy('mes', 'asc')
            ->get();
        
        // Preparar datos para la gráfica (últimos 12 meses)
        $meses = [];
        $totales = [];
        
        for ($i = 11; $i >= 0; $i--) {
            $fecha = now()->subMonths($i);
            $nombreMes = $fecha->locale('es')->monthName;
            $meses[] = $nombreMes;
            
            $total = $tramitesPorMes->filter(function($item) use ($fecha) {
                return $item->año == $fecha->year && $item->mes == $fecha->month;
            })->first();
            
            $totales[] = $total ? $total->total : 0;
        }
        
        return view('industria.estadisticas', compact(
            'totalContribuyentes',
            'totalTramites',
            'totalDocumentos',
            'meses',
            'totales'
        ));
    }
}