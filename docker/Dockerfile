FROM ubuntu:22.04

MAINTAINER "David Gran"

ENV OS_LOCALE="C.UTF-8"
ENV PHP_VERSION="8.1"
RUN apt-get update && apt-get install -y locales && locale-gen es_ES.UTF-8
ENV LANG=${OS_LOCALE} \
    LANGUAGE=${OS_LOCALE} \
    LC_ALL=${OS_LOCALE} \
    DEBIAN_FRONTEND=noninteractive

RUN apt-get update && apt-get install -y --no-install-recommends \
    git \
    openssl \
    unzip \
    wget \
    curl \
    software-properties-common \
    apt-transport-https \
    nano \
    make \
    ca-certificates \
    gpg-agent \
    && rm -rf /var/lib/apt/lists/*

# Configure yarn
RUN curl -sL https://deb.nodesource.com/setup_18.x | bash -
RUN curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add -
RUN echo "deb https://dl.yarnpkg.com/debian/ stable main" | tee /etc/apt/sources.list.d/yarn.list

RUN dpkg-reconfigure locales \
    && add-apt-repository -y ppa:ondrej/php \
    && add-apt-repository -y ppa:ondrej/apache2 \
    && apt-get update \
    && apt-get install -y --no-install-recommends \
    php${PHP_VERSION} \
    apache2 \
    libapache2-mod-php${PHP_VERSION} \
    libargon2-0 \
    libsodium23 \
    gnupg \
    gnupg2 \
    nodejs \
    yarn \
    openssh-client \
    libpcre2-16-0 \
    libpcre2-32-0 \
    libpcre2-8-0 \
    libpcre2-dev \
    && rm -rf /var/lib/apt/lists/*

# Configure apache
COPY apache2/000-default.conf /etc/apache2/sites-enabled/000-default.conf
RUN a2enmod php${PHP_VERSION} headers rewrite deflate filter

# Install php extensions
RUN apt-get update && apt-get install -y --no-install-recommends \
        php${PHP_VERSION}-mbstring \
        php${PHP_VERSION}-bcmath \
        php${PHP_VERSION}-bz2 \
        php${PHP_VERSION}-imap \
        php${PHP_VERSION}-intl \
        php${PHP_VERSION}-soap \
        php${PHP_VERSION}-xsl \
        php${PHP_VERSION}-xmlrp \
        php${PHP_VERSION}-tidy \
        php${PHP_VERSION}-curl \
        php${PHP_VERSION}-mysql \
        php${PHP_VERSION}-zip \
        php${PHP_VERSION}-xml \
        php${PHP_VERSION}-gd \
        php${PHP_VERSION}-redis \
        && rm -rf /var/lib/apt/lists/*

RUN mkdir /usr/local/etc/certs
RUN wget -O /usr/local/etc/certs/cacert.pem http://curl.haxx.se/ca/cacert.pem#

# Configure system TimeZone
RUN ln -snf /usr/share/zoneinfo/Etc/UTC /etc/localtime && echo "Etc/UTC" > /etc/timezone

# Copy php.ini configuration
COPY php/php.ini /etc/php/${PHP_VERSION}/apache2/php.ini
COPY php/php.ini /etc/php/${PHP_VERSION}/cli/php.ini

# Install Composer https://getcomposer.org/doc/faqs/how-to-install-composer-programmatically.md
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN export ACTUAL_CHECKSUM=$(php -r "echo hash_file('sha384', 'composer-setup.php');")
RUN if [ $(php -r 'copy("https://composer.github.io/installer.sig", "php://stdout");') != $(php -r "echo hash_file('sha384', 'composer-setup.php');") ] ; then echo 'COMPOSER ERROR: Invalid installer checksum' && rm composer-setup.php && exit 1 ; fi
RUN php composer-setup.php --quiet
RUN mv composer.phar /usr/local/bin/composer
RUN composer --version

# Add symfony alias
RUN echo 'alias sf="php bin/console"' >> ~/.bashrc
RUN echo 'alias phpunit="/var/www/ecmvela/vendor/bin/phpunit"' >> ~/.bashrc

# Set working directory
WORKDIR /var/www/ecmvela

# Define sessions dir
RUN mkdir -p /tmp/sessions && chmod 777 /tmp/sessions && chown -R www-data:www-data /tmp/sessions

# User is root
RUN mkdir -p /root/.ssh && ln -s /run/secrets/dependencies_rsa /root/.ssh/id_rsa
RUN echo "Host bitbucket.org\n\tStrictHostKeyChecking no\n" >> /root/.ssh/config
RUN chown -R root:root /root/.ssh