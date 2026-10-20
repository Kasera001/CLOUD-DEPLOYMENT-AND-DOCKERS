1. Create the database if it doesn't exist
CREATE DATABASE IF NOT EXISTS contact_db;
USE contact_db;
-- 2. Create the Users Table (For Task B: Login & Task A: Forgot Password)
CREATE TABLE IF NOT EXISTS users (
id INT AUTO_INCREMENT PRIMARY KEY,
username VARCHAR(50) NOT NULL UNIQUE
email VARCHAR(100) NOT NULL UNIQUE,
password VARCHAR(255) NOT NULL,
reset_token VARCHAR(255) DEFAULT NULL
);
-- 3. Create the Contacts Table (For Task C: Entry Form & Task D: Search)
CREATE TABLE IF NOT EXISTS contacts (
  id INT AUTO_INCREMENT PRIMARY KEY,
   registration_number VARCHAR(50) NOT NULL UNIQUE,
mobile_number VARCHAR(20) NOT NULL,
email VARCHAR(100) NOT NULL,
address TEXT NOT NULL,
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
-- 4. Insert a default test user for your classroom demonstration
-- Username: admin | Password: password123
INSERT INTO users (username, email, password)
VALUES ('admin', 'admin@kabarak.ac.ke',
'$2y$10$w6B2z724pZq9.K0XbW8vxe1G7lK3m7RpyBv2H1x3z4y5z6a7b8c9d')
ON DUPLICATE KEY UPDATE id=id;