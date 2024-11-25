# Usamos la imagen oficial de PHP con Apache
FROM php:8.3-apache

# Instalamos extensiones necesarias de PHP
RUN docker-php-ext-install pdo pdo_mysql

# Habilitar mod_rewrite para Apache
RUN a2enmod rewrite

# Instalamos Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Instalamos Xdebug
RUN pecl install xdebug && docker-php-ext-enable xdebug

# Configuramos Xdebug
COPY docker/php/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

# Configuramos la carpeta raíz del proyecto
WORKDIR /var/www/html

# Cambiar la configuración de Apache para usar /var/www/html/public como DocumentRoot
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

# Crear una carpeta pública si no existe (en caso de que falte en el proyecto)
RUN mkdir -p /var/www/html/public

# Agregar un alias para la carpeta easyphpdatatables
RUN echo 'Alias /easyphpdatatables /var/www/html/vendor/hstanleycrow/easyphpdatatables/src' >> /etc/apache2/sites-available/000-default.conf && \
    echo '<Directory /var/www/html/vendor/hstanleycrow/easyphpdatatables/src>\n    Require all granted\n</Directory>' >> /etc/apache2/sites-available/000-default.conf

# Agregar un alias para la carpeta de recursos
RUN echo 'Alias /resources /var/www/html/resources' >> /etc/apache2/sites-available/000-default.conf && \
    echo '<Directory /var/www/html/resources>\n    Require all granted\n</Directory>' >> /etc/apache2/sites-available/000-default.conf

# Reiniciar Apache para aplicar cambios en configuración
RUN service apache2 restart