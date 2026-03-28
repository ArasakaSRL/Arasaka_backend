<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {

     
        DB::statement('CREATE EXTENSION IF NOT EXISTS "pgcrypto";');

        Schema::create('tecnologias', function (Blueprint $table) {
            $table->uuid('id_tecnologia')->primary()->default(DB::raw('gen_random_uuid()'));
            $table->string('nombre',225)->nullable();
            $table->string('descripcion',255)->nullable();
            $table->text('logo',255)->nullable();
        });
        Schema::create('proyecto_tecnologia', function (Blueprint $table) {
            $table->uuid('id_tecnologia');
            $table->uuid('id_proyecto');
            $table->primary(['id_tecnologia','id_proyecto']);
            
            $table->foreign('id_tecnologia')->references('id_tecnologia')->on('tecnologias')->cascadeOnDelete();
            $table->foreign('id_proyecto')->references('id_proyecto')->on('proyecto')->cascadeOnDelete();
        });

        Schema::create('categoria_tecnologia', function (Blueprint $table) {
            $table->uuid('id_categoria_tecnologia')->primary()->default(DB::raw('gen_random_uuid()'));
            $table->uuid('id_tecnologia');
            $table->string('nombre')->nullable();

            $table->foreign('id_tecnologia')->references('id_tecnologia')->on('tecnologias');
        });

        Schema::create('habilidades_tiene_tecnologias', function (Blueprint $table) {
            $table->uuid('id_habilidad');
            $table->uuid('id_tecnologia');
            $table->primary(['id_habilidad','id_tecnologia']);
            
            $table->foreign('id_habilidad')->references('id_habilidad')->on('habilidad')->cascadeOnDelete();
            $table->foreign('id_tecnologia')->references('id_tecnologia')->on('tecnologias')->cascadeOnDelete();
         });
    }

    public function down(): void {
        Schema::dropIfExists('habilidades_tiene_tecnologias');
        Schema::dropIfExists('categoria_tecnologia');
        Schema::dropIfExists('proyecto_tecnologia');
        Schema::dropIfExists('tecnologias');
        
    }
};