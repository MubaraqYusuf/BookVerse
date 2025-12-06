CREATE DATABASE IF NOT EXISTS library_db;
USE library_db;

CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100),
  email VARCHAR(100) UNIQUE,
  password VARCHAR(255) NOT NULL,
  role ENUM('admin','user') DEFAULT 'user',
  reset_code VARCHAR(20) NULL,
  reset_expiry DATETIME NULL
);

CREATE TABLE IF NOT EXISTS books (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(100),
  author VARCHAR(100),
  category VARCHAR(50),
  quantity INT,
  status VARCHAR(20) DEFAULT 'Available',
  image VARCHAR(255) NULL
);

CREATE TABLE IF NOT EXISTS members (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100),
  email VARCHAR(100),
  contact VARCHAR(50)
);

CREATE TABLE IF NOT EXISTS borrow (
  id INT AUTO_INCREMENT PRIMARY KEY,
  member_id INT NULL,
  book_id INT NOT NULL,
  user_id INT NULL,
  borrow_date DATE,
  return_date DATE,
  status VARCHAR(20) DEFAULT 'Borrowed',
  FOREIGN KEY (book_id) REFERENCES books(id),
  FOREIGN KEY (member_id) REFERENCES members(id),
  FOREIGN KEY (user_id) REFERENCES users(id)
);
