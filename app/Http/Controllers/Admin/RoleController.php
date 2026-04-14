<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        $usuarios = User::all();
        
        return view('admin.permisos.index', compact('roles', 'usuarios'));
    }
    
    public function edit($id)
    {
        $role = Role::findById($id);
        $permissions = Permission::all();
        $rolePermissions = $role->permissions->pluck('name')->toArray();
        
        return view('admin.permisos.editar', compact('role', 'permissions', 'rolePermissions'));
    }
    
    public function update(Request $request, $id)
    {
        $role = Role::findById($id);
        
        $request->validate([
            'permissions' => 'nullable|array',
        ]);
        
        $role->syncPermissions($request->permissions ?? []);
        
        return redirect()->route('admin.permisos')
            ->with('success', "Permisos actualizados para el rol {$role->name}");
    }
    
    public function asignarUsuario(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'role' => 'required|exists:roles,name',
        ]);
        
        $user = User::find($request->user_id);
        $user->syncRoles([$request->role]);
        
        return redirect()->route('admin.permisos')
            ->with('success', "Rol asignado correctamente a {$user->name}");
    }
}