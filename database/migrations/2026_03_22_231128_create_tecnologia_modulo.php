<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {

     
        DB::statement('CREATE EXTENSION IF NOT EXISTS "pgcrypto";');

        Schema::create('tecnologias', function (Blueprint $table) {
            $table->uuid('id_tecnologia')->primary()->default(DB::raw('gen_random_uuid()'));
            $table->uuid('id_proyecto');
            $table->uuid('id_habilidad');
            $table->string('nombre',225)->nullable();
            $table->string('descripcion',255)->nullable();

            $table->foreign('id_proyecto')->references('id_proyecto')->on('proyecto');
            $table->foreign('id_habilidad')->references('id_habilidad')->on('habilidad');
        });

        Schema::create('categoria_tecnologia', function (Blueprint $table) {
            $table->uuid('id_categoria_tecnologia')->primary()->default(DB::raw('gen_random_uuid()'));
            $table->uuid('id_tecnologia');
            $table->string('nombre',225)->nullable();

            $table->foreign('id_tecnologia')->references('id_tecnologia')->on('tecnologias');
        });
    }

    public function down(): void {
        Schema::dropIfExists('categoria_tecnologia');
        Schema::dropIfExists('tecnologias');
    }
};