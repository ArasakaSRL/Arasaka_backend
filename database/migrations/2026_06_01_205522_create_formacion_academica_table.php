<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('formacion_academica', function (Blueprint $table) {

            $table->uuid('id_formacion_academica')
                ->primary()
                ->default(DB::raw('gen_random_uuid()'));

            $table->uuid('id_portafolio');

            $table->string('institucion', 100);

            $table->string('titulo', 50);

            $table->enum('nivel', [
                'Tecnico',
                'Licenciatura',
                'Maestria',
                'Doctorado',
                'PostDoctorado',
                'Especialidad'
            ]);

            $table->date('fecha_inicio');

            $table->date('fecha_fin')->nullable();

            $table->string('descripcion', 550)->nullable();

            $table->timestamps();

            $table->foreign('id_portafolio')
                ->references('id_portafolio')
                ->on('portafolio')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('formacion_academica');
    }
};