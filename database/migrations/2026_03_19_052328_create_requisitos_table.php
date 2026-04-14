<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('requisitos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subtramite_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('nombre');
            $table->boolean('es_archivo')->default(true);
            $table->boolean('multiple')->default(false);
            $table->integer('orden')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('requisitos');
    }
};