<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('contribuyentes', function (Blueprint $table) {
            // Solo agregar las columnas que NO existen
            if (!Schema::hasColumn('contribuyentes', 'apellido_paterno')) {
                $table->string('apellido_paterno')->nullable();
            }
            if (!Schema::hasColumn('contribuyentes', 'apellido_materno')) {
                $table->string('apellido_materno')->nullable();
            }
            if (!Schema::hasColumn('contribuyentes', 'curp')) {
                $table->string('curp', 18)->nullable();
            }
            if (!Schema::hasColumn('contribuyentes', 'nombre_empresa')) {
                $table->string('nombre_empresa')->nullable();
            }
            if (!Schema::hasColumn('contribuyentes', 'tipo_persona')) {
                $table->enum('tipo_persona', ['fisica', 'moral'])->default('fisica');
            }
            if (!Schema::hasColumn('contribuyentes', 'user_id')) {
                $table->foreignId('user_id')->nullable()->constrained();
            }
        });
    }

    public function down(): void
    {
        Schema::table('contribuyentes', function (Blueprint $table) {
            $table->dropColumn([
                'apellido_paterno',
                'apellido_materno',
                'curp',
                'nombre_empresa',
                'tipo_persona',
                'user_id',
            ]);
        });
    }
};