<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Solo agregar rol si no existe
            if (!Schema::hasColumn('users', 'rol')) {
                $table->string('rol')->default('usuario')->after('password');
            }
            
            // No intentamos agregar activo porque ya existe
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['rol']); // Solo eliminamos rol
        });
    }
};