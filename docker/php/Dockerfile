FROM php:7.1-fpm

#RUN curl -sL https://deb.nodesource.com/setup_6.x | bash -
#
RUN apt-get update \
    && apt-get install -y \
#      nodejs \
#      curl \
#      bzip2 \
#      ssmtp \
#      sudo \
#      vim \
      git
#      zip \
#      unzip \
#      zlib1g-dev \
#      libfontconfig \
#    && apt-get clean
#
#RUN pecl install \
#    xdebug-2.5.0
#
#COPY ext-xdebug.ini /usr/local/etc/php/conf.d/ext-xdebug.ini
#
#RUN docker-php-ext-enable \
#    xdebug
#
#RUN docker-php-ext-install \
#    pdo \
#    pdo_mysql \
#    bcmath \
#    zip

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN groupadd -r --gid 1000 php_user \
    && useradd -r -u 1000 -g 1000 php_user \
    && usermod -aG sudo php_user \
    && echo "php_user ALL=(ALL) NOPASSWD:ALL" | tee -a /etc/sudoers

RUN mkdir -p /home/php_user \
    && chown -R php_user:1000 /home/php_user

USER php_user

WORKDIR /var/www/gothinkster
