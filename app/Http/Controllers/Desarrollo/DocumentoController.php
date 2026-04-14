<?php

namespace App\Http\Controllers\Desarrollo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contribuyente;
use App\Models\TramiteDocumento;
use App\Models\DocumentoAdjunto;
use App\Models\DocumentoVigencia;
use App\Models\ActividadTramite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DocumentoController extends Controller
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

        $contribuyentes = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('desarrollo.documentos.index', compact('contribuyentes'));
    }

    public function create($contribuyente_id)
    {
        $contribuyente = Contribuyente::findOrFail($contribuyente_id);
        return view('desarrollo.documentos.create', compact('contribuyente'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'contribuyente_id' => 'required|exists:contribuyentes,id',
            'archivos' => 'nullable|array',
            'documento_final' => 'nullable|file|mimes:pdf|max:10240',
        ]);

        // Guardar documento final
        $documentoFinalPath = null;
        if ($request->hasFile('documento_final')) {
            $documentoFinalPath = $request->file('documento_final')->store(
                'desarrollo/documentos_finales/' . $request->contribuyente_id,
                'public'
            );
        }

        // Crear el trámite
        $tramite = TramiteDocumento::create([
            'contribuyente_id' => $request->contribuyente_id,
            'tramite' => $request->tramite,
            'user_id' => Auth::id(),
            'documento_final_path' => $documentoFinalPath,
            'mostrar_en_cotejo' => $request->mostrar_en_cotejo ?? false,
            'area_id' => 2,
        ]);

        $archivosKeys = [];

        // Guardar documentos adjuntos
        if ($request->hasFile('archivos')) {
            foreach ($request->file('archivos') as $key => $file) {
                $ruta = $file->store('desarrollo/documentos/' . $request->contribuyente_id, 'public');
                $archivosKeys[] = $key;
                
                // Obtener el valor del radio button para este documento
                $mostrarEnCotejo = $request->input('mostrar_' . $key, false);
                
                DocumentoAdjunto::create([
                    'tramite_documento_id' => $tramite->id,
                    'nombre_documento' => $key,
                    'archivo_path' => $ruta,
                    'mostrar_en_cotejo' => $mostrarEnCotejo,
                ]);

                // Registrar vigencia
                $vigencia = match (true) {
                    str_contains($key, 'luz') || str_contains($key, 'agua') => now()->addMonths(2),
                    str_contains($key, 'cedula') || str_contains($key, 'licencia') => now()->addYear(),
                    str_contains($key, 'ine') => now()->addYears(10),
                    default => now()->addYear(),
                };

                DocumentoVigencia::create([
                    'contribuyente_id' => $request->contribuyente_id,
                    'area_id' => 2,
                    'nombre_documento' => $key,
                    'archivo_path' => $ruta,
                    'fecha_vencimiento' => $vigencia,
                    'estado' => $vigencia->isPast() ? 'vencido' : 'vigente',
                ]);
            }
        }

        // Registrar actividad
        ActividadTramite::create([
            'user_id' => Auth::id(),
            'area_id' => 2,
            'contribuyente_id' => $request->contribuyente_id,
            'tramite' => $request->tramite ?? 'Trámite general',
            'documentos_subidos' => json_encode($archivosKeys),
            'documento_nombre' => $request->hasFile('documento_final') ? 'Documento final' : null,
            'accion' => $request->hasFile('documento_final') ? 'completó trámite' : 'subió requisitos',
        ]);

        return redirect()->route('desarrollo.documentos.cargar', $request->contribuyente_id)
            ->with('success', 'Trámite guardado correctamente');
    }

    public function guardarDocumentoFinal(Request $request)
    {
        $request->validate([
            'contribuyente_id' => 'required|exists:contribuyentes,id',
            'documento_final' => 'required|file|mimes:pdf|max:10240',
            'mostrar_en_cotejo' => 'boolean',
        ]);

        $path = $request->file('documento_final')->store(
            'desarrollo/documentos_finales/' . $request->contribuyente_id,
            'public'
        );

        TramiteDocumento::create([
            'contribuyente_id' => $request->contribuyente_id,
            'tramite' => $request->tramite,
            'documento_final_path' => $path,
            'mostrar_en_cotejo' => $request->mostrar_en_cotejo ?? false,
            'user_id' => Auth::id(),
            'area_id' => 2,
        ]);

        return redirect()->back()->with('success', 'Documento final guardado correctamente');
    }

    public function eliminarVersion($id)
    {
        $documento = TramiteDocumento::findOrFail($id);
        
        if ($documento->area_id != Auth::user()->area_id) {
            return redirect()->back()->with('error', 'No tienes permiso para eliminar este documento');
        }
        
        if ($documento->documento_final_path) {
            Storage::disk('public')->delete($documento->documento_final_path);
        }
        
        $documento->delete();
        
        return redirect()->back()->with('success', 'Documento eliminado correctamente');
    }
}