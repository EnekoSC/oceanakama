# oceaNakama

Plataforma web para entusiastas del mundo marino: cursos de buceo (certificaciones SSI), venta de equipamiento técnico y organización de expediciones.

**Stack:** Laravel 12 · PHP 8.3 · MySQL 8.0 · Redis · Alpine.js · TailwindCSS 3 · Filament 3 · Vite · Docker

---

## Requisitos previos

- Docker y Docker Compose
- (Opcional) PHP 8.3, Composer, Node 20 y npm para desarrollo sin Docker

---

## Inicio rápido (Docker)

```bash
# 1. Clonar y configurar variables de entorno
cp .env.example .env
cp laravel/.env.example laravel/.env

# 2. Levantar todos los servicios
docker compose up -d

# 3. Instalar dependencias y preparar la app
docker compose exec app composer install
docker compose exec app php artisan key:generate
docker compose exec app php artisan migrate --seed

# 4. Acceder a la aplicación
# App:       http://localhost:8000
# Mailpit:   http://localhost:8026
# Admin:     http://localhost:8000/admin
```

> El contenedor `node` ejecuta `npm install && npm run dev` automáticamente con HMR.

---

## Inicio rápido (sin Docker)

```bash
cd laravel
composer setup    # Instala dependencias, genera .env, key, migraciones, npm install y build
composer dev      # Arranca servidor Laravel + queue + logs + Vite en paralelo
```

---

## Comandos de Docker

| Comando | Descripción |
|---------|-------------|
| `docker compose up -d` | Levantar todos los servicios en background |
| `docker compose down` | Parar todos los servicios |
| `docker compose down -v` | Parar servicios y eliminar volúmenes (BD, Redis) |
| `docker compose logs -f app` | Ver logs del contenedor PHP en tiempo real |
| `docker compose logs -f node` | Ver logs de Vite/npm |
| `docker compose exec app bash` | Abrir terminal en el contenedor PHP |
| `docker compose exec app composer install` | Instalar dependencias PHP |
| `docker compose restart app` | Reiniciar el contenedor PHP |
| `docker compose build --no-cache` | Reconstruir la imagen desde cero |

---

## Artisan (Laravel CLI)

Ejecutar dentro del contenedor: `docker compose exec app php artisan <comando>`

### Base de datos

| Comando | Descripción |
|---------|-------------|
| `php artisan migrate` | Ejecutar migraciones pendientes |
| `php artisan migrate:fresh --seed` | Recrear toda la BD y poblar con seeders |
| `php artisan migrate:rollback` | Revertir última migración |
| `php artisan migrate:status` | Ver estado de las migraciones |
| `php artisan db:seed` | Ejecutar seeders |
| `php artisan make:migration create_tabla_table` | Crear nueva migración |

### Generadores (make)

| Comando | Descripción |
|---------|-------------|
| `php artisan make:model NombreModelo -mfsc` | Modelo + migración + seeder + factory + controlador |
| `php artisan make:controller NombreController --resource` | Controlador con métodos CRUD |
| `php artisan make:middleware NombreMiddleware` | Crear middleware |
| `php artisan make:mail NombreMail --markdown=emails.nombre` | Crear mailable con template Markdown |
| `php artisan make:request NombreRequest` | Crear Form Request (validación) |
| `php artisan make:observer NombreObserver --model=Modelo` | Crear observer para un modelo |
| `php artisan make:enum NombreEnum` | Crear enum |

### Cache y configuración

| Comando | Descripción |
|---------|-------------|
| `php artisan config:clear` | Limpiar caché de configuración |
| `php artisan cache:clear` | Limpiar caché de la aplicación |
| `php artisan route:clear` | Limpiar caché de rutas |
| `php artisan view:clear` | Limpiar caché de vistas compiladas |
| `php artisan optimize:clear` | Limpiar todas las cachés de una vez |
| `php artisan optimize` | Cachear config, rutas y vistas (producción) |

### Colas y jobs

| Comando | Descripción |
|---------|-------------|
| `php artisan queue:listen` | Escuchar y procesar jobs de la cola |
| `php artisan queue:work` | Procesar jobs (más eficiente, no recarga código) |
| `php artisan queue:retry all` | Reintentar todos los jobs fallidos |
| `php artisan queue:flush` | Eliminar todos los jobs fallidos |

### Utilidades

| Comando | Descripción |
|---------|-------------|
| `php artisan tinker` | Consola interactiva PHP (REPL) |
| `php artisan pail` | Ver logs en tiempo real con colores |
| `php artisan route:list` | Listar todas las rutas registradas |
| `php artisan route:list --path=api` | Filtrar rutas por prefijo |
| `php artisan storage:link` | Crear symlink público para storage |

---

## Filament (Panel de administración)

| Comando | Descripción |
|---------|-------------|
| `php artisan make:filament-resource Nombre --generate` | Crear recurso CRUD con formulario y tabla autogenerados |
| `php artisan make:filament-page NombrePagina` | Crear página personalizada |
| `php artisan make:filament-widget NombreWidget` | Crear widget para el dashboard |
| `php artisan make:filament-relation-manager NombreResource relacion NombreColumna` | Crear gestor de relaciones |

---

## Testing

```bash
# Ejecutar todos los tests
docker compose exec app composer test

# Ejecutar solo tests unitarios
docker compose exec app php artisan test --testsuite=Unit

# Ejecutar solo tests de feature
docker compose exec app php artisan test --testsuite=Feature

# Ejecutar un test específico
docker compose exec app php artisan test --filter=NombreDelTest

# Con cobertura (requiere Xdebug)
docker compose exec app php artisan test --coverage
```

---

## Linting y formato de código

```bash
# Formatear código PHP con Laravel Pint (PSR-12)
docker compose exec app ./vendor/bin/pint

# Ver qué cambios haría sin aplicar
docker compose exec app ./vendor/bin/pint --test
```

---

## Frontend (Vite + TailwindCSS)

```bash
# Desarrollo con HMR (ya corre automáticamente en Docker via contenedor node)
npm run dev

# Build para producción
npm run build
```

---

## Permisos y roles (Spatie)

```bash
# Crear un rol
php artisan permission:create-role admin

# Crear un permiso
php artisan permission:create-permission "editar cursos"
```

---

## Puertos por defecto

| Servicio | Puerto | Configurable en |
|----------|--------|-----------------|
| Nginx (App) | 8000 | `.env` → `NGINX_PORT` |
| MySQL | 3307 | `.env` → `MYSQL_PORT` |
| Redis | 6380 | `.env` → `REDIS_PORT` |
| Mailpit UI | 8026 | `.env` → `MAILPIT_UI_PORT` |
| Mailpit SMTP | 1026 | `.env` → `MAILPIT_SMTP_PORT` |
| Vite (HMR) | 5174 | `.env` → `VITE_PORT` |

---

## Estructura del proyecto

```
nakama/
├── docker-compose.yml          # Orquestación de servicios
├── Dockerfile                  # Imagen PHP-FPM
├── docker/
│   ├── nginx/default.conf      # Configuración Nginx
│   └── php/local.ini           # Configuración PHP
└── laravel/                    # Aplicación Laravel
    ├── app/
    │   ├── Filament/           # Panel admin (recursos, páginas, widgets)
    │   ├── Http/Controllers/   # Controladores
    │   ├── Models/             # Modelos Eloquent
    │   ├── Mail/               # Clases de email
    │   ├── Enums/              # Enumeraciones PHP
    │   └── Settings/           # Configuración Spatie Settings
    ├── config/                 # Archivos de configuración
    ├── database/
    │   ├── migrations/         # Migraciones de BD
    │   ├── seeders/            # Datos de prueba
    │   └── factories/          # Factories para testing
    ├── resources/views/        # Plantillas Blade
    ├── routes/                 # Definición de rutas
    ├── tests/                  # Tests PHPUnit
    ├── composer.json           # Dependencias PHP
    └── package.json            # Dependencias Node
```

---

## Credenciales de desarrollo

| Servicio | Usuario | Contraseña |
|----------|---------|------------|
| MySQL | nakama | secret |
| MySQL (root) | root | secret |
| MySQL DB | nakama | — |
