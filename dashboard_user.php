<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'user') {
    header("Location: home.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>User Dashboard - BookVerse</title>
    <link rel="stylesheet" href="style.css">

<style>
    body {
        background:#0f1a3c;
        color:white;
        margin:0;
        font-family:'Segoe UI', sans-serif;
    }

    .navbar {
        display:flex;
        justify-content:space-between;
        align-items:center;
        padding:15px 25px;
        background:#1c284d;
        color:white;
    }
    .navbar .brand {
        font-size:22px;
        font-weight:700;
        display:flex;
        align-items:center;
        gap:8px;
    }
    .navbar a {
        color:#93c5fd;
        margin-left:20px;
        text-decoration:none;
        font-weight:600;
    }
    .user-badge {
        background:white;
        color:#1e3a8a;
        padding:5px 12px;
        border-radius:20px;
        margin-right:10px;
        font-size:14px;
        font-weight:600;
    }

    /* Dashboard Layout */
    h1 {
        text-align:center;
        margin-top:35px;
        font-size:36px;
    }
    p.subtitle {
        text-align:center;
        color:#d1d5db;
        margin-top:8px;
        font-size:16px;
    }

    .grid-container {
        max-width:900px;
        margin:40px auto;
        display:grid;
        grid-template-columns:repeat(auto-fit,minmax(250px,1fr));
        gap:25px;
        padding:10px;
    }

    .dash-card {
        background:rgba(255,255,255,0.10);
        padding:25px;
        text-align:center;
        border-radius:12px;
        box-shadow:0 6px 22px rgba(0,0,0,0.35);
        transition:.25s;
        cursor:pointer;
    }

    /* BLUE HOVER EFFECT (MATCH ADMIN PANEL) */
    .dash-card:hover {
        background:#2563eb !important;
        transform:scale(1.05);
        color:white;
        box-shadow:0 0 20px rgba(37,99,235,0.7);
    }

    .dash-card span.icon {
        font-size:28px;
        margin-bottom:10px;
        display:block;
    }

    /* Make text white on hover */
    .dash-card:hover a {
        color:white !important;
    }

    .dash-card a {
        color:white;
        text-decoration:none;
        font-size:18px;
        font-weight:600;
        display:block;
        margin-top:10px;
    }
</style>
</head>

<body>

<!-- NAVBAR -->
<div class="navbar">
    <div class="brand">📘 BookVerse</div>

    <div>
        <span class="user-badge"><?php echo $_SESSION['name']; ?></span>
        <a href="logout.php">Logout</a>
    </div>
</div>

<!-- USER DASHBOARD -->
<h1>Welcome, <?php echo $_SESSION['name']; ?></h1>
<p class="subtitle">Your personal library dashboard.</p>

<div class="grid-container">

    <div class="dash-card" onclick="window.location='user_books.php'">
        <span class="icon">📚</span>
        <a href="user_books.php">Browse Books</a>
    </div>

    <div class="dash-card" onclick="window.location='user_borrow.php'">
        <span class="icon">📖</span>
        <a href="user_borrow.php">My Borrowed Books</a>
    </div>

</div>

</body>
</html>
