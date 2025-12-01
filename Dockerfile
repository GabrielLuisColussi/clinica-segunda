FROM php:8.2-fpm

# Instala dependências necessárias para o Laravel
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip \
    libzip-dev \
    libonig-dev \
    libpq-dev \
    libsqlite3-dev \
    sqlite3 \
    && docker-php-ext-install pdo pdo_mysql pdo_sqlite zip \
    && rm -rf /var/lib/apt/lists/*

# Copia o Composer do container oficial
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Comando padrão (php-fpm será levantado e o nginx vai se comunicar via fastcgi)
CMD ["php-fpm"]

