# Usa la imagen de PHP con Apache preinstalado
FROM php:8.1-apache

# Copia el contenido de tu proyecto al directorio del servidor web en el contenedor
COPY . /var/www/html/

# Habilita módulos adicionales si los necesitas
RUN docker-php-ext-install pdo pdo_mysql
