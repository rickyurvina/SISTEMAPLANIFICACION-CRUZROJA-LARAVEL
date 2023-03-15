# ----------------------
# Composer install step
# ----------------------
FROM composer:2.0 as build

WORKDIR /app

RUN mkdir public

COPY composer.json composer.json
COPY database/ database/

RUN composer install \
    --ignore-platform-reqs \
    --no-interaction \
    --no-plugins \
    --no-scripts \
    --prefer-dist

# ----------------------
# Assets install step
# ----------------------
FROM node:alpine as assets

WORKDIR /app

RUN mkdir resources
RUN mkdir public

COPY webpack.mix.js /app
COPY package.json /app
COPY --from=build /app/vendor/tinymce/tinymce /app/vendor/tinymce/tinymce
COPY resources /app/resources

# Install dependencies and compile assets
RUN npm install && npm run production

# ----------------------
# The FPM container
# ----------------------
FROM php:8.1-fpm

WORKDIR /app

# Install dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libpq-dev \
    zip \
    unzip \
    zlib1g-dev \
    libicu-dev \
    g++ \
    libzip-dev \
    curl

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install extensions
RUN docker-php-ext-install pdo pdo_pgsql mbstring exif pcntl bcmath gd

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

#copy configs
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
ENV APP_HOME /app/
COPY . ${APP_HOME}
COPY --from=build /app/vendor/ /app/vendor/
COPY --from=build /app/public/ /app/public/
COPY --from=assets /app/public/ /app/public/

WORKDIR ${APP_HOME}

# Copy existing application directory permissions
COPY --chown=www-data:www-data . /app

# Change current user to www
USER www-data

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]
