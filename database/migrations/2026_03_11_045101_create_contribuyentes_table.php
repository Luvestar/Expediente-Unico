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
        Schema::create('contribuyentes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('apellidos');
            $table->string('rfc', 13)->unique();
            $table->string('telefono')->nullable();
            $table->string('email')->nullable();
            $table->string('nombre_empresa');
            $table->string('giro_comercial');
            $table->text('direccion');
            $table->enum('tipo_persona', ['fisica', 'moral'])->default('fisica');
            $table->foreignId('user_id')->constrained(); // Quién registró
            $table->foreignId('area_id')->default(1); // Industria y Comercio
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contribuyentes');
    }
};