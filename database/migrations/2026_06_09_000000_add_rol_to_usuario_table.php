<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('usuario', function (Blueprint $table) {
            $table->string('rol', 20)->default('user')->after('estado');
        });

        DB::table('usuario')
            ->where('correo', 'jhonvergara437@gmail.com')
            ->update(['rol' => 'admin']);
    }

    public function down(): void
    {
        Schema::table('usuario', function (Blueprint $table) {
            $table->dropColumn('rol');
        });
    }
};
