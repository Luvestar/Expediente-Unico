<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // ==========================================
        // CREAR PERMISOS (SOLO LOS QUE EXISTEN)
        // ==========================================
        
        // Permisos para contribuyentes
        Permission::create(['name' => 'ver contribuyentes']);
        Permission::create(['name' => 'crear contribuyentes']);
        Permission::create(['name' => 'editar contribuyentes']);
        Permission::create(['name' => 'eliminar contribuyentes']);
        
        // Permisos para documentos
        Permission::create(['name' => 'ver documentos']);
        Permission::create(['name' => 'subir documentos']);
        
        // Permisos para consultas
        Permission::create(['name' => 'ver expediente']);
        Permission::create(['name' => 'ver cotejo']);
        Permission::create(['name' => 'ver historial']);
        Permission::create(['name' => 'exportar csv']);
        
        // Permisos para órdenes de cobro
        Permission::create(['name' => 'crear ordenes']);
        Permission::create(['name' => 'ver ordenes']);
        
        // Permisos de acceso por área
        Permission::create(['name' => 'acceso industria']);
        Permission::create(['name' => 'acceso desarrollo']);
        Permission::create(['name' => 'acceso proteccion']);
        Permission::create(['name' => 'acceso ingresos']);
        
        // Permisos de administración (solo para admin general)
        Permission::create(['name' => 'administrar usuarios']);
        Permission::create(['name' => 'ver configuracion']);
        Permission::create(['name' => 'editar configuracion']);
        
        // ==========================================
        // CREAR ROLES
        // ==========================================
        
        // Rol: Administrador General (todos los permisos)
        $adminGeneral = Role::create(['name' => 'Administrador general']);
        $adminGeneral->givePermissionTo(Permission::all());
        
        // Rol: Administrador de área
        $adminArea = Role::create(['name' => 'Administrador de área']);
        $adminArea->givePermissionTo([
            'ver contribuyentes',
            'crear contribuyentes',
            'editar contribuyentes',
            'eliminar contribuyentes',
            'ver documentos',
            'subir documentos',
            'ver expediente',
            'ver cotejo',
            'ver historial',
            'exportar csv',
            'crear ordenes',
            'ver ordenes',
            'acceso industria',
            'acceso desarrollo',
            'acceso proteccion',
            'acceso ingresos',
        ]);
        
        // Rol: Jefe de área
        $jefeArea = Role::create(['name' => 'Jefe de área']);
        $jefeArea->givePermissionTo([
            'ver contribuyentes',
            'crear contribuyentes',
            'ver documentos',
            'subir documentos',
            'ver expediente',
            'ver cotejo',
            'ver historial',
            'exportar csv',
            'crear ordenes',
            'ver ordenes',
            'acceso industria',
            'acceso desarrollo',
            'acceso proteccion',
            'acceso ingresos',
        ]);
        
        // Rol: Usuario
        $usuario = Role::create(['name' => 'Usuario']);
        $usuario->givePermissionTo([
            'ver contribuyentes',
            'crear contribuyentes',
            'ver documentos',
            'subir documentos',
            'ver expediente',
            'ver cotejo',
            'ver historial',
            'exportar csv',
            'crear ordenes',
            'ver ordenes',
            'acceso industria',
            'acceso desarrollo',
            'acceso proteccion',
            'acceso ingresos',
        ]);
        
        // ==========================================
        // ASIGNAR ROLES A USUARIOS EXISTENTES
        // ==========================================
        
        // Administrador general
        $adminUser = User::where('email', 'admin@expedienteunico.com')->first();
        if ($adminUser) {
            $adminUser->assignRole('Administrador general');
        }
        
        // Industria
        $industriaUser = User::where('email', 'industria@tepeaca.com')->first();
        if ($industriaUser) {
            $industriaUser->assignRole('Administrador de área');
        }
        
        // Desarrollo
        $desarrolloUser = User::where('email', 'desarrollo@tepeaca.com')->first();
        if ($desarrolloUser) {
            $desarrolloUser->assignRole('Administrador de área');
        }
        
        // Protección
        $proteccionUser = User::where('email', 'proteccion@tepeaca.com')->first();
        if ($proteccionUser) {
            $proteccionUser->assignRole('Administrador de área');
        }
        
        // Ingresos
        $ingresosUser = User::where('email', 'ingresos@tepeaca.com')->first();
        if ($ingresosUser) {
            $ingresosUser->assignRole('Administrador de área');
        }
    }
}