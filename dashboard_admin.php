<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: home.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard - BookVerse</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">

<style>
    /* PAGE TITLE */
    h1 {
        margin-bottom: 8px;
        text-align: center;
    }
    p.subtitle {
        color: #cbd5e1;
        text-align: center;
        margin-bottom: 30px;
        font-size: 15px;
    }

    /* BUTTON GRID */
    .admin-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 20px;
        max-width: 900px;
        margin: 0 auto;
        margin-top: 20px;
    }

    .admin-btn {
        background: rgba(255,255,255,0.13);
        backdrop-filter: blur(10px);
        padding: 16px;
        height: 60px;

        display: flex;
        align-items: center;
        justify-content: center;

        text-align: center;
        font-size: 16px;
        font-weight: 600;
        border-radius: 12px;
        color: white;
        text-decoration: none;

        border: 1px solid rgba(255,255,255,0.15);

        transition: 0.25s ease-out;
    }

    .admin-btn:hover {
        background: #2563eb;
        transform: scale(1.05);
        border-color: #1d4ed8;
    }
</style>

</head>
<body>

<!-- NAVBAR -->
<div class="navbar fade-in">
    <div class="brand">📘 Admin Panel</div>

    <div>
        <span class="user-badge"><?php echo $_SESSION['name']; ?></span>
        <a href="logout.php" class="btn-light" style="padding:8px 14px;border-radius:8px;">Logout</a>
    </div>
</div>

<!-- PAGE CONTENT -->
<div class="page-container fade-in">

    <h1>Admin Dashboard</h1>
    <p class="subtitle">Manage books, members, borrowings, reports, and users.</p>

    <!-- BUTTON GRID -->
    <div class="admin-grid">

        <a class="admin-btn" href="books.php">📚 Manage Books</a>

        <a class="admin-btn" href="members.php">👥 Manage Members</a>

        <a class="admin-btn" href="borrow.php">🔄 Borrow / Return</a>

        <a class="admin-btn" href="borrow_history.php">📘 Borrow History</a>

        <a class="admin-btn" href="report.php">📊 Reports</a>

        <a class="admin-btn" href="admin_reset_panel.php">🔐 Reset User Passwords</a>
    </div>

</div>

</body>
</html>
