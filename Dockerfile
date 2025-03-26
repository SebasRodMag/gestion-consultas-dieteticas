FROM mysql:8.0

# Establecemos variables de entorno para la configuración de MySQL
ENV MYSQL_ROOT_PASSWORD=
ENV MYSQL_DATABASE=gestion_consulta_dietetica
#ENV MYSQL_USER=root
#ENV MYSQL_PASSWORD=

# Copiamos el script de la base de datos para inicializarla
COPY database.sql /docker-entrypoint-initdb.d/

# Exponemos el puerto 3306 para acceder a MySQL
EXPOSE 3306