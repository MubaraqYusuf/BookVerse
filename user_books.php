<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'user') {
    header("Location: home.php");
    exit;
}

include('db_connect.php');
include('classes/BookManager.php');

$Book = new BookManager($conn);

$user_id  = $_SESSION['user_id'];
$search   = $_GET['search']   ?? "";
$category = $_GET['category'] ?? "";

$result = $Book->getBooks($search, $category);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Browse Books</title>
    <link rel="stylesheet" href="style.css">

<style>
    .book-grid {
        margin-top:25px;
        display:grid;
        grid-template-columns:repeat(auto-fit,minmax(230px,1fr));
        gap:20px;
    }
    .book-card {
        background:rgba(255,255,255,0.12);
        padding:18px;
        border-radius:14px;
        text-align:center;
        box-shadow:0 6px 24px rgba(0,0,0,0.4);
    }
    .book-card img {
        width:120px;
        height:160px;
        border-radius:8px;
        object-fit:cover;
        margin-bottom:10px;
    }
    .borrow-btn {
        width:100%!important;
        display:block!important;
        padding:14px 0!important;
        margin-top:14px;
        border-radius:12px;
        background:#2563eb;
        color:white;
        font-weight:600;
    }
    .borrow-btn:hover {
        background:#1e40af;
        transform:scale(1.02);
    }
    .borrow-btn-disabled {
        width:100%;
        padding:14px 0;
        margin-top:14px;
        border-radius:12px;
        background:#6b7280;
        color:white;
        opacity:.8;
        font-weight:600;
        display:block;
    }
</style>

</head>
<body>

<div class="navbar fade-in">
    <span class="brand">📚 Browse Books</span>
    <div>
        <span class="user-badge"><?= $_SESSION['name']; ?></span>
        <a href="dashboard_user.php">Dashboard</a>
        <a href="logout.php" class="btn-light">Logout</a>
    </div>
</div>

<div class="page-container fade-in">

<h1>Find Books</h1>

<form method="get" class="card" style="max-width:500px;">
    <input type="text" name="search" placeholder="Search..."
           value="<?= $search; ?>">

    <select name="category">
        <option value="">All Categories</option>
        <?php
        $cats = $conn->query("SELECT DISTINCT category FROM books");
        while ($c = $cats->fetch_assoc()):
            $sel = ($category == $c['category']) ? "selected" : "";
        ?>
            <option <?= $sel; ?>><?= $c['category']; ?></option>
        <?php endwhile; ?>
    </select>
</form>

<div class="book-grid">

<?php if ($result->num_rows === 0): ?>

    <div style="grid-column:1/-1;text-align:center;padding:40px;">
        <div style="font-size:40px;opacity:.6;">📘</div>
        <p style="color:#d1d5db;font-size:18px;">No books found.</p>
    </div>

<?php else: ?>

<?php while ($b = $result->fetch_assoc()): ?>

<?php $alreadyBorrowed = $Book->userBorrowed($user_id, $b['id']); ?>

<div class="book-card">

    <img src="uploads/<?= $b['image']; ?>">

    <h3><?= $b['title']; ?></h3>
    <p><?= $b['author']; ?></p>
    <p><b><?= $b['category']; ?></b></p>

    <?php if ($b['status'] !== "Available"): ?>
        <span class="borrow-btn-disabled">Borrowed</span>

    <?php elseif ($alreadyBorrowed): ?>
        <span class="borrow-btn-disabled">Borrowed</span>

    <?php else: ?>
        <a class="borrow-btn" href="user_borrow.php?borrow=<?= $b['id']; ?>">Borrow</a>
    <?php endif; ?>

</div>

<?php endwhile; ?>

<?php endif; ?>

</div>

</div>
</body>
</html>
