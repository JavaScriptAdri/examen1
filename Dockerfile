# Utilitza la imatge oficial de PHP amb Apache
FROM php:8.0-apache

# Instal·la extensions de PHP si el teu projecte les necessita
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Copia tot el projecte al directori web per defecte d'Apache
COPY . /var/www/html/

# Assigna permisos a la carpeta web per assegurar que el servidor pot accedir-hi
RUN chown -R www-data:www-data /var/www/html

# Exposa el port 80 per accedir a l'aplicació web
EXPOSE 80

# Comanda per iniciar Apache
CMD ["apache2-foreground"]
