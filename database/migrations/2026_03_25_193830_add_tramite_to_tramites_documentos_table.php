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
    Schema::table('tramites_documentos', function (Blueprint $table) {
        $table->string('tramite')->nullable()->after('area_id');
    });
}

public function down()
{
    Schema::table('tramites_documentos', function (Blueprint $table) {
        $table->dropColumn('tramite');
    });
}
};
