<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('documentos_vigencia', function (Blueprint $table) {
            if (!Schema::hasColumn('documentos_vigencia', 'es_universal')) {
                $table->boolean('es_universal')->default(false)->after('area_id');
            }
            if (!Schema::hasColumn('documentos_vigencia', 'subido_por_area')) {
                $table->unsignedBigInteger('subido_por_area')->nullable()->after('es_universal');
            }
        });
    }

    public function down()
    {
        Schema::table('documentos_vigencia', function (Blueprint $table) {
            $table->dropColumn(['es_universal', 'subido_por_area']);
        });
    }
};