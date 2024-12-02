# Usar la imagen oficial de PHP 8.2 con FPM
FROM php:8.2-fpm

# Establecer el directorio de trabajo dentro del contenedor
WORKDIR /var/www/html

# Instalar dependencias necesarias
RUN apt-get update && apt-get install -y libpq-dev git unzip && \
    docker-php-ext-install pdo pdo_mysql

# Instalar Composer para gestionar dependencias de PHP
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copiar el contenido de tu proyecto dentro del contenedor
COPY . .

# Instalar las dependencias de Symfony
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Exponer el puerto 9000 para PHP-FPM
EXPOSE 9000

# Ejecutar PHP-FPM
CMD ["php-fpm"]
