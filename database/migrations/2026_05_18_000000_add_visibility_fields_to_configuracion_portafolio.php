<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('configuracion_portafolio', function (Blueprint $table) {
            $table->boolean('mostrar_redes_profesionales')->nullable()->default(true)->after('mostrar_servicios');
            $table->boolean('mostrar_cv')->nullable()->default(true)->after('mostrar_redes_profesionales');
            $table->boolean('mostrar_contacto')->nullable()->default(true)->after('mostrar_cv');
        });
    }

    public function down(): void
    {
        Schema::table('configuracion_portafolio', function (Blueprint $table) {
            $table->dropColumn(['mostrar_redes_profesionales', 'mostrar_cv', 'mostrar_contacto']);
        });
    }
};
