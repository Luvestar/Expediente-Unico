<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // 1. Agregar area_id a documentos_vigencia
        if (!Schema::hasColumn('documentos_vigencia', 'area_id')) {
            Schema::table('documentos_vigencia', function (Blueprint $table) {
                $table->unsignedBigInteger('area_id')->nullable()->after('contribuyente_id');
                $table->foreign('area_id')->references('id')->on('areas')->onDelete('set null');
            });
        }
        
        // 2. Agregar campos faltantes a documentos_vigencia
        if (!Schema::hasColumn('documentos_vigencia', 'tramite_documento_id')) {
            Schema::table('documentos_vigencia', function (Blueprint $table) {
                $table->unsignedBigInteger('tramite_documento_id')->nullable()->after('area_id');
                $table->foreign('tramite_documento_id')->references('id')->on('tramites_documentos')->onDelete('set null');
            });
        }
        
        // 3. Agregar area_id a actividad_tramites
        if (!Schema::hasColumn('actividad_tramites', 'area_id')) {
            Schema::table('actividad_tramites', function (Blueprint $table) {
                $table->unsignedBigInteger('area_id')->nullable()->after('id');
                $table->foreign('area_id')->references('id')->on('areas')->onDelete('set null');
            });
        }
        
        // 4. Agregar campos de detalle a actividad_tramites
        if (!Schema::hasColumn('actividad_tramites', 'tramite_id')) {
            Schema::table('actividad_tramites', function (Blueprint $table) {
                $table->unsignedBigInteger('tramite_id')->nullable()->after('tramite');
                $table->string('documento_nombre')->nullable()->after('documentos_subidos');
                $table->date('fecha_vencimiento')->nullable()->after('documento_nombre');
                $table->string('accion')->default('registró')->after('fecha_vencimiento');
            });
        } else {
            // Si ya existe tramite_id pero faltan los otros
            if (!Schema::hasColumn('actividad_tramites', 'documento_nombre')) {
                Schema::table('actividad_tramites', function (Blueprint $table) {
                    $table->string('documento_nombre')->nullable()->after('documentos_subidos');
                    $table->date('fecha_vencimiento')->nullable()->after('documento_nombre');
                    $table->string('accion')->default('registró')->after('fecha_vencimiento');
                });
            }
        }
        
        // 5. Agregar índice para mejorar rendimiento
        Schema::table('documentos_vigencia', function (Blueprint $table) {
            $table->index(['area_id', 'estado', 'fecha_vencimiento']);
        });
        
        Schema::table('actividad_tramites', function (Blueprint $table) {
            $table->index(['area_id', 'created_at']);
        });
    }

    public function down()
    {
        // Eliminar índices
        Schema::table('documentos_vigencia', function (Blueprint $table) {
            $table->dropIndex(['area_id', 'estado', 'fecha_vencimiento']);
        });
        
        Schema::table('actividad_tramites', function (Blueprint $table) {
            $table->dropIndex(['area_id', 'created_at']);
        });
        
        // Eliminar columnas de documentos_vigencia
        if (Schema::hasColumn('documentos_vigencia', 'tramite_documento_id')) {
            Schema::table('documentos_vigencia', function (Blueprint $table) {
                $table->dropForeign(['tramite_documento_id']);
                $table->dropColumn('tramite_documento_id');
            });
        }
        
        if (Schema::hasColumn('documentos_vigencia', 'area_id')) {
            Schema::table('documentos_vigencia', function (Blueprint $table) {
                $table->dropForeign(['area_id']);
                $table->dropColumn('area_id');
            });
        }
        
        // Eliminar columnas de actividad_tramites
        if (Schema::hasColumn('actividad_tramites', 'area_id')) {
            Schema::table('actividad_tramites', function (Blueprint $table) {
                $table->dropForeign(['area_id']);
                $table->dropColumn('area_id');
            });
        }
        
        if (Schema::hasColumn('actividad_tramites', 'tramite_id')) {
            Schema::table('actividad_tramites', function (Blueprint $table) {
                $table->dropColumn('tramite_id');
            });
        }
        
        if (Schema::hasColumn('actividad_tramites', 'documento_nombre')) {
            Schema::table('actividad_tramites', function (Blueprint $table) {
                $table->dropColumn(['documento_nombre', 'fecha_vencimiento', 'accion']);
            });
        }
    }
};