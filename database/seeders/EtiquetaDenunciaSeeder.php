<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EtiquetaDenunciaSeeder extends Seeder
{
    public function run(): void
    {
        $etiquetas = [
            // Contenido inapropiado
            ['nombre' => 'Contenido indebido'],
            ['nombre' => 'Contenido violento'],
            ['nombre' => 'Contenido para adultos'],
            ['nombre' => 'Lenguaje ofensivo'],
            ['nombre' => 'Discurso de odio'],

            // Información
            ['nombre' => 'Información falsa'],
            ['nombre' => 'Información engañosa'],
            ['nombre' => 'Datos de contacto falsos'],
            ['nombre' => 'Credenciales falsas'],
            ['nombre' => 'Experiencia laboral falsa'],

            // Propiedad intelectual
            ['nombre' => 'Plagio'],
            ['nombre' => 'Uso no autorizado de imágenes'],
            ['nombre' => 'Violación de derechos de autor'],

            // Comportamiento
            ['nombre' => 'Spam'],
            ['nombre' => 'Suplantación de identidad'],
            ['nombre' => 'Perfil duplicado'],
            ['nombre' => 'Publicidad no permitida'],

            // Privacidad y seguridad
            ['nombre' => 'Exposición de datos personales'],
            ['nombre' => 'Contenido malicioso o phishing'],

            // Otros
            ['nombre' => 'Otro motivo'],
        ];

        foreach ($etiquetas as $etiqueta) {
            $existe = DB::table('etiqueta_denuncia')->where('nombre', $etiqueta['nombre'])->exists();
            if (!$existe) {
                DB::table('etiqueta_denuncia')->insert([
                    'nombre' => $etiqueta['nombre'],
                ]);
            }
        }
    }
}
