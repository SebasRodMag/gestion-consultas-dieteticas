FROM php:8.2-apache

# Actualizamos la lista de paquetes
RUN apt-get update

# Instalamos las librerías necesarias
RUN apt-get install -y libonig-dev zlib1g-dev libpng-dev git zip unzip libzip-dev

#Instala el cliente de MySQL.
RUN apt-get install -y default-mysql-client

# Instalamos las extensiones de PHP necesarias
RUN docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd zip

# Instalamos Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Establecemos el directorio de trabajo
WORKDIR /var/www/html

# Removemos cualquier contenido existente
RUN rm -rf ./*

# Creamos un nuevo proyecto de Laravel
RUN composer create-project --prefer-dist laravel/laravel .

# Copiamos el archivo de configuración de Laravel
COPY .env.example .env

# Vaciar el archivo .env
RUN > .env

# Generar la clave de cifrado y pasarla al archivo .env
RUN php artisan key:generate --show --no-interaction | sed 's/^/APP_KEY=/' > .env

# Limpiamos la caché
RUN php artisan config:clear
RUN php artisan cache:clear

# Damos permisos
RUN chown -R www-data:www-data storage bootstrap/cache
RUN chmod -R 755 storage bootstrap/cache
RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 755 /var/www/html

# Apache configuration
RUN a2enmod rewrite
COPY ./apache/vhost.conf /etc/apache2/sites-available/000-default.conf
RUN a2dissite 000-default && a2ensite 000-default
RUN service apache2 restart

# Establecer la variable de entorno APP_KEY
ENV APP_KEY=${APP_KEY}

EXPOSE 80