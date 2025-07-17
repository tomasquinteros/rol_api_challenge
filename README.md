# API - Users - Auth
[![Laravel](https://img.shields.io/badge/laravel-9-blue.svg?style=for-the-badge)](https://laravel.com)
[![Conventional Commits](https://img.shields.io/badge/Conventional%20Commits-1.0.0-blue.svg?style=for-the-badge)](https://conventionalcommits.org)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=for-the-badge)](/LICENSE)

## API Reference
Se puede utilizar

| **endpoint**                                      | **method** | **description**                                                                                                                                                    |
|---------------------------------------------------|------------|--------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| /api/auth/login                                   | POST       | Logueo de usuario                                                                                                                                                  |
| /api/auth/logout                                  | POST       | Logout de usuario                                                                                                                                                  |
| /api/auth/revokeTokensByUser                      | POST       | Eliminar tokens de usuario                                                                                                                                         |
| /api/users                                        | GET        | Obtener todos los usuarios con paginacion. Parametros opcionales: `page` : numero de pagina, `limit` : cantidad de usuarios por pagina, `name`: filtrar por nombre |

## ✅ Requisitos

### Opción 1: Instalación clásica

- PHP >= 8.1
- Composer
- MySQL o SQLite
- Extensiones PHP necesarias: `openssl`, `pdo`, `mbstring`, `tokenizer`, `xml`, `ctype`, `json`, `bcmath`, `sqlite3`


### Opción 2: Usar Docker (Recomendado para evitar conflictos de entorno)


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
DB_DATABASE=${PWD}/database/database.sqlite

# 6. Generar la key de la app
php artisan key:generate

# 7. Ejecutar migraciones y seeders
php artisan migrate --seed

# 8. Levantar servidor
php artisan serve
```
## 🚀 Instalación Clásica
```
# 1. Clonar el repositorio
git clone https://github.com/usuario/mi-proyecto-laravel.git
cd mi-proyecto-laravel

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
php artisan migrate
exit
```

