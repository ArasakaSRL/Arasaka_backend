<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('interaccion_certificacion', function (Blueprint $table) {
            $table->uuid('id_interaccion')
                  ->primary()
                  ->default(DB::raw('gen_random_uuid()'));

            $table->uuid('id_visitante');
            $table->foreign('id_visitante')
                  ->references('id_visitante')
                  ->on('visitante');

            $table->uuid('id_certificacion');
            $table->foreign('id_certificacion')
                  ->references('id_certificacion')
                  ->on('certificacion');

            $table->integer('hover_count')->default(0);
            $table->integer('hover_ms')->default(0);
            $table->integer('clic_abrir_modal')->default(0);
            $table->integer('clic_ver_credencial')->default(0);
            $table->integer('clic_cerrar_modal')->default(0);

            $table->timestampTz('ultima_interaccion')->useCurrent();

            $table->unique(['id_visitante', 'id_certificacion']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('interaccion_certificacion');
    }
};