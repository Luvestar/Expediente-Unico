<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('contribuyentes', function (Blueprint $table) {
            // Verificar si existe la columna antes de agregarla
            if (!Schema::hasColumn('contribuyentes', 'giro_comercial')) {
                $table->string('giro_comercial')->nullable()->after('nombre_empresa');
            }
            
            if (!Schema::hasColumn('contribuyentes', 'tipo_persona')) {
                $table->enum('tipo_persona', ['fisica', 'moral'])->default('fisica')->after('giro_comercial');
            }
            
            if (!Schema::hasColumn('contribuyentes', 'user_id')) {
                $table->foreignId('user_id')->nullable()->constrained()->after('area_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('contribuyentes', function (Blueprint $table) {
            $table->dropColumn(['giro_comercial', 'tipo_persona', 'user_id']);
        });
    }
};