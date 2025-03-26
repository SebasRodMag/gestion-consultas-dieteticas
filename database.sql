CREATE DATABASE IF NOT EXISTS gestion_consulta_dietetica;
USE gestion_consulta_dietetica;

-- Tabla USUARIOS
CREATE TABLE USUARIOS (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    apellidos VARCHAR(150) NOT NULL,
    dni_usuario VARCHAR(9) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    fecha_nacimiento DATE NOT NULL,
    telefono VARCHAR(15),
    rol ENUM('paciente', 'especialista', 'usuario', 'administrador') DEFAULT 'usuario',
    fecha_creacion DATE NOT NULL,
    fecha_actualizacion DATE
);

-- Tabla ESPECIALISTA
CREATE TABLE ESPECIALISTA (
    id_especialista INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT UNIQUE NOT NULL,
    especialidad VARCHAR(100) NOT NULL,
    FOREIGN KEY (id_usuario) REFERENCES USUARIOS(id_usuario) ON DELETE CASCADE
);

-- Tabla PACIENTE
CREATE TABLE PACIENTE (
    id_paciente INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT UNIQUE NOT NULL,
    fecha_alta DATE NOT NULL,
    fecha_baja DATE DEFAULT NULL,
    FOREIGN KEY (id_usuario) REFERENCES USUARIOS(id_usuario) ON DELETE CASCADE
);

-- Tabla HISTORIAL_MEDICO
CREATE TABLE HISTORIAL_MEDICO (
    id_historial INT AUTO_INCREMENT PRIMARY KEY,
    id_paciente INT NOT NULL,
    descripcion TEXT,
    fecha_hora_ultima_modificacion DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_paciente) REFERENCES PACIENTE(id_paciente) ON DELETE CASCADE
);

-- Tabla DOCUMENTOS
CREATE TABLE DOCUMENTOS (
    id_documento INT AUTO_INCREMENT PRIMARY KEY,
    id_historial INT NOT NULL,
    nombre_archivo VARCHAR(255) NOT NULL,
    ruta_archivo TEXT NOT NULL,
    fecha_hora_subida DATETIME DEFAULT CURRENT_TIMESTAMP,
    fecha_hora_ultima_modificacion DATETIME NULL,
    FOREIGN KEY (id_historial) REFERENCES HISTORIAL_MEDICO(id_historial) ON DELETE CASCADE
);

-- Tabla CONSULTA (resuelve la relación N:M entre PACIENTE y ESPECIALISTA)
CREATE TABLE CONSULTA (
    id_consulta INT AUTO_INCREMENT PRIMARY KEY,
    id_especialista INT NOT NULL,
    id_paciente INT NOT NULL,
    tipo_consulta ENUM('presencial', 'telemática') NOT NULL,
    fecha_hora_consulta DATETIME NOT NULL,
    estado ENUM('pendiente', 'realizada', 'cancelada') DEFAULT 'pendiente',
    comentario TEXT DEFAULT NULL,
    FOREIGN KEY (id_especialista) REFERENCES ESPECIALISTA(id_especialista) ON DELETE CASCADE,
    FOREIGN KEY (id_paciente) REFERENCES PACIENTE(id_paciente) ON DELETE CASCADE
);

-- Restricción para evitar solapamiento entre PACIENTE y ESPECIALISTA
CREATE TRIGGER before_insert_paciente
BEFORE INSERT ON PACIENTE
FOR EACH ROW
BEGIN
    IF EXISTS (SELECT 1 FROM ESPECIALISTA WHERE id_usuario = NEW.id_usuario) THEN
        SIGNAL SQLSTATE '45000' 
        SET MESSAGE_TEXT = 'El usuario ya está registrado como especialista.';
    END IF;
END;

CREATE TRIGGER antes_insertar_especialista
BEFORE INSERT ON ESPECIALISTA
FOR EACH ROW
BEGIN
    IF EXISTS (SELECT 1 FROM PACIENTE WHERE id_usuario = NEW.id_usuario) THEN
        SIGNAL SQLSTATE '45000' 
        SET MESSAGE_TEXT = 'El usuario ya está registrado como paciente.';
    END IF;
END;