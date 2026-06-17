<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {

        Schema::create('usuario', function (Blueprint $table) {
            $table->uuid('id_usuario')->primary()->default(DB::raw('gen_random_uuid()'));
            $table->string('nombre',50)->nullable();
            $table->string('apellido',50)->nullable();
            $table->string('correo',150)->nullable();
            $table->text('password')->nullable();
            $table->string('biografia',550)->nullable();
            $table->text('url_foto')->nullable();
            $table->boolean('estado')->nullable();
            $table->boolean('verificacion_email')->nullable();
            $table->timestamps();
        });

        Schema::create('rol', function (Blueprint $table) {
            $table->uuid('id_rol')->primary()->default(DB::raw('gen_random_uuid()'));
            $table->string('nombre_rol',50)->nullable();
            $table->string('descripcion',550)->nullable();
        });

        Schema::create('usuario_rol', function (Blueprint $table) {
            $table->uuid('id_usuario');
            $table->uuid('id_rol');
            $table->primary(['id_usuario','id_rol']);

            $table->foreign('id_usuario')->references('id_usuario')->on('usuario')->cascadeOnDelete();
            $table->foreign('id_rol')->references('id_rol')->on('rol')->cascadeOnDelete();
        });

        Schema::create('telefono', function (Blueprint $table) {
            $table->uuid('id_telefono')->primary()->default(DB::raw('gen_random_uuid()'));
            $table->uuid('id_usuario');
            $table->string('telefono',10)->nullable();

            $table->foreign('id_usuario')->references('id_usuario')->on('usuario')->cascadeOnDelete();
        });

        Schema::create('pais', function (Blueprint $table) {
            $table->uuid('id_pais')->primary()->default(DB::raw('gen_random_uuid()'));
            $table->uuid('id_usuario');
            $table->string('nombre',255)->nullable();

            $table->foreign('id_usuario')->references('id_usuario')->on('usuario')->cascadeOnDelete();
        });

        Schema::create('profesion', function (Blueprint $table) {
            $table->uuid('id_profesion')->primary()->default(DB::raw('gen_random_uuid()'));
            $table->string('nombre',50)->nullable();
            $table->string('descripcion',550)->nullable();
        });

        Schema::create('usuario_profesion', function (Blueprint $table) {
            $table->uuid('id_usuario');
            $table->uuid('id_profesion');
            $table->primary(['id_usuario','id_profesion']);

            $table->foreign('id_usuario')->references('id_usuario')->on('usuario')->cascadeOnDelete();
            $table->foreign('id_profesion')->references('id_profesion')->on('profesion')->cascadeOnDelete();
        });

        Schema::create('idioma', function (Blueprint $table) {
            $table->uuid('id_idioma')->primary()->default(DB::raw('gen_random_uuid()'));
            $table->string('nombre',100)->nullable();
        });

        Schema::create('nivel_ingles', function (Blueprint $table) {
            $table->uuid('id_nivel_ingles')->primary()->default(DB::raw('gen_random_uuid()'));
            $table->uuid('id_idioma')->nullable();
            $table->string('nivel',2)->nullable();

            $table->foreign('id_idioma')->references('id_idioma')->on('idioma');
        });

        Schema::create('usuario_idioma', function (Blueprint $table) {
            $table->uuid('id_usuario');
            $table->uuid('id_idioma');
            $table->primary(['id_usuario','id_idioma']);
            $table->foreign('id_usuario')->references('id_usuario')->on('usuario')->cascadeOnDelete();
            $table->foreign('id_idioma')->references('id_idioma')->on('idioma')->cascadeOnDelete();
        });
    }

    public function down(): void {
        Schema::dropIfExists('usuario_idioma');
        Schema::dropIfExists('nivel_ingles');
        Schema::dropIfExists('idioma');
        Schema::dropIfExists('usuario_profesion');
        Schema::dropIfExists('profesion');
        Schema::dropIfExists('pais');
        Schema::dropIfExists('telefono');
        Schema::dropIfExists('usuario_rol');
        Schema::dropIfExists('rol');
        Schema::dropIfExists('usuario');
    }
};