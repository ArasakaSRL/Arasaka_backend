<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('interaccion_experiencia', function (Blueprint $table) {
            $table->uuid('id_interaccion')
                  ->primary()
                  ->default(DB::raw('gen_random_uuid()'));

            $table->uuid('id_visitante');
            $table->foreign('id_visitante')
                  ->references('id_visitante')
                  ->on('visitante');

            $table->uuid('id_experiencia');
            $table->foreign('id_experiencia')
                  ->references('id_experiencia')
                  ->on('experiencia');

            $table->boolean('fue_visible')->default(false);
            $table->integer('hover_count')->default(0);
            $table->integer('hover_ms')->default(0);

            $table->timestampTz('ultima_interaccion')->useCurrent();

            $table->unique(['id_visitante', 'id_experiencia']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('interaccion_experiencia');
    }
};