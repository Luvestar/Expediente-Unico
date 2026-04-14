<?php

namespace App\Http\Controllers\Industria;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contribuyente;
use App\Models\TramiteDocumento;
use Illuminate\Support\Facades\Auth;
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
        
        return view('industria.consulta.index', compact('resultados'));
    }

    public function expediente($id)
    {
        $contribuyente = Contribuyente::findOrFail($id);
        $tramites = TramiteDocumento::where('contribuyente_id', $id)
            ->where('area_id', 1)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('industria.consulta.expediente', compact('contribuyente', 'tramites'));
    }

    public function show($id)
    {
        $tramite = TramiteDocumento::with('contribuyente')->findOrFail($id);
        return view('industria.consulta.show', compact('tramite'));
    }

    public function create()
    {
        return view('industria.contribuyente.crear');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'rfc' => 'required|string|max:13|unique:contribuyentes,rfc',
            'telefono' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'nombre_empresa' => 'required|string|max:255',
            'giro_comercial' => 'required|string|max:255',
            'direccion' => 'required|string',
            'tipo_persona' => 'required|in:fisica,moral',
        ]);

        Contribuyente::create([
            'nombre' => $request->nombre,
            'apellidos' => $request->apellidos,
            'rfc' => strtoupper($request->rfc),
            'telefono' => $request->telefono,
            'email' => $request->email,
            'nombre_empresa' => $request->nombre_empresa,
            'giro_comercial' => $request->giro_comercial,
            'direccion' => $request->direccion,
            'tipo_persona' => $request->tipo_persona,
            'user_id' => Auth::id(),
            'area_id' => 1,
            'activo' => true,
        ]);

        return redirect()->route('industria.contribuyente.crear')
                         ->with('success', 'Contribuyente registrado correctamente');
    }

    public function edit(string $id)
    {
        $contribuyente = Contribuyente::findOrFail($id);
        return view('industria.contribuyente.editar', compact('contribuyente'));
    }

    public function update(Request $request, string $id)
    {
        $contribuyente = Contribuyente::findOrFail($id);
        
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'rfc' => 'required|string|max:13|unique:contribuyentes,rfc,' . $id,
            'telefono' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'nombre_empresa' => 'required|string|max:255',
            'giro_comercial' => 'required|string|max:255',
            'direccion' => 'required|string',
            'tipo_persona' => 'required|in:fisica,moral',
        ]);

        $contribuyente->update($request->all());

        return redirect()->route('industria.contribuyentes')
                         ->with('success', 'Contribuyente actualizado correctamente');
    }

    public function destroy(string $id)
    {
        $contribuyente = Contribuyente::findOrFail($id);
        $contribuyente->delete();

        return redirect()->route('industria.contribuyentes')
                         ->with('success', 'Contribuyente eliminado correctamente');
    }

    public function descargar(Request $request)
    {
        $path = $request->query('path');
        $fullPath = storage_path('app/public/' . $path);
        
        if (file_exists($fullPath)) {
            return response()->download($fullPath);
        }
        
        return redirect()->back()->with('error', 'El archivo no existe.');
    }

    public function cotejar($id)
    {
        $contribuyente = Contribuyente::findOrFail($id);
        $documentos = CotejoHelper::getDocumentosParaCotejo($id);
        
        return view('industria.consulta.cotejar', compact('contribuyente', 'documentos'));
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

    public function descargarZIP($id)
    {
        $contribuyente = Contribuyente::findOrFail($id);
        $tramites = TramiteDocumento::where('contribuyente_id', $id)
            ->where('area_id', 1)
            ->get();
        
        return redirect()->back()->with('info', 'Funcionalidad de descarga ZIP en desarrollo');
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