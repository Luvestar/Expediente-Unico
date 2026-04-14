<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Contribuyentes
        Schema::table('contribuyentes', function (Blueprint $table) {
            $table->index('nombre', 'idx_nombre');
            $table->index('rfc', 'idx_rfc');
            $table->index('nombre_empresa', 'idx_empresa');
            $table->index('created_at', 'idx_created');
        });
        
        // Trámites documentos
        Schema::table('tramites_documentos', function (Blueprint $table) {
            $table->index('contribuyente_id', 'idx_contribuyente');
            $table->index('area_id', 'idx_area');
            $table->index('created_at', 'idx_created');
        });
        
        // Documentos vigencia
        Schema::table('documentos_vigencia', function (Blueprint $table) {
            $table->index('contribuyente_id', 'idx_contribuyente');
            $table->index('area_id', 'idx_area');
            $table->index('fecha_vencimiento', 'idx_fecha_vencimiento');
        });
        
        // Actividad tramites
        Schema::table('actividad_tramites', function (Blueprint $table) {
            $table->index('contribuyente_id', 'idx_contribuyente');
            $table->index('area_id', 'idx_area');
            $table->index('created_at', 'idx_created');
        });
    }

    public function down()
    {
        // Contribuyentes
        Schema::table('contribuyentes', function (Blueprint $table) {
            $table->dropIndex('idx_nombre');
            $table->dropIndex('idx_rfc');
            $table->dropIndex('idx_empresa');
            $table->dropIndex('idx_created');
        });
        
        // Trámites documentos
        Schema::table('tramites_documentos', function (Blueprint $table) {
            $table->dropIndex('idx_contribuyente');
            $table->dropIndex('idx_area');
            $table->dropIndex('idx_created');
        });
        
        // Documentos vigencia
        Schema::table('documentos_vigencia', function (Blueprint $table) {
            $table->dropIndex('idx_contribuyente');
            $table->dropIndex('idx_area');
            $table->dropIndex('idx_fecha_vencimiento');
        });
        
        // Actividad tramites
        Schema::table('actividad_tramites', function (Blueprint $table) {
            $table->dropIndex('idx_contribuyente');
            $table->dropIndex('idx_area');
            $table->dropIndex('idx_created');
        });
    }
};