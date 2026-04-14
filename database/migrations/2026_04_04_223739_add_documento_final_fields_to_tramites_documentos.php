<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('tramites_documentos', function (Blueprint $table) {
            if (!Schema::hasColumn('tramites_documentos', 'documento_final_path')) {
                $table->string('documento_final_path')->nullable()->after('archivos');
            }
            if (!Schema::hasColumn('tramites_documentos', 'mostrar_en_cotejo')) {
                $table->boolean('mostrar_en_cotejo')->default(false)->after('documento_final_path');
            }
        });
    }

    public function down()
    {
        Schema::table('tramites_documentos', function (Blueprint $table) {
            $table->dropColumn(['documento_final_path', 'mostrar_en_cotejo']);
        });
    }
};