<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {

        // Asegurar extensión UUID en PostgreSQL
        DB::statement('CREATE EXTENSION IF NOT EXISTS "pgcrypto";');

        Schema::create('servicio', function (Blueprint $table) {
            $table->uuid('id_servicio')->primary()->default(DB::raw('gen_random_uuid()'));
            $table->uuid('id_portafolio');
            $table->string('nombre',150)->nullable();
            $table->string('descripcion',550)->nullable();
            $table->boolean('activo')->nullable();

            $table->foreign('id_portafolio')->references('id_portafolio')->on('portafolio');
        });
        
        Schema::create('categoria_certificacion', function (Blueprint $table) {
            $table->uuid('id_categoria_certificacion')->primary()->default(DB::raw('gen_random_uuid()'));
            $table->string('nombre',150)->nullable();
            $table->string('descripcion',550)->nullable();
            $table->text('url_imagen')->nullable();
        });

        Schema::create('certificacion', function (Blueprint $table) {
            $table->uuid('id_certificacion')->primary()->default(DB::raw('gen_random_uuid()'));
            $table->uuid('id_portafolio');
            $table->uuid('id_categoria_certificacion')->nullable();
            $table->string('titulo',100)->nullable();
            $table->string('descripcion',550)->nullable();
            $table->string('institucion_emisora',150)->nullable();
            $table->date('fecha_obtencion')->nullable();
            $table->text('url_archivo')->nullable();

            $table->foreign('id_portafolio')->references('id_portafolio')->on('portafolio');
            $table->foreign('id_categoria_certificacion')->references('id_categoria_certificacion')->on('categoria_certificacion');
        });

        Schema::create('redes_profesionales', function (Blueprint $table) {
            $table->uuid('id_red_profesional')->primary()->default(DB::raw('gen_random_uuid()'));
            $table->uuid('id_portafolio');
            $table->string('nombre',150)->nullable();
            $table->text('url')->nullable();

            $table->foreign('id_portafolio')->references('id_portafolio')->on('portafolio');
        });
    }

    public function down(): void {
        Schema::dropIfExists('redes_profesionales');
        Schema::dropIfExists('categoria_certificacion');
        Schema::dropIfExists('certificacion');
        Schema::dropIfExists('servicio');
    }
};