#<!-- Comentario: agregado para prueba de commit — solo un comentario, no se crea archivo. 2026-05-24 -->
#
#E-Commerce Laravel
#
#Sistema web de comercio electrónico desarrollado con Laravel. Permite administrar usuarios, productos, categorías y ventas mediante autenticación con verificación de dos factores.

## Tecnologías usadas

- Laravel 12
- PHP 8.2
- Blade
- Tailwind CSS / Vite
- SQLite para pruebas automáticas
- SQLite o MySQL para producción
- Git y GitHub
- GitHub Actions para integración continua
- Render para despliegue cloud con Docker

## Requisitos

- PHP 8.2 o superior
- Composer
- Node.js 20 o superior
- NPM
- SQLite o MySQL

## Instalación local

```bash
git clone https://github.com/USUARIO/NOMBRE-REPOSITORIO.git
cd NOMBRE-REPOSITORIO
composer install
npm install
cp .env.example .env
php artisan key:generate
```

Para usar SQLite en local:

```bash
touch database/database.sqlite
```

En el archivo `.env` configurar:

```env
DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite
```

Después ejecutar:

```bash
php artisan migrate --seed
npm run build
php artisan serve
```

## Ejecución de pruebas

```bash
php artisan test
```

Las pruebas se encuentran en:

```bash
tests/Feature/SistemaEcommerceTest.php
```

Validan comportamiento real del sistema, incluyendo:

- Página principal disponible.
- Login disponible en `/entrar`.
- Dashboard protegido por autenticación.
- Login incorrecto con errores de sesión.
- Generación de código 2FA.
- Verificación correcta de código 2FA.
- Acceso al dashboard para administrador autenticado.
- Registro de productos en base de datos.
- Validación de campos obligatorios.
- Restricción de permisos para clientes.

## Integración continua

El pipeline se encuentra en:

```bash
.github/workflows/laravel.yml
```

Se ejecuta automáticamente al hacer:

- `push` hacia `main`
- `pull request` hacia `main`

El pipeline realiza:

1. Clonado del repositorio.
2. Instalación de PHP.
3. Instalación de dependencias Composer.
4. Instalación de dependencias NPM.
5. Compilación de assets.
6. Configuración de entorno de pruebas.
7. Configuración de SQLite.
8. Ejecución de migraciones y seeders.
9. Ejecución de pruebas automáticas.

## Despliegue cloud

La aplicación está preparada para desplegarse en Render usando Docker.

Archivos incluidos para despliegue:

```bash
Dockerfile
docker/start.sh
render.yaml
```

Render puede conectarse al repositorio de GitHub y desplegar automáticamente cada cambio enviado a la rama `main`.

## Variables de entorno

Las variables de entorno deben configurarse en la plataforma cloud y no deben subirse en un archivo `.env` al repositorio.

Variables mínimas:

```env
APP_NAME=E-Commerce Laravel
APP_ENV=production
APP_KEY=base64:GENERAR_CON_php_artisan_key_generate_show
APP_DEBUG=false
APP_URL=https://URL-DE-TU-APP.onrender.com

DB_CONNECTION=sqlite
DB_HOST=
DB_PORT=
DB_DATABASE=database/database.sqlite
DB_USERNAME=
DB_PASSWORD=

SESSION_DRIVER=file
CACHE_STORE=file
QUEUE_CONNECTION=sync
MAIL_MAILER=log
```

Para generar la clave de aplicación:

```bash
php artisan key:generate --show
```

## URL pública del sistema

Pendiente de colocar después del despliegue:

```text
https://URL-DE-TU-APP.onrender.com
```

## Flujo básico de Git

Comandos sugeridos:

```bash
git add .
git commit -m "Configuración inicial del pipeline CI"
git commit -m "Implementación de pruebas automáticas del sistema"
git commit -m "Configuración de despliegue cloud con Docker"
git commit -m "Actualización de variables de entorno de ejemplo"
git commit -m "Versión final estable para despliegue"
git push origin main
```

## Seguridad

- No subir `.env` al repositorio.
- No hardcodear credenciales.
- No subir claves privadas.
- Usar variables de entorno en la plataforma cloud.
- Verificar que GitHub Actions termine correctamente antes del despliegue final.

## Pruebas automáticas

El sistema incluye pruebas Feature para validar página principal, login, protección del dashboard, autenticación 2FA, permisos de usuario y registro de productos.

## Ejecución local

Para ejecutar el sistema localmente se debe instalar Composer, configurar el archivo .env, ejecutar las migraciones y levantar el servidor con php artisan serve.

