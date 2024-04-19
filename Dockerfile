FROM php:8.2-fpm as php
ENV PRJSETUP_PATH="/var/www/html"
# Install dependencies
RUN apt-get update && \
    apt-get install -y \
    libzip-dev \
    zip

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql zip

# Copy the application code
COPY . /var/www/html

# Set the working directory
WORKDIR ${PRJSETUP_PATH}

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install project dependencies
RUN composer install

# Set permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN cp ${PRJSETUP_PATH}/docker-entrypoint.sh /docker-entrypoint.sh \
    && chmod +x /docker-entrypoint.sh
ENTRYPOINT [ "/docker-entrypoint.sh" ]
