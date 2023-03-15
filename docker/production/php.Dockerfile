# ----------------------
# Assets install step
# ----------------------
FROM node:alpine as assets

WORKDIR /app

RUN mkdir resources
RUN mkdir public

COPY webpack.mix.js /app
COPY package.json /app
COPY resources /app/resources

# Install dependencies and compile assets
RUN npm install && npm run production


FROM php:8.1-fpm

# Set working directory
WORKDIR /var/www

# Add docker php ext repo
ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

# Install php extensions
RUN chmod +x /usr/local/bin/install-php-extensions && sync && \
    install-php-extensions mbstring pdo pdo_pgsql zip exif pcntl gd memcached intl

# Install dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libxrender1 \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    unzip \
    git \
    curl \
    lua-zlib-dev \
    libmemcached-dev \
    libpq-dev \
    nginx

# Install supervisor
RUN apt-get install -y supervisor

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Add user for laravel application
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

COPY --from=assets /app/public/ /var/www/public/

# Copy code to /var/www
COPY --chown=www:www-data . /var/www

# add root to www group
RUN chmod -R ug+w /var/www/storage
RUN chmod -R ug+w /var/www/bootstrap/cache

# Copy nginx/php/supervisor configs
RUN cp docker/production/supervisor.conf /etc/supervisord.conf
RUN cp docker/production/php.ini /usr/local/etc/php/conf.d/app.ini
#RUN cp docker/production/nginx.conf /etc/nginx/sites-enabled/default

# PHP Error Log Files
RUN mkdir /var/log/php
RUN touch /var/log/php/errors.log && chmod 777 /var/log/php/errors.log

# Deployment steps
RUN composer install --optimize-autoloader
RUN chmod +x /var/www/docker/production/run.sh

ENTRYPOINT ["/var/www/docker/production/run.sh"]