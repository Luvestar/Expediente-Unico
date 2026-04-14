<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Crear usuario administrador
        $admin = User::create([
            'name' => 'Administrador',
            'email' => 'admin@expedienteunico.com',
            'password' => Hash::make('12345678'),
            'rol' => 'administrador',
            'activo' => true,
        ]);

        $this->command->info('✅ Usuario administrador creado: admin@expedienteunico.com / 12345678');
    }
}