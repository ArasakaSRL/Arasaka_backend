<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProfesionSeeder extends Seeder
{
    public function run(): void
    {
        $profesiones = [
            // Desarrollo de software
            ['nombre' => 'Desarrollador Frontend',       'descripcion' => 'Especialista en interfaces de usuario web'],
            ['nombre' => 'Desarrollador Backend',        'descripcion' => 'Especialista en lógica de servidor y APIs'],
            ['nombre' => 'Desarrollador Full Stack',     'descripcion' => 'Desarrollo completo frontend y backend'],
            ['nombre' => 'Desarrollador Móvil',          'descripcion' => 'Desarrollo de aplicaciones para iOS y Android'],
            ['nombre' => 'Desarrollador de Software',    'descripcion' => 'Desarrollo de aplicaciones y sistemas'],
            ['nombre' => 'Ingeniero de Software',        'descripcion' => 'Diseño y construcción de sistemas de software'],

            // Datos e IA
            ['nombre' => 'Científico de Datos',          'descripcion' => 'Análisis y modelado de datos'],
            ['nombre' => 'Analista de Datos',            'descripcion' => 'Interpretación y visualización de datos'],
            ['nombre' => 'Ingeniero de Datos',           'descripcion' => 'Diseño de pipelines y arquitecturas de datos'],
            ['nombre' => 'Especialista en IA',           'descripcion' => 'Inteligencia artificial y aprendizaje automático'],
            ['nombre' => 'Especialista en Machine Learning', 'descripcion' => 'Modelos y algoritmos de ML'],

            // Infraestructura y redes
            ['nombre' => 'DevOps Engineer',              'descripcion' => 'Automatización e integración continua'],
            ['nombre' => 'Administrador de Sistemas',    'descripcion' => 'Gestión de servidores e infraestructura'],
            ['nombre' => 'Administrador de Redes',       'descripcion' => 'Configuración y mantenimiento de redes'],
            ['nombre' => 'Ingeniero Cloud',              'descripcion' => 'Arquitectura y servicios en la nube'],
            ['nombre' => 'Especialista en Ciberseguridad', 'descripcion' => 'Seguridad informática y protección de datos'],

            // Diseño y UX
            ['nombre' => 'Diseñador UI/UX',              'descripcion' => 'Diseño de interfaces y experiencia de usuario'],
            ['nombre' => 'Diseñador Gráfico',            'descripcion' => 'Creación de contenido visual y branding'],

            // QA y gestión
            ['nombre' => 'QA Engineer',                  'descripcion' => 'Pruebas y aseguramiento de la calidad'],
            ['nombre' => 'Scrum Master',                 'descripcion' => 'Gestión ágil de proyectos de software'],
            ['nombre' => 'Product Manager',              'descripcion' => 'Gestión y estrategia de producto'],
            ['nombre' => 'Analista de Sistemas',         'descripcion' => 'Análisis y requerimientos de sistemas'],

            // Otras áreas TI
            ['nombre' => 'Soporte Técnico',              'descripcion' => 'Asistencia técnica a usuarios y equipos'],
            ['nombre' => 'Arquitecto de Software',       'descripcion' => 'Diseño de arquitecturas de sistemas complejos'],
            ['nombre' => 'Blockchain Developer',         'descripcion' => 'Desarrollo de contratos inteligentes y DApps'],
            ['nombre' => 'Desarrollador de Videojuegos', 'descripcion' => 'Creación de videojuegos y simulaciones'],
        ];

        foreach ($profesiones as $profesion) {
            $existe = DB::table('profesion')->where('nombre', $profesion['nombre'])->exists();
            if (!$existe) {
                DB::table('profesion')->insert([
                    'id_profesion' => \Illuminate\Support\Str::uuid(),
                    'nombre'       => $profesion['nombre'],
                    'descripcion'  => $profesion['descripcion'],
                ]);
            }
        }
    }
}
