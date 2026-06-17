<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('configuracion_sistema', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('denuncias_advertencia')->default(8);
            $table->unsignedInteger('denuncias_suspension')->default(10);
            $table->unsignedInteger('portafolios_advertencia')->default(2);
            $table->unsignedInteger('portafolios_suspension')->default(3);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('configuracion_sistema');
    }
};
