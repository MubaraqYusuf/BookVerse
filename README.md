# 📚 BookVerse Library Management System  
A modern PHP & MySQL web application for managing books, users, borrowing, and administration.

<p align="center">
  <img src="https://img.shields.io/badge/Status-Active-brightgreen?style=for-the-badge">
  <img src="https://img.shields.io/badge/PHP-8+-777BB4?style=for-the-badge&logo=php&logoColor=white">
  <img src="https://img.shields.io/badge/MySQL-5.7+-4479A1?style=for-the-badge&logo=mysql&logoColor=white">
  <img src="https://img.shields.io/badge/License-Educational-blue?style=for-the-badge">
</p>

<p align="center">
  <img src="https://img.shields.io/badge/UI-Responsive-00A8E8?style=flat-square">
  <img src="https://img.shields.io/badge/Security-Password%20Hashing-success?style=flat-square">
  <img src="https://img.shields.io/badge/Features-Full--Stack-orange?style=flat-square">
</p>

---

## 📌 Table of Contents
- [📚 BookVerse Library Management System](#-bookverse-library-management-system)
- [✨ Features](#-features)
- [🛠 Tech Stack](#-tech-stack)
- [📂 Project Structure](#-project-structure)
- [⚙ Installation](#-installation)
- [🔐 Login Credentials](#-login-credentials)
- [🧪 Test Scenarios](#-test-scenarios)
- [📊 ER Diagram](#-er-diagram)
- [🗺 Sitemap](#-sitemap)
- [🤝 Contributors](#-contributors)
- [📝 License](#-license)

---

## ✨ Features

### 👤 User Features
- Register, login, logout  
- Browse available books  
- Borrow & return books  
- Prevent duplicate borrowing  
- View My Borrowed Books  
- Forgot & reset password  
- Fully responsive UI  

### 🛠 Admin Features
- Admin login  
- Manage books (add, edit, delete)  
- Manage members  
- Borrow/return control  
- Reports dashboard  
- User password reset panel  
- Search, filtering & data summaries  

---

## 🛠 Tech Stack

| Layer | Technology |
|-------|------------|
| Frontend | HTML5, CSS3, JavaScript |
| Backend | PHP 8+ |
| Database | MySQL |
| UI | Modern Dark Theme |
| Tools | phpMyAdmin, XAMPP/WAMP |

---

## 📂 Project Structure

```
BookVerse/
├── home.php
├── about.php
├── schema.php
├── sitemap.php
├── feedback.php
├── user_login.php
├── register.php
├── forgot_password.php
├── reset_password.php
│
├── dashboard_user.php
│   ├── user_books.php
│   └── user_borrow.php
│
├── admin_secret_login.php
├── dashboard_admin.php
│   ├── books.php
│   ├── update_book.php
│   ├── members.php
│   ├── update_member.php
│   ├── borrow.php
│   ├── report.php
│   └── admin_reset_panel.php
│
├── classes/
│   ├── BookManager.php
│
├── includes/
│   ├── db_connect.php
│
└── uploads/
```

---

## ⚙ Installation

1. Download or clone the project:
```
git clone https://github.com/yourrepo/bookverse.git
```

2. Move to your server directory:
- XAMPP → htdocs  
- WAMP → www  

3. Import **database.sql** into phpMyAdmin.

4. Update database config in `db_connect.php`.

5. Run:
```
http://localhost/BookVerse/home.php
```

---

## 🔐 Login Credentials

### Admin
```
Email: admin@bookverse.com
Password: admin123
```

### Test User
```
Email: user@bookverse.com
Password: user123
```

---

## 🧪 Test Scenarios
- Borrow book limit enforcement  
- Prevent borrowing same book twice  
- Borrow/return workflow validation  
- Admin password reset panel  
- Responsive UI verification  
- Database CRUD operations tested  

---

## 📊 ER Diagram
(Insert ER diagram image here)

---

## 🗺 Sitemap
(Insert sitemap image here)

---

## 🤝 Contributors
- **Mubaraq Yusuf**  
- **Miškinis Dovydas**

---

## 📝 License
This project is for **educational use** only.
