FROM php:7.2.0-fpm-alpine
RUN apk update \
    && apk upgrade \
    && apk add libxml2-dev php5-soap curl libmemcached-dev zlib-dev libjpeg-turbo-dev libpng-dev freetype-dev openssl-dev libmcrypt-dev \
    && pecl channel-update pecl.php.net \
    && docker-php-ext-install zip \
    && docker-php-ext-install tokenizer \
    && docker-php-ext-install pdo_mysql \
    && docker-php-ext-configure gd --enable-gd-native-ttf --with-jpeg-dir=/usr/lib --with-freetype-dir=/usr/include/freetype2 \
    && docker-php-ext-install gd \
    && docker-php-ext-install soap \
    && docker-php-ext-configure opcache --enable-opcache \
    && docker-php-ext-install opcache \
    && docker-php-ext-install bcmath

#-------------PHPUNIT----------------
ARG INSTALL_PHPUNIT=false
RUN if [ ${INSTALL_PHPUNIT} = true ]; then \
php -r "copy('https://phar.phpunit.de/phpunit.phar', 'phpunit.phar');" && \
    chmod +x phpunit.phar && \
    mv phpunit.phar /usr/local/bin/phpunit \
	;fi


#-------------XDEBUG----------------
ARG INSTALL_XDEBUG=false
RUN if [ ${INSTALL_XDEBUG} = true ]; then \
    apk add cmake autoconf build-base \
    && pecl install xdebug \
#    && pecl install xdebug-2.6.0alpha1 \ # if not work prev line
    && docker-php-ext-enable xdebug \
    ;fi

#-------------COMPOSER----------------
ARG INSTALL_COMPOSER=false
RUN if [ ${INSTALL_COMPOSER} = true ]; then \
    php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
     && php composer-setup.php \
     && php -r "unlink('composer-setup.php');" \
     && mv composer.phar /usr/local/bin/composer \
    ;fi

#-------------AMQP----------------
ARG INSTALL_AMQP=false
RUN if [ ${INSTALL_AMQP} = true ]; then \
    apk update \
    && apk upgrade \
    && apk add cmake autoconf build-base \
    && apk add rabbitmq-c \
    apk add --update php7-amqp \
    #pecl install amqp \ # uncomment if not work prev line
     && docker-php-ext-enable amqp \
    ;fi







ADD xdebug.ini /usr/local/etc/php/conf.d/
ADD opcache.ini  /usr/local/etc/php/conf.d/