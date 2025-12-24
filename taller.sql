-- =========================================
-- BASE DE DATOS
-- =========================================
CREATE DATABASE IF NOT EXISTS proyecto_pa_taller
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_general_ci;

USE proyecto_pa_taller;

-- =========================================
-- TABLA USUARIOS (LOGIN)
-- =========================================
CREATE TABLE usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL
) ENGINE=InnoDB;

-- =========================================
-- TABLA CLIENTES
-- =========================================
CREATE TABLE clientes (
    id_cliente INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    telefono VARCHAR(20) NOT NULL,
    email VARCHAR(100),
    fecha_alta DATE NOT NULL
) ENGINE=InnoDB;

-- =========================================
-- TABLA VEHICULOS
-- =========================================
CREATE TABLE vehiculos (
    id_vehiculo INT AUTO_INCREMENT PRIMARY KEY,
    marca VARCHAR(50) NOT NULL,
    modelo VARCHAR(50) NOT NULL,
    matricula VARCHAR(15) NOT NULL UNIQUE,
    id_cliente INT NOT NULL,
    CONSTRAINT fk_vehiculo_cliente
        FOREIGN KEY (id_cliente)
        REFERENCES clientes(id_cliente)
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- =========================================
-- TABLA REPARACIONES
-- =========================================
CREATE TABLE reparaciones (
    id_reparacion INT AUTO_INCREMENT PRIMARY KEY,
    descripcion TEXT NOT NULL,
    fecha DATE NOT NULL,
    estado ENUM('pendiente','en curso','finalizada') NOT NULL,
    precio DECIMAL(8,2) NOT NULL,
    id_vehiculo INT NOT NULL,
    CONSTRAINT fk_reparacion_vehiculo
        FOREIGN KEY (id_vehiculo)
        REFERENCES vehiculos(id_vehiculo)
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- =========================================
-- USUARIO ADMIN DE PRUEBA
-- email: admin@taller.com
-- contraseña: admin123
-- =========================================
INSERT INTO usuarios (email, password_hash)
VALUES (
    'admin@taller.com',
    '$2y$10$Vx9pFZPpHn9YvC7PZ6Z7rO6zA2R2pO6qD6z6qZyZpJ6Qb9N2c6G7W'
);