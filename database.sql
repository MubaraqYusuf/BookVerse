-- ============================================
-- BOOKVERSE LIBRARY MANAGEMENT SYSTEM DATABASE
-- ============================================

CREATE DATABASE IF NOT EXISTS library_db;
USE library_db;

-- ==========================
-- USERS TABLE
-- ==========================
DROP TABLE IF EXISTS users;
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(100) UNIQUE NOT NULL,
  password VARCHAR(255) NOT NULL,
  role ENUM('admin','user') DEFAULT 'user',
  reset_code VARCHAR(20) NULL,
  reset_expiry DATETIME NULL
);

-- ==========================
-- BOOKS TABLE
-- ==========================
DROP TABLE IF EXISTS books;
CREATE TABLE books (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(150) NOT NULL,
  author VARCHAR(120) NOT NULL,
  category VARCHAR(60) NOT NULL,
  quantity INT NOT NULL DEFAULT 1,
  status VARCHAR(20) DEFAULT 'Available',
  image VARCHAR(255) NULL
);

-- ==========================
-- MEMBERS TABLE (Admin use)
-- ==========================
DROP TABLE IF EXISTS members;
CREATE TABLE members (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(100),
  contact VARCHAR(50)
);

-- ==========================
-- BORROW TABLE 
-- (Tracks both USERS + MEMBERS)
-- ==========================
DROP TABLE IF EXISTS borrow;
CREATE TABLE borrow (
  id INT AUTO_INCREMENT PRIMARY KEY,

  -- For user-based borrowing (User Dashboard)
  user_id INT NULL,

  -- For member-based borrowing (Admin Panel)
  member_id INT NULL,

  book_id INT NOT NULL,

  borrow_date DATE,
  due_date DATE,
  return_date DATE,

  status VARCHAR(20) DEFAULT 'Borrowed',

  FOREIGN KEY (book_id) REFERENCES books(id) ON DELETE CASCADE,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
  FOREIGN KEY (member_id) REFERENCES members(id) ON DELETE SET NULL
);
