<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('informacion_basica', function (Blueprint $table) {
            $table->uuid('id_informacion_basica')->primary()->default(DB::raw('gen_random_uuid()'));
            $table->uuid('id_portafolio');
            $table->string('nombre_completo', 150);
            $table->string('gmail', 150);
            $table->string('contrasena', 255);
            $table->string('pais', 100)->nullable();
            $table->string('foto_perfil', 500)->nullable();
            $table->string('foto_perfil_public_id', 255)->nullable();
            $table->string('biografia', 550)->nullable();

            $table->foreign('id_portafolio')
                ->references('id_portafolio')
                ->on('portafolio')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('informacion_basica');
    }
};
