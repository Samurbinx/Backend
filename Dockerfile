# Usamos una imagen oficial de PHP con Apache
FROM php:8.2-apache

# Habilitar módulos necesarios de Apache
RUN a2enmod rewrite

# RUN sed -i 's|/var/www/html|/var/www/html/public|' /etc/apache2/sites-available/000-default.conf

# Copiar el archivo de configuración de Symfony
COPY apache.conf /etc/apache2/sites-available/apache.conf

# Deshabilitar configuración predeterminada y habilitar la nueva
RUN a2dissite 000-default.conf && a2ensite apache.conf

RUN echo "ServerName 192.168.1.135" >> /etc/apache2/apache2.conf

# Instalar dependencias del sistema operativo
RUN apt-get update && apt-get install -y \
    libxml2-dev \
    libicu-dev \
    libpq-dev \
    git \
    unzip \
    && docker-php-ext-install xml intl pdo pdo_mysql

# Instalar Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copiar composer.json y composer.lock
COPY composer.json composer.lock /var/www/html/

# Establecer el directorio de trabajo
WORKDIR /var/www/html

# Instalar las dependencias de Symfony usando Composer
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Copiar el código de tu backend Symfony al contenedor
COPY . /var/www/html/

RUN chmod -R 777 /var/www/html/var /var/www/html/vendor

# Exponer el puerto 80 (el puerto estándar para HTTP)
EXPOSE 80

# Iniciar Apache en el contenedor
CMD ["apache2-foreground"]

