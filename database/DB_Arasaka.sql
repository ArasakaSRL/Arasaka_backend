-- EXTENSION
CREATE EXTENSION IF NOT EXISTS "pgcrypto";

CREATE TABLE usuario (
    id_usuario UUID PRIMARY KEY DEFAULT gen_random_uuid (),
    nombre VARCHAR(50),
    apellido VARCHAR(50),
    correo VARCHAR(150),
    password TEXT,
    biografia VARCHAR(550),
    url_foto TEXT,
    estado BOOLEAN,
    verificacion_email BOOLEAN,
    created_at TIMESTAMPTZ DEFAULT now(),
    updated_at TIMESTAMPTZ DEFAULT now()
);

CREATE TABLE rol (
    id_rol UUID PRIMARY KEY DEFAULT gen_random_uuid (),
    nombre_rol VARCHAR(50),
    descripcion VARCHAR(550)
);

CREATE TABLE usuario_rol (
    id_usuario UUID,
    id_rol UUID,
    PRIMARY KEY (id_usuario, id_rol),
    FOREIGN KEY (id_usuario) REFERENCES usuario (id_usuario) ON DELETE CASCADE,
    FOREIGN KEY (id_rol) REFERENCES rol (id_rol) ON DELETE CASCADE
);

CREATE TABLE telefono (
    id_telefono UUID PRIMARY KEY DEFAULT gen_random_uuid (),
    id_usuario UUID,
    telefono VARCHAR(10),
    FOREIGN KEY (id_usuario) REFERENCES usuario (id_usuario) ON DELETE CASCADE
);

CREATE TABLE pais (
    id_pais UUID PRIMARY KEY DEFAULT gen_random_uuid (),
    id_usuario UUID,
    nombre VARCHAR(255),
    FOREIGN KEY (id_usuario) REFERENCES usuario (id_usuario) ON DELETE CASCADE
);

CREATE TABLE profesion (
    id_profesion UUID PRIMARY KEY DEFAULT gen_random_uuid (),
    nombre VARCHAR(50),
    descripcion VARCHAR(550)
);

CREATE TABLE usuario_profesion (
    id_usuario UUID,
    id_profesion UUID,
    PRIMARY KEY (id_usuario, id_profesion),
    FOREIGN KEY (id_usuario) REFERENCES usuario (id_usuario) ON DELETE CASCADE,
    FOREIGN KEY (id_profesion) REFERENCES profesion (id_profesion) ON DELETE CASCADE
);

CREATE TABLE idioma (
    id_idioma UUID PRIMARY KEY DEFAULT gen_random_uuid (),
    nombre VARCHAR(100)
);

CREATE TABLE nivel_ingles (
    id_nivel_ingles UUID PRIMARY KEY DEFAULT gen_random_uuid (),
    id_idioma UUID,
    nivel VARCHAR(2),
    FOREIGN KEY (id_idioma) REFERENCES idioma (id_idioma)
);

CREATE TABLE usuario_idioma (
    id_usuario UUID,
    id_idioma UUID,
    PRIMARY KEY (id_usuario, id_idioma),
    FOREIGN KEY (id_usuario) REFERENCES usuario (id_usuario) ON DELETE CASCADE,
    FOREIGN KEY (id_idioma) REFERENCES idioma (id_idioma) ON DELETE CASCADE
);

CREATE TABLE portafolio (
    id_portafolio UUID PRIMARY KEY DEFAULT gen_random_uuid (),
    id_usuario UUID,
    nombre VARCHAR(50),
    visibilidad BOOLEAN,
    descripcion VARCHAR(550),
    fecha_creacion DATE,
    fecha_actualizacion DATE,
    FOREIGN KEY (id_usuario) REFERENCES usuario (id_usuario)
);

CREATE TABLE configuracion_portafolio (
    id_configuracion_portafolio UUID PRIMARY KEY DEFAULT gen_random_uuid (),
    id_portafolio UUID,
    mostrar_proyecto BOOLEAN,
    mostrar_habilidades BOOLEAN,
    mostrar_experiencia BOOLEAN,
    mostrar_certificaciones BOOLEAN,
    mostrar_servicios BOOLEAN,
    paleta_colores TEXT,
    FOREIGN KEY (id_portafolio) REFERENCES portafolio (id_portafolio)
);

CREATE TABLE visualizaciones_portafolio (
    id_visualizacion_portafolio UUID PRIMARY KEY DEFAULT gen_random_uuid (),
    id_portafolio UUID,
    numero INTEGER,
    fecha DATE,
    ip_vista TEXT,
    clics_redes DECIMAL,
    FOREIGN KEY (id_portafolio) REFERENCES portafolio (id_portafolio)
);

CREATE TABLE reporte (
    id_reporte UUID PRIMARY KEY DEFAULT gen_random_uuid (),
    id_visualizacion_portafolio UUID,
    tipo VARCHAR(150),
    fecha_creacion DATE,
    direccion_ip TEXT,
    FOREIGN KEY (id_visualizacion_portafolio) REFERENCES visualizaciones_portafolio (id_visualizacion_portafolio)
);

CREATE TABLE proyecto (
    id_proyecto UUID PRIMARY KEY DEFAULT gen_random_uuid (),
    id_portafolio UUID,
    nombre VARCHAR(50),
    descripcion VARCHAR(550),
    fecha_inicio DATE,
    fecha_fin DATE,
    url_demo TEXT,
    url_github TEXT,
    destacado BOOLEAN,
    created_at TIMESTAMPTZ DEFAULT now(),
    updated_at TIMESTAMPTZ DEFAULT now(),
    FOREIGN KEY (id_portafolio) REFERENCES portafolio (id_portafolio)
);

CREATE TABLE estado_proyecto (
    id_estado_proyecto UUID PRIMARY KEY DEFAULT gen_random_uuid (),
    id_proyecto UUID,
    estado VARCHAR,
    FOREIGN KEY (id_proyecto) REFERENCES proyecto (id_proyecto)
);

CREATE TABLE url_imagen_proyecto (
    id_url_imagen_proyecto UUID PRIMARY KEY DEFAULT gen_random_uuid (),
    id_proyecto UUID,
    url_imagen TEXT,
    FOREIGN KEY (id_proyecto) REFERENCES proyecto (id_proyecto)
);

CREATE TABLE categoria_habilidad (
    id_categoria_habilidad UUID PRIMARY KEY DEFAULT gen_random_uuid (),
    nombre VARCHAR(100)
);

CREATE TABLE nivel_de_habilidad (
    id_nivel_habilidad UUID PRIMARY KEY DEFAULT gen_random_uuid (),
    nivel VARCHAR(50)
);

CREATE TABLE habilidad (
    id_habilidad UUID PRIMARY KEY DEFAULT gen_random_uuid (),
    id_portafolio UUID,
    id_categoria_habilidad UUID,
    id_nivel_habilidad UUID,
    nombre VARCHAR(50),
    FOREIGN KEY (id_portafolio) REFERENCES portafolio (id_portafolio),
    FOREIGN KEY (id_categoria_habilidad) REFERENCES categoria_habilidad (id_categoria_habilidad),
    FOREIGN KEY (id_nivel_habilidad) REFERENCES nivel_de_habilidad (id_nivel_habilidad)
);

CREATE TABLE tecnologias (
    id_tecnologia UUID PRIMARY KEY DEFAULT gen_random_uuid (),
    id_proyecto UUID,
    id_habilidad UUID,
    nombre VARCHAR(225),
    descripcion VARCHAR(255),
    FOREIGN KEY (id_proyecto) REFERENCES proyecto (id_proyecto),
    FOREIGN KEY (id_habilidad) REFERENCES habilidad (id_habilidad)
);

CREATE TABLE categoria_tecnologia (
    id_categoria_tecnologia UUID PRIMARY KEY DEFAULT gen_random_uuid (),
    id_tecnologia UUID,
    nombre VARCHAR(225),
    FOREIGN KEY (id_tecnologia) REFERENCES tecnologias (id_tecnologia)
);

CREATE TABLE tipo_experiencia (
    id_tipo_experiencia UUID PRIMARY KEY DEFAULT gen_random_uuid (),
    nombre VARCHAR(100)
);

CREATE TABLE experiencia (
    id_experiencia UUID PRIMARY KEY DEFAULT gen_random_uuid (),
    id_portafolio UUID,
    id_tipo_experiencia UUID,
    cargo VARCHAR(100),
    nombre_organizacion VARCHAR(255),
    descripcion VARCHAR(550),
    fecha_inicio DATE,
    fecha_fin DATE,
    vigente BOOLEAN,
    FOREIGN KEY (id_portafolio) REFERENCES portafolio (id_portafolio),
    FOREIGN KEY (id_tipo_experiencia) REFERENCES tipo_experiencia (id_tipo_experiencia)
);

=
CREATE TABLE servicio (
    id_servicio UUID PRIMARY KEY DEFAULT gen_random_uuid (),
    id_portafolio UUID,
    nombre VARCHAR(150),
    descripcion VARCHAR(550),
    activo BOOLEAN,
    FOREIGN KEY (id_portafolio) REFERENCES portafolio (id_portafolio)
);

CREATE TABLE certificacion (
    id_certificacion UUID PRIMARY KEY DEFAULT gen_random_uuid (),
    id_portafolio UUID,
    titulo VARCHAR(100),
    descripcion VARCHAR(550),
    institucion_emisora VARCHAR(150),
    fecha_obtencion DATE,
    url_archivo TEXT,
    id_categoria_certificacion UUID,
    FOREIGN KEY (id_portafolio) REFERENCES portafolio (id_portafolio),
    FOREIGN KEY (id_categoria_certificacion) REFERENCES categoria_certificacion (id_categoria_certificacion)
);

CREATE TABLE redes_profesionales (
    id_red_profesional UUID PRIMARY KEY DEFAULT gen_random_uuid (),
    id_portafolio UUID,
    nombre VARCHAR(150),
    url TEXT,
    FOREIGN KEY (id_portafolio) REFERENCES portafolio (id_portafolio)
);

SELECT * FROM tecnologias LIMIT 5;
SELECT * FROM habilidad LIMIT 5;SELECT * FROM habilidades_tiene_tecnologias;

SELECT
    tc.table_name,
    kcu.column_name,
    ccu.table_name AS foreign_table_name,
    ccu.column_name AS foreign_column_name,
    rc.delete_rule
FROM information_schema.table_constraints tc
JOIN information_schema.key_column_usage kcu
    ON tc.constraint_name = kcu.constraint_name
JOIN information_schema.referential_constraints rc
    ON tc.constraint_name = rc.constraint_name
JOIN information_schema.constraint_column_usage ccu
    ON ccu.constraint_name = tc.constraint_name
WHERE tc.constraint_type = 'FOREIGN KEY'
ORDER BY tc.table_name;