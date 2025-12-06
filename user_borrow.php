<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'user') {
    header("Location: home.php");
    exit;
}

include('db_connect.php');

$user_id = $_SESSION['user_id'];



/* =====================================================
   HANDLE BOOK BORROW REQUEST
   ===================================================== */
if (isset($_GET['borrow'])) {
    $book_id = intval($_GET['borrow']);

    // Check if user already borrowed this book
    $check = $conn->query("
        SELECT * FROM borrow
        WHERE user_id=$user_id AND book_id=$book_id AND status='Borrowed'
    ");

    if ($check->num_rows > 0) {
        echo "<script>alert('You already borrowed this book.'); window.location='user_books.php';</script>";
        exit;
    }

    // Check if book is available
    $status = $conn->query("SELECT status FROM books WHERE id=$book_id")->fetch_assoc()['status'];
    if ($status !== 'Available') {
        echo "<script>alert('This book is already borrowed.'); window.location='user_books.php';</script>";
        exit;
    }

    // Insert borrow record (without admin due-date control)
    $conn->query("
        INSERT INTO borrow (user_id, book_id, borrow_date, status)
        VALUES ($user_id, $book_id, NOW(), 'Borrowed')
    ");

    // Update book status → borrowed
    $conn->query("UPDATE books SET status='Borrowed' WHERE id=$book_id");

    echo "<script>alert('Book borrowed successfully!'); window.location='user_borrow.php';</script>";
    exit;
}



/* =====================================================
   HANDLE BOOK RETURN REQUEST
   ===================================================== */
if (isset($_GET['return'])) {
    $borrow_id = intval($_GET['return']);

    $b = $conn->query("
        SELECT * FROM borrow 
        WHERE id=$borrow_id AND user_id=$user_id
    ")->fetch_assoc();

    if ($b && $b['status'] == 'Borrowed') {

        $book_id = $b['book_id'];

        // Mark as returned
        $conn->query("UPDATE borrow SET status='Returned', return_date=NOW() WHERE id=$borrow_id");

        // Make book available again
        $conn->query("UPDATE books SET status='Available' WHERE id=$book_id");

        echo "<script>alert('Book returned successfully!'); window.location='user_borrow.php';</script>";
        exit;
    }
}



/* =====================================================
   FETCH USER BORROWED BOOKS
   ===================================================== */
$sql = "
SELECT b.*, bk.title, bk.author, bk.category, bk.image
FROM borrow b
JOIN books bk ON b.book_id = bk.id
WHERE b.user_id = $user_id
ORDER BY b.id DESC
";

$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>My Borrowed Books</title>
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
    .return-btn {
        width:100%!important;
        display:block!important;
        padding:14px 0!important;
        margin-top:14px;
        border-radius:12px;
        background:#2563eb;
        color:white;
        font-weight:600;
        text-align:center;
    }
    .return-btn:hover {
        background:#1e40af;
        transform:scale(1.02);
    }
    .returned-label {
        width:100%;
        padding:14px 0;
        margin-top:14px;
        border-radius:12px;
        background:#6b7280;
        color:white;
        opacity:.8;
        font-weight:600;
        display:block;
        text-align:center;
        cursor:not-allowed;
    }
</style>
</head>

<body>

<div class="navbar fade-in">
    <span class="brand">📘 My Borrowed Books</span>
    <div>
        <span class="user-badge"><?= $_SESSION['name']; ?></span>
        <a href="dashboard_user.php">Dashboard</a>
        <a href="logout.php" class="btn-light">Logout</a>
    </div>
</div>

<div class="page-container fade-in">

<h1>My Borrowed Books</h1>

<div class="book-grid">

<?php if ($result->num_rows === 0): ?>

    <div style="grid-column:1/-1;text-align:center;padding:40px;">
        <div style="font-size:40px;opacity:.6;">📘</div>
        <p style="color:#d1d5db;font-size:18px;">No borrowed books yet.</p>
    </div>

<?php else: ?>

<?php while ($b = $result->fetch_assoc()): ?>

<div class="book-card">

    <img src="uploads/<?= $b['image']; ?>">

    <h3><?= $b['title']; ?></h3>
    <p><?= $b['author']; ?></p>
    <p><b><?= $b['category']; ?></b></p>

    <p><b>Borrowed:</b> <?= $b['borrow_date']; ?></p>

    <?php if ($b['due_date']): ?>
        <p><b>Due:</b> <?= $b['due_date']; ?></p>
    <?php endif; ?>

    <?php if ($b['status'] === "Borrowed"): ?>
        <a class="return-btn" href="user_borrow.php?return=<?= $b['id']; ?>">Return Book</a>
    <?php else: ?>
        <span class="returned-label">Returned</span>
    <?php endif; ?>

</div>

<?php endwhile; ?>

<?php endif; ?>

</div>

</div>

</body>
</html>
