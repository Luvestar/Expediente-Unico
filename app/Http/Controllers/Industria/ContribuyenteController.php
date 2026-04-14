<?php

namespace App\Http\Controllers\Industria;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contribuyente;
use Illuminate\Support\Facades\Auth;

class ContribuyenteController extends Controller
{
    public function index(Request $request)
    {
        $query = Contribuyente::where('area_id', 1);

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nombre', 'LIKE', "%{$search}%")
                  ->orWhere('apellido_paterno', 'LIKE', "%{$search}%")
                  ->orWhere('apellido_materno', 'LIKE', "%{$search}%")
                  ->orWhere('rfc', 'LIKE', "%{$search}%")
                  ->orWhere('nombre_empresa', 'LIKE', "%{$search}%");
            });
        }

        // PAGINACIÓN: 10 contribuyentes por página
        $contribuyentes = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('industria.contribuyente.index', compact('contribuyentes'));
    }

    public function create()
    {
        return view('industria.contribuyente.crear');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido_paterno' => 'required|string|max:255',
            'apellido_materno' => 'nullable|string|max:255',
            'rfc' => 'required|string|max:13|unique:contribuyentes,rfc',
            'curp' => 'nullable|string|max:18',
            'email' => 'nullable|email|max:255',
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'required|string',
            'giro_comercial' => 'required|string|max:255',
            'nombre_empresa' => 'nullable|string|max:255',
            'tipo_persona' => 'required|in:fisica,moral',
        ]);

        Contribuyente::create([
            'nombre' => $request->nombre,
            'apellidos' => $request->apellido_paterno . ' ' . $request->apellido_materno,
            'apellido_paterno' => $request->apellido_paterno,
            'apellido_materno' => $request->apellido_materno,
            'rfc' => strtoupper($request->rfc),
            'curp' => strtoupper($request->curp),
            'email' => $request->email,
            'telefono' => $request->telefono,
            'direccion' => $request->direccion,
            'giro_comercial' => $request->giro_comercial,
            'nombre_empresa' => $request->nombre_empresa,
            'tipo_persona' => $request->tipo_persona,
            'user_id' => Auth::id(),
            'area_id' => 1,
            'activo' => true,
        ]);

        return redirect()->route('industria.documentos.index')
                         ->with('success', 'Contribuyente registrado correctamente');
    }

    public function show(string $id)
    {
        $contribuyente = Contribuyente::findOrFail($id);
        return view('industria.contribuyente.show', compact('contribuyente'));
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
            'apellido_paterno' => 'required|string|max:255',
            'apellido_materno' => 'nullable|string|max:255',
            'rfc' => 'required|string|max:13|unique:contribuyentes,rfc,' . $id,
            'telefono' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'direccion' => 'required|string',
            'giro_comercial' => 'required|string|max:255',
            'nombre_empresa' => 'nullable|string|max:255',
            'tipo_persona' => 'required|in:fisica,moral',
        ]);

        $contribuyente->update([
            'nombre' => $request->nombre,
            'apellido_paterno' => $request->apellido_paterno,
            'apellido_materno' => $request->apellido_materno,
            'rfc' => strtoupper($request->rfc),
            'telefono' => $request->telefono,
            'email' => $request->email,
            'direccion' => $request->direccion,
            'giro_comercial' => $request->giro_comercial,
            'nombre_empresa' => $request->nombre_empresa,
            'tipo_persona' => $request->tipo_persona,
        ]);

        return redirect()->route('industria.documentos.index')
                         ->with('success', 'Contribuyente actualizado correctamente');
    }

    public function destroy(string $id)
    {
        $contribuyente = Contribuyente::findOrFail($id);
        $contribuyente->delete();

        return redirect()->route('industria.documentos.index')
                         ->with('success', 'Contribuyente eliminado correctamente');
    }
}