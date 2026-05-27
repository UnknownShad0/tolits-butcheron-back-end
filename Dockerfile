FROM php:8.2-cli

# Install dependencies
RUN apt-get update && apt-get install -y \
    curl zip unzip git nodejs npm

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www

COPY . .

RUN composer install --no-dev --optimize-autoloader
RUN npm install && npm run build

RUN cp .env.example .env && php artisan key:generate

EXPOSE 8080

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8080"]