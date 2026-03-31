# Usuario — Endpoints

Base URL: `/api`
Autenticación: **Bearer Token** (Laravel Sanctum)
Todos los endpoints requieren el header:
```
Authorization: Bearer {token}
```

---

## Profesiones del usuario

### GET `/usuario/profesiones`
Obtiene las profesiones asignadas al usuario autenticado.

**Request**
```
GET /api/usuario/profesiones
Authorization: Bearer {token}
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
Authorization: Bearer {token}
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
Authorization: Bearer {token}
```

**Response 200**
```json
{
  "message": "Profesión desasignada correctamente"
}
```

---

## Editar información del usuario

### PATCH `/usuario/biografia`
Actualiza únicamente la biografía del usuario autenticado.

**Request**
```
PATCH /api/usuario/biografia
Authorization: Bearer {token}
Content-Type: application/json
```
```json
{
  "biografia": "Soy un desarrollador apasionado por la tecnología..."
}
```

**Validaciones**
| Campo | Tipo | Requerido | Reglas |
|-------|------|-----------|--------|
| `biografia` | string | Sí | Máx. 550 caracteres |

**Response 200**
```json
{
  "message": "Biografía actualizada correctamente",
  "data": {
    "id_usuario": "uuid",
    "nombre": "Juan",
    "apellido": "Pérez",
    "correo": "juan@example.com",
    "biografia": "Soy un desarrollador apasionado por la tecnología...",
    "url_foto": "https://..."
  }
}
```

---

### PATCH `/usuario/foto`
Actualiza únicamente la foto de perfil del usuario autenticado.

**Request**
```
PATCH /api/usuario/foto
Authorization: Bearer {token}
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
    "biografia": "...",
    "url_foto": "https://example.com/fotos/mi-foto.jpg"
  }
}
```

---

### PATCH `/usuario/nombre`
Actualiza el nombre y/o apellido del usuario autenticado. Se pueden enviar ambos o solo uno.

**Request**
```
PATCH /api/usuario/nombre
Authorization: Bearer {token}
Content-Type: application/json
```
```json
{
  "nombre": "Juan",
  "apellido": "Pérez"
}
```

**Validaciones**
| Campo | Tipo | Requerido | Reglas |
|-------|------|-----------|--------|
| `nombre` | string | Opcional* | Máx. 50 caracteres |
| `apellido` | string | Opcional* | Máx. 50 caracteres |

> *Al menos uno debe enviarse. Si se envía el campo, no puede estar vacío.

**Response 200**
```json
{
  "message": "Nombre actualizado correctamente",
  "data": {
    "id_usuario": "uuid",
    "nombre": "Juan",
    "apellido": "Pérez",
    "correo": "juan@example.com",
    "biografia": "...",
    "url_foto": "https://..."
  }
}
```

---

## Errores comunes

| Código | Descripción |
|--------|-------------|
| `401` | Token inválido o no enviado |
| `422` | Error de validación en el body |
| `404` | Recurso no encontrado (ej. profesión inexistente) |
