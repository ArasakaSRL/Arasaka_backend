<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('portafolio', function (Blueprint $table) {
            $table->boolean('link_activo')->default(false);
            $table->timestamp('fecha_expiracion_link')->nullable();
            $table->string('duracion_link', 20)->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('portafolio', function (Blueprint $table) {
            $table->dropColumn(['link_activo', 'fecha_expiracion_link', 'duracion_link']);
        });
    }
};
