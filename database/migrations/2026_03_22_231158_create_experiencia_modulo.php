<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {

        
        DB::statement('CREATE EXTENSION IF NOT EXISTS "pgcrypto";');

        Schema::create('tipo_experiencia', function (Blueprint $table) {
            $table->uuid('id_tipo_experiencia')->primary()->default(DB::raw('gen_random_uuid()'));
            $table->string('nombre',100)->nullable();
        });

        Schema::create('experiencia', function (Blueprint $table) {
            $table->uuid('id_experiencia')->primary()->default(DB::raw('gen_random_uuid()'));
            $table->uuid('id_portafolio');
            $table->uuid('id_tipo_experiencia');
            $table->string('cargo',100)->nullable();
            $table->string('nombre_organizacion',255)->nullable();
            $table->string('descripcion',550)->nullable();
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_fin')->nullable();
            $table->boolean('vigente')->nullable();

            $table->foreign('id_portafolio')->references('id_portafolio')->on('portafolio');
            $table->foreign('id_tipo_experiencia')->references('id_tipo_experiencia')->on('tipo_experiencia');
        });
    }

    public function down(): void {
        Schema::dropIfExists('experiencia');
        Schema::dropIfExists('tipo_experiencia');
    }
};