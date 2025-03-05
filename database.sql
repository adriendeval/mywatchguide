-- Création de la base de données
CREATE DATABASE mywatchguide;
USE mywatchguide;

-- Création de la table users
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(100) NOT NULL
);

-- Création de la table ratings
CREATE TABLE ratings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    tmdb_type ENUM('movie', 'tv') NOT NULL,
    tmdb_id INT,
    rating INT CHECK (rating >= 1 AND rating <= 10),
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Création de la table favorites
CREATE TABLE favorites (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    tmdb_type ENUM('movie', 'tv') NOT NULL,
    tmdb_id INT,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Insertion de fausses données dans la table users
INSERT INTO users (username, password) VALUES
('alice', 'password'),
('bob', 'password'),
('adriendeval', 'password');

INSERT INTO ratings (user_id, tmdb_type, tmdb_id, rating) VALUES
(1, 101, 4),
(1, 102, 5),
(2, 101, 3),
(2, 103, 4),
(3, 102, 5);

INSERT INTO favorites (user_id, tmdb_type, tmdb_id) VALUES
(1, 101), 
(1, 102),
(1, 103),
(2, 101),
(1, 103),
(2, 102),
(3, 101);