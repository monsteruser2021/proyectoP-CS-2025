CREATE DATABASE vital_mind;

USE vital_mind;

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    dob DATE NOT NULL,
    hobbies VARCHAR(255) NOT NULL,
    gender VARCHAR(10) NOT NULL,
    role_id INT NOT NULL,
    bio TEXT
);
