Se realiza el diseño de la Base de Datos con su modelo Entidad – Relación, su paso al modelo relacional y los script de creación de tablas.

Se crea un script para la creación de la base de datos.  
Se crea un script que inserte datos en la BD a partir de un conjunto de datos inicial sobre el que poder ir realizando las primeras pruebas. 
Se realiza un diagrama de la base de datos para tener una representación gráfica.
Se realizan Bosquejos de la interfaz de usuario
se realiza un diagrama de las interfaces
Se realiza un diagrama del flujo del código
Si dispone el proyecto en en dos Carpetas:
    Backend: para Laravel
    Frontend: para Angular

Se realiza la instalación de los frameworks en sus respectivos directorios, asi como Docker en el directorio Raíz.

Se implementan las siguientes tablas:
En app/migrations:
create_users_table.php
create_cache_table.php
create_jobs_table.php
create_usuarios_table.php
create_especialistas_table.php
create_pacientes_table.php
create_consultas_table.php
create_historial_medico_table.php
create_documentos_table.php
create_logs_table.php
create_bonos_table.php
create_pagos_table.php
create_entradas_historial_table.php

Se valora el estado de un paciente, si ya ha sido tratado o si es su primera vez con el campo 'estado'
Estado: ENUM (['pendiente', 'activo', 'finalizado'])->default('pendiente');
Se implementaron Políticas
Se esta implementando la funcionalidad de cambiar el tipo de rol a un usuario