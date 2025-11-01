# Use the official PHP image with Apache
FROM php:8.2-apache

# Copy project files into Apache's web root
COPY . /var/www/html/

# Set permissions so Apache can read the files
RUN chmod -R 755 /var/www/html

# Enable Apache modules
RUN a2enmod rewrite

# Set the Render port as an environment variable
ENV PORT=10000

# Tell Apache to listen on Render's dynamic port (not 80!)
RUN sed -i "s/80/${PORT}/g" /etc/apache2/ports.conf \
    && sed -i "s/:80>/:${PORT}>/g" /etc/apache2/sites-available/000-default.conf

# Expose the same port
EXPOSE 10000

# Start Apache in the foreground
CMD ["apache2-foreground"]

