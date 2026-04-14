<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Verificar si la tabla existe
        if (Schema::hasTable('contribuyentes')) {
            Schema::table('contribuyentes', function (Blueprint $table) {
                // Modificar columnas a TEXT para soportar cifrado
                $table->text('rfc')->change();
                $table->text('curp')->nullable()->change();
                $table->text('email')->nullable()->change();
                $table->text('telefono')->nullable()->change();
                $table->text('direccion')->nullable()->change();
            });
        }
    }

    public function down()
    {
        if (Schema::hasTable('contribuyentes')) {
            Schema::table('contribuyentes', function (Blueprint $table) {
                $table->string('rfc', 13)->change();
                $table->string('curp', 18)->nullable()->change();
                $table->string('email', 255)->nullable()->change();
                $table->string('telefono', 20)->nullable()->change();
                $table->string('direccion', 255)->nullable()->change();
            });
        }
    }
};