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
        $table->foreignId('area_id')->nullable()->after('tramite_id');
    });
}

public function down()
{
    Schema::table('tramites_documentos', function (Blueprint $table) {
        $table->dropColumn('area_id');
    });
}
};
