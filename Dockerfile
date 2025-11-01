# Use the official PHP image with Apache
FROM php:8.2-apache

# Copy all your project files to Apache’s web root
COPY . /var/www/html/

# Give permission to Apache
RUN chmod -R 755 /var/www/html/

# Enable Apache mod_rewrite (optional, helps if you use clean URLs)
RUN a2enmod rewrite

# Tell Render to use port 10000 (Render requires this)
ENV PORT=10000

# Expose Render’s dynamic port
EXPOSE 10000

# Start Apache in foreground (keeps container alive)
CMD ["apache2-foreground"]

