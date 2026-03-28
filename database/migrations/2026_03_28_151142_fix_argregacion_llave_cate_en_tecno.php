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
        Schema::table('tecnologias', function (Blueprint $table) {
            //
                $table->uuid('id_categoria_tecnologia')->nullable();
                $table->foreign('id_categoria_tecnologia')->references('id_categoria_tecnologia')->on('categoria_tecnologia')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tecnologias', function (Blueprint $table) {
            //
                $table->dropForeign(['id_categoria_tecnologia']);
                $table->dropColumn('id_categoria_tecnologia');
        });
    }
};
