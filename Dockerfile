FROM php:7.4-apache

# Copy app folder
COPY ./App /var/www/html/App

# Copy public folder
COPY ./public /var/www/html/public

# Copy index.php from the root
COPY ./index.php /var/www/html/index.php

EXPOSE 80

# Set the default command
CMD [ "php", "-S", "0.0.0.0:80", "-t", "/" ]
