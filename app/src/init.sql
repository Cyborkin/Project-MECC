CREATE DATABASE IF NOT EXISTS honeypot;
USE honeypot;

CREATE TABLE IF NOT EXISTS products (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255),
  description TEXT
);

CREATE TABLE IF NOT EXISTS comments (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user VARCHAR(100),
  message TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO products (name, description) VALUES
('Widget', 'A useful widget'),
('Gadget', 'An amazing gadget'),
('Admin Console', 'A secret admin console');

INSERT INTO comments (user, message) VALUES
('System', 'Welcome to the honeypot!');

-- create a user table (for demonstrating SQLi exfil)
CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(100),
  password VARCHAR(255)
);

INSERT INTO users (username,password) VALUES ('admin','supersecret');

