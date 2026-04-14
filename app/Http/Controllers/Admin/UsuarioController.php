<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Area;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with('area');
        
        // Búsqueda por nombre, apellidos, email o teléfono
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('nombre_completo', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%")
                  ->orWhere('telefono', 'LIKE', "%{$search}%");
            });
        }
        
        // PAGINACIÓN: 10 usuarios por página
        $usuarios = $query->orderBy('created_at', 'desc')->paginate(10);
        
        // Estadísticas para las tarjetas
        $totalUsuarios = User::count();
        $activos = User::where('activo', true)->count();
        $inactivos = User::where('activo', false)->count();
        $administrativos = User::where('rol', 'Administrador general')->count();
        
        return view('admin.usuarios.index', compact(
            'usuarios', 
            'totalUsuarios', 
            'activos', 
            'inactivos', 
            'administrativos'
        ));
    }

    public function create()
    {
        $areas = Area::where('activa', true)->get();
        return view('admin.usuarios.crear', compact('areas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'telefono' => 'nullable|string|max:20',
            'username' => 'required|string|max:255|unique:users,name',
            'area_id' => 'required|exists:areas,id',
            'password' => 'required|min:6|confirmed',
        ]);
        
        User::create([
            'name' => $request->username,
            'nombre_completo' => $request->nombre . ' ' . $request->apellidos,
            'email' => $request->email,
            'telefono' => $request->telefono,
            'password' => Hash::make($request->password),
            'area_id' => $request->area_id,
            'rol' => 'usuario',
            'activo' => true,
        ]);
        
        return redirect()->route('admin.usuarios.crear')
                         ->with('success', 'Usuario creado correctamente');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $usuario = User::findOrFail($id);
        $areas = Area::where('activa', true)->get();
        return view('admin.usuarios.editar', compact('usuario', 'areas'));
    }

    public function update(Request $request, string $id)
    {
        $usuario = User::findOrFail($id);

        $rules = [
            'nombre_completo' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'telefono' => 'nullable|string|max:20',
            'username' => 'required|string|max:255|unique:users,name,' . $id,
            'rol' => 'required|string|in:Administrador general,Administrador de área,Jefe de área,Usuario',
        ];

        if ($request->rol === 'Administrador general') {
            $rules['area_id'] = 'nullable';
        } else {
            $rules['area_id'] = 'required|exists:areas,id';
        }

        if ($request->filled('password')) {
            $rules['password'] = 'min:6|confirmed';
        }

        $request->validate($rules);

        $updateData = [
            'name' => $request->username,
            'nombre_completo' => $request->nombre_completo,
            'email' => $request->email,
            'telefono' => $request->telefono,
            'rol' => $request->rol,
        ];

        if ($request->rol === 'Administrador general') {
            $updateData['area_id'] = null;
        } else {
            $updateData['area_id'] = $request->area_id;
        }

        $usuario->update($updateData);

        if ($request->filled('password')) {
            $usuario->password = Hash::make($request->password);
            $usuario->save();
        }

        $usuario->syncRoles([$request->rol]);

        return redirect()->route('admin.usuarios')
                         ->with('success', 'Usuario actualizado correctamente');
    }

    public function destroy(string $id)
    {
        $usuario = User::findOrFail($id);
        
        if (auth()->id() == $id) {
            return redirect()->route('admin.usuarios')
                             ->with('error', 'No puedes eliminar tu propio usuario');
        }
        
        $usuario->delete();
        
        return redirect()->route('admin.usuarios')
                         ->with('success', 'Usuario eliminado correctamente');
    }

    public function toggleEstado(string $id)
    {
        $usuario = User::findOrFail($id);
        
        if (auth()->id() == $id) {
            return redirect()->route('admin.usuarios')
                             ->with('error', 'No puedes cambiar tu propio estado');
        }
        
        $usuario->activo = !$usuario->activo;
        $usuario->save();
        
        $estado = $usuario->activo ? 'activado' : 'desactivado';
        
        return redirect()->route('admin.usuarios')
                         ->with('success', "Usuario {$estado} correctamente");
    }
}