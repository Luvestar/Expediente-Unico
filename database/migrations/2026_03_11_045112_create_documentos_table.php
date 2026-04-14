<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('documentos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('tipo'); // Licencia, Permiso, Constancia, etc.
            $table->string('numero_oficial')->nullable();
            $table->date('fecha_expedicion');
            $table->date('fecha_vigencia')->nullable();
            $table->enum('estado', ['vigente', 'por_vencer', 'vencido', 'tramite'])->default('vigente');
            $table->string('archivo_path')->nullable(); // Ruta del archivo PDF
            $table->text('observaciones')->nullable();
            
            // Llaves foráneas
            $table->foreignId('contribuyente_id')->constrained()->onDelete('cascade');
            $table->foreignId('area_id')->constrained();
            $table->foreignId('user_id')->constrained(); // Quién registró
            
            $table->timestamps();
            
            // Índices para búsquedas rápidas
            $table->index('estado');
            $table->index('fecha_vigencia');
        });
    }

    public function down()
    {
        Schema::dropIfExists('documentos');
    }
};