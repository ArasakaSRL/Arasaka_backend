# Auth — Endpoints

Base URL: `/api`
Autenticación: **Cookie de sesión** (Laravel Sanctum — cookie `laravel_session`)

---

## POST `/registrar`

Crea un nuevo usuario. Opcionalmente crea su portafolio en el mismo request.

> No requiere sesión activa. Si ya hay sesión iniciada, retorna `302`.

---

### Caso 1 — Registro sin portafolio

**Thunder Client**
```
POST http://localhost:8000/api/registrar
Content-Type: application/json
```

**Body**
```json
{
  "nombre": "Juan",
  "apellido": "Perez",
  "correo": "juan@example.com",
  "password": "Password123!",
  "password_confirmation": "Password123!",
  "crear_portafolio": false
}
```

**Response 204** — Sin contenido. Usuario creado y sesión iniciada automáticamente.

---

### Caso 2 — Registro con portafolio

**Thunder Client**
```
POST http://localhost:8000/api/registrar
Content-Type: application/json
```

**Body**
```json
{
  "nombre": "Juan",
  "apellido": "Perez",
  "correo": "juan@example.com",
  "password": "Password123!",
  "password_confirmation": "Password123!",
  "crear_portafolio": true,
  "portafolio": {
    "nombre": "Mi Portafolio",
    "descripcion": "Portafolio profesional de desarrollo web",
    "visibilidad": true
  }
}
```

**Response 204** — Sin contenido. Usuario y portafolio creados, sesión iniciada automáticamente.

---

### Validaciones

| Campo | Tipo | Requerido | Reglas |
|-------|------|-----------|--------|
| `nombre` | string | Sí | Máx. 255 caracteres |
| `apellido` | string | Sí | Máx. 255 caracteres |
| `correo` | string (email) | Sí | Email válido, único, máx. 255 caracteres |
| `password` | string | Sí | Debe cumplir política de contraseñas de Laravel |
| `password_confirmation` | string | Sí | Debe coincidir con `password` |
| `biografia` | string | No | — |
| `url_foto` | string (URL) | No | URL válida, máx. 500 caracteres |
| `estado` | boolean | No | — |
| `verificacion_email` | boolean | No | Default: `false` |
| `crear_portafolio` | boolean | No | Default: `false` |
| `portafolio.nombre` | string | **Sí si** `crear_portafolio: true` | Máx. 255 caracteres |
| `portafolio.descripcion` | string | No | — |
| `portafolio.visibilidad` | boolean | **Sí si** `crear_portafolio: true` | `true` = público, `false` = privado |

---

### Errores

**Response 422** — Validación fallida
```json
{
  "message": "The correo has already been taken.",
  "errors": {
    "correo": ["The correo has already been taken."]
  }
}
```

```json
{
  "message": "The portafolio.nombre field is required when crear portafolio is true.",
  "errors": {
    "portafolio.nombre": ["The portafolio.nombre field is required when crear portafolio is true."],
    "portafolio.visibilidad": ["The portafolio.visibilidad field is required when crear portafolio is true."]
  }
}
```

---

## POST `/iniciar-sesion`

**Thunder Client**
```
POST http://localhost:8000/api/iniciar-sesion
Content-Type: application/json
```

**Body**
```json
{
  "correo": "juan@example.com",
  "password": "Password123!"
}
```

**Response 204** — Sesión iniciada (cookie `laravel_session` seteada automáticamente).

**Response 422** — Credenciales incorrectas
```json
{
  "message": "These credentials do not match our records.",
  "errors": {
    "correo": ["These credentials do not match our records."]
  }
}
```

---

## POST `/cerrar-sesion`

> Requiere sesión activa.

**Thunder Client**
```
POST http://localhost:8000/api/cerrar-sesion
```

**Response 204** — Sesión cerrada.

---

## POST `/recuperar-contrasena`

Envía un correo con el link para restablecer la contraseña.

**Thunder Client**
```
POST http://localhost:8000/api/recuperar-contrasena
Content-Type: application/json
```

**Body**
```json
{
  "email": "juan@example.com"
}
```

**Response 200**
```json
{
  "status": "We have emailed your password reset link."
}
```

---

## POST `/restablecer-contrasena`

Restablece la contraseña usando el token recibido por correo.

**Thunder Client**
```
POST http://localhost:8000/api/restablecer-contrasena
Content-Type: application/json
```

**Body**
```json
{
  "token": "token-del-correo",
  "email": "juan@example.com",
  "password": "NuevaClave123!",
  "password_confirmation": "NuevaClave123!"
}
```

**Response 200**
```json
{
  "status": "Your password has been reset."
}
```

---

## Notas para el frontend

- Todos los requests que mutan estado deben incluir el header `X-XSRF-TOKEN` (o usar `withCredentials: true` con Axios, que lo maneja automáticamente).
- La sesión se maneja por cookie, no por Bearer token. Configurar el cliente HTTP con `withCredentials: true`.
- Después del registro y del login la respuesta es **204 sin body** — no hay token en el body.
- En Thunder Client: activar **"Send Cookies"** y **"Store Cookies"** para que la cookie de sesión persista entre requests.
