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
    Schema::table('documentos_vigencia', function (Blueprint $table) {
        $table->foreignId('area_id')->nullable()->after('contribuyente_id');
    });
}

public function down()
{
    Schema::table('documentos_vigencia', function (Blueprint $table) {
        $table->dropColumn('area_id');
    });
}
};
