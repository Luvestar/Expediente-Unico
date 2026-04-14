<?php

namespace App\Http\Controllers\Ingresos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contribuyente;
use App\Models\TramiteDocumento;
use App\Helpers\CotejoHelper;

class ConsultaController extends Controller
{
    public function index(Request $request)
    {
        $query = Contribuyente::where('area_id', 1);
        
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $palabras = explode(' ', $search);
            
            $query->where(function($q) use ($palabras, $search) {
                $q->where('nombre', 'LIKE', "%{$search}%")
                  ->orWhere('apellido_paterno', 'LIKE', "%{$search}%")
                  ->orWhere('apellido_materno', 'LIKE', "%{$search}%")
                  ->orWhere('rfc', 'LIKE', "%{$search}%")
                  ->orWhere('nombre_empresa', 'LIKE', "%{$search}%")
                  ->orWhere('giro_comercial', 'LIKE', "%{$search}%");
                
                foreach ($palabras as $palabra) {
                    if (strlen($palabra) >= 2) {
                        $q->orWhere('nombre', 'LIKE', "%{$palabra}%")
                          ->orWhere('apellido_paterno', 'LIKE', "%{$palabra}%")
                          ->orWhere('apellido_materno', 'LIKE', "%{$palabra}%");
                    }
                }
            });
        }
        
        // PAGINACIÓN: 10 contribuyentes por página
        $resultados = $query->orderBy('nombre')->paginate(10);
        
        return view('ingresos.consulta.index', compact('resultados'));
    }

    public function cotejar($id)
    {
        $contribuyente = Contribuyente::findOrFail($id);
        $documentos = CotejoHelper::getDocumentosParaCotejo($id);
        
        return view('ingresos.consulta.cotejar', compact('contribuyente', 'documentos'));
    }

    public function expediente($id)
    {
        $contribuyente = Contribuyente::findOrFail($id);
        
        // Trámites de INGRESOS (área_id = 4)
        $tramitesIngresos = TramiteDocumento::where('contribuyente_id', $id)
            ->where('area_id', 4)
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Trámites de INDUSTRIA (área_id = 1)
        $tramitesIndustria = TramiteDocumento::where('contribuyente_id', $id)
            ->where('area_id', 1)
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Trámites de DESARROLLO (área_id = 2)
        $tramitesDesarrollo = TramiteDocumento::where('contribuyente_id', $id)
            ->where('area_id', 2)
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Trámites de PROTECCIÓN (área_id = 3)
        $tramitesProteccion = TramiteDocumento::where('contribuyente_id', $id)
            ->where('area_id', 3)
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('ingresos.consulta.expediente', compact(
            'contribuyente',
            'tramitesIngresos',
            'tramitesIndustria',
            'tramitesDesarrollo',
            'tramitesProteccion'
        ));
    }

    public function descargar(Request $request)
    {
        $path = $request->get('path');
        $fullPath = storage_path('app/public/' . $path);
        
        if (file_exists($fullPath)) {
            return response()->download($fullPath);
        }
        
        return redirect()->back()->with('error', 'Archivo no encontrado');
    }

    public function verDocumento($path)
    {
        $fullPath = storage_path('app/public/' . $path);
        
        if (!file_exists($fullPath)) {
            abort(404, 'Archivo no encontrado');
        }
        
        return response()->file($fullPath, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . basename($fullPath) . '"'
        ]);
    }

    public function verPDF($path)
    {
        $fullPath = storage_path('app/public/' . $path);
        
        if (!file_exists($fullPath)) {
            abort(404, 'Archivo no encontrado');
        }
        
        return response()->file($fullPath, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . basename($fullPath) . '"'
        ]);
    }
}