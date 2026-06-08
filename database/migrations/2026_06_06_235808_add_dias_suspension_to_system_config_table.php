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
        Schema::table('system_config', function (Blueprint $table) {
            $table->unsignedInteger('dias_suspension_portafolio')->default(30)->after('portafolios_suspension');
            $table->unsignedInteger('dias_suspension_usuario')->default(30)->after('dias_suspension_portafolio');
        });
    }

    public function down(): void
    {
        Schema::table('system_config', function (Blueprint $table) {
            $table->dropColumn(['dias_suspension_portafolio', 'dias_suspension_usuario']);
        });
    }
};
