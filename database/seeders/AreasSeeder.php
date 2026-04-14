<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AreasSeeder extends Seeder
{
    public function run()
    {
        DB::table('areas')->insert([
            [
                'nombre' => 'Industria y Comercio',
                'descripcion' => 'Gestión de licencias comerciales e industriales',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => 'Desarrollo Urbano',
                'descripcion' => 'Permisos de construcción y uso de suelo',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => 'Protección Civil',
                'descripcion' => 'Dictámenes de seguridad y riesgo',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}