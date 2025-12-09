FROM php:7.2-apache

# Reparar repositórios antigos do Debian Stretch
RUN sed -i 's/deb.debian.org/archive.debian.org/g' /etc/apt/sources.list \
 && sed -i 's|security.debian.org|archive.debian.org|g' /etc/apt/sources.list \
 && sed -i '/stretch-updates/d' /etc/apt/sources.list

# Instalar dependências do CakePHP 2
RUN apt-get update && apt-get install -y \
    libicu-dev libxml2-dev zip unzip git \
  && docker-php-ext-install intl mbstring xml pdo pdo_mysql \
  && apt-get clean && rm -rf /var/lib/apt/lists/*

# Habilitar mod_rewrite
RUN a2enmod rewrite

# Configuração do Apache para permitir .htaccess
RUN sed -i 's/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

WORKDIR /var/www/html