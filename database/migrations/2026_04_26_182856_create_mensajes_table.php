<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('mensajes', function (Blueprint $table) {
            $table->uuid('id_mensaje')->primary()->default(DB::raw('gen_random_uuid()'));
            $table->uuid('id_remitente')->nullable();
            $table->string('nombre_remitente');
            $table->string('correo_remitente');
            $table->uuid('id_destinatario')->nullable();
            $table->string('correo_destinatario');
            $table->string('asunto');
            $table->text('contenido');
            $table->boolean('leido')->default(false);
            $table->timestamp('fecha_envio')->useCurrent();

            $table->foreign('id_remitente')->references('id_usuario')->on('usuario')->nullOnDelete();
            $table->foreign('id_destinatario')->references('id_usuario')->on('usuario')->nullOnDelete();
        });

        Schema::create('adjuntos_mensaje', function (Blueprint $table) {
            $table->uuid('id_adjunto')->primary()->default(DB::raw('gen_random_uuid()'));
            $table->uuid('id_mensaje');
            $table->string('nombre_archivo');
            $table->string('url_archivo');
            $table->string('tipo_mime')->nullable();

            $table->foreign('id_mensaje')->references('id_mensaje')->on('mensajes')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('adjuntos_mensaje');
        Schema::dropIfExists('mensajes');
    }
};
