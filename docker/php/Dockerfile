FROM php:zts-alpine

WORKDIR /var/www

RUN apk --update upgrade

# PHP cURL
RUN apk add curl curl-dev
RUN docker-php-ext-install curl && docker-php-ext-enable curl

# PHP Parallel
#RUN apk add autoconf gcc g++ make
#RUN pecl install parallel && docker-php-ext-enable parallel

EXPOSE 8000
CMD ["php", "-S", "0.0.0.0:8000"]
