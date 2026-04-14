<?php

namespace App\Http\Controllers\Industria;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contribuyente;
use App\Models\TramiteDocumento;
use App\Models\DocumentoAdjunto;
use App\Models\ActividadTramite;
use App\Models\DocumentoVigencia;
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

        return view('industria.documentos.index', compact('contribuyentes'));
    }
    
    public function create($contribuyente_id)
    {
        $contribuyenteSeleccionado = Contribuyente::findOrFail($contribuyente_id);
        return view('industria.documentos.create', compact('contribuyenteSeleccionado'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'contribuyente_id' => 'required|exists:contribuyentes,id',
            'campos_texto' => 'nullable|array',
            'archivos' => 'nullable|array',
        ]);

        // Crear el trámite
        $tramite = TramiteDocumento::create([
            'contribuyente_id' => $request->contribuyente_id,
            'area_id' => 1,
            'tramite' => $request->tramite,
            'campos_texto' => $request->campos_texto,
            'user_id' => Auth::id(),
        ]);

        $archivosKeys = [];

        // Guardar documentos adjuntos y registrar vigencias
        if ($request->hasFile('archivos')) {
            foreach ($request->file('archivos') as $key => $file) {
                $ruta = $file->store('documentos/' . $request->contribuyente_id, 'public');
                $archivosKeys[] = $key;
                
                // Extraer el nombre base (quitar prefijos como '1_1_' o '1_2_')
                // Ejemplo: '1_1_rfc' → 'rfc', '1_2_domicilio' → 'domicilio'
                $nombreBase = preg_replace('/^\d+_\d+_/', '', $key);
                $mostrarEnCotejo = $request->input('mostrar_' . $nombreBase, false);
                
                // Guardar en documentos_adjuntos
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
                    'area_id' => 1,
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
            'area_id' => 1,
            'contribuyente_id' => $request->contribuyente_id,
            'tramite' => $request->tramite ?? 'Trámite general',
            'documentos_subidos' => json_encode($archivosKeys),
        ]);

        return redirect()->route('industria.documentos.index')
            ->with('success', 'Documentos guardados correctamente');
    }
}