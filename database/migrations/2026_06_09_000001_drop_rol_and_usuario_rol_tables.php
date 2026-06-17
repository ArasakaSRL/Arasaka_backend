<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::dropIfExists('usuario_rol');
        Schema::dropIfExists('rol');
    }

    public function down(): void
    {
        Schema::create('rol', function (Blueprint $table) {
            $table->uuid('id_rol')->primary()->default(DB::raw('gen_random_uuid()'));
            $table->string('nombre_rol', 50)->nullable();
            $table->string('descripcion', 550)->nullable();
        });

        Schema::create('usuario_rol', function (Blueprint $table) {
            $table->uuid('id_usuario');
            $table->uuid('id_rol');
            $table->primary(['id_usuario', 'id_rol']);

            $table->foreign('id_usuario')->references('id_usuario')->on('usuario')->cascadeOnDelete();
            $table->foreign('id_rol')->references('id_rol')->on('rol')->cascadeOnDelete();
        });
    }
};
