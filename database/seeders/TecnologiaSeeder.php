<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TecnologiaSeeder extends Seeder
{
    public function run(): void
    {
        $grupos = [
            'Frontend' => [
                ['nombre' => 'HTML',           'descripcion' => 'Lenguaje de marcado para la web',               'logo' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/html5/html5-original.svg'],
                ['nombre' => 'CSS',            'descripcion' => 'Hojas de estilo para diseño web',               'logo' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/css3/css3-original.svg'],
                ['nombre' => 'JavaScript',     'descripcion' => 'Lenguaje de programación para la web',          'logo' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/javascript/javascript-original.svg'],
                ['nombre' => 'TypeScript',     'descripcion' => 'JavaScript con tipado estático',                'logo' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/typescript/typescript-original.svg'],
                ['nombre' => 'React',          'descripcion' => 'Biblioteca de UI para JavaScript',              'logo' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/react/react-original.svg'],
                ['nombre' => 'Vue.js',         'descripcion' => 'Framework progresivo de JavaScript',            'logo' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/vuejs/vuejs-original.svg'],
                ['nombre' => 'Angular',        'descripcion' => 'Framework de Google para SPAs',                 'logo' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/angularjs/angularjs-original.svg'],
                ['nombre' => 'Next.js',        'descripcion' => 'Framework React con SSR y SSG',                 'logo' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/nextjs/nextjs-original.svg'],
                ['nombre' => 'Tailwind CSS',   'descripcion' => 'Framework CSS de utilidades',                   'logo' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/tailwindcss/tailwindcss-original.svg'],
                ['nombre' => 'Bootstrap',      'descripcion' => 'Framework CSS responsivo',                      'logo' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/bootstrap/bootstrap-original.svg'],
            ],
            'Backend' => [
                ['nombre' => 'PHP',            'descripcion' => 'Lenguaje de programación del lado servidor',    'logo' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/php/php-original.svg'],
                ['nombre' => 'Laravel',        'descripcion' => 'Framework PHP elegante y expresivo',            'logo' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/laravel/laravel-original.svg'],
                ['nombre' => 'Node.js',        'descripcion' => 'Entorno de ejecución JavaScript en servidor',   'logo' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/nodejs/nodejs-original.svg'],
                ['nombre' => 'Express.js',     'descripcion' => 'Framework minimalista para Node.js',            'logo' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/express/express-original.svg'],
                ['nombre' => 'Python',         'descripcion' => 'Lenguaje de programación versátil',             'logo' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/python/python-original.svg'],
                ['nombre' => 'Django',         'descripcion' => 'Framework web de alto nivel para Python',       'logo' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/django/django-plain.svg'],
                ['nombre' => 'FastAPI',        'descripcion' => 'Framework moderno y rápido para APIs en Python','logo' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/fastapi/fastapi-original.svg'],
                ['nombre' => 'Java',           'descripcion' => 'Lenguaje de programación orientado a objetos',  'logo' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/java/java-original.svg'],
                ['nombre' => 'Spring Boot',    'descripcion' => 'Framework Java para microservicios',            'logo' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/spring/spring-original.svg'],
                ['nombre' => 'C#',             'descripcion' => 'Lenguaje de Microsoft para .NET',               'logo' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/csharp/csharp-original.svg'],
                ['nombre' => '.NET',           'descripcion' => 'Plataforma de desarrollo de Microsoft',         'logo' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/dotnetcore/dotnetcore-original.svg'],
                ['nombre' => 'Go',             'descripcion' => 'Lenguaje de programación de Google',            'logo' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/go/go-original-wordmark.svg'],
                ['nombre' => 'Ruby on Rails',  'descripcion' => 'Framework web para Ruby',                       'logo' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/rails/rails-original-wordmark.svg'],
            ],
            'Base de datos' => [
                ['nombre' => 'PostgreSQL',     'descripcion' => 'Base de datos relacional avanzada',             'logo' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/postgresql/postgresql-original.svg'],
                ['nombre' => 'MySQL',          'descripcion' => 'Sistema de gestión de base de datos relacional','logo' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/mysql/mysql-original.svg'],
                ['nombre' => 'MongoDB',        'descripcion' => 'Base de datos NoSQL orientada a documentos',    'logo' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/mongodb/mongodb-original.svg'],
                ['nombre' => 'Redis',          'descripcion' => 'Almacén de datos en memoria',                   'logo' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/redis/redis-original.svg'],
                ['nombre' => 'SQLite',         'descripcion' => 'Base de datos ligera basada en archivos',       'logo' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/sqlite/sqlite-original.svg'],
                ['nombre' => 'Firebase',       'descripcion' => 'Plataforma de base de datos en tiempo real',    'logo' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/firebase/firebase-plain.svg'],
            ],
            'DevOps y Cloud' => [
                ['nombre' => 'Docker',         'descripcion' => 'Plataforma de contenedores',                    'logo' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/docker/docker-original.svg'],
                ['nombre' => 'Kubernetes',     'descripcion' => 'Orquestación de contenedores',                  'logo' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/kubernetes/kubernetes-plain.svg'],
                ['nombre' => 'AWS',            'descripcion' => 'Amazon Web Services',                           'logo' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/amazonwebservices/amazonwebservices-original-wordmark.svg'],
                ['nombre' => 'Google Cloud',   'descripcion' => 'Plataforma en la nube de Google',              'logo' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/googlecloud/googlecloud-original.svg'],
                ['nombre' => 'Azure',          'descripcion' => 'Plataforma en la nube de Microsoft',            'logo' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/azure/azure-original.svg'],
                ['nombre' => 'Git',            'descripcion' => 'Sistema de control de versiones',               'logo' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/git/git-original.svg'],
                ['nombre' => 'GitHub',         'descripcion' => 'Plataforma de repositorios Git',                'logo' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/github/github-original.svg'],
                ['nombre' => 'Linux',          'descripcion' => 'Sistema operativo de código abierto',           'logo' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/linux/linux-original.svg'],
            ],
            'Móvil' => [
                ['nombre' => 'React Native',   'descripcion' => 'Framework multiplataforma de React',            'logo' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/react/react-original.svg'],
                ['nombre' => 'Flutter',        'descripcion' => 'Framework UI multiplataforma de Google',        'logo' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/flutter/flutter-original.svg'],
                ['nombre' => 'Swift',          'descripcion' => 'Lenguaje de Apple para iOS y macOS',            'logo' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/swift/swift-original.svg'],
                ['nombre' => 'Kotlin',         'descripcion' => 'Lenguaje moderno para Android',                 'logo' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/kotlin/kotlin-original.svg'],
            ],
            'Diseño' => [
                ['nombre' => 'Figma',          'descripcion' => 'Herramienta de diseño UI/UX colaborativa',      'logo' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/figma/figma-original.svg'],
                ['nombre' => 'Adobe XD',       'descripcion' => 'Herramienta de diseño y prototipado de Adobe',  'logo' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/xd/xd-plain.svg'],
                ['nombre' => 'Photoshop',      'descripcion' => 'Editor de imágenes profesional de Adobe',       'logo' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/photoshop/photoshop-plain.svg'],
            ],
            'Inteligencia Artificial' => [
                ['nombre' => 'TensorFlow',     'descripcion' => 'Plataforma de ML de Google',                    'logo' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/tensorflow/tensorflow-original.svg'],
                ['nombre' => 'PyTorch',        'descripcion' => 'Framework de deep learning de Meta',            'logo' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/pytorch/pytorch-original.svg'],
                ['nombre' => 'Pandas',         'descripcion' => 'Librería de análisis de datos en Python',       'logo' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/pandas/pandas-original.svg'],
            ],
        ];

        foreach ($grupos as $categoria => $tecnologias) {
            // Obtener o crear la categoría
            $cat = DB::table('categoria_tecnologia')->where('nombre', $categoria)->first();
            if (!$cat) {
                $idCat = (string) Str::uuid();
                DB::table('categoria_tecnologia')->insert([
                    'id_categoria_tecnologia' => $idCat,
                    'nombre'                  => $categoria,
                ]);
            } else {
                $idCat = $cat->id_categoria_tecnologia;
            }

            foreach ($tecnologias as $tec) {
                $existe = DB::table('tecnologias')->where('nombre', $tec['nombre'])->exists();
                if (!$existe) {
                    DB::table('tecnologias')->insert([
                        'id_tecnologia'           => (string) Str::uuid(),
                        'nombre'                  => $tec['nombre'],
                        'descripcion'             => $tec['descripcion'],
                        'logo'                    => $tec['logo'],
                        'id_categoria_tecnologia' => $idCat,
                    ]);
                }
            }
        }
    }
}
