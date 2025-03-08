CREATE DATABASE vital_mind;

USE vital_mind;

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    fullname VARCHAR(100) NOT NULL,
    dob DATE NOT NULL,
    preferences VARCHAR(50) NOT NULL,
    hobbies VARCHAR(255) NOT NULL,
    gender VARCHAR(10) NOT NULL,
    bio TEXT
);

CREATE TABLE articulos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    contenido TEXT NOT NULL,
    fecha DATE NOT NULL,
    usuario_id INT,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);

CREATE TABLE comentarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    contenido TEXT NOT NULL,
    fecha DATE NOT NULL,
    usuario_id INT,
    articulo_id INT,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id),
    FOREIGN KEY (articulo_id) REFERENCES articulos(id)
);