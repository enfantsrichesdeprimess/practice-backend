FROM php:8.4-apache
ARG SSH_PASS=password
ARG SSH_USER=login
ARG LARAVEL
ARG YII
ARG VUE
ARG REACT
ARG ANGULAR

# Install dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    libzip-dev \
    libpng-dev \
    libjpeg62-turbo-dev \
    libwebp-dev libjpeg62-turbo-dev libpng-dev libxpm-dev \
    libfreetype6 \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl 

# Install extensions
RUN docker-php-ext-install pdo_mysql zip exif pcntl mysqli gd

#Install ssh
RUN apt-get -y install --fix-missing openssh-server


#Add user
RUN useradd -m -s /bin/bash -p $(openssl passwd -1 $SSH_PASS) $SSH_USER
RUN usermod -g $SSH_USER $SSH_USER
RUN usermod -aG sudo $SSH_USER
RUN chown -R $SSH_USER.$SSH_USER /var/www
RUN echo "cd /var/www">>/home/$SSH_USER/.bashrc

#Install Composer
# INSTALL COMPOSER
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

#install Laravel
RUN if [ "${LARAVEL}" = "true" ]; then su - $SSH_USER -c "composer global require laravel/installer" && \
                                ln -s /home/$SSH_USER/.config/composer/vendor/bin/laravel /usr/local/bin/laravel; fi

#install Yii
RUN if [ "${YII}" = "true" ]; then su - $SSH_USER -c "composer create-project --prefer-dist yiisoft/yii2-app-basic basic" && \
                               cp -a -T /home/${SSH_USER}/basic /var/www/basic-yii; fi

#Install node
RUN curl -fsSL https://deb.nodesource.com/setup_current.x | bash - && apt-get install -y nodejs

#install Vue
RUN if [ "${VUE}" = "true" ]; then npm install -g @vue/cli; fi

#install React
RUN if [ "${REACT}" = "true" ]; then npm install -g create-react-app && \
                                su - $SSH_USER -c "create-react-app react-project" && \
                                cp -a -T /home/${SSH_USER}/react-project /var/www/react-project; fi

#install Angular
RUN if [ "${ANGULAR}" = "true" ]; then npm install -g @angular/cli && \
                                su - $SSH_USER -c "ng new angular-project" && \
                                cp -a -T /home/${SSH_USER}/angular-project /var/www/angular-project; fi

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Copy scripts/config into the image as a fallback.
# (docker-compose bind-mounts them, but on some setups the mount can fail)
COPY start.sh /usr/local/bin/start.sh
COPY sshd_config /etc/ssh/sshd_config

# If these files were created on Windows, they may contain CRLF (`\r\n`).
# Docker bind-mount preserves bytes, and CRLF in the shebang breaks execution.
RUN tmp="$(mktemp)" && tr -d '\r' < /usr/local/bin/start.sh > "$tmp" && mv "$tmp" /usr/local/bin/start.sh && \
    tmp="$(mktemp)" && tr -d '\r' < /etc/ssh/sshd_config > "$tmp" && mv "$tmp" /etc/ssh/sshd_config

#Apache configure
RUN a2enmod rewrite

# Normalize (in case bind-mount reintroduced CRLF), make executable, then run.
ENTRYPOINT ["/bin/sh", "-c", "tmp=\"$(mktemp)\"; tr -d '\r' < /usr/local/bin/start.sh > \"$tmp\" && cp \"$tmp\" /usr/local/bin/start.sh && rm -f \"$tmp\"; tmp=\"$(mktemp)\"; tr -d '\r' < /etc/ssh/sshd_config > \"$tmp\" && cp \"$tmp\" /etc/ssh/sshd_config 2>/dev/null && rm -f \"$tmp\" || true; chmod 777 /usr/local/bin/start.sh; exec /usr/local/bin/start.sh"]

RUN a2enmod rewrite

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/000-default.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

RUN echo "DocumentRoot /var/www/html/public" >> /etc/apache2/apache2.conf
RUN sed -i 's|<Directory /var/www/html>|<Directory /var/www/html/public>|' /etc/apache2/apache2.conf
RUN curl -sS https://getcomposer.org/installer | php -- \
    --install-dir=/usr/local/bin --filename=composer