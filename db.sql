-- Suppression de la base de données si elle existe déjà
DROP DATABASE IF EXISTS film_tracker;

-- Création de la base de données
CREATE DATABASE film_tracker;

-- Utilisation de la base de données
USE film_tracker;

-- Création de la table users pour stocker les informations des utilisateurs
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE
);

-- Création de la table content pour stocker les informations sur les films et séries
CREATE TABLE content (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    type ENUM('film', 'serie') NOT NULL,
    rating INT DEFAULT 0,
    tmdb_id INT
);

-- Création de la table favorites pour stocker les favoris
CREATE TABLE favorites (
    id INT AUTO_INCREMENT PRIMARY KEY,
    content_id INT,
    user_id INT,
    FOREIGN KEY (content_id) REFERENCES content(id),
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Création de la table watchlist pour stocker les éléments à voir
CREATE TABLE watchlist (
    id INT AUTO_INCREMENT PRIMARY KEY,
    content_id INT,
    user_id INT,
    FOREIGN KEY (content_id) REFERENCES content(id),
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Création de la table viewed pour stocker les éléments vus
CREATE TABLE viewed (
    id INT AUTO_INCREMENT PRIMARY KEY,
    content_id INT,
    user_id INT,
    FOREIGN KEY (content_id) REFERENCES content(id),
    FOREIGN KEY (user_id) REFERENCES users(id)
);