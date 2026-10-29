# Dockerfile defines how to build the web application container. Itselects a PHP 8.2 image with Apache, installs the PDO MySQL extensions, copies theapplication files nto the web server directory, and exposes port 80 for HTTP traffic.
#php imagee with apache
FROM php:8.2-apache

# install the pdo extension on php can speak to mysql database container
RUN docker-php-ext-install pdo pdo_mysql

RUN apt-get update \
    && apt-get install -y --no-install-recommends msmtp \
    && rm -rf /var/lib/apt/lists/*

RUN printf 'defaults\nauth off\ntls off\naccount mailpit\nhost mail\nport 1025\nfrom no-reply@kabarak.ac.ke\naccount default : mailpit\n' > /etc/msmtprc

RUN echo 'sendmail_path = "/usr/bin/msmtp -t"' > /usr/local/etc/php/conf.d/mail.ini

#copy the local files into the  containers web directory
COPY . /var/www/html/

 # open the docker port 80

EXPOSE 80

