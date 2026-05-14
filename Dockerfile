# Docker multi-stage para Laravel 12 + PHP 8.2 + PostgreSQL + Node (Vite/Tailwind)
### estágio node: compila assets do frontend
FROM node:18-alpine AS node-builder
WORKDIR /app

# Copia apenas os arquivos de package primeiro para melhor cache
COPY package.json package-lock.json* ./
RUN npm ci --legacy-peer-deps || npm install

# Copia os arquivos do frontend necessários para o build
COPY vite.config.js tailwind.config.js postcss.config.js ./
COPY resources resources

RUN npm run build

### estágio composer: instala dependências PHP (produção)
FROM php:8.2-cli AS composer-stage
WORKDIR /app

# Instala dependências de sistema necessárias para extensões e para o Composer
RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        git \
        unzip \
        curl \
        libpq-dev \
        libzip-dev \
    && docker-php-ext-install pdo pdo_pgsql \
    && rm -rf /var/lib/apt/lists/*

# Instala o Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copia arquivos do Composer e instala dependências sem os pacotes de desenvolvimento
COPY composer.json composer.lock* ./
# Copia código necessário para que o Composer e autoload encontrem arquivos (antes de instalar)
COPY app app
COPY bootstrap bootstrap
COPY config config
COPY database database
COPY routes routes
COPY artisan artisan
RUN composer install --no-dev --prefer-dist --no-interaction --optimize-autoloader --no-progress || composer install --no-dev --no-interaction

### imagem final: runtime
FROM php:8.2-cli
WORKDIR /app

# Dependências em tempo de execução necessárias para extensões
RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        ca-certificates \
        git \
        unzip \
        libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql \
    && rm -rf /var/lib/apt/lists/*

# Copia os arquivos da aplicação
COPY . .

# Copia o diretório `vendor` (do estágio composer-stage) e os assets compilados (do node-builder)
COPY --from=composer-stage /app/vendor ./vendor
COPY --from=node-builder /app/public/build ./public/build

# Garante que `storage` e `bootstrap/cache` sejam graváveis pelo processo web
RUN chown -R www-data:www-data ./storage ./bootstrap/cache || true

# Entrypoint: roda migrations e depois inicia o servidor embutido do Laravel
RUN set -ex \
    && printf '#!/bin/sh\nset -e\n# Gera APP_KEY se não foi fornecida via variável de ambiente\nif [ -z "${APP_KEY}" ]; then\n  php artisan key:generate --ansi --force || true\nfi\n# Executa migrations (force para não interativo)\nphp artisan migrate --force\n# Inicia o servidor embutido na porta 10000\nexec php artisan serve --host=0.0.0.0 --port=10000\n' > /usr/local/bin/docker-entrypoint.sh \
    && chmod +x /usr/local/bin/docker-entrypoint.sh

EXPOSE 10000

ENTRYPOINT ["/usr/local/bin/docker-entrypoint.sh"]
