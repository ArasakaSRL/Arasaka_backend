<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('interaccion_habilidad_tecnica', function (Blueprint $table) {
            $table->uuid('id_interaccion')
                  ->primary()
                  ->default(DB::raw('gen_random_uuid()'));

            $table->uuid('id_visitante');
            $table->foreign('id_visitante')
                  ->references('id_visitante')
                  ->on('visitante');

            $table->uuid('id_habilidad');
            $table->foreign('id_habilidad')
                  ->references('id_habilidad')
                  ->on('habilidad');

            $table->integer('clic_expandir')->default(0);
            $table->integer('clic_cerrar')->default(0);

            $table->timestampTz('ultima_interaccion')->useCurrent();

            $table->unique(['id_visitante', 'id_habilidad']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('interaccion_habilidad_tecnica');
    }
};