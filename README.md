# Sistema de Gestión de Biblioteca Digital

## Descripción
Este proyecto es una aplicación web desarrollada con **Laravel** diseñada para la administración eficiente de una biblioteca. Permite el control de inventario de libros, registro de usuarios y gestión de préstamos, optimizando los tiempos de búsqueda y consulta.

## Tecnologías Utilizadas
- **Framework:** Laravel 10 (o la versión que se use)
- **Base de Datos:** MySQL
- **Frontend:** Bootstrap
- **Control de versiones:** Git / GitHub

## Funcionalidades Principales
- **Catálogo Dinámico:** Búsqueda rápida de libros por categoría o título.
- **Gestión de Usuarios:** Roles diferenciados para administradores y lectores.
- **Panel Administrativo:** Interfaz intuitiva para altas, bajas y cambios de material bibliográfico.

## Instalación y Configuración
1. Clona el repositorio:
   `git clone https://github.com/Jasiel789/Biblioteca-Digital.git`
2. Instala las dependencias:
   `composer install`
3. Copia el archivo de entorno:
   `cp .env.example .env`
4. Genera la llave de la aplicación:
   `php artisan key:generate`
5. Ejecuta las migraciones de la base de datos:
   `php artisan migrate`

## Autor
Desarrollado por **Jasiel Bernal**.
