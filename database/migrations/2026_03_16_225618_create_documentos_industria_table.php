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
        Schema::create('documentos_industria', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contribuyente_id')->constrained()->onDelete('cascade');
            $table->enum('proceso', [
                'cedulas_comerciales',
                'licencias_funcionamiento',
                'cobro_ambulante',
                'mercado_municipal',
                'corral_consejo',
                'central_abastos',
                'inspecciones',
                'notificaciones_retiro',
                'notificaciones_regularizacion',
                'carga_descarga',
                'anuncios_volantes',
                'temporada'
            ]);
            $table->enum('tipo', ['primera_vez', 'refrendo', 'general'])->default('general');
            
            // Campos para Cédulas Comerciales - Primera Vez
            $table->string('rfc_actualizada')->nullable();
            $table->string('comprobante_domicilio')->nullable();
            $table->string('constancia_pc')->nullable();
            $table->string('licencia_suelo')->nullable();
            $table->string('licencia_alineamiento')->nullable();
            $table->json('fotografias')->nullable();
            $table->string('contrato_arrendamiento')->nullable();
            $table->string('ine_propietario')->nullable();
            
            // Campos para Refrendo
            $table->string('cedula_anterior')->nullable();
            $table->string('factura_anterior')->nullable();
            
            // Campos comunes
            $table->text('observaciones')->nullable();
            $table->foreignId('user_id')->constrained();
            $table->boolean('vigente')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documentos_industria');
    }
};