# Guia01_2026 - API Biblioteca con JWT

API REST desarrollada en Laravel 12 para la gestion de usuarios, autores, categorias, libros y prestamos, con autenticacion JWT.

## Stack

- PHP 8.2+
- Laravel 12
- MySQL 8.4
- Redis
- JWT (`php-open-source-saver/jwt-auth`)
- Docker Compose (Laravel Sail)

## Funcionalidades implementadas

- Autenticacion JWT: registro, login, perfil, refresh y logout.
- CRUD de categorias.
- CRUD de autores.
- CRUD de libros con relacion a categoria y autores.
- CRUD de prestamos con detalle de libros prestados.
- Endpoints protegidos con `auth:api` (excepto login y registro).

## Modelo de datos

- `users` para autenticacion de la API.
- `Usuarios` para los clientes/usuarios de biblioteca.
- `Categorias`.
- `Autores`.
- `Libros` (pertenece a categoria y se relaciona con autores).
- `Prestamos` (pertenece a `Usuarios`).
- `DetallePrestamo` (detalle de libros por prestamo).
- Tabla pivote `libro_autor`.

## Endpoints principales

Base URL sugerida: `http://localhost:8080/api`

### Auth

- `POST /auth/register`
- `POST /auth/login`
- `GET /auth/me` (token requerido)
- `POST /auth/refresh` (token requerido)
- `POST /auth/logout` (token requerido)

### Recursos protegidos (token JWT requerido)

- `users`: `GET /users`, `GET /users/{id}`, `POST /users`, `PUT /users/{id}`, `DELETE /users/{id}`
- `posts`: `GET /posts`, `GET /posts/my-posts`, `GET /posts/{id}`, `POST /posts`, `PUT /posts/{id}`, `DELETE /posts/{id}`
- `categorias`: `GET /categorias`, `GET /categorias/{id}`, `POST /categorias`, `PUT /categorias/{id}`, `DELETE /categorias/{id}`
- `autores`: `GET /autores`, `GET /autores/{id}`, `POST /autores`, `PUT /autores/{id}`, `DELETE /autores/{id}`
- `libros`: `GET /libros`, `GET /libros/{id}`, `POST /libros`, `PUT /libros/{id}`, `DELETE /libros/{id}`
- `prestamos`: `GET /prestamos`, `GET /prestamos/{id}`, `POST /prestamos`, `PUT /prestamos/{id}`, `DELETE /prestamos/{id}`

## Ejemplo rapido de uso

1) Registrar o iniciar sesion para obtener token:

```http
POST /api/auth/login
Content-Type: application/json

{
  "email": "admin@example.com",
  "password": "password"
}
```

2) Usar el token en endpoints protegidos:

```http
Authorization: Bearer TU_TOKEN
```

3) Crear un prestamo:

```http
POST /api/prestamos
Content-Type: application/json
Authorization: Bearer TU_TOKEN

{
  "id_usuario": 1,
  "fecha_prestamo": "2026-04-22",
  "fecha_devolucion": "2026-04-29",
  "libros": [1, 2]
}
```

## Instalacion local (Docker)

1. Clonar el repositorio y entrar al proyecto.
2. Crear archivo `.env` desde `.env.example`.
3. Levantar servicios:

```bash
docker compose up -d
```

4. Instalar dependencias de PHP:

```bash
docker compose exec laravel.test composer install
```

5. Generar llave de aplicacion:

```bash
docker compose exec laravel.test php artisan key:generate
```

6. Ejecutar migraciones:

```bash
docker compose exec laravel.test php artisan migrate
```

7. (Opcional) Limpiar caches:

```bash
docker compose exec laravel.test php artisan optimize:clear
```

## Ejecucion sin Docker (opcional)

Si ejecutas localmente sin contenedores:

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
```

## Estado del proyecto

Proyecto funcional con autenticacion JWT y modulo de biblioteca completo (categorias, autores, libros y prestamos) listo para pruebas con Postman/Insomnia.
# guia01 - Guia

Este proyecto usa Laravel + Docker + MySQL + JWT.

La forma recomendada para correrlo es con Docker Compose.

## Requisitos

- Docker Desktop
- Git

## 1) Clonar el repositorio

```bash
git clone https://github.com/TU_USUARIO/guia01.git
cd guia01
```

## 2) Crear archivo .env desde .env.example

Linux/macOS:

```bash
cp .env.example .env
```

Windows PowerShell:

```powershell
Copy-Item .env.example .env
```

## 3) Levantar contenedores

Linux/macOS:

```bash
docker compose up -d
```

Windows PowerShell:

```powershell
docker compose up -d
```

Nota: no necesitas poner nombres de contenedor manuales.
Los comandos usan el nombre del servicio laravel.test definido en compose.yaml.

## 4) Instalar dependencias PHP dentro del contenedor

Linux/macOS:

```bash
docker compose exec laravel.test composer install
```

Windows PowerShell:

```powershell
docker compose exec laravel.test composer install
```

## 5) Generar llaves de Laravel y JWT

Linux/macOS:

```bash
docker compose exec laravel.test php artisan key:generate
docker compose exec laravel.test php artisan jwt:secret --force
```

Windows PowerShell:

```powershell
docker compose exec laravel.test php artisan key:generate
docker compose exec laravel.test php artisan jwt:secret --force
```

## 6) Crear tablas en base de datos

Primera vez:

Linux/macOS:

```bash
docker compose exec laravel.test php artisan migrate
```

Windows PowerShell:

```powershell
docker compose exec laravel.test php artisan migrate
```

Si quieres reiniciar todo desde cero:

Linux/macOS:

```bash
docker compose exec laravel.test php artisan migrate:fresh
```

Windows PowerShell:

```powershell
docker compose exec laravel.test php artisan migrate:fresh
```

## 7) Abrir el proyecto

- App: http://localhost:8080

## 8) Probar endpoints protegidos

1. Hacer login en POST /api/auth/login desde docs.
2. Copiar access_token.
3. Usar Bearer Token en las pruebas de endpoints.

## 9) Uso del CRUD (paso a paso)

Regla simple:

- Los endpoints de auth no llevan token.
- El resto de endpoints si llevan Authorization: Bearer TU_TOKEN.

### Paso 1: crear usuario de acceso

- POST /api/auth/register
- Body:

```json
{
	"first_name": "Ana",
	"last_name": "Lopez",
	"email": "ana@example.com",
	"password": "12345678",
	"password_confirmation": "12345678"
}
```

### Paso 2: hacer login y copiar token

- POST /api/auth/login
- Body:

```json
{
	"email": "ana@example.com",
	"password": "12345678"
}
```

### Paso 3: crear categorias y autores

- POST /api/categorias

```json
{
	"nombre": "Programacion"
}
```

- POST /api/autores

```json
{
	"nombre": "Gabriel Garcia Marquez"
}
```

### Paso 4: crear libros

- POST /api/libros

```json
{
	"titulo": "Cien Anos de Soledad",
	"año_publicacion": 1967,
	"id_categoria": 1,
	"autores": [1]
}
```

### Paso 5: crear prestamos

- POST /api/prestamos

```json
{
	"id_usuario": 1,
	"fecha_prestamo": "2026-04-22",
	"fecha_devolucion": "2026-04-29",
	"libros": [1]
}
```

### Paso 6: listar, editar y eliminar

- Listar:
	- GET /api/categorias
	- GET /api/autores
	- GET /api/libros
	- GET /api/prestamos
- Editar:
	- PUT /api/categorias/{categoria}
	- PUT /api/autores/{autor}
	- PUT /api/libros/{libro}
	- PUT /api/prestamos/{prestamo}
- Eliminar:
	- DELETE /api/categorias/{categoria}
	- DELETE /api/autores/{autor}
	- DELETE /api/libros/{libro}
	- DELETE /api/prestamos/{prestamo}

## Comandos utiles

Ver contenedores:

Linux/macOS:

```bash
docker compose ps
```

Windows PowerShell:

```powershell
docker compose ps
```

Ver logs de app:

Linux/macOS:

```bash
docker compose logs -f laravel.test
```

Windows PowerShell:

```powershell
docker compose logs -f laravel.test
```

Limpiar cache Laravel si algo no refleja cambios:

Linux/macOS:

```bash
docker compose exec laravel.test php artisan optimize:clear
```

Windows PowerShell:

```powershell
docker compose exec laravel.test php artisan optimize:clear
```

## Errores comunes

1. Error de DB host mysql no encontrado.
	- Pasa cuando corres php artisan migrate en host Windows.
	- Solucion: correr siempre artisan dentro del contenedor.

2. Error SecretMissingException de JWT.
	- Falta JWT_SECRET en .env.
	- Solucion: ejecutar php artisan jwt:secret --force dentro del contenedor.

## Subir a repositorio publico

Antes de subir:

- No subir .env
- Si por error subiste secretos, regenerarlos

Comandos:

```bash
php artisan serve
```