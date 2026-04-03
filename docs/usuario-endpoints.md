# Usuario — Endpoints

Base URL: `/api`
Autenticación: **Cookie de sesión** (Laravel Sanctum)
Todos los endpoints requieren sesión activa (cookie `laravel_session`).

---

## Profesiones del usuario

### GET `/usuario/profesiones`
Obtiene las profesiones asignadas al usuario autenticado.

**Request**
```
GET /api/usuario/profesiones
```

**Response 200**
```json
{
  "data": [
    {
      "id_profesion": "uuid",
      "nombre": "Desarrollador Web",
      "descripcion": "Desarrollo de aplicaciones web"
    }
  ]
}
```

---

### POST `/usuario/profesiones`
Asigna una profesión existente al usuario autenticado.

**Request**
```
POST /api/usuario/profesiones
Content-Type: application/json
```
```json
{
  "id_profesion": "uuid-de-la-profesion"
}
```

**Validaciones**
| Campo | Tipo | Requerido | Reglas |
|-------|------|-----------|--------|
| `id_profesion` | string (UUID) | Sí | Debe existir en la tabla `profesion` |

**Response 201**
```json
{
  "message": "Profesión asignada correctamente"
}
```

**Response 422** — UUID inválido
```json
{
  "message": "The id profesion field must be a valid UUID.",
  "errors": {
    "id_profesion": ["The id profesion field must be a valid UUID."]
  }
}
```

---

### DELETE `/usuario/profesiones/{id}`
Desasigna una profesión del usuario autenticado.

**Request**
```
DELETE /api/usuario/profesiones/{id_profesion}
```

**Response 200**
```json
{
  "message": "Profesión desasignada correctamente"
}
```

---

## Editar información del usuario

### PATCH `/usuario/informacion`
Actualiza la información del usuario autenticado. Se pueden enviar uno o varios campos.

**Request**
```
PATCH /api/usuario/informacion
Content-Type: application/json
```
```json
{
  "nombre": "Juan",
  "apellido": "Pérez",
  "descripcion_laboral": "Desarrollador full stack con 5 años de experiencia",
  "correo": "juan@example.com"
}
```

**Validaciones**
| Campo | Tipo | Requerido | Reglas |
|-------|------|-----------|--------|
| `nombre` | string | Opcional* | Máx. 50 caracteres |
| `apellido` | string | Opcional* | Máx. 50 caracteres |
| `descripcion_laboral` | string | Opcional* | Máx. 550 caracteres |
| `correo` | string (email) | Opcional* | Email válido, máx. 255 caracteres |

> *Al menos uno debe enviarse. Si se envía el campo, no puede estar vacío.

**Response 200**
```json
{
  "message": "Información actualizada correctamente",
  "data": {
    "id_usuario": "uuid",
    "nombre": "Juan",
    "apellido": "Pérez",
    "correo": "juan@example.com",
    "descripcion_laboral": "Desarrollador full stack con 5 años de experiencia",
    "url_foto": "https://..."
  }
}
```

---

### PATCH `/usuario/foto`
Actualiza la foto de perfil del usuario autenticado.

**Request**
```
PATCH /api/usuario/foto
Content-Type: application/json
```
```json
{
  "url_foto": "https://example.com/fotos/mi-foto.jpg"
}
```

**Validaciones**
| Campo | Tipo | Requerido | Reglas |
|-------|------|-----------|--------|
| `url_foto` | string (URL) | Sí | URL válida, máx. 500 caracteres |

**Response 200**
```json
{
  "message": "Foto actualizada correctamente",
  "data": {
    "id_usuario": "uuid",
    "nombre": "Juan",
    "apellido": "Pérez",
    "correo": "juan@example.com",
    "descripcion_laboral": "...",
    "url_foto": "https://example.com/fotos/mi-foto.jpg"
  }
}
```

---

## Errores comunes

| Código | Descripción |
|--------|-------------|
| `401` | Sesión inválida o no iniciada |
| `422` | Error de validación en el body |
| `404` | Recurso no encontrado (ej. profesión inexistente) |
