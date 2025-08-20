FROM php:8.2-fpm

# Arguments defined in docker-compose.yml
ARG user
ARG uid

#update packages list & upgrade them
RUN apt-get update && apt-get upgrade -y

#install PHP intl
RUN apt-get install -y zlib1g-dev libicu-dev g++
RUN docker-php-ext-configure intl
RUN docker-php-ext-install intl

#install PHP zip
RUN apt-get install -y libzip-dev zip \
    && docker-php-ext-install zip

#install php mysql extension
RUN docker-php-ext-install pdo pdo_mysql mysqli

#install redis extension
RUN pecl install redis \
	&& docker-php-ext-enable redis

#install exif extension
RUN docker-php-ext-install exif

#install gd extension
RUN apt-get install -y libfreetype6-dev libjpeg62-turbo-dev libpng-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd

#set php memory_limit
RUN echo 'memory_limit = 512M' > /usr/local/etc/php/conf.d/docker-php-memlimit.ini;

# Set upload_max_filesize and post_max_size
RUN echo 'upload_max_filesize = 300M' >> /usr/local/etc/php/conf.d/uploads.ini
RUN echo 'post_max_size = 200M' >> /usr/local/etc/php/conf.d/uploads.ini

#install git & wget & zip
RUN apt-get update && apt-get install -y git
RUN apt-get install wget
RUN apt-get install -y zip

#instal procps
RUN apt-get install -y procps

#install composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php -r "if (hash_file('sha384', 'composer-setup.php') === '$(wget -q -O - https://composer.github.io/installer.sig)') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
RUN php composer-setup.php --install-dir=/usr/local/bin --filename=composer
RUN php -r "unlink('composer-setup.php');"

# Create system user to run Composer and Artisan Commands
RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user
RUN usermod -aG sudo $user
RUN echo "${user} ALL=(ALL) NOPASSWD: ALL" >> /etc/sudoers

#install yarn
RUN apt-get install -y gnupg
RUN curl -fsSL https://dl.yarnpkg.com/debian/pubkey.gpg | gpg --dearmor -o /usr/share/keyrings/yarnkey.gpg
RUN echo "deb [signed-by=/usr/share/keyrings/yarnkey.gpg] https://dl.yarnpkg.com/debian/ stable main" > /etc/apt/sources.list.d/yarn.list
RUN apt-get update && apt-get install -y yarn

#update node to the latest stable version
RUN apt-get install -y npm && npm cache clean -f \
 && npm install -g n \
 #need to open another terminal for this
 && n stable

WORKDIR /app

RUN chown -R 1000:1000 /app
RUN mkdir /.composer \
    && chown -R 1000:1000 /.composer
RUN mkdir /.cache \
    && chown -R 1000:1000 /.cache
RUN mkdir /.yarn \
    && chown -R 1000:1000 /.yarn
RUN mkdir -p /.config \
    && chown -R 1000:1000 /.config
USER $user
