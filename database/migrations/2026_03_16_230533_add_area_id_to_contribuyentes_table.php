<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // La columna ya existe, no hacemos nada
    }

    public function down(): void
    {
        // No hacemos nada al revertir
    }
};