<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('portafolio', function (Blueprint $table) {
            $table->dropForeign(['id_usuario']);

            $table->foreign('id_usuario')
                ->references('id_usuario')
                ->on('usuario')
                ->cascadeOnDelete();
        });

        Schema::table('configuracion_portafolio', function (Blueprint $table) {
            $table->dropForeign(['id_portafolio']);

            $table->foreign('id_portafolio')
                ->references('id_portafolio')
                ->on('portafolio')
                ->cascadeOnDelete();
        });

        Schema::table('reporte', function (Blueprint $table) {
            $table->dropForeign(['id_visualizacion_portafolio']);

            $table->foreign('id_visualizacion_portafolio')
                ->references('id_visualizacion_portafolio')
                ->on('visualizaciones_portafolio')
                ->cascadeOnDelete();
        });

        Schema::table('proyecto', function (Blueprint $table) {
            $table->dropForeign(['id_portafolio']);

            $table->foreign('id_portafolio')
                ->references('id_portafolio')
                ->on('portafolio')
                ->cascadeOnDelete();
        });

        Schema::table('estado_proyecto', function (Blueprint $table) {
            $table->dropForeign(['id_proyecto']);

            $table->foreign('id_proyecto')
                ->references('id_proyecto')
                ->on('proyecto')
                ->cascadeOnDelete();
        });

        Schema::table('url_imagen_proyecto', function (Blueprint $table) {
            $table->dropForeign(['id_proyecto']);

            $table->foreign('id_proyecto')
                ->references('id_proyecto')
                ->on('proyecto')
                ->cascadeOnDelete();
        });


        Schema::table('experiencia', function (Blueprint $table) {
            $table->dropForeign(['id_portafolio']);
            $table->dropForeign(['id_tipo_experiencia']);

            $table->foreign('id_portafolio')
                ->references('id_portafolio')
                ->on('portafolio')
                ->cascadeOnDelete();

            $table->foreign('id_tipo_experiencia')
                ->references('id_tipo_experiencia')
                ->on('tipo_experiencia')
                ->cascadeOnDelete();
        });

        Schema::table('servicio', function (Blueprint $table) {
            $table->dropForeign(['id_portafolio']);

            $table->foreign('id_portafolio')
                ->references('id_portafolio')
                ->on('portafolio')
                ->cascadeOnDelete();
        });

        Schema::table('certificacion', function (Blueprint $table) {
            $table->dropForeign(['id_portafolio']);
            $table->dropForeign(['id_categoria_certificacion']);

            $table->foreign('id_portafolio')
                ->references('id_portafolio')
                ->on('portafolio')
                ->cascadeOnDelete();

            $table->foreign('id_categoria_certificacion')
                ->references('id_categoria_certificacion')
                ->on('categoria_certificacion')
                ->cascadeOnDelete();
        });

        Schema::table('redes_profesionales', function (Blueprint $table) {
            $table->dropForeign(['id_portafolio']);

            $table->foreign('id_portafolio')
                ->references('id_portafolio')
                ->on('portafolio')
                ->cascadeOnDelete();
        });

        Schema::table('nivel_ingles', function (Blueprint $table) {
            $table->dropForeign(['id_idioma']);

            $table->foreign('id_idioma')
                ->references('id_idioma')
                ->on('idioma')
                ->cascadeOnDelete();
        });
    
    Schema::table('tecnologias', function (Blueprint $table) {
    $table->dropForeign(['id_categoria_tecnologia']);

    $table->foreign('id_categoria_tecnologia')
        ->references('id_categoria_tecnologia')
        ->on('categoria_tecnologia')
        ->cascadeOnDelete();
    });
    Schema::table('visitante', function (Blueprint $table) {
    $table->dropForeign(['id_portafolio']);

    $table->foreign('id_portafolio')
        ->references('id_portafolio')
        ->on('portafolio')
        ->cascadeOnDelete();
});

Schema::table('interaccion_perfil', function (Blueprint $table) {
    $table->dropForeign(['id_visitante']);

    $table->foreign('id_visitante')
        ->references('id_visitante')
        ->on('visitante')
        ->cascadeOnDelete();
});
Schema::table('interaccion_habilidad_blanda', function (Blueprint $table) {
    $table->dropForeign(['id_visitante']);
    $table->dropForeign(['id_habilidad']);

    $table->foreign('id_visitante')
        ->references('id_visitante')
        ->on('visitante')
        ->cascadeOnDelete();

    $table->foreign('id_habilidad')
        ->references('id_habilidad')
        ->on('habilidad')
        ->cascadeOnDelete();
});

Schema::table('interaccion_habilidad_tecnica', function (Blueprint $table) {
    $table->dropForeign(['id_visitante']);
    $table->dropForeign(['id_habilidad']);

    $table->foreign('id_visitante')
        ->references('id_visitante')
        ->on('visitante')
        ->cascadeOnDelete();

    $table->foreign('id_habilidad')
        ->references('id_habilidad')
        ->on('habilidad')
        ->cascadeOnDelete();
});

Schema::table('interaccion_experiencia', function (Blueprint $table) {
    $table->dropForeign(['id_visitante']);
    $table->dropForeign(['id_experiencia']);

    $table->foreign('id_visitante')
        ->references('id_visitante')
        ->on('visitante')
        ->cascadeOnDelete();

    $table->foreign('id_experiencia')
        ->references('id_experiencia')
        ->on('experiencia')
        ->cascadeOnDelete();
});

Schema::table('interaccion_proyecto', function (Blueprint $table) {
    $table->dropForeign(['id_visitante']);
    $table->dropForeign(['id_proyecto']);

    $table->foreign('id_visitante')
        ->references('id_visitante')
        ->on('visitante')
        ->cascadeOnDelete();

    $table->foreign('id_proyecto')
        ->references('id_proyecto')
        ->on('proyecto')
        ->cascadeOnDelete();
});

Schema::table('interaccion_certificacion', function (Blueprint $table) {
    $table->dropForeign(['id_visitante']);
    $table->dropForeign(['id_certificacion']);

    $table->foreign('id_visitante')
        ->references('id_visitante')
        ->on('visitante')
        ->cascadeOnDelete();

    $table->foreign('id_certificacion')
        ->references('id_certificacion')
        ->on('certificacion')
        ->cascadeOnDelete();
});

Schema::table('clic_perfil', function (Blueprint $table) {
    $table->dropForeign(['id_visitante']);

    $table->foreign('id_visitante')
        ->references('id_visitante')
        ->on('visitante')
        ->cascadeOnDelete();
});

Schema::table('clic_habilidad_tecnica', function (Blueprint $table) {
    $table->dropForeign(['id_visitante']);

    $table->foreign('id_visitante')
        ->references('id_visitante')
        ->on('visitante')
        ->cascadeOnDelete();
});

Schema::table('clic_habilidad_blanda', function (Blueprint $table) {
    $table->dropForeign(['id_visitante']);

    $table->foreign('id_visitante')
        ->references('id_visitante')
        ->on('visitante')
        ->cascadeOnDelete();
});

Schema::table('clic_experiencia', function (Blueprint $table) {
    $table->dropForeign(['id_visitante']);

    $table->foreign('id_visitante')
        ->references('id_visitante')
        ->on('visitante')
        ->cascadeOnDelete();
});

Schema::table('clic_proyecto', function (Blueprint $table) {
    $table->dropForeign(['id_visitante']);

    $table->foreign('id_visitante')
        ->references('id_visitante')
        ->on('visitante')
        ->cascadeOnDelete();
});

Schema::table('clic_certificacion', function (Blueprint $table) {
    $table->dropForeign(['id_visitante']);

    $table->foreign('id_visitante')
        ->references('id_visitante')
        ->on('visitante')
        ->cascadeOnDelete();
});
Schema::table('denuncia_portafolio', function (Blueprint $table) {
    $table->dropForeign(['id_portafolio']);
    $table->dropForeign(['id_etiqueta_denuncia']);

    $table->foreign('id_portafolio')
        ->references('id_portafolio')
        ->on('portafolio')
        ->cascadeOnDelete();

    $table->foreign('id_etiqueta_denuncia')
        ->references('id_etiqueta_denuncia')
        ->on('etiqueta_denuncia')
        ->cascadeOnDelete();
});

    }

    public function down(): void
    {
    }
};