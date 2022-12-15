FROM php:8-apache

WORKDIR /var/www

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN chmod +x /usr/local/bin/install-php-extensions && install-php-extensions gd

RUN a2enmod rewrite

COPY . .
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install
RUN rm -rf /var/www/html && ln -s /var/www/public /var/www/html
RUN chown -R www-data /var/www

EXPOSE 80
