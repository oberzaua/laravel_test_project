FROM php:8.2-fpm

# Arguments defined in docker-compose.yml
ARG user
ARG uid

USER root

# xdebug install + log
RUN pecl install xdebug
RUN docker-php-ext-enable xdebug
RUN mkdir /var/www/html/xdebug
RUN touch /var/www/html/xdebug/xdebug.log
RUN chmod 0666 /var/www/html/xdebug/xdebug.log

# Configure Xdebug
RUN echo "xdebug.start_with_request=yes" >> /usr/local/etc/php/conf.d/xdebug.ini
RUN echo "xdebug.mode=debug,develop,profile" >> /usr/local/etc/php/conf.d/xdebug.ini
RUN echo "xdebug.log=/var/www/html/xdebug/xdebug.log" >> /usr/local/etc/php/conf.d/xdebug.ini
RUN echo "xdebug.discover_client_host=1" >> /usr/local/etc/php/conf.d/xdebug.ini 
RUN echo "xdebug.client_host=host.docker.internal" >> /usr/local/etc/php/conf.d/xdebug.ini 

# Install unzip utility and libs needed by zip PHP extension 
RUN apt-get update && apt-get install -y \
    zlib1g-dev \
    libzip-dev \
    unzip
RUN docker-php-ext-install zip
# mysql driver
RUN docker-php-ext-install pdo_mysql

# node + pnpm
RUN apt update
RUN apt -y install nodejs
RUN apt -y install curl 
RUN curl -fsSL https://get.pnpm.io/install.sh | bash -

# Install composer (php package manager)
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer


# Create system user to run Composer and Artisan Commands
RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user
RUN usermod -g www-data $user


# Set working directory
WORKDIR /var/www/htmllaravel
USER $user
# Expose port 9000 and start php-fpm server (for FastCGI Process Manager)
EXPOSE 9000
CMD ["php-fpm"]