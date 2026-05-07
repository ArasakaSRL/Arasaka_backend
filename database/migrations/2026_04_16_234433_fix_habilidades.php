<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {   
        Schema::table('habilidad', function (Blueprint $table) {
            $table->dropForeign(['id_categoria_habilidad']);
            $table->dropForeign(['id_nivel_habilidad']);
            $table->dropColumn('id_categoria_habilidad');
            $table->dropColumn('id_nivel_habilidad'); // Eliminar varias
            $table->enum('categoria_habilidad', ['blanda','tecnica'])->nullable();
            $table->enum('nivel', ['Principiante','Intermedio', 'Competente', 'Avanzado', 'Experto'])->nullable();
        });
        Schema::dropIfExists('categoria_habilidad');
        Schema::dropIfExists('nivel_de_habilidad');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('habilidad', function (Blueprint $table) {
            $table->string('id_categoria_habilidad');
            $table->string('id_nivel_habilidad'); // Eliminar varias
            $table->foreign('id_categoria_habilidad')->references('id_categoria_habilidad')->on('categoria_habilidad');
            $table->foreign('id_nivel_habilidad')->references('id_nivel_habilidad')->on('nivel_de_habilidad');
        });
       Schema::create('categoria_habilidad', function (Blueprint $table) {
            $table->uuid('id_categoria_habilidad')->primary()->default(DB::raw('gen_random_uuid()'));
            $table->string('nombre',100)->nullable();
        });

        Schema::create('nivel_de_habilidad', function (Blueprint $table) {
            $table->uuid('id_nivel_habilidad')->primary()->default(DB::raw('gen_random_uuid()'));
            $table->string('nivel',50)->nullable();
        });
    }
};
