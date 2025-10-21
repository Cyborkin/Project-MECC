#db/init.sql (seed data)

CREATE DATABASE IF NOT EXISTS honeypot;
USE honeypot;
CREATE TABLE IF NOT EXISTS users (
	id INT AUTO_INCREMENT PRIMARY KEY,
	username VARCHAR(100) NOT NULL,
	password VARCHAR(255) NOT NULL,
	role VARCHAR(50) DEFAULT 'user'
);
INSERT INTO users (username, password, role) VALUES
('alice', 'password123', 'user'),
('bob', 'hunter2', 'user'),
('admin', 'toor', 'admin');
CREATE TABLE IF NOT EXISTS products (
	id INT AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(150),
	description TEXT
);
INSERT INTO products (name, description) VALUES
('Gizmo', 'Small gizmo that does things'),
('Widget', 'Shiny widget - limited edition');

