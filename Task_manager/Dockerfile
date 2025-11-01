# Use the official PHP image with Apache
FROM php:8.2-apache

# Copy all your project files to Apache's web root
COPY . /var/www/html/

# Give Apache permission to read files
RUN chmod -R 755 /var/www/html/

# Enable Apache rewrite module (optional but good practice)
RUN a2enmod rewrite

# Tell Render to use dynamic port
ENV PORT=10000

# Update Apache to listen on Render's port
RUN sed -i "s/80/${PORT}/g" /etc/apache2/ports.conf /etc/apache2/sites-available/000-default.conf

# Expose that port for Render
EXPOSE 10000

# Start Apache
CMD ["apache2-foreground"]

