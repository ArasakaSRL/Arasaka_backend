<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('denuncia_portafolio', function (Blueprint $table) {
            $table->dropForeign(['id_usuario']);
            $table->dropColumn('id_usuario');
        });
    }

    public function down(): void
    {
        Schema::table('denuncia_portafolio', function (Blueprint $table) {
            $table->uuid('id_usuario')->nullable();
            $table->foreign('id_usuario')
                  ->references('id_usuario')
                  ->on('usuario');
        });
    }
};
