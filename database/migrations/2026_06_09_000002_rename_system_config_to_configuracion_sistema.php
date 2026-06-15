<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::rename('system_config', 'configuracion_sistema');
    }

    public function down(): void
    {
        Schema::rename('configuracion_sistema', 'system_config');
    }
};
