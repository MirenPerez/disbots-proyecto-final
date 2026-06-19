CREATE DATABASE IF NOT EXISTS disbots_tienda CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE disbots_tienda;

DROP TABLE IF EXISTS productos;
DROP TABLE IF EXISTS usuarios;

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    rol ENUM('admin','normal') NOT NULL DEFAULT 'normal',
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(120) NOT NULL,
    descripcion TEXT NOT NULL,
    categoria VARCHAR(80) NOT NULL,
    precio DECIMAL(8,2) NOT NULL,
    imagen VARCHAR(255) DEFAULT NULL,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO usuarios (nombre, email, password, rol) VALUES
('Administradora', 'admin@disbots.com', '$2y$12$Y0RQ21QgS0ytTNmb1Y8ynetR490eXpw80k1TXlKmkWad5ngzwFln.', 'admin'),
('Usuario Normal', 'user@disbots.com', '$2y$12$Y0RQ21QgS0ytTNmb1Y8ynetR490eXpw80k1TXlKmkWad5ngzwFln.', 'normal');

INSERT INTO productos (nombre, descripcion, categoria, precio, imagen) VALUES
('Moderation Bot', 'Bot para proteger servidores contra spam, raids y mensajes ofensivos.', 'Moderación', 19.99, NULL),
('Music Bot', 'Bot de música con comandos sencillos para canales de voz.', 'Entretenimiento', 14.99, NULL),
('Economy Bot', 'Sistema de monedas, recompensas y tienda interna para comunidades.', 'Economía', 24.99, NULL),
('Tickets Bot', 'Gestión de tickets de soporte para servidores de Discord.', 'Soporte', 29.99, NULL),
('Welcome Bot', 'Mensajes automáticos de bienvenida y despedida.', 'Comunidad', 9.99, NULL);
