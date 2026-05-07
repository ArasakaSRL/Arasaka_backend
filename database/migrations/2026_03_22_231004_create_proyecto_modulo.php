<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {

     
        DB::statement('CREATE EXTENSION IF NOT EXISTS "pgcrypto";');

        Schema::create('proyecto', function (Blueprint $table) {
            $table->uuid('id_proyecto')->primary()->default(DB::raw('gen_random_uuid()'));
            $table->uuid('id_portafolio');
            $table->string('nombre',50)->nullable();
            $table->string('descripcion',550)->nullable();
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_fin')->nullable();
            $table->text('url_demo')->nullable();
            $table->text('url_github')->nullable();
            $table->boolean('destacado')->nullable();
            $table->timestamp('fecha_creacion')->nullable();
            $table->timestamp('fecha_actualizacion')->nullable();
            
            $table->foreign('id_portafolio')->references('id_portafolio')->on('portafolio');
        });

        Schema::create('estado_proyecto', function (Blueprint $table) {
            $table->uuid('id_estado_proyecto')->primary()->default(DB::raw('gen_random_uuid()'));
            $table->uuid('id_proyecto');
            $table->string('estado');

            $table->foreign('id_proyecto')->references('id_proyecto')->on('proyecto');
        });

        Schema::create('url_imagen_proyecto', function (Blueprint $table) {
            $table->uuid('id_url_imagen_proyecto')->primary()->default(DB::raw('gen_random_uuid()'));
            $table->uuid('id_proyecto');
            $table->text('url_imagen')->nullable();

            $table->foreign('id_proyecto')->references('id_proyecto')->on('proyecto');
        });
    }

    public function down(): void {
        Schema::dropIfExists('url_imagen_proyecto');
        Schema::dropIfExists('estado_proyecto');
        Schema::dropIfExists('proyecto');
    }
};