<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('usuario', function (Blueprint $table) {
            $table->dropColumn(['codigo_verificacion', 'codigo_verificacion_expira']);
        });
    }

    public function down(): void
    {
        Schema::table('usuario', function (Blueprint $table) {
            $table->string('codigo_verificacion', 6)->nullable()->after('verificacion_email');
            $table->timestamp('codigo_verificacion_expira')->nullable()->after('codigo_verificacion');
        });
    }
};
