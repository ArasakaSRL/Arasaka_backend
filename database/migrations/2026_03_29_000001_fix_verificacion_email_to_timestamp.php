<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement('ALTER TABLE usuario ALTER COLUMN verificacion_email TYPE timestamp USING NULL');
    }

    public function down(): void
    {
        Schema::table('usuario', function (Blueprint $table) {
            $table->boolean('verificacion_email')->nullable()->change();
        });
    }
};
