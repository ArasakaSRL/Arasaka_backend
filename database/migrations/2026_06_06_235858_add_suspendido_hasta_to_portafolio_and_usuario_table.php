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
        Schema::table('portafolio', function (Blueprint $table) {
            $table->timestampTz('suspendido_hasta')->nullable()->after('suspendido');
        });

        Schema::table('usuario', function (Blueprint $table) {
            $table->timestampTz('suspendido_hasta')->nullable()->after('suspendido');
        });
    }

    public function down(): void
    {
        Schema::table('portafolio', function (Blueprint $table) {
            $table->dropColumn('suspendido_hasta');
        });

        Schema::table('usuario', function (Blueprint $table) {
            $table->dropColumn('suspendido_hasta');
        });
    }
};
