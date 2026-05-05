<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('interaccion_perfil', function (Blueprint $table) {
            $table->uuid('id_interaccion')
                  ->primary()
                  ->default(DB::raw('gen_random_uuid()'));

            $table->uuid('id_visitante');
            $table->foreign('id_visitante')
                  ->references('id_visitante')
                  ->on('visitante');

            $table->integer('hover_foto_count')->default(0);
            $table->integer('hover_foto_ms')->default(0);
            $table->integer('hover_correo_count')->default(0);
            $table->integer('hover_correo_ms')->default(0);

            $table->integer('clic_foto_perfil')->default(0);
            $table->integer('clic_correo')->default(0);
            $table->integer('clic_linkedin')->default(0);
            $table->integer('clic_github')->default(0);
            $table->integer('clic_contactar')->default(0);
            $table->integer('clic_descargar_cv')->default(0);

            $table->timestampTz('ultima_interaccion')->useCurrent();

            $table->unique('id_visitante');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('interaccion_perfil');
    }
};