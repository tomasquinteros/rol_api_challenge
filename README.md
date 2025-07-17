# API - Users - Auth
[![Laravel](https://img.shields.io/badge/laravel-10-blue.svg?style=for-the-badge)](https://laravel.com)
![Swagger](https://img.shields.io/badge/-Swagger-%23Clojure?style=for-the-badge&logo=swagger&logoColor=white)

## API Reference

| **Endpoint**                   | **Método** | **Descripción**                                                               | **Ejemplo de Solicitud**                                                          |
| ------------------------------ | ---------- | ----------------------------------------------------------------------------- | --------------------------------------------------------------------------------- |
| `/api/auth/login`              | `POST`     | Logueo de usuario                                                             | `{ "email": "usuario@ejemplo.com", "password": "contraseña" }`                    |
| `/api/auth/logout`             | `POST`     | Logout de usuario                                                             | Header: `Authorization: Bearer <access_token>`                                    |
| `/api/auth/revokeTokensByUser` | `POST`     | Eliminar tokens del usuario                                                   | Header: `Authorization: Bearer <access_token>`                                    |
| `/api/users`                   | `GET`      | Obtener usuarios con paginación y filtros opcionales: `name`, `limit`, `page` | `/api/users?name=juan&limit=10&page=2` <br> `/api/users?page=2` <br> `/api/users` |
| `/api/documentation`           | `GET`      | Documentación Swagger                                                         | URL para acceder a la documentación de la API                                     |



## Login para prueba:
`email` => admin@admin.com
`password` => admin123

## ✅ Requisitos

### Opción 1: Instalación clásica

- PHP >= 8.1
- Composer
- MySQL o SQLite
- Extensiones PHP necesarias: `openssl`, `pdo`, `mbstring`, `tokenizer`, `xml`, `ctype`, `json`, `bcmath`, `sqlite3`


### Opción 2: Usar Docker (Recomendado para evitar conflictos de entorno)
- [Docker Engine](https://docs.docker.com/get-docker/) instalado (v20+ recomendado)
- [Docker Compose](https://docs.docker.com/compose/install/) instalado (v2.0+ recomendado)
- Sistema operativo compatible (Linux, macOS, Windows con WSL2)
- Puerto `80` o `8000` libre para exponer la aplicación

## 🚀 Instalación Clásica

```bash
# 1. Clonar el repositorio
git clone https://github.com/tomasquinteros/rol_api_challenge.git
cd rol_api_challenge

# 2. Instalar dependencias PHP
composer install

# 3. Copiar archivo de entorno
cp .env.example .env

# 4. Crear archivo de base de datos SQLite
touch database/database.sqlite

# 5. Configurar el archivo .env para usar SQLite:
# (Editar las siguientes líneas en .env)
DB_CONNECTION=sqlite

# 6. Generar la key de la app
php artisan key:generate

# 7. Ejecutar migraciones y seeders
php artisan migrate --seed
# 8. Generar o actualizar la documentación Swagger
php artisan l5-swagger:generate
# 9. Levantar servidor
php artisan serve
```
## 🚀 Instalación con Docker
```
# 1. Clonar el repositorio
git clone https://github.com/tomasquinteros/rol_api_challenge.git
cd rol_api_challenge

# 2. Copiar archivo de entorno
cp .env.example .env
# 3. Configurar el archivo .env para usar Mysql
# Editar las siguientes lineas
#DB_CONNECTION=sqlite
DB_CONNECTION=mysql
DB_HOST=api_rol_challenge_db
DB_PORT=3306
DB_DATABASE=api_rol_challenge
DB_USERNAME=laravel
DB_PASSWORD=secret
# 4. Crear contenedores
docker-compose up -d --build

# 5. Instalar dependencias dentro del contenedor
docker exec -it app bash
composer install
php artisan key:generate
php artisan l5-swagger:generate
php artisan migrate
exit
```

