<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('denuncia_portafolio', function (Blueprint $table) {
            $table->uuid('id_denuncia_portafolio')
                  ->primary()
                  ->default(DB::raw('gen_random_uuid()'));

            $table->uuid('id_portafolio');
            $table->foreign('id_portafolio')
                  ->references('id_portafolio')
                  ->on('portafolio');

            $table->unsignedBigInteger('id_etiqueta_denuncia');
            $table->foreign('id_etiqueta_denuncia')
                  ->references('id_etiqueta_denuncia')
                  ->on('etiqueta_denuncia');

            $table->text('motivo')->nullable();

            $table->timestampsTz();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('denuncia_portafolio');
    }
};
