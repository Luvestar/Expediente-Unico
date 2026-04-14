<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tramites_documentos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contribuyente_id')->constrained()->onDelete('cascade');
            $table->foreignId('tramite_id')->nullable()->constrained();
            $table->foreignId('subtramite_id')->nullable()->constrained()->onDelete('cascade');
            $table->json('campos_texto')->nullable();
            $table->json('archivos')->nullable();
            $table->foreignId('user_id')->constrained();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tramites_documentos');
    }
};