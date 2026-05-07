<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('interaccion_perfil', function (Blueprint $table) {
            $table->integer('clic_general')->default(0);
        });

        Schema::table('interaccion_habilidad_tecnica', function (Blueprint $table) {
            $table->integer('clic_general')->default(0);
        });

        Schema::table('interaccion_habilidad_blanda', function (Blueprint $table) {
            $table->integer('clic_general')->default(0);
        });

        Schema::table('interaccion_experiencia', function (Blueprint $table) {
            $table->integer('clic_general')->default(0);
        });

        Schema::table('interaccion_proyecto', function (Blueprint $table) {
            $table->integer('clic_general')->default(0);
        });

        Schema::table('interaccion_certificacion', function (Blueprint $table) {
            $table->integer('clic_general')->default(0);
        });
    }

    public function down(): void
    {
        Schema::table('interaccion_perfil',            fn($t) => $t->dropColumn('clic_general'));
        Schema::table('interaccion_habilidad_tecnica', fn($t) => $t->dropColumn('clic_general'));
        Schema::table('interaccion_habilidad_blanda',  fn($t) => $t->dropColumn('clic_general'));
        Schema::table('interaccion_experiencia',       fn($t) => $t->dropColumn('clic_general'));
        Schema::table('interaccion_proyecto',          fn($t) => $t->dropColumn('clic_general'));
        Schema::table('interaccion_certificacion',     fn($t) => $t->dropColumn('clic_general'));
    }
};