<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('mensaje_destacado', function (Blueprint $table) {
            $table->uuid('id_destacado')->primary();
            $table->uuid('id_usuario');
            $table->uuid('id_mensaje');
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('id_usuario')->references('id_usuario')->on('usuario')->cascadeOnDelete();
            $table->foreign('id_mensaje')->references('id_mensaje')->on('mensajes')->cascadeOnDelete();
            $table->unique(['id_usuario', 'id_mensaje']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mensaje_destacado');
    }
};
