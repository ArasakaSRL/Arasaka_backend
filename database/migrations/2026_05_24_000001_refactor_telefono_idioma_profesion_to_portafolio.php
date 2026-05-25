<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // --- TELÉFONOS: cambiar FK de id_usuario a id_portafolio ---
        DB::statement('TRUNCATE TABLE telefono CASCADE');
        Schema::table('telefono', function (Blueprint $table) {
            $table->dropForeign(['id_usuario']);
            $table->dropColumn('id_usuario');
            $table->uuid('id_portafolio')->after('id_telefono');
            $table->foreign('id_portafolio')
                ->references('id_portafolio')
                ->on('portafolio')
                ->onDelete('cascade');
        });

        // --- IDIOMAS: reemplazar usuario_idioma por portafolio_idioma ---
        Schema::dropIfExists('usuario_idioma');

        Schema::create('portafolio_idioma', function (Blueprint $table) {
            $table->uuid('id_portafolio');
            $table->uuid('id_idioma');
            $table->primary(['id_portafolio', 'id_idioma']);
            $table->foreign('id_portafolio')
                ->references('id_portafolio')
                ->on('portafolio')
                ->onDelete('cascade');
            $table->foreign('id_idioma')
                ->references('id_idioma')
                ->on('idioma')
                ->onDelete('cascade');
        });

        // --- PROFESIONES: reemplazar usuario_profesion por portafolio_profesion ---
        Schema::dropIfExists('usuario_profesion');

        Schema::create('portafolio_profesion', function (Blueprint $table) {
            $table->uuid('id_portafolio');
            $table->uuid('id_profesion');
            $table->primary(['id_portafolio', 'id_profesion']);
            $table->foreign('id_portafolio')
                ->references('id_portafolio')
                ->on('portafolio')
                ->onDelete('cascade');
            $table->foreign('id_profesion')
                ->references('id_profesion')
                ->on('profesion')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        // Revertir teléfonos
        Schema::table('telefono', function (Blueprint $table) {
            $table->dropForeign(['id_portafolio']);
            $table->dropColumn('id_portafolio');
            $table->uuid('id_usuario')->after('id_telefono');
            $table->foreign('id_usuario')
                ->references('id_usuario')
                ->on('usuario')
                ->onDelete('cascade');
        });

        Schema::dropIfExists('portafolio_idioma');
        Schema::dropIfExists('portafolio_profesion');
    }
};
