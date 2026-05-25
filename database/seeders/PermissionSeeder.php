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
        // PERMISOS PARA GUARD 'web' (Áreas)
        // ==========================================
        
        $permisosWeb = [
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
        ];
        
        foreach ($permisosWeb as $permiso) {
            Permission::firstOrCreate([
                'name' => $permiso,
                'guard_name' => 'web'
            ]);
        }
        
        // ==========================================
        // PERMISOS PARA GUARD 'admin'
        // ==========================================
        
        $permisosAdmin = [
            'ver usuarios',
            'crear usuarios',
            'editar usuarios',
            'eliminar usuarios',
            'ver roles',
            'asignar roles',
            'ver configuracion',
            'editar configuracion',
            'ver dashboard',
        ];
        
        foreach ($permisosAdmin as $permiso) {
            Permission::firstOrCreate([
                'name' => $permiso,
                'guard_name' => 'admin'
            ]);
        }
        
        // ==========================================
        // CREAR ROLES PARA GUARD 'web' (Áreas)
        // ==========================================
        
        // Administrador de área (todos los permisos web)
        $adminArea = Role::firstOrCreate([
            'name' => 'Administrador de área',
            'guard_name' => 'web'
        ]);
        $adminArea->syncPermissions(Permission::where('guard_name', 'web')->get());
        
        // Jefe de área (permisos sin eliminar)
        $jefeArea = Role::firstOrCreate([
            'name' => 'Jefe de área',
            'guard_name' => 'web'
        ]);
        $jefeArea->syncPermissions(Permission::where('guard_name', 'web')
            ->whereNotIn('name', ['eliminar contribuyentes'])
            ->get());
        
        // Usuario (permisos básicos)
        $usuario = Role::firstOrCreate([
            'name' => 'Usuario',
            'guard_name' => 'web'
        ]);
        $usuario->syncPermissions(Permission::where('guard_name', 'web')
            ->whereIn('name', [
                'ver contribuyentes',
                'ver documentos',
                'ver expediente',
                'ver cotejo',
                'ver historial',
                'acceso industria',
                'acceso desarrollo',
                'acceso proteccion',
                'acceso ingresos'
            ])->get());
        
        // ==========================================
        // CREAR ROLES PARA GUARD 'admin'
        // ==========================================
        
        // Administrador general (todos los permisos)
        $adminGeneral = Role::firstOrCreate([
            'name' => 'Administrador general',
            'guard_name' => 'admin'
        ]);
        $adminGeneral->syncPermissions(Permission::where('guard_name', 'admin')->get());
        
        // Administrador de área (permisos de admin)
        $adminAreaAdmin = Role::firstOrCreate([
            'name' => 'Administrador de área',
            'guard_name' => 'admin'
        ]);
        $adminAreaAdmin->syncPermissions(Permission::where('guard_name', 'admin')->get());
        
        // Jefe de área (permisos de admin)
        $jefeAreaAdmin = Role::firstOrCreate([
            'name' => 'Jefe de área',
            'guard_name' => 'admin'
        ]);
        $jefeAreaAdmin->syncPermissions(Permission::where('guard_name', 'admin')->get());
        
        // Usuario (permisos de admin)
        $usuarioAdmin = Role::firstOrCreate([
            'name' => 'Usuario',
            'guard_name' => 'admin'
        ]);
        $usuarioAdmin->syncPermissions(Permission::where('guard_name', 'admin')->get());
        
        // ==========================================
        // ASIGNAR ROLES A USUARIOS EXISTENTES
        // ==========================================
        
        // Administrador general (usa guard admin)
        $adminUser = User::where('email', 'admin@expedienteunico.com')->first();
        if ($adminUser) {
            $adminUser->assignRole($adminGeneral);
            $this->command->info("✅ Rol 'Administrador general' asignado a {$adminUser->email}");
        }
        
        // Usuarios por área (usan guard web)
        $areasUsers = [
            'industria@tepeaca.com' => 'Industria',
            'desarrollo@tepeaca.com' => 'Desarrollo',
            'proteccion@tepeaca.com' => 'Protección',
            'ingresos@tepeaca.com' => 'Ingresos',
        ];
        
        foreach ($areasUsers as $email => $area) {
            $user = User::where('email', $email)->first();
            if ($user) {
                $user->assignRole($adminArea);
                $this->command->info("✅ Rol 'Administrador de área' asignado a {$user->email} ({$area})");
            }
        }
        
        $this->command->info('🎉 Seeder ejecutado correctamente!');
    }
}