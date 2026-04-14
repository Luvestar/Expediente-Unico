<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('documentos_vigencia', function (Blueprint $table) {
        $table->id();
        $table->foreignId('contribuyente_id')->constrained();
        $table->string('nombre_documento');
        $table->string('archivo_path');
        $table->date('fecha_vencimiento');
        $table->enum('estado', ['vigente', 'vencido'])->default('vigente');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documentos_vigencia');
    }
};
