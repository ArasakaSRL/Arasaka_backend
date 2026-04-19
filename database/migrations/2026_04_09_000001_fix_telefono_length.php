<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('telefono', function (Blueprint $table) {
            $table->string('telefono', 20)->change();
        });
    }

    public function down(): void
    {
        Schema::table('telefono', function (Blueprint $table) {
            $table->string('telefono', 10)->change();
        });
    }
};
