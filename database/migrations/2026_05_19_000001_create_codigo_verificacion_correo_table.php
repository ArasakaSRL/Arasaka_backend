<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('codigo_verificacion_correo', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('id_usuario');
            $table->string('correo_nuevo');
            $table->string('codigo', 6);
            $table->timestamp('expira_en');
            $table->timestamps();

            $table->foreign('id_usuario')->references('id_usuario')->on('usuario')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('codigo_verificacion_correo');
    }
};
