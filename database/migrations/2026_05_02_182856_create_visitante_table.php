<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('visitante', function (Blueprint $table) {
            $table->uuid('id_visitante')
                  ->primary()
                  ->default(DB::raw('gen_random_uuid()'));

            $table->uuid('id_portafolio');
            $table->foreign('id_portafolio')
                  ->references('id_portafolio')
                  ->on('portafolio');

            $table->string('visitor_id', 64);

            $table->timestampTz('primera_visita')->useCurrent();
            $table->timestampTz('ultima_visita')->useCurrent();

            $table->unique(['visitor_id', 'id_portafolio']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('visitante');
    }
};