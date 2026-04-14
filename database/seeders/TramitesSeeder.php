<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tramite;
use App\Models\Subtramite;
use App\Models\Requisito;

class TramitesSeeder extends Seeder
{
    public function run()
    {
        // Trámite 1: Cédulas Comerciales
        $t1 = Tramite::create(['nombre' => 'Cobro y expedición de Cédulas Comerciales', 'orden' => 1]);
        $st1 = Subtramite::create(['tramite_id' => $t1->id, 'nombre' => 'Refrendo y/o Primera vez']);
        // No se asignan requisitos aquí porque se cargarán dinámicamente con el punto -1

        // Trámite 2: Licencias de Funcionamiento
        $t2 = Tramite::create(['nombre' => 'Cobro y expedición de Licencias de Funcionamiento', 'orden' => 2]);
        $st2 = Subtramite::create(['tramite_id' => $t2->id, 'nombre' => 'Refrendo']);

        // Trámite 3: Cobro ambulante
        $t3 = Tramite::create(['nombre' => 'Cobro ambulante', 'orden' => 3]);
        $st3 = Subtramite::create(['tramite_id' => $t3->id, 'nombre' => 'General']);

        // Trámite 4: Administración de Mercado Municipal
        $t4 = Tramite::create(['nombre' => 'Administración de Mercado Municipal Dr. Julian Yunes Arellano', 'orden' => 4]);
        $st4 = Subtramite::create(['tramite_id' => $t4->id, 'nombre' => 'General']);

        // Trámite 5: Administración de Corral de Consejo
        $t5 = Tramite::create(['nombre' => 'Administración de Corral de Consejo', 'orden' => 5]);
        $st5 = Subtramite::create(['tramite_id' => $t5->id, 'nombre' => 'General']);

        // Trámite 6: Administración de Central de Abastos
        $t6 = Tramite::create(['nombre' => 'Administración de Central de Abastos (Tianguis)', 'orden' => 6]);
        $st6 = Subtramite::create(['tramite_id' => $t6->id, 'nombre' => 'General']);

        // Trámite 7: Inspecciones
        $t7 = Tramite::create(['nombre' => 'Inspecciones', 'orden' => 7]);
        $st7 = Subtramite::create(['tramite_id' => $t7->id, 'nombre' => 'General']);

        // Trámite 8: Notificaciones sobre retiro de mercancía
        $t8 = Tramite::create(['nombre' => 'Notificaciones a comercios sobre retiro de mercancía', 'orden' => 8]);
        $st8 = Subtramite::create(['tramite_id' => $t8->id, 'nombre' => 'General']);

        // Trámite 9: Notificación de regularización
        $t9 = Tramite::create(['nombre' => 'Notificación de regularización y/o empadronamiento', 'orden' => 9]);
        $st9 = Subtramite::create(['tramite_id' => $t9->id, 'nombre' => 'General']);

        // Trámite 10: Cobro de Carga y Descarga
        $t10 = Tramite::create(['nombre' => 'Cobro de Carga y Descarga', 'orden' => 10]);
        $st10 = Subtramite::create(['tramite_id' => $t10->id, 'nombre' => 'General']);

        // Trámite 11: Cobro de anuncios
        $t11 = Tramite::create(['nombre' => 'Cobro de anuncios o repartición de volantes', 'orden' => 11]);
        $st11 = Subtramite::create(['tramite_id' => $t11->id, 'nombre' => 'General']);

        // Trámite 12: Cobro de Temporada
        $t12 = Tramite::create(['nombre' => 'Cobro de Temporada (Navidad, todos santos, feria octubre y abril)', 'orden' => 12]);
        $st12 = Subtramite::create(['tramite_id' => $t12->id, 'nombre' => 'General']);

        $this->command->info('✅ 12 trámites creados correctamente');
    }
}