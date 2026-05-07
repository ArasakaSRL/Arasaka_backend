-- SEEDERS

-- USUARIOS
INSERT INTO
    usuario (
        id_usuario,
        nombre,
        apellido,
        correo,
        password,
        estado,
        verificacion_email
    )
VALUES (
        gen_random_uuid (),
        'Juan',
        'Perez',
        'juan@gmail.com',
        '123456',
        true,
        true
    ),
    (
        gen_random_uuid (),
        'Maria',
        'Lopez',
        'maria@gmail.com',
        '123456',
        true,
        true
    );

-- ROLES
INSERT INTO
    rol (
        id_rol,
        nombre_rol,
        descripcion
    )
VALUES (
        gen_random_uuid (),
        'ADMIN',
        'Administrador del sistema'
    ),
    (
        gen_random_uuid (),
        'USUARIO',
        'Usuario normal'
    );

-- USUARIO_ROL
INSERT INTO
    usuario_rol (id_usuario, id_rol)
SELECT u.id_usuario, r.id_rol
FROM usuario u, rol r
WHERE
    u.correo = 'juan@gmail.com'
    AND r.nombre_rol = 'ADMIN';

INSERT INTO
    usuario_rol (id_usuario, id_rol)
SELECT u.id_usuario, r.id_rol
FROM usuario u, rol r
WHERE
    u.correo = 'maria@gmail.com'
    AND r.nombre_rol = 'USUARIO';

-- TELEFONO
INSERT INTO
    telefono (
        id_telefono,
        id_usuario,
        telefono
    )
SELECT gen_random_uuid (), id_usuario, '70000000'
FROM usuario;

-- PAIS
INSERT INTO
    pais (id_pais, id_usuario, nombre)
SELECT gen_random_uuid (), id_usuario, 'Bolivia'
FROM usuario;

-- PROFESION
INSERT INTO
    profesion (
        id_profesion,
        nombre,
        descripcion
    )
VALUES (
        gen_random_uuid (),
        'Desarrollador',
        'Programador de software'
    ),
    (
        gen_random_uuid (),
        'Diseñador',
        'Diseño UI/UX'
    );

-- USUARIO_PROFESION
INSERT INTO
    usuario_profesion (id_usuario, id_profesion)
SELECT u.id_usuario, p.id_profesion
FROM usuario u, profesion p
WHERE
    p.nombre = 'Desarrollador';

-- IDIOMA
INSERT INTO
    idioma (id_idioma, nombre)
VALUES (gen_random_uuid (), 'Ingles'),
    (gen_random_uuid (), 'Español');

-- NIVEL INGLES
INSERT INTO
    nivel_ingles (
        id_nivel_ingles,
        id_idioma,
        nivel
    )
SELECT gen_random_uuid (), id_idioma, 'B2'
FROM idioma
WHERE
    nombre = 'Ingles';

-- USUARIO_IDIOMA
INSERT INTO
    usuario_idioma (id_usuario, id_idioma)
SELECT u.id_usuario, i.id_idioma
FROM usuario u, idioma i;

-- PORTAFOLIO

INSERT INTO
    portafolio (
        id_portafolio,
        id_usuario,
        nombre,
        visibilidad,
        descripcion,
        fecha_creacion
    )
SELECT
    gen_random_uuid (),
    id_usuario,
    'Portafolio Personal',
    true,
    'Mi portafolio profesional',
    CURRENT_DATE
FROM usuario;

-- CONFIGURACION PORTAFOLIO
INSERT INTO
    configuracion_portafolio (
        id_configuracion_portafolio,
        id_portafolio,
        mostrar_proyecto,
        mostrar_habilidades
    )
SELECT
    gen_random_uuid (),
    id_portafolio,
    true,
    true
FROM portafolio;

-- VISUALIZACIONES
INSERT INTO
    visualizaciones_portafolio (
        id_visualizacion_portafolio,
        id_portafolio,
        numero,
        fecha
    )
SELECT
    gen_random_uuid (),
    id_portafolio,
    10,
    CURRENT_DATE
FROM portafolio;

-- REPORTE
INSERT INTO
    reporte (
        id_reporte,
        id_visualizacion_portafolio,
        tipo,
        fecha_creacion
    )
SELECT
    gen_random_uuid (),
    id_visualizacion_portafolio,
    'VISITA',
    CURRENT_DATE
FROM visualizaciones_portafolio;

-- PROYECTOS

INSERT INTO
    proyecto (
        id_proyecto,
        id_portafolio,
        nombre,
        descripcion,
        fecha_inicio
    )
SELECT
    gen_random_uuid (),
    id_portafolio,
    'Sistema Web',
    'Proyecto en Laravel',
    CURRENT_DATE
FROM portafolio;

-- ESTADO PROYECTO
INSERT INTO
    estado_proyecto (
        id_estado_proyecto,
        id_proyecto,
        estado
    )
SELECT gen_random_uuid (), id_proyecto, 'Activo'
FROM proyecto;

-- IMAGEN PROYECTO
INSERT INTO
    url_imagen_proyecto (
        id_url_imagen_proyecto,
        id_proyecto,
        url_imagen
    )
SELECT gen_random_uuid (), id_proyecto, 'https://img.com/demo.png'
FROM proyecto;

-- HABILIDADES

INSERT INTO
    categoria_habilidad (
        id_categoria_habilidad,
        nombre
    )
VALUES (gen_random_uuid (), 'Backend');

INSERT INTO
    nivel_de_habilidad (id_nivel_habilidad, nivel)
VALUES (
        gen_random_uuid (),
        'Avanzado'
    );

INSERT INTO
    habilidad (
        id_habilidad,
        id_portafolio,
        id_categoria_habilidad,
        id_nivel_habilidad,
        nombre
    )
SELECT gen_random_uuid (), p.id_portafolio, c.id_categoria_habilidad, n.id_nivel_habilidad, 'Laravel'
FROM
    portafolio p,
    categoria_habilidad c,
    nivel_de_habilidad n
LIMIT 1;
-- TECNOLOGIAS

INSERT INTO
    tecnologias (
        id_tecnologia,
        id_proyecto,
        id_habilidad,
        nombre
    )
SELECT gen_random_uuid (), pr.id_proyecto, h.id_habilidad, 'PostgreSQL'
FROM proyecto pr, habilidad h
LIMIT 1;

INSERT INTO
    categoria_tecnologia (
        id_categoria_tecnologia,
        id_tecnologia,
        nombre
    )
SELECT
    gen_random_uuid (),
    id_tecnologia,
    'Base de datos'
FROM tecnologias;

-- EXPERIENCIA

INSERT INTO
    tipo_experiencia (id_tipo_experiencia, nombre)
VALUES (gen_random_uuid (), 'Laboral');

INSERT INTO
    experiencia (
        id_experiencia,
        id_portafolio,
        id_tipo_experiencia,
        cargo,
        nombre_organizacion
    )
SELECT gen_random_uuid (), p.id_portafolio, t.id_tipo_experiencia, 'Developer', 'Empresa X'
FROM portafolio p, tipo_experiencia t
LIMIT 1;

-- SERVICIOS
INSERT INTO
    servicio (
        id_servicio,
        id_portafolio,
        nombre,
        activo
    )
SELECT
    gen_random_uuid (),
    id_portafolio,
    'Desarrollo Web',
    true
FROM portafolio;

-- CERTIFICACION
INSERT INTO
    certificacion (
        id_certificacion,
        id_portafolio,
        titulo
    )
SELECT
    gen_random_uuid (),
    id_portafolio,
    'Certificado Laravel'
FROM portafolio;

-- REDES
INSERT INTO
    redes_profesionales (
        id_red_profesional,
        id_portafolio,
        nombre,
        url
    )
SELECT
    gen_random_uuid (),
    id_portafolio,
    'LinkedIn',
    'https://linkedin.com'
FROM portafolio;

INSERT INTO
    categoria_certificacion (
        nombre,
        descripcion,
        url_imagen
    )
VALUES (
        'Idiomas',
        'Lenguajes aprendidos',
        'https://res.cloudinary.com/dkopjpuqx/image/upload/v1775527529/a6b425_48880d306dd5487ab1f9fed9a4ab7f91_mv2_trrgj5.jpg'
    ),
    (
        'Insignias',
        'Logros especificos',
        'https://res.cloudinary.com/dkopjpuqx/image/upload/v1775345490/look-my-medal_apeb4v.jpg'
    ),
    (
        'Academicos',
        'Certificaciones',
        'https://res.cloudinary.com/dkopjpuqx/image/upload/v1775346665/close-up-graduates-shaking-hands_2_lke1pt.jpg'
    ),
    (
        'Capacitaciones',
        'Certificaciones de capacitación',
        'https://res.cloudinary.com/dkopjpuqx/image/upload/v1775346365/male-computer-programmer-coding-computer-language-on-desktop-pc-in-picture-id963127020-1_yngqwp.jpg'
    ),
    (
        'Competencias',
        'Certificaciones de competencias',
        'https://res.cloudinary.com/dkopjpuqx/image/upload/v1775347039/YnZ-ZECO_1256x620__1_rle0rl.jpg'
    ),
    (
        'Logros',
        'Reconocimientos y achievements',
        'https://res.cloudinary.com/dkopjpuqx/image/upload/v1775347223/hombre-que-soporta-una-taza-del-trofeo-del-oro-88335544_kwzrdq.jpg'
    );

INSERT INTO
    tecnologias (nombre, descripcion, logo)
VALUES (
        'PHP',
        'Lenguaje de programación usado para desarrollo web en el backend',
        'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/php/php-original.svg'
    ),
    (
        'Laravel',
        'Framework PHP para desarrollo web',
        'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/laravel/laravel-line-wordmark.svg'
    ),
    (
        'PostgreSQL',
        'Sistema de gestión de bases de datos relacional',
        'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/postgresql/postgresql-original.svg'
    ),
    (
        'Figma',
        'Biblioteca JavaScript para construir interfaces de usuario',
        'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/figma/figma-original.svg'
    ),
    (
        'Node.js',
        'Entorno de ejecución para JavaScript en el servidor',
        'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/nodejs/nodejs-original.svg'
    ),
    (
        'Docker',
        'Plataforma de contenedores para desarrollar, enviar y ejecutar aplicaciones',
        'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/docker/docker-original.svg'
    ),
    (
        'React',
        'Biblioteca JavaScript para construir interfaces de usuario',
        'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/react/react-original.svg'
    ),
    (
        'Git',
        'Sistema de control de versiones distribuido',
        'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/git/git-original.svg'
    ),
    (
        'AWS',
        'Plataforma de servicios en la nube de Amazon',
        'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/amazonwebservices/amazonwebservices-original-wordmark.svg'
    ),
    (
        'Python',
        'Lenguaje de programación de alto nivel',
        'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/python/python-original.svg'
    ),
    (
        'Django',
        'Framework de alto nivel para desarrollo web en Python',
        'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/django/django-original.svg'
    ),
    (
        'Angular',
        'Framework de aplicaciones web desarrollado por Google',
        'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/angularjs/angularjs-original.svg'
    ),
    (
        'Vue.js',
        'Framework progresivo para construir interfaces de usuario',
        'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/vuejs/vuejs-original.svg'
    ),
    (
        'Ruby on Rails',
        'Framework de desarrollo web para el lenguaje Ruby',
        'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/rails/rails-original-wordmark.svg'
    ),
    (
        'Swift',
        'Lenguaje de programación para iOS y macOS desarrollado por Apple',
        'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/swift/swift-original.svg'
    ),
    (
        'Kotlin',
        'Lenguaje de programación moderno para Android y JVM',
        'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/kotlin/kotlin-original.svg'
    ),
    (
        'Flutter',
        'Framework de UI para construir aplicaciones nativas para móviles, web y escritorio',
        'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/flutter/flutter-original.svg'
    ),
    (
        'TypeScript',
        'Superset de JavaScript que añade tipado estático',
        'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/typescript/typescript-original.svg'
    ),
    (
        'Sass',
        'Preprocesador CSS que añade características como variables y anidamiento',
        'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/sass/sass-original.svg'
    ),
    (
        'Webpack',
        'Empaquetador de módulos para aplicaciones JavaScript modernas',
        'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/webpack/webpack-original.svg'
    ),
    (
        'MySQL',
        'Sistema de gestión de bases de datos relacional',
        'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/mysql/mysql-original.svg'
    ),
    (
        'MongoDB',
        'Base de datos NoSQL orientada a documentos',
        'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/mongodb/mongodb-original.svg'
    ),
    (
        'Redis',
        'Base de datos en memoria, utilizada como caché y broker de mensajes',
        'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/redis/redis-original.svg'
    ),
    (
        'GraphQL',
        'Lenguaje de consulta para APIs desarrollado por Facebook',
        'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/graphql/graphql-original.svg'
    ),
    (
        'Elasticsearch',
        'Motor de búsqueda y análisis basado en Lucene',
        'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/elasticsearch/elasticsearch-original.svg'
    ),
    (
        'RabbitMQ',
        'Broker de mensajes que implementa el protocolo AMQP',
        'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/rabbitmq/rabbitmq-original.svg'
    ),
    (
        'Jenkins',
        'Servidor de automatización para integración continua y entrega continua',
        'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/jenkins/jenkins-original.svg'
    ),
    (
        'java',
        'Lenguaje de programación de propósito general, concurrente, orientado a objetos',
        'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/java/java-original.svg'
    ),
    (
        'C#',
        'Lenguaje de programación moderno y orientado a objetos desarrollado por Microsoft',
        'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/csharp/csharp-original.svg'
    ),
    (
        'Go',
        'Lenguaje de programación desarrollado por Google, conocido por su simplicidad y rendimiento',
        'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/go/go-original.svg'
    ),
    (
        'Rust',
        'Lenguaje de programación de sistemas enfocado en la seguridad y el rendimiento',
        'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/rust/rust-plain.svg'
    ),
    (
        'Scala',
        'Lenguaje de programación que combina características de programación funcional y orientada a objetos',
        'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/scala/scala-original.svg'
    ),
    (
        'Perl',
        'Lenguaje de programación de alto nivel, conocido por su potencia en procesamiento de texto',
        'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/perl/perl-original.svg'
    ),
    (
        'Haskell',
        'Lenguaje de programación funcional puro, conocido por su fuerte sistema de tipos',
        'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/haskell/haskell-original.svg'
    ),
    (
        'C++',
        'Lenguaje de programación de propósito general, conocido por su rendimiento y flexibilidad',
        'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/cplusplus/cplusplus-original.svg'
    ),
    (
        'C',
        'Lenguaje de programación de bajo nivel, ampliamente utilizado para desarrollo de sistemas y aplicaciones embebidas',
        'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/c/c-original.svg'
    ),
    (
        'javaScript',
        'Lenguaje de programación de alto nivel, utilizado principalmente para desarrollo web',
        'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/javascript/javascript-original.svg'
    ),
    (
        'HTML5',
        'Lenguaje de marcado para estructurar contenido en la web',
        'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/html5/html5-original.svg'
    ),
    (
        'CSS3',
        'Lenguaje de estilo para describir la presentación de un documento HTML',
        'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/css3/css3-original.svg'
    ),
    (
        'Bootstrap',
        'Framework de CSS para diseño web responsivo',
        'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/bootstrap/bootstrap-original.svg'
    ),
    (
        'Tailwind CSS',
        'Framework de CSS para diseño web utilitario',
        'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/tailwindcss/tailwindcss-plain.svg'
    ),
    (
        'Material-UI',
        'Framework de componentes React para diseño web',
        'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/materialui/materialui-original.svg'
    ),
    (
        'Ant Design',
        'Framework de componentes React para diseño web',
        'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/antdesign/antdesign-original.svg'
    ),
    (
        'Bulma',
        'Framework de CSS para diseño web responsivo',
        'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/bulma/bulma-plain.svg'
    ),
    (
        'Foundation',
        'Framework de CSS para diseño web responsivo',
        'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/foundation/foundation-original.svg'
    ),
    (
        'Semantic UI',
        'Framework de CSS para diseño web responsivo',
        'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/semanticui/semanticui-original.svg'
    ),
    (
        'Next.js',
        'Framework de React para aplicaciones web renderizadas en el servidor',
        'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/nextjs/nextjs-original.svg'
    ),
    (
        'NestJS',
        'Framework de Node.js para construir aplicaciones del lado del servidor',
        'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/nestjs/nestjs-original.svg'
    ),
    (
        'Express.js',
        'Framework de Node.js para construir aplicaciones web y APIs',
        'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/express/express-original.svg'
    ),
    (
        '.NET',
        'Framework de desarrollo de software desarrollado por Microsoft',
        'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/dotnet/dotnet-original.svg'
    ),
    (
        'Spring boot',
        'Framework de Java para construir aplicaciones web y microservicios',
        'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/spring/spring-original.svg'
    );