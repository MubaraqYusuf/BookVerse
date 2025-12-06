<?php
session_start();

// Last visit cookie
$lastVisitMessage = "";
if (isset($_COOKIE['last_visit'])) {
    $lastVisitMessage = "Your last visit was on: " . $_COOKIE['last_visit'];
}
setcookie('last_visit', date("Y-m-d H:i:s"), time() + (30*24*60*60));
?>
<!DOCTYPE html>
<html>
<head>
  <title>BookVerse Library - Home</title>
  <meta charset="UTF-8">
  <meta name="author" content="Team BookVerse - Mubaraq Yusuf and Miškinis Dovydas">
  <meta name="description" content="BookVerse Library Management System">
  <meta name="keywords" content="library, bookverse, php, mysql, student project">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="stylesheet" href="style.css">

  <style>
    .homepage-wrapper {
        display:flex;
        flex-direction:column;
        justify-content:flex-start;
        align-items:center;
        text-align:center;
        max-width: 850px;
        margin: 40px auto;
        padding: 20px;
    }

    h1 {
        font-size: 40px;
        margin-top: 10px;
    }

    .intro-text {
        margin-top: 20px;
        font-size: 17px;
        color: #d1d5db;
        line-height: 1.7;
        padding: 0 20px;
    }

    .hero-image {
        width: 100%;
        max-width: 750px;
        margin-top: 25px;
        margin-bottom: 20px;
        border-radius: 12px;
        box-shadow: 0 10px 35px rgba(0,0,0,0.35);
    }
  </style>

</head>
<body>

<!-- TOP NAVBAR -->
<div class="navbar fade-in">
    <div class="brand">📘 BookVerse</div>

    <div>
        <a href="home.php">Home</a>
        <a href="about.php">About</a>
        <a href="sitemap.php">Site Map</a>
        <a href="schema.php">DB Schema</a>
        <a href="feedback.php">Feedback</a>
        <a href="user_login.php" class="btn-light">Login</a>
    </div>
</div>


<!-- MAIN HOMEPAGE -->
<div class="homepage-wrapper fade-in">

    <!-- Floating LOGO -->
    <div class="logo-circle">
        <svg viewBox="0 0 24 24">
            <path d="M4 3h14a2 2 0 012 2v15l-4-3-4 3-4-3-4 3V5a2 2 0 012-2z"/>
        </svg>
    </div>

    <h1>BookVerse Library Management System</h1>

    <!-- Hero Image -->
    <img src="img/home.png" alt="BookVerse Library System" class="hero-image">

    <p class="intro-text"> 
        <b>Welcome to BookVerse - a modern, database-driven library management system
        designed to simplify book organization, borrowing, membership tracking, 
        and reporting.</b>
        <br><br>
    </p>

    <!-- Last visit -->
    <?php if ($lastVisitMessage): ?>
        <p style="margin-top:20px;color:#cbd5e1;font-size:14px;">
            <?= $lastVisitMessage ?>
        </p>
    <?php endif; ?>

</div>


<!-- FOOTER -->
<p style="text-align:center;margin-top:20px;color:#cbd5e1;font-size:13px;">
    © <?= date("Y"); ?> BookVerse Library • Created by <b>Mubaraq Yusuf and Miškinis Dovydas</b>
</p>

</body>
</html>
