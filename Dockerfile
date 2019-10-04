FROM php:7.2-apache
RUN docker-php-ext-install pdo_mysql

# Run update and install packages
RUN apt-get update && apt-get install -y \
apt-utils \
curl \
nano 

# Set work dir (apache default public_html)
WORKDIR /var/www/html

# Copy local app files to container 
COPY . /var/www/html/

# Expose prot 80
EXPOSE 80

# Start apache
CMD ["apachectl", "-D", "FOREGROUND"]
