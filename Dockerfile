# We start to build our image from php-apache image.
# https://hub.docker.com/_/php

FROM php:7.2-apache

# Run update and install packages
# curl and nano is installed for testing purposes. You may not actually need them.
#
# install -y option means Automatic yes to prompts;
# assume "yes" as answer to all prompts and run non-interactively.
RUN apt-get update && apt-get install -y \
curl \
nano

# Install php pdo package so our app can create a pdo connetion to our database
RUN docker-php-ext-install pdo_mysql

# Set current working directory to apache default public html directory.
WORKDIR /var/www/html

# Copy local app files to container 
COPY ./src /var/www/html/

# Expose 80 means to expose/open the TCP port 80 to the host computer.
# https://docs.docker.com/engine/reference/builder/#expose
EXPOSE 80

# Start apache
CMD ["apachectl", "-D", "FOREGROUND"]

# For more info see: https://docs.docker.com/engine/reference/builder/