# Use an official PHP runtime as the base image
FROM php:7.4-apache

# Set the working directory inside the container
WORKDIR /var/www/html

# Copy the application files to the working directory
COPY . .

# Install any dependencies your application requires
# For example, if you use composer, uncomment the following lines
# COPY composer.json composer.lock ./
# RUN composer install --no-scripts --no-autoloader

# Expose port 80 for the Apache server
EXPOSE 80

# Set the default command
CMD [ "php", "-S", "0.0.0.0:80", "-t", "/" ]
