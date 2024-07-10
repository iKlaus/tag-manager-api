FROM php:8.3-apache

# gd requires libpng-dev and zlib1g-dev
# git is needed by composer
# zip requires libzip-dev
RUN apt-get -y update \
    && apt-get install -y git libpng-dev libzip-dev zlib1g-dev

# Sentry requires "excimer" and it is not available via docker-php-ext-install
# TODO: We should better not rely on this github link
RUN curl -sSL https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions -o - | sh -s \
      bcmath @composer excimer gd opcache pcntl zip

COPY .docker/vhost.conf /etc/apache2/sites-available/000-default.conf

# OpCache
RUN { \
		echo 'opcache.enable=1'; \
		echo 'opcache.enable_cli=1'; \
		echo 'opcache.validate_timestamps=${OPCACHE_VALIDATE_TIMESTAMPS}'; \
		echo 'opcache.revalidate_freq=0'; \
		echo 'opcache.memory_consumption=128'; \
		echo 'opcache.max_accelerated_files=5000'; \
		echo 'opcache.fast_shutdown=1'; \
		echo 'opcache.interned_strings_buffer=16'; \
	} > /usr/local/etc/php/conf.d/opcache-recommended.ini

RUN echo "error_reporting=E_ALL" > /usr/local/etc/php/conf.d/php.ini && \
    echo "display_errors=1" >> /usr/local/etc/php/conf.d/php.ini  && \
    echo "log_errors=1" >> /usr/local/etc/php/conf.d/php.ini  && \
    echo "memory_limit=450M" >> /usr/local/etc/php/conf.d/php.ini

RUN a2enmod rewrite

WORKDIR /var/www/html

COPY --chown=www-data:www-data . /var/www/html

# COMPOSER_AUTH gets passed from docker-compose.yaml locally and .github/workflows/deploy-to-aws-fargate.yml on github
# TODO: This should be converted into --secret (see https://docs.docker.com/engine/reference/builder/#arg)
ARG COMPOSER_AUTH

RUN date > container_created_at
