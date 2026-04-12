<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {

       
        DB::statement('CREATE EXTENSION IF NOT EXISTS "pgcrypto";');

        Schema::create('portafolio', function (Blueprint $table) {
            $table->uuid('id_portafolio')->primary()->default(DB::raw('gen_random_uuid()'));
            $table->uuid('id_usuario');
            $table->string('nombre',50)->nullable();
            $table->boolean('visibilidad')->nullable();
            $table->string('descripcion',550)->nullable();
            $table->string('slug')->unique();
            $table->date('fecha_creacion')->nullable();
            $table->date('fecha_actualizacion')->nullable();

            $table->foreign('id_usuario')->references('id_usuario')->on('usuario');
        });

        Schema::create('configuracion_portafolio', function (Blueprint $table) {
            $table->uuid('id_configuracion_portafolio')->primary()->default(DB::raw('gen_random_uuid()'));
            $table->uuid('id_portafolio');
            $table->boolean('mostrar_proyecto')->nullable();
            $table->boolean('mostrar_habilidades')->nullable();
            $table->boolean('mostrar_experiencia')->nullable();
            $table->boolean('mostrar_certificaciones')->nullable();
            $table->boolean('mostrar_servicios')->nullable();
            $table->text('paleta_colores')->nullable();

            $table->foreign('id_portafolio')->references('id_portafolio')->on('portafolio');
        });

        Schema::create('visualizaciones_portafolio', function (Blueprint $table) {
            $table->uuid('id_visualizacion_portafolio')->primary()->default(DB::raw('gen_random_uuid()'));
            $table->uuid('id_portafolio');
            $table->integer('numero')->nullable();
            $table->date('fecha')->nullable();
            $table->text('ip_vista')->nullable();
            $table->decimal('clics_redes')->nullable();

            $table->foreign('id_portafolio')->references('id_portafolio')->on('portafolio');
        });

        Schema::create('reporte', function (Blueprint $table) {
            $table->uuid('id_reporte')->primary()->default(DB::raw('gen_random_uuid()'));
            $table->uuid('id_visualizacion_portafolio');
            $table->string('tipo',150)->nullable();
            $table->date('fecha_creacion')->nullable();
            $table->text('direccion_ip')->nullable();

            $table->foreign('id_visualizacion_portafolio')
                  ->references('id_visualizacion_portafolio')
                  ->on('visualizaciones_portafolio');
        });
    }

    public function down(): void {
        Schema::dropIfExists('reporte');
        Schema::dropIfExists('visualizaciones_portafolio');
        Schema::dropIfExists('configuracion_portafolio');
        Schema::dropIfExists('portafolio');
    }
};