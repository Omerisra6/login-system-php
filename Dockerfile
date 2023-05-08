# Use an official PHP runtime as the base image
FROM php:7.4-apache

# Set the working directory inside the container
WORKDIR /

# Copy the application files to the working directory
COPY . .

# Expose port 80 for the Apache server
EXPOSE 80

# Set the default command
CMD [ "php", "-S", "0.0.0.0:80", "-t", "/" ]
