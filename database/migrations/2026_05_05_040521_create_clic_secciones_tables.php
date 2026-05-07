<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clic_habilidad_tecnica', function (Blueprint $table) {
            $table->uuid('id_clic')->primary()->default(DB::raw('gen_random_uuid()'));
            $table->uuid('id_visitante');
            $table->foreign('id_visitante')->references('id_visitante')->on('visitante');
            $table->uuid('id_habilidad')->nullable();
            $table->string('campo', 50);
            $table->decimal('x', 6, 5)->nullable();
            $table->decimal('y', 6, 5)->nullable();
            $table->timestampTz('created_at')->useCurrent();
        });

        Schema::create('clic_habilidad_blanda', function (Blueprint $table) {
            $table->uuid('id_clic')->primary()->default(DB::raw('gen_random_uuid()'));
            $table->uuid('id_visitante');
            $table->foreign('id_visitante')->references('id_visitante')->on('visitante');
            $table->uuid('id_habilidad')->nullable();
            $table->string('campo', 50);
            $table->decimal('x', 6, 5)->nullable();
            $table->decimal('y', 6, 5)->nullable();
            $table->timestampTz('created_at')->useCurrent();
        });

        Schema::create('clic_experiencia', function (Blueprint $table) {
            $table->uuid('id_clic')->primary()->default(DB::raw('gen_random_uuid()'));
            $table->uuid('id_visitante');
            $table->foreign('id_visitante')->references('id_visitante')->on('visitante');
            $table->uuid('id_experiencia')->nullable();
            $table->string('campo', 50);
            $table->decimal('x', 6, 5)->nullable();
            $table->decimal('y', 6, 5)->nullable();
            $table->timestampTz('created_at')->useCurrent();
        });

        Schema::create('clic_proyecto', function (Blueprint $table) {
            $table->uuid('id_clic')->primary()->default(DB::raw('gen_random_uuid()'));
            $table->uuid('id_visitante');
            $table->foreign('id_visitante')->references('id_visitante')->on('visitante');
            $table->uuid('id_proyecto')->nullable();
            $table->string('campo', 50);
            $table->decimal('x', 6, 5)->nullable();
            $table->decimal('y', 6, 5)->nullable();
            $table->timestampTz('created_at')->useCurrent();
        });

        Schema::create('clic_certificacion', function (Blueprint $table) {
            $table->uuid('id_clic')->primary()->default(DB::raw('gen_random_uuid()'));
            $table->uuid('id_visitante');
            $table->foreign('id_visitante')->references('id_visitante')->on('visitante');
            $table->uuid('id_certificacion')->nullable();
            $table->string('campo', 50);
            $table->decimal('x', 6, 5)->nullable();
            $table->decimal('y', 6, 5)->nullable();
            $table->timestampTz('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clic_habilidad_tecnica');
        Schema::dropIfExists('clic_habilidad_blanda');
        Schema::dropIfExists('clic_experiencia');
        Schema::dropIfExists('clic_proyecto');
        Schema::dropIfExists('clic_certificacion');
    }
};