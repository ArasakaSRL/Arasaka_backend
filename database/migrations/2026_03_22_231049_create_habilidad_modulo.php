<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {

     
        DB::statement('CREATE EXTENSION IF NOT EXISTS "pgcrypto";');

        Schema::create('categoria_habilidad', function (Blueprint $table) {
            $table->uuid('id_categoria_habilidad')->primary()->default(DB::raw('gen_random_uuid()'));
            $table->string('nombre',100)->nullable();
        }); 

            Schema::create('nivel_de_habilidad', function (Blueprint $table) {
            $table->uuid('id_nivel_habilidad')->primary()->default(DB::raw('gen_random_uuid()'));
            $table->string('nivel',50)->nullable();
        });

        Schema::create('habilidad', function (Blueprint $table) {
            $table->uuid('id_habilidad')->primary()->default(DB::raw('gen_random_uuid()'));
            $table->uuid('id_portafolio');
            $table->uuid('id_categoria_habilidad');
            $table->uuid('id_nivel_habilidad');
            //$table->enum('categoria_habilidad', ['blanda','tecnica'])->nullable();
            //$table->enum('nivel', ['Principiante','Intermedio', 'Competente', 'Avanzado', 'Experto'])->nullable();
            $table->string('nombre',50)->nullable();
            $table->timestamp('fecha_creacion')->nullable();
            $table->timestamp('fecha_actualizacion')->nullable();

            $table->foreign('id_portafolio')->references('id_portafolio')->on('portafolio');
            $table->foreign('id_categoria_habilidad')->references('id_categoria_habilidad')->on('categoria_habilidad');
            $table->foreign('id_nivel_habilidad')->references('id_nivel_habilidad')->on('nivel_de_habilidad');
        });
    }

    public function down(): void {
        Schema::dropIfExists('habilidad');
        //Schema::dropIfExists('nivel_de_habilidad');
        //Schema::dropIfExists('categoria_habilidad');
    }
};