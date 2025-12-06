<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>About BookVerse - Author & Creator</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">

<style>
    .page-container {
        max-width: 900px;
        margin: 40px auto;
        padding: 20px;
        text-align: center;
    }

    .author-card {
        background: rgba(255,255,255,0.12);
        backdrop-filter: blur(12px);
        padding: 20px;
        margin-bottom: 25px;
        border-radius: 14px;
        box-shadow: 0 6px 24px rgba(0, 0, 0, 0.4);
        text-align: left;
    }

    .author-name {
        font-size: 22px;
        font-weight: 700;
        margin-bottom: 8px;
        color: #fff;
    }

    .author-desc {
        color: #e2e8f0;
        line-height: 1.6;
        font-size: 15px;
    }

    h1 {
        margin-bottom: 15px;
        font-size: 36px;
    }

    p.subtitle {
        color: #d1d5db;
        font-size: 16px;
        margin-bottom: 30px;
    }
</style>
</head>

<body>

<!-- NAVBAR -->
<div class="navbar fade-in">
    <div class="brand">📘 BookVerse</div>

    <div>
        <a href="home.php">Home</a>
        <a href="sitemap.php">Site Map</a>
        <a href="schema.php">DB Schema</a>
        <a href="feedback.php">Feedback</a>
        <a href="about.php">About</a>

        <?php if (!isset($_SESSION['role'])): ?>
            <a href="user_login.php" class="btn-light" style="padding:6px 14px;border-radius:8px;">
                Login
            </a>
        <?php else: ?>
            <?php if ($_SESSION['role'] === 'admin'): ?>
                <a href="dashboard_admin.php">Dashboard</a>
            <?php else: ?>
                <a href="dashboard_user.php">Dashboard</a>
            <?php endif; ?>
            <a href="logout.php" class="btn-light" style="padding:6px 14px;border-radius:8px;">
                Logout
            </a>
        <?php endif; ?>
    </div>
</div>

<!-- MAIN CONTENT -->
<div class="page-container fade-in">

    <h1>About</h1>
    <p class="subtitle">
        Meet the authors behind the books and the creators of the BookVerse Library System.
    </p>

    <!-- PROJECT CREATORS -->
    <div class="author-card">
        <div class="author-name">Creator of BookVerse</div>
        <p class="author-desc">
            BookVerse Library Management System was created by <b>Mubaraq Yusuf</b> as a modern database-driven application designed to simplify
            library operations, borrowing, authentication, and reporting.
            <br><br>
            This system highlights real-world development principles such as CRUD functionality,
            database integration, UI/UX design, and secure login features.
        </p>
    </div>

    <!-- AUTHOR 1 -->
    <div class="author-card">
        <div class="author-name">Mubaraq Yusuf</div>
        <p class="author-desc">
            A cybersecurity student and a dedicated software engineer with hands-on experience in both web and mobile development.
            Passionate about building efficient and user-friendly applications.
            <br><br>
            Contact: mubaraq.yusuf@knf.stud.vu.lt 
        </p>
    </div>

</div>

<!-- FOOTER -->
<p style="text-align:center;margin-top:20px;color:#cbd5e1;font-size:13px;">
    © <?php echo date("Y"); ?> BookVerse Library • Created by <b>Mubaraq Yusuf</b>
</p>

</body>
</html>

