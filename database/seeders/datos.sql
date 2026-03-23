
-- SEEDERS


-- USUARIOS
INSERT INTO usuario (id_usuario, nombre, apellido, correo, password, estado, verificacion_email)
VALUES
(gen_random_uuid(), 'Juan', 'Perez', 'juan@gmail.com', '123456', true, true),
(gen_random_uuid(), 'Maria', 'Lopez', 'maria@gmail.com', '123456', true, true);

-- ROLES
INSERT INTO rol (id_rol, nombre_rol, descripcion)
VALUES
(gen_random_uuid(), 'ADMIN', 'Administrador del sistema'),
(gen_random_uuid(), 'USUARIO', 'Usuario normal');

-- USUARIO_ROL
INSERT INTO usuario_rol (id_usuario, id_rol)
SELECT u.id_usuario, r.id_rol
FROM usuario u, rol r
WHERE u.correo = 'juan@gmail.com' AND r.nombre_rol = 'ADMIN';

INSERT INTO usuario_rol (id_usuario, id_rol)
SELECT u.id_usuario, r.id_rol
FROM usuario u, rol r
WHERE u.correo = 'maria@gmail.com' AND r.nombre_rol = 'USUARIO';

-- TELEFONO
INSERT INTO telefono (id_telefono, id_usuario, telefono)
SELECT gen_random_uuid(), id_usuario, '70000000' FROM usuario;

-- PAIS
INSERT INTO pais (id_pais, id_usuario, nombre)
SELECT gen_random_uuid(), id_usuario, 'Bolivia' FROM usuario;

-- PROFESION
INSERT INTO profesion (id_profesion, nombre, descripcion)
VALUES
(gen_random_uuid(), 'Desarrollador', 'Programador de software'),
(gen_random_uuid(), 'Diseñador', 'Diseño UI/UX');

-- USUARIO_PROFESION
INSERT INTO usuario_profesion (id_usuario, id_profesion)
SELECT u.id_usuario, p.id_profesion
FROM usuario u, profesion p
WHERE p.nombre = 'Desarrollador';

-- IDIOMA
INSERT INTO idioma (id_idioma, nombre)
VALUES
(gen_random_uuid(), 'Ingles'),
(gen_random_uuid(), 'Español');

-- NIVEL INGLES
INSERT INTO nivel_ingles (id_nivel_ingles, id_idioma, nivel)
SELECT gen_random_uuid(), id_idioma, 'B2' FROM idioma WHERE nombre = 'Ingles';

-- USUARIO_IDIOMA
INSERT INTO usuario_idioma (id_usuario, id_idioma)
SELECT u.id_usuario, i.id_idioma
FROM usuario u, idioma i;

-- PORTAFOLIO


INSERT INTO portafolio (id_portafolio, id_usuario, nombre, visibilidad, descripcion, fecha_creacion)
SELECT gen_random_uuid(), id_usuario, 'Portafolio Personal', true, 'Mi portafolio profesional', CURRENT_DATE
FROM usuario;

-- CONFIGURACION PORTAFOLIO
INSERT INTO configuracion_portafolio (id_configuracion_portafolio, id_portafolio, mostrar_proyecto, mostrar_habilidades)
SELECT gen_random_uuid(), id_portafolio, true, true FROM portafolio;

-- VISUALIZACIONES
INSERT INTO visualizaciones_portafolio (id_visualizacion_portafolio, id_portafolio, numero, fecha)
SELECT gen_random_uuid(), id_portafolio, 10, CURRENT_DATE FROM portafolio;

-- REPORTE
INSERT INTO reporte (id_reporte, id_visualizacion_portafolio, tipo, fecha_creacion)
SELECT gen_random_uuid(), id_visualizacion_portafolio, 'VISITA', CURRENT_DATE FROM visualizaciones_portafolio;

-- PROYECTOS

INSERT INTO proyecto (id_proyecto, id_portafolio, nombre, descripcion, fecha_inicio)
SELECT gen_random_uuid(), id_portafolio, 'Sistema Web', 'Proyecto en Laravel', CURRENT_DATE
FROM portafolio;

-- ESTADO PROYECTO
INSERT INTO estado_proyecto (id_estado_proyecto, id_proyecto, estado)
SELECT gen_random_uuid(), id_proyecto, 'Activo' FROM proyecto;

-- IMAGEN PROYECTO
INSERT INTO url_imagen_proyecto (id_url_imagen_proyecto, id_proyecto, url_imagen)
SELECT gen_random_uuid(), id_proyecto, 'https://img.com/demo.png' FROM proyecto;

-- HABILIDADES

INSERT INTO categoria_habilidad (id_categoria_habilidad, nombre)
VALUES (gen_random_uuid(), 'Backend');

INSERT INTO nivel_de_habilidad (id_nivel_habilidad, nivel)
VALUES (gen_random_uuid(), 'Avanzado');

INSERT INTO habilidad (id_habilidad, id_portafolio, id_categoria_habilidad, id_nivel_habilidad, nombre)
SELECT gen_random_uuid(), p.id_portafolio, c.id_categoria_habilidad, n.id_nivel_habilidad, 'Laravel'
FROM portafolio p, categoria_habilidad c, nivel_de_habilidad n
LIMIT 1;
-- TECNOLOGIAS

INSERT INTO tecnologias (id_tecnologia, id_proyecto, id_habilidad, nombre)
SELECT gen_random_uuid(), pr.id_proyecto, h.id_habilidad, 'PostgreSQL'
FROM proyecto pr, habilidad h
LIMIT 1;

INSERT INTO categoria_tecnologia (id_categoria_tecnologia, id_tecnologia, nombre)
SELECT gen_random_uuid(), id_tecnologia, 'Base de datos' FROM tecnologias;

-- EXPERIENCIA

INSERT INTO tipo_experiencia (id_tipo_experiencia, nombre)
VALUES (gen_random_uuid(), 'Laboral');

INSERT INTO experiencia (id_experiencia, id_portafolio, id_tipo_experiencia, cargo, nombre_organizacion)
SELECT gen_random_uuid(), p.id_portafolio, t.id_tipo_experiencia, 'Developer', 'Empresa X'
FROM portafolio p, tipo_experiencia t
LIMIT 1;

-- SERVICIOS
INSERT INTO servicio (id_servicio, id_portafolio, nombre, activo)
SELECT gen_random_uuid(), id_portafolio, 'Desarrollo Web', true FROM portafolio;

-- CERTIFICACION
INSERT INTO certificacion (id_certificacion, id_portafolio, titulo)
SELECT gen_random_uuid(), id_portafolio, 'Certificado Laravel' FROM portafolio;

-- REDES
INSERT INTO redes_profesionales (id_red_profesional, id_portafolio, nombre, url)
SELECT gen_random_uuid(), id_portafolio, 'LinkedIn', 'https://linkedin.com' FROM portafolio;